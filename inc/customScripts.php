<?php
/**
 * customScripts.php
 *
 * @since      ${SINCE}
 * @package    ${NAMESPACE}
 * @author     alfiopiccione <alfio.piccione@gmail.com>
 * @copyright  Copyright (c) 2019, alfiopiccione
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2
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

$scripts = array();

// Get the Environment.
$dev = ! ! ('dev' === AP_DEBUG);

/**
 * This is a custom method for enqueue scripts
 */
if (! is_admin() && is_page_template('templates/wpl.php')) {
    $scripts = array_merge($scripts, array(
        // Head
        array(
            'handle'   => 'wpl-jquery',
            'file'     => 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'position' => 'wpl_footer',
            'async'    => true,
        ),
        array(
            'handle'   => 'wpl-owl',
            'file'     => \WpLanding\Plugin::getPluginDirUrl('assets/owl/owl.carousel.min.js'),
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'position' => 'wpl_footer',
            'async'    => true,
        ),
        array(
            'handle'   => 'wpl-main',
            'file'     => \WpLanding\Plugin::getPluginDirUrl('assets/js/wpl.js'),
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'position' => 'wpl_footer',
            'async'    => true,
        ),
    ));
}

// Include CF7 scripts
if (class_exists('WPCF7') && file_exists(wpcf7_plugin_path('includes/js/scripts.js'))) {
    $scripts[] = array(
        'handle'   => 'wpl-jquery',
        'file'     => wpcf7_plugin_url('includes/js/scripts.js'),
        'deps'     => array(),
        'ver'      => $dev ? time() : WPL_VERSION,
        'position' => 'wpl_footer',
        'localize' => array(
            'var'    => 'wpcf7',
            'script' => array(
                'apiSettings' => array(
                    'root'      => esc_url_raw(rest_url('contact-form-7/v1')),
                    'namespace' => 'contact-form-7/v1',
                ),
            ),
        ),
    );

    // support for WP_CACHE
    if (defined('WP_CACHE') and WP_CACHE) {
        $scripts['localize']['script']['cached'] = 1;
    }
}

return apply_filters('wpl-custom-scripts_list', $scripts);
