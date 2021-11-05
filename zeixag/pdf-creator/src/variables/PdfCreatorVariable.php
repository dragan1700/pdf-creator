<?php
/**
 * pdf creator plugin for Craft CMS 3.x
 *
 * create PDFs
 *
 * @link      https://zeix.com/team/dragan-nikolic/
 * @copyright Copyright (c) 2021 Dragan Nikolic
 */

namespace zeixag\pdfcreator\variables;

use zeixag\pdfcreator\PdfCreator;

use Craft;

/**
 * pdf creator Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.pdfCreator }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Dragan Nikolic
 * @package   PdfCreator
 * @since     1.0.0
 */
class PdfCreatorVariable {
  // Public Methods
  // =========================================================================

  /**
   * Whatever you want to output to a Twig template can go into a Variable method.
   * You can have as many variable functions as you want.  From any Twig template,
   * call it like this:
   *
   *     {{ craft.pdfCreator.exampleVariable }}
   *
   * Or, if your variable requires parameters from Twig:
   *
   *     {{ craft.pdfCreator.exampleVariable(twigValue) }}
   *
   * @param null $optional
   * @return string
   */
  public function exampleVariable($optional = null) {
    $result = "And away we go to the Twig template...";
    if ($optional) {
      $result = "I'm feeling optional today...";
    }
    return $result;
  }

  public function getVersion() {
    return PdfCreator::$plugin->pdfCreatorService->getVersion();
  }

  public function listSites() {
    return PdfCreator::$plugin->pdfCreatorService->listSites();
  }

  public function listPages() {
    return PdfCreator::$plugin->pdfCreatorService->listPages();
  }

  public function getPageSelection() {
    return PdfCreator::$plugin->pdfCreatorService->getPageSelection();
  }

  public function fpc() {
    return PdfCreator::$plugin->pdfCreatorService->fpc();
  }

  public function fgc() {
    return PdfCreator::$plugin->pdfCreatorService->fgc();
  }
}
