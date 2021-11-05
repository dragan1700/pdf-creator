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

use zeixag\pdfcreator\PdfCreator;

use Craft;
use craft\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;


/**
 * Pagelist Controller
 *
 * @author    Dragan Nikolic
 * @package   PdfCreator
 * @since     1.0.0
 */
class PagelistController extends Controller {

  // Protected Properties
  // =========================================================================

  /**
   * @var    bool|array Allows anonymous access to this controller's actions.
   *         The actions must be in 'kebab-case'
   * @access protected
   */
  protected $allowAnonymous = ['index', 'do-something', 'get-page-selection'];

  // Public Methods
  // =========================================================================

  /**
   * Handle a request going to our plugin's index action URL,
   * e.g.: actions/pdf-creator/pagelist
   *
   * @return mixed
   */
  public function actionIndex() {
    $this->requirePostRequest();
    $this->requireAcceptsJson();
    $request = Craft::$app->getRequest();

    return $this->asJson([
      'success' => true,
      'hello' => 'world'
    ]);
  }
}
