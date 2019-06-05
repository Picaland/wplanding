<?php
/**
 * WpLanding
 *
 * Plugin Name: WpLanding
 * Plugin URI: https://alfiopiccione.com
 * Description: WpLanding
 * Version: 1.0.0
 * Author: alfiopiccione <alfio.piccione@gmail.com>
 * Author URI: https://alfiopiccione.com
 * License GPL 2 Text
 * Domain: wpl
 *
 * Copyright (C) 2019 alfiopiccione <alfio.piccione@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (! defined('AP_DEBUG')) {
    define('AP_DEBUG', 'dev');
}

// Define constant.
define('WPL_NAME', 'WpLanding');
define('WPL_NAME_TEMPLATE', 'WP Landing template');
define('WPL_TEXTDOMAIN', 'wpl');
define('WPL_VERSION', '1.0.0');
// Plugin DIR
define('WPL_PLUGIN_DIR', basename(plugin_dir_path(__FILE__)));
// Dirs
define('WPL_DIR', plugin_dir_path(__FILE__));
// Uri
define('WPL_URL', plugin_dir_url(__FILE__));

// Base Requirements.
require_once untrailingslashit(WPL_DIR . '/src/Plugin.php');
require_once untrailingslashit(WPL_DIR . '/requires.php');
require_once \WpLanding\Plugin::getPluginDirPath('/src/Autoloader.php');

// Setup Autoloader.
$loaderMap = include \WpLanding\Plugin::getPluginDirPath('/inc/autoloaderMapping.php');
$loader    = new \WpLanding\Autoloader();

$loader->addNamespaces($loaderMap);
$loader->register();

// Register the activation hook.
register_activation_hook(__FILE__, array('WpLanding\\Activate', 'activate'));
register_deactivation_hook(__FILE__, array('WpLanding\\Deactivate', 'deactivate'));

// Init
add_action('plugins_loaded', function () {
    // Load plugin text-domain.
    load_plugin_textdomain('wpl', false, '/' . WPL_PLUGIN_DIR . '/languages/');

    \WpLanding\PageTemplate::getInstance();

    $filters = array();

    // Global filter
    $filters = array_merge(
        $filters,
        include \WpLanding\Plugin::getPluginDirPath('/inc/filters.php')
    );
    // Admin filter
    if (is_admin()) {
        $filters = array_merge(
            $filters,
            include \WpLanding\Plugin::getPluginDirPath('/inc/filtersAdmin.php')
        );
    } // Front filter
    else {
        $filters = array_merge(
            $filters,
            include \WpLanding\Plugin::getPluginDirPath('/inc/filtersFront.php')
        );
    }

    // Loader init.
    $init = new WpLanding\Init(new WpLanding\Loader(), $filters);
    $init->init();
}, 20);
