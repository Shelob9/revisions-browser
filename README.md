# revisions-browser
Front-end revision browser via REST API proof of concept.

Requires: REST API Version 2.0-beta15

What this does: adds revisions browsing link to top of post when looking at single post and you can edit, with next/previous links.

Notes, beacuse this is a quick proof of concept and I need to move on for the day:
* Disable `WP_DEBUG` if using 2.0-beta15, if you pull latest from Github, the issue I'm worried about is fixed: https://github.com/WP-API/WP-API/issues/2836
* Click the next revision to go to first revision (maybe prev/next should be reversed)
* I didn't get fancy and disable previous/ next links when there is nothing to naviagate to. Pull requests welcome.
* This UI looks bad. Pull request welcome.
