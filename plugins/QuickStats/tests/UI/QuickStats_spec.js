/*!
 * Matomo - free/libre analytics platform
 *
 * Screenshot integration tests.
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

describe("QuickStats", function () {
    this.timeout(0);


    before(function () {
        testEnvironment.pluginsToLoad = ['QuickStats'];
        testEnvironment.save();
    });

    it('should show the QuickStats button on the page', async function() {
        var urlToTest = "?module=CoreHome&action=index&idSite=1&period=day&date=2010-01-03";
        await page.goto(urlToTest);
        expect(await page.screenshot( { fullPage: true })).to.matchImage('QuickStatsModal_button');
    });

    it('should open the QuickStats modal and take a screenshot', async function() {
        var urlToTest = "?module=CoreHome&action=index&idSite=1&period=day&date=2010-01-03";
        await page.goto(urlToTest);

        await page.click('#quick-stats-button-container button.btn');

        await page.waitForTimeout(500);

        expect(await page.screenshot( { fullPage: true })).to.matchImage('QuickStatsModal_open');
    });
});
