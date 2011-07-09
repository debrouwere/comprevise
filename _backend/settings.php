<?php

/*
 * Hi there! Thanks for buying Comprevise.
 * 
 * If you're looking for a way to configure the app, 
 * _settings.ini in the main directory is what you're 
 * looking for. This file is just plumbing, and best 
 * left as-is.
 */

$config = parse_ini_file('../_settings.ini', true);
 
/* THEME */

define('CR_THEME', $config['settings']['THEME']);
define('CR_SORT_ORDER', $config['settings']['SORT_ORDER']);
define('CR_ANIMATE', $config['settings']['ANIMATE']);
define('CR_NAV_POSITION', $config['settings']['NAV_POSITION']);
define('CR_ALIGNMENT', $config['settings']['ALIGNMENT']);
define('CR_PASSWORD', $config['settings']['PASSWORD']);

/* TECHNICAL STUFF */

define('CR_DEBUG', !!$config['plumbing']['DEBUG']);
define('CR_BASE_URL_OVERRIDE', $config['plumbing']['BASE_URL_OVERRIDE']);

/* CLIENT-SPECIFIC STUFF */

unset($config['settings']);
unset($config['plumbing']);

$CR_SETTINGS = $config;