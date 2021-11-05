<?php
/**
 * pdf creator plugin for Craft CMS 3.x
 *
 * create PDFs
 *
 * @link      https://zeix.com/team/dragan-nikolic/
 * @copyright Copyright (c) 2021 Dragan Nikolic
 */

namespace zeixag\pdfcreator\utilities;

use zeixag\pdfcreator\PdfCreator;
use zeixag\pdfcreator\assetbundles\pdfcreatorutilityutility\PdfCreatorUtilityUtilityAsset;

use Craft;
use craft\base\Utility;

/**
 * pdf creator Utility
 *
 * Utility is the base class for classes representing Control Panel utilities.
 *
 * https://craftcms.com/docs/plugins/utilities
 *
 * @author    Dragan Nikolic
 * @package   PdfCreator
 * @since     1.0.0
 */
class PdfCreatorUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * Returns the display name of this utility.
     *
     * @return string The display name of this utility.
     */
    public static function displayName(): string
    {
        return Craft::t('pdf-creator', 'PdfCreatorUtility');
    }

    /**
     * Returns the utility’s unique identifier.
     *
     * The ID should be in `kebab-case`, as it will be visible in the URL (`admin/utilities/the-handle`).
     *
     * @return string
     */
    public static function id(): string
    {
        return 'pdfcreator-pdf-creator-utility';
    }

    /**
     * Returns the path to the utility's SVG icon.
     *
     * @return string|null The path to the utility SVG icon
     */
    public static function iconPath()
    {
        return Craft::getAlias("@zeixag/pdfcreator/assetbundles/pdfcreatorutilityutility/dist/img/PdfCreatorUtility-icon.svg");
    }

    /**
     * Returns the number that should be shown in the utility’s nav item badge.
     *
     * If `0` is returned, no badge will be shown
     *
     * @return int
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * Returns the utility's content HTML.
     *
     * @return string
     */
    public static function contentHtml(): string
    {
        Craft::$app->getView()->registerAssetBundle(PdfCreatorUtilityUtilityAsset::class);

        $someVar = 'Have a nice day!';
        return Craft::$app->getView()->renderTemplate(
            'pdf-creator/_components/utilities/PdfCreatorUtility_content',
            [
                'someVar' => $someVar
            ]
        );
    }
}
