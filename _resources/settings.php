<?php

/*
 * Hi there! Thanks for buying Comprevise.
 * 
 * This is the only file you should ever have to touch in
 * order to customize Comprevise to your liking.
 */
 
/* THEME */

// One of 'dark', 'dark-serif', 'dark-shiny', 'light', 'light-serif', 'light-shiny'.
define('CR_THEME', 'light');
// Sort concepts revisions either by last modified date (last_changed) or 
// alphabetically (alphabetical).
define('CR_SORT_ORDER', 'alphabetical');
// Automatically show or hide the navigational menu based on your cursor, 
// either 'yes' or 'no'.
define('CR_ANIMATE', 'yes');
// Position the navigational menu either at the top of your browser, or 
// at the bottom. Specify 'no' to disable the menu.
define('CR_NAV_POSITION', 'bottom');

/* TECHNICAL STUFF */

// You can turn debugging to troubleshoot the app.
// This should be false when Comprevise is
// used in a production environment.
define('CR_DEBUG', false);
// If Comprevise doesn't live at the domain root, and
// clean urls are giving you grief, add in the subdirectory. 
// For example, if the app is available at 
// http://yourdomain.com/concepts, specify '/concepts' as the 
// base url.
// Most servers and hosts won't need this, so leave it blank
// unless you know what you're doing.
define('CR_BASE_URL_OVERRIDE', NULL);
