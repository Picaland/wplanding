<?php
/**
 * AcfFunctions.php
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

namespace WpLanding\Functions;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Get Field Helper
 *
 * @param $field
 * @param $option
 *
 * @return mixed|null
 */
function getField($field, $option)
{
    if (function_exists('get_field')) {

        // Theme option field
        if ('option' === $option) {
            return get_field($field, $option);
        }

        if (is_main_query()) {
            $option = get_the_ID();
        }

        if (is_home()) {
            $option = get_option('page_for_posts');
        }

        if (is_front_page()) {
            $option = get_option('page_on_front');
        }

        return get_field($field, $option);
    }

    return null;
}