<?php
/**
 * customStyles.php
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

$styles = array();

// Get the Environment.
$dev = ! ! ('dev' === AP_DEBUG);

/**
 * This is a custom method for enqueue styles
 */
if (! is_admin() && is_page_template('templates/wpl.php')) {
    $styles = array_merge($styles, array(
        // Head
        array(
            'handle'   => 'wpl-atd_style',
            'file'     => \WpLanding\Plugin::getPluginDirUrl('assets/css/atf.css'),
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'media'    => 'all',
            'position' => 'wpl_head',
        ),
        // Footer
        array(
            'handle'   => 'wpl-font_style',
            'file'     => 'https://fonts.googleapis.com/css?family=Libre+Baskerville:400,700|Open+Sans:400,700',
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'media'    => 'all',
            'position' => 'wpl_footer',
        ),
        array(
            'handle'   => 'wpl-fa_icon_style',
            'file'     => 'https://use.fontawesome.com/releases/v5.6.1/css/all.css',
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'media'    => 'all',
            'position' => 'wpl_footer',
        ),
        array(
            'handle'   => 'wpl-main_style',
            'file'     => \WpLanding\Plugin::getPluginDirUrl('assets/css/wpl.css'),
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'media'    => 'all',
            'position' => 'wpl_footer',
        ),
        array(
            'handle'   => 'wpl-owl',
            'file'     => \WpLanding\Plugin::getPluginDirUrl('assets/owl/owl.carousel.min.css'),
            'deps'     => array(),
            'ver'      => $dev ? time() : WPL_VERSION,
            'media'    => 'all',
            'position' => 'wpl_footer',
        ),
    ));
}

return apply_filters('wpl-custom-styles_list', $styles);
