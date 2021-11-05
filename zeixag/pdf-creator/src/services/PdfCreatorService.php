<?php
/**
 * pdf creator plugin for Craft CMS 3.x
 *
 * create PDFs
 *
 * @link      https://zeix.com/team/dragan-nikolic/
 * @copyright Copyright (c) 2021 Dragan Nikolic
 */

namespace zeixag\pdfcreator\services;

use craft\gql\queries\Category;
use zeixag\pdfcreator\PdfCreator;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use craft\helpers\App;
use DOMDocument;
use DOMXPath;
use IvoPetkov\HTML5DOMDocument;

//@error_reporting(0);

/**
 * PdfCreatorService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Dragan Nikolic
 * @package   PdfCreator
 * @since     1.0.0
 */
class PdfCreatorService extends Component {
  // Public Methods
  // =========================================================================

  /**
   * This function can literally be anything you want, and you can have as many service
   * functions as you want
   *
   * From any other plugin file, call it like this:
   *
   *     PdfCreator::$plugin->pdfCreatorService->exampleService()
   *
   * @return mixed
   */
  public function exampleService() {
    $result = 'something';
    // Check our Plugin's settings for `someAttribute`
    if (PdfCreator::$plugin->getSettings()->someAttribute) {
        //
    }

    return $result;
  }

  public function getVersion() {
    return PdfCreator::$plugin->version;
  }

  public function listPages() {
    $entries = Entry::find()
      ->site('annualReport2020')
      ->anyStatus()
      ->limit(99)
      ->all();
    return $entries;
  }

  // $selection passed from CP
  // PdfCreator::$plugin->pdfCreatorService->generatePdfFromPageSelection($selection)
  public function generatePdfFromPageSelection($selection) {
    $html         = '';
    $pages        = $selection["pageSelection"];
    $metaTitle    = $selection["metaTitle"];
    $metaAuthor   = $selection["metaAuthor"];
    $metaSubject  = $selection["metaSubject"];
    $metaKeywords = $selection["metaKeywords"];
    $fileName     = $selection["fileName"];
    $imgLogo      = Craft::$app->view->assetManager->getPublishedUrl('@zeixag/pdfcreator/assetbundles/indexcpsection/dist', true) . '/img/Zeix_Logo_ohne_Claim-gross.png';
    $imgRocket    = Craft::$app->view->assetManager->getPublishedUrl('@zeixag/pdfcreator/assetbundles/indexcpsection/dist', true) . '/img/rakete-illustration-01.png';
    $headCss      = Craft::$app->view->assetManager->getPublishedUrl('@zeixag/pdfcreator/assetbundles/pdfcreator/dist/css', true) . '/head.css';

    foreach ($pages as $page) {

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $page);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $response = curl_exec($ch);
      $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);

      if ((int)$status === 200) {
        $dom = new HTML5DOMDocument();
        $dom->loadHTML($response);
        $dom->preserveWhiteSpace = false;
        $xpath                   = new DOMXPath($dom);
        libxml_use_internal_errors(true);
        $xpath_resultset = $dom->getElementsByTagName('main');
        $htmlDirty       = $dom->saveHTML($xpath_resultset->item(0));
        $html            .= $htmlDirty;
        libxml_clear_errors();

      } else {
//        exit("oops... something went wrong");
        $html .= "Error<br>";
        $html .= "Status: $status<br>$page<hr>";
      }
    }

    $justTheMeat = str_ireplace(array('<main role="main">', '</main>'), '', $html);

    $printHead = <<<KOPF
<!DOCTYPE HTML>
<html lang="de-CH"
  dir="ltr">
  <head>
    <base href="https://dev.annually.zeix.com/" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&amp;display=swap" rel="stylesheet">
    <link href="/assets/generated/css/main.css" rel="stylesheet" />
    <link href="$headCss" rel="stylesheet" media="print" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <title>$metaTitle</title>
  </head>
  <body>
    <img src="$imgRocket" class="cover-image" alt="">
    <div class="logo-holder">
        <img src="$imgLogo" class="logo" alt="">
        <h1 class="h1">$metaTitle</h1>
    </div>
    <pagebreak />
    <tocpagebreak links="1" />
    <main>
KOPF;

    $printFoot = '<script src="/assets/generated/js/chunk-vendors.js"></script>
                    <script src="/assets/generated/js/main.js"></script>
                    </main></body></html>';

    $pfui = array('<h6', '<h5', '<h4', '<h3', '<h2', '<h1', '</h6>', '</h5>', '</h4>', '</h3>', '</h2>', '</h1>');
    $hui  = array('<h7', '<h6', '<h5', '<h4', '<h3', '<h2', '</h7>', '</h6>', '</h5>', '</h4>', '</h3>', '</h2>');

    $kosherMeat = str_ireplace($pfui, $hui, $justTheMeat);
//    $finalHTML  = PdfCreator::$plugin->pdfCreatorService->compress_html($printHead . $kosherMeat . $printFoot);
//    $finalHTML  = PdfCreator::$plugin->pdfCreatorService->compress_html($printHead . $kosherMeat . $printFoot);
    $finalHTML = $printHead . $kosherMeat . $printFoot;


    /*
     * -------------------------------------------------------------------------------------------
     * if you'd like to use your own custom fonts, add them to vendor/mpdf/mpdf/ttfonts directory
     * -------------------------------------------------------------------------------------------
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs      = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData          = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
      'fontdata' => $fontData + [
          'metric' => [
            'R' => 'Metric-Regular.ttf',
            'B' => 'Metric-Medium.ttf',
          ],
          'tiempos' => [
            'R' => 'TiemposText-Regular.ttf',
          ]
        ],
      'default_font' => 'metric'
    ]);
    */

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetTitle($metaTitle);
    $mpdf->SetCreator($metaAuthor);
    $mpdf->SetAuthor($metaAuthor);
    $mpdf->SetSubject($metaSubject);
    $mpdf->SetKeywords($metaKeywords);
//    $mpdf->SetProtection(array('copy', 'print'), '', 'PiiDiiEffZ31X');

    $mpdf->h2toc = array(
      'H1' => 0,
      'H2' => 1,
      'H3' => 2,
    );

    $mpdf->SetHTMLFooter("
<table width='100%' class='pdf-footer' style='font-size: 7pt;'>
    <tr>
        <td width='33%'>{DATE j.m.Y}</td>
        <td width='33%' align='center'>{PAGENO} / {nbpg}</td>
        <td width='34%' style='text-align: right;'>$metaTitle</td>
    </tr>
</table>");
    $mpdf->WriteHTML($finalHTML);

    $rootPath   = Craft::getAlias('@rootPath');
    $reportPath = $rootPath . '/web/content-files/reports/';
    $reportUrl  = Craft::getAlias('@baseUrl') . '/content-files/reports/';

    $fn      = $reportPath . "$fileName.pdf";
    $fnHTML  = $reportPath . "$fileName.html";
    $urlPDF  = $reportUrl . "$fileName.pdf";
    $urlHTML = $reportUrl . "$fileName.html";

    @file_put_contents($fnHTML, $finalHTML);

    $mpdf->Output($fn, 'F');

    $res = array(
      'status' => 'ok',
      'pdf' => $urlPDF,
      'html' => $urlHTML
    );

//    if ($mpdf->Output($fn, 'F')) {
//      $res = array(
//        'status' => 'ok',
//        'pdf' => $urlPDF,
//        'html' => $urlHTML
//      );
//    } else {
//      $res = array(
//        'status' => 'mpdf error - PDF was not generated',
//        'pdf' => '',
//        'html' => ''
//      );
//    }

    echo json_encode($res); // results in 404 error "template not found"
//    see https://craftcms.stackexchange.com/questions/32607/action-route-not-available-from-url-what-do-i-have-wrong

    die();

  }

}
