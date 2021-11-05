<?php
/**
 * pdf creator plugin for Craft CMS 3.x
 *
 * create PDFs
 *
 * @link      https://zeix.com/team/dragan-nikolic/
 * @copyright Copyright (c) 2021 Dragan Nikolic
 */

namespace zeixag\pdfcreator\controllers;

use phpDocumentor\Reflection\Type;
use zeixag\pdfcreator\PdfCreator;

use Craft;
use craft\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use DOMDocument;
use DOMXPath;

use mdfp\mpdf;

@error_reporting(0);
@ini_set('max_execution_time', 6000); // 100 minutes
@ini_set('memory_limit', '4096M');


/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Dragan Nikolic
 * @package   PdfCreator
 * @since     1.0.0
 */
class DefaultController extends Controller
{

  // Protected Properties
  // =========================================================================

  /**
   * @var    bool|array Allows anonymous access to this controller's actions.
   *         The actions must be in 'kebab-case'
   * @access protected
   */
  protected $allowAnonymous = ['index', 'do-something', 'get-page-selection', 'send-status-after-pdf-generation'];

  // Public Methods
  // =========================================================================

  /**
   * Handle a request going to our plugin's index action URL,
   * e.g.: actions/pdf-creator/default
   *
   * @return mixed
   */
  public function actionIndex()
  {
    $result = 'Welcome to the DefaultController actionIndex() method';

    return $result;
  }

  /**
   * Handle a request going to our plugin's actionDoSomething URL,
   * e.g.: actions/pdf-creator/default/do-something
   *
   * @return mixed
   */

  public function actionDoSomething()
  {
    $result = 'Welcome to the DefaultController actionDoSomething() method';

    return $result;
  }

  public function actionGetPageSelection()
  {
    $this->requirePostRequest();
    $this->requireAcceptsJson();
    $request = Craft::$app->getRequest();
    $pageSelection = $request->getRawBody(); // string
    $pageSelectionArray = json_decode($pageSelection, true);
    PdfCreator::$plugin->pdfCreatorService->generatePdfFromPageSelection($pageSelectionArray);
  }

  /*
  public function actionSendStatusAfterPdfGeneration()
  {
    $this->requirePostRequest();
    $this->requireAcceptsJson();
    $request = Craft::$app->getRequest();
    $pageSelection = $request->getRawBody(); // string
    $pageSelectionArray = json_decode($pageSelection, true);
    $status = $pageSelectionArray["status"];
    $html = $pageSelectionArray["html"];
    $pdf = $pageSelectionArray["pdf"];
    $res = array(
      'status' => 'ok',
      'pdf' => 'test.pdf',
      'html' => 'test.html'
    );
  }
  */

}
