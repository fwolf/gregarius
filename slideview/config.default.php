<?php
/**
 * Configure file
 *
 * Usage:
 *  1. Copy to a new file named 'config.php'
 *  2. (Optional)Remove code outside of 'Config define area'
 *  3. Change defines
 *  4. (Optional)Remove defines no change needed
 *
 * For defines which need compute to get final result:
 *  1. Remove from 'config.php', use compute job in 'config.default.php'
 *  2. Do compute in 'config.php'
 *
 * DO NOT MODIFY 'config.default.php' DIRECTLY.
 *
 * @package     Fwlib
 * @subpackage  Core
 * @copyright   Copyright © 2013, Fwolf
 * @author      Fwolf <fwolf.aide+fwlib@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL v3
 * @since       2013-07-26
 */


// Init global config array
if ('config.default.php' == basename(__FILE__)) {
    $config = array();


    // Load user config if exists
    if (file_exists(__DIR__ . '/config.php')) {
        require __DIR__ . '/config.php';
    }
    $configUser = $config;


/*
    // Load requirement lib autoload file
    // Fwlib
    if (!isset($config['lib.path.fwlib'])) {
        $config['lib.path.fwlib'] = 'fwlib/';
    }
    require $config['lib.path.fwlib'] . 'autoload.php';
*/
    define('FWOLFLIB', 'fwlib/');
}


/***********************************************************
 * Config define area
 *
 * Use $configUser to compute value if needed.
 *
 * In config.php, code outside this area can be removed.
 **********************************************************/





/***********************************************************
 * Config define area end
 **********************************************************/


// Merge user and default config
if ('config.default.php' == basename(__FILE__)) {
    $config = array_merge($config, $configUser);

    // Deal with $config with Config class or use as global
}
