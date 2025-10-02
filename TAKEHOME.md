## How the Solution Works

I inserted the component through the Template.pageFooter hook in QuickStats.php. I used a vue-entry on a div element to load the plugin.

The plugin works by placing a button in the footer element. When the button is pressed, the API is queried for the statistics, which is shown in a table on the modal.

## Key Architectural / Design Decisions
Reuse of methods and components made available in Matomo, no need to reinvent the wheel. It also enforces consistency across the UI.

I assumed if a user has no view access or they are on the login module, then the quick stats button should not show.

## Setup / Configuration
No dependencies added, just make sure the plugin is built.

`ddev matomo:console vue:build QuickStats`

## Potential Improvements
- Delay loading until page content has loaded
- Refresh button to pull data again
- 

## UI Tests
UI tests have been added, I've added one that checks for the button on the screen, and one that checks the modal will load.

I'm not sure if the environment was setup correctly but I had to edit some config files to get the tests running.