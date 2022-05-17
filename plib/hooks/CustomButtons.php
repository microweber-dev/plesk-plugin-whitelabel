<?php
/**
 * Microweber auto provision plesk plugin
 * Author: Bozhidar Slaveykov
 * @email: info@microweber.com
 * Copyright: Microweber CMS
 */

class Modules_Microweber_CustomButtons extends pm_Hook_CustomButtons
{

    public function getButtons()
    {
        $showButtons = Modules_Microweber_Helper::showMicroweberButtons();
        if (!$showButtons) {
            return [];
        }

        $places = [];
        $places[] = [
            'place' => [
                self::PLACE_DOMAIN,
                self::PLACE_DOMAIN_PROPERTIES,
                self::PLACE_RESELLER_TOOLS_AND_SETTINGS
            ],
            'title' => Modules_Microweber_WhiteLabel::getBrandName(),
            'description' => 'View all ' . Modules_Microweber_WhiteLabel::getBrandName() . ' websites.',
            'icon' => Modules_Microweber_WhiteLabel::getBrandAppIcon(),
            'link' => pm_Context::getBaseUrl() . 'index.php/index/index',
            'contextParams' => true
        ];

        $places[] = [
            'place' => self::PLACE_ADMIN_NAVIGATION,
            'section' => self::SECTION_NAV_SERVER_MANAGEMENT,
            'order' => 15,
            'title' => Modules_Microweber_WhiteLabel::getBrandName(),
            'description' => 'Install last version of ' . Modules_Microweber_WhiteLabel::getBrandName(),
            'link' => pm_Context::getActionUrl('index', ''),
            'icon' => Modules_Microweber_WhiteLabel::getBrandInvertIcon()
        ];

        $places[] = [
            'place' => [self::PLACE_HOSTING_PANEL_TABS],
            'order' => 15,
            'title' => Modules_Microweber_WhiteLabel::getBrandName(),
            'description' => 'Install last version of ' . Modules_Microweber_WhiteLabel::getBrandName(),
            'link' => pm_Context::getActionUrl('index'),
            'icon' => Modules_Microweber_WhiteLabel::getBrandInvertIcon()
        ];

        $places[] = [
            'place' => [
                self::PLACE_RESELLER_NAVIGATION,
                self::PLACE_HOSTING_PANEL_NAVIGATION,
                self::PLACE_ADMIN_TOOLS_AND_SETTINGS,
            ],
            'order' => 15,
            'title' => Modules_Microweber_WhiteLabel::getBrandName(),
            'description' => 'Install last version of ' . Modules_Microweber_WhiteLabel::getBrandName(),
            'link' => pm_Context::getActionUrl('index', 'index'),
            'icon' => Modules_Microweber_WhiteLabel::getBrandInvertIcon()
        ];

        return $places;
    }

    public function isDomainPropertiesButtonVisible(array $params)
    {
        if (!isset($params['site_id'])) {
            return false;
        }

        if (isset($params['alias_id']) && !empty($params['alias_id'])) {
            return false;
        }

        $domain = pm_Domain::getByDomainId($params['site_id']);

        return $domain->hasHosting();
    }
}
