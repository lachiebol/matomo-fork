<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\QuickStats;

use Piwik\View;

class QuickStats extends \Piwik\Plugin
{

    public function registerEvents()
    {
        return [
            'Template.pageFooter' => 'addQuickStatsElement'
        ];
    }


    public function addQuickStatsElement(&$out) {

        $out .= "<div vue-entry=\"QuickStats.QuickStatsModal\"></div>";
    }

}
