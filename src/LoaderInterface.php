<?php
/**
 * LoaderInterface.php
 *
 * @since      1.0.0
 * @package    WpLanding
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

namespace WpLanding;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Class LoaderInterface
 *
 * @since  1.0.0
 * @author alfiopiccione <alfio.piccione@gmail.com>
 */
interface LoaderInterface
{
    /**
     * Add Filters
     *
     * @since  1.0.0
     *
     * @param array $haystack The instance containing the list of filters and their arguments.
     *
     * @return LoaderInterface The instance of chaining
     */
    public function addFilters(array $haystack);

    /**
     * Add Action
     *
     * @since  1.0.0
     *
     * @param string $context The context of the action. Allowed 'admin', 'front'.
     * @param string $args    Arguments.
     *
     * @return void
     */
    public function addAction($context, $args);

    /**
     * Add Filter
     *
     * @since  1.0.0
     *
     * @param string $context The context of the filter. Allowed 'admin', 'front'.
     * @param string $args    Arguments.
     *
     * @return void
     */
    public function addFilter($context, $args);

    /**
     * Add Filters based on context
     *
     * @since  1.0.0
     *
     * @throws \ErrorException If the $func parameter is not callable
     *
     * @return void
     */
    public function load();
}