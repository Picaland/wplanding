<?php
/**
 * Loader.php
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
 * Class Loader
 *
 * @since  1.0.0
 * @author alfiopiccione <alfio.piccione@gmail.com>
 */
class Loader implements LoaderInterface
{
    /**
     * Actions
     *
     * The actions hooks
     *
     * @since  1.0.0
     *
     * @var array A list of actions
     */
    private $actions;

    /**
     * Filters
     *
     * The filters hooks
     *
     * @since  1.0.0
     *
     * @var array A list of filters
     */
    private $filters;

    /**
     * Construct
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->actions = array();
        $this->filters = array();
    }

    /**
     * Clean the Collection
     *
     * Avoid add same filters multiple times.
     *
     * @since  1.0.0
     *
     * @return void
     */
    private function clean()
    {
        $this->filters = array();
        $this->actions = array();
    }

    /**
     * Add Filters / Actions
     *
     * @param array    $filters The filters to add.
     * @param callable $func    The function to call. 'add_action' or 'add_filter'
     *
     * @return void
     */
    private function add($filters, $func)
    {
        foreach ($filters as $args) {
            $priority     = isset($args['priority']) ? absint($args['priority']) : 20;
            $acceptedArgs = isset($args['accepted_args']) ? absint($args['accepted_args']) : 1;

            if (is_array($args['filter'])) {
                foreach ($args['filter'] as $filter) {
                    $this->add(array(
                        array(
                            'filter'        => $filter,
                            'callback'      => $args['callback'],
                            'priority'      => $priority,
                            'accepted_args' => $acceptedArgs,
                        ),
                    ), $func);
                }
            } else {
                $func($args['filter'], $args['callback'], $priority, $acceptedArgs);
            }
        }
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
     * Add Filters
     *
     * @since  1.0.0
     *
     * @param array $haystack The instance containing the list of filters and their arguments.
     *
     * @return LoaderInterface The instance of chaining
     */
    public function addFilters(array $haystack)
    {
        foreach ($haystack as $context => $filters) {
            foreach ($filters as $type => $args) {
                foreach ($args as $arg) {
                    $method = 'add' . ucfirst($type);
                    $this->{$method}($context, $arg);
                }
            }
        }

        return $this;
    }

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
    public function addAction($context, $args)
    {
        $this->actions[$context][] = $args;
    }

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
    public function addFilter($context, $args)
    {
        $this->filters[$context][] = $args;
    }

    /**
     * Add Filters based on context
     *
     * @since  1.0.0
     *
     * @throws \ErrorException If the $func parameter is not callable
     *
     * @return void
     */
    public function load()
    {
        // Add the shared filters.
        if (! empty($this->actions['inc'])) {
            $this->add($this->actions['inc'], 'add_action');
        }

        if (! empty($this->filters['inc'])) {
            $this->add($this->filters['inc'], 'add_filter');
        }

        // Get the context of filters.
        $context = is_admin() ? 'admin' : 'front';

        // Add the filters based on context.
        if (! empty($this->actions[$context])) {
            $this->add($this->actions[$context], 'add_action');
        }
        if (! empty($this->filters[$context])) {
            $this->add($this->filters[$context], 'add_filter');
        }

        // Additional Ajax Filters if needed.
        if (! empty($this->actions['ajax'])) {
            $this->add($this->actions['ajax'], 'add_action');
        }

        // Be sure to clean the collection to prevent add filters multiple time.
        $this->clean();
    }
}
