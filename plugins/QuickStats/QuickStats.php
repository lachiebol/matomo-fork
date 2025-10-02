<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\QuickStats;

use Piwik\Access;
use Piwik\Piwik;

class QuickStats extends \Piwik\Plugin
{

    public function registerEvents()
    {
        return [
            'Template.pageFooter' => 'addQuickStatsElement'
        ];
    }

    public function addQuickStatsElement(&$out) {

        // Anonymous user with no access at all should be restricted, and it should not show on the login page
        $sitesWithAccess=Access::getInstance()->getSitesIdWithAtLeastViewAccess();
        if (count($sitesWithAccess)&&Piwik::getModule()!=='Login') { 
            $out .= "<div vue-entry=\"QuickStats.QuickStatsModal\"></div>";
        }
    }

}
