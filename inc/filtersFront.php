<?php
/**
 * filtersFront.php
 *
 * @since      1.0.0
 * @package    ${NAMESPACE}
 * @author     alfiopiccione <alfio.piccione@gmail.com>
 * @copyright  Copyright (c) 2018, alfiopiccione
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2
 *
 * Copyright (C) 2018 alfiopiccione <alfio.piccione@gmail.com>
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

$resources = new \WpLanding\Resources();

//
//  array(
//      'filter'        => ''
//      'callback'      => ''
//      'priority'      => ''
//      'accepted_args' => ''
//  )
//

return apply_filters('wpl-filters_front', array(
    'front' => array(
        'action' => array(
            /**
             * Enqueue @since 1.0.0
             */
            array(
                'filter'   => array('wpl_head', 'wpl_footer'),
                'callback' => array($resources, 'customMethodResources'),
                'priority' => 20,
            ),

            /**
             * Edit landing link
             */
            array(
                'filter'   => 'wpl_footer',
                'callback' => function () {
                    if (current_user_can('edit_post', get_the_ID())) {
                        edit_post_link(
                            esc_html__('Edit', WPL_TEXTDOMAIN),
                            '<div id="wpl_edit_landing">',
                            '</div>',
                            get_the_ID(),
                            'wpl-edit-landing-link'
                        );
                    }
                },
                'priority' => 20,
            ),

        ),
        'filter' => array(),
    ),
));
