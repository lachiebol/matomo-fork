## How the Solution Works

I inserted the component through the Template.pageFooter hook in QuickStats.php. I used a vue-entry on a div element to load the plugin, it looks like a lot of vue components get output through twig, but since we weren't using twig in this exercise I just appended the div element to &$out.

The plugin works by placing a button in the footer element. When the button is pressed, the modal is shown and the API is queried for the statistics, which is shown in a table.

## Key Architectural / Design Decisions

Reuse of methods and components made available in Matomo, no need to reinvent the wheel. It also enforces consistency across the UI.

I assumed if a user has no view access or they are on the login module, then the quick stats button should not show.

## Setup / Configuration

No dependencies added, just make sure the plugin is built with this command:

`ddev matomo:console vue:build QuickStats`

## Potential Improvements

Delay loading quick stats button until all page content has loaded

Refresh button to pull data again

Add the ability to change the time period that's being queried, and select what website you'd like to see stats for

## UI Tests

UI tests have been added, I've added one that checks for the button on the screen, and one that checks the modal will load.

To run the tests:

`ddev matomo:console test:ui QuickStats`

For subsequent test runs use:

`ddev matomo:console tests:run-ui QuickStats --persist-fixture-data`

# Testing

Unit tests, test methods like toggleQuickStatsModal to ensure they're opening the modal. These would go in a /tests/unit folder in /src/. I would use tools like Jest or Mocha, and a given then when pattern.

Integration tests, testing the modal opens and populates the data correctly. These would go in a tests/integration folder in /src/. Same as above but with more general test cases.

End-to-end tests, testing real interactions with the model across different platforms. I would use tools like Cypress or Playwright. Because e2e testing covers a complete system, these tests would live in the src of the project as a whole.

QA testing, back and forth with QA team to make sure my feature meets the requirements specified in the user story.