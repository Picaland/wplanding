<?php
/**
 * PageTemplate.php
 *
 * @since      ${SINCE}
 * @package    WpLanding
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

namespace WpLanding;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Class Page Template
 *
 * @since  ${SINCE}
 * @author alfiopiccione <alfio.piccione@gmail.com>
 */
class PageTemplate
{
    /**
     * Instance of this class.
     */
    private static $instance;

    /**
     * The array of templates.
     */
    protected $templates = array();

    /**
     * Returns an instance of this class.
     *
     * @return PageTemplate
     */
    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * PageTemplate constructor.
     *
     * Initializes the plugin by setting filters and administration functions.
     */
    private function __construct()
    {
        // Add a filter to the attributes metabox to inject template into the cache.
        if (version_compare(floatval(get_bloginfo('version')), '4.7', '<')) {
            // 4.6 and older
            add_filter(
                'page_attributes_dropdown_pages_args',
                array($this, 'registerProjectTemplates')
            );
        } else {
            // Add a filter to the wp 4.7 version attributes metabox
            add_filter(
                'theme_page_templates',
                array($this, 'addNewTemplate')
            );
        }

        // Add a filter to the save post to inject out template into the page cache
        add_filter(
            'wp_insert_post_data',
            array($this, 'registerProjectTemplates')
        );

        // Add a filter to the template include to determine if the page has our
        // template assigned and return it's path
        add_filter(
            'template_include',
            array($this, 'viewProjectTemplate')
        );

        // Add templates in array.
        $this->templates = array(
            'templates/wpl.php' => WPL_NAME_TEMPLATE,
        );
    }

    /**
     * Adds our template to the page dropdown for v4.7+
     *
     * @param $postTemplates
     *
     * @return array
     */
    public function addNewTemplate($postTemplates)
    {
        $postTemplates = array_merge($postTemplates, $this->templates);

        return $postTemplates;
    }

    /**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists where it doens't really exist.
     *
     * @param $atts
     *
     * @return mixed
     */
    public function registerProjectTemplates($atts)
    {
        // Create the key used for the themes cache
        $cacheKey = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());

        // Retrieve the cache list.
        // If it doesn't exist, or it's empty prepare an array
        $templates = wp_get_theme()->get_page_templates();

        if (empty($templates)) {
            $templates = array();
        }

        // New cache, therefore remove the old one
        wp_cache_delete($cacheKey, 'themes');

        // Now add our template to the list of templates by merging our templates
        // with the existing templates array from the cache.
        $templates = array_merge($templates, $this->templates);

        // Add the modified cache to allow WordPress to pick it up for listing
        // available templates
        wp_cache_add($cacheKey, $templates, 'themes', 1800);

        return $atts;
    }

    /**
     * Checks if the template is assigned to the page
     *
     * @param $template
     *
     * @return string
     */
    public function viewProjectTemplate($template)
    {
        // Return the search template if we're searching (instead of the template for the first result)
        if (is_search()) {
            return $template;
        }

        // Get global post
        $post = get_post();

        // Return template if post is empty
        if (! $post) {
            return $template;
        }

        // Return default template if we don't have a custom one defined
        if (! isset($this->templates[get_post_meta(
                $post->ID,
                '_wp_page_template',
                true
            )])
        ) {
            return $template;
        }

        /**
         *  Allows filtering of file path
         */
        $filePath = apply_filters('wpl-page_template_plugin_dir_path', plugin_dir_path(__DIR__));

        $file = $filePath . get_post_meta(
                $post->ID, '_wp_page_template', true
            );

        // Just to be safe, we check if the file exist first
        if (file_exists($file)) {
            return $file;
        } else {
            echo $file;
        }

        // Return template
        return $template;
    }
}
