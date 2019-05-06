<?php
/**
 * Init.php
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
 * Class Init
 *
 * @since  1.0.0
 * @author alfiopiccione <alfio.piccione@gmail.com>
 */
class Init
{
    /**
     * Register
     *
     * @since  1.0.0
     *
     * @var Loader The register instance
     */
    private $loader;

    /**
     * Filters
     *
     * @since  1.0.0
     *
     * @var array A list of filters and their callbacks
     */
    private $filters;

    /**
     * Construct
     *
     * @since  1.0.0
     *
     * @throws \Exception In case the init has been performed.
     *
     * @param LoaderInterface $loader  The loader to use during the init.
     * @param array           $filters The filters for back-end.
     */
    public function __construct(LoaderInterface $loader, array $filters)
    {
        $this->loader  = $loader;
        $this->filters = $filters;
    }

    /**
     * Prevent Deserialization
     *
     * Serialized version of this class is prohibited.
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function __wakeup()
    {
        trigger_error(esc_html__('Cheatin&#8217; huh?', CWPL_TEXTDOMAIN), E_USER_ERROR);
    }

    /**
     * Prevent Cloning
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function __clone()
    {
        trigger_error(esc_html__('Cheatin&#8217; huh?', CWPL_TEXTDOMAIN), E_USER_ERROR);
    }

    /**
     * Init
     *
     * @since  1.0.0
     *
     * @throws \Exception In case the init has been performed.
     *
     * @return void
     */
    public function init()
    {
        // Add Filters.
        $this->loader->addFilters($this->filters)
                     ->load();
    }
}