<?php
/**
 * Resurces.php
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
 * Class Resources
 *
 * @since  1.0.0
 * @author alfiopiccione <alfio.piccione@gmail.com>
 */
final class Resources
{
    /**
     * Register
     *
     * @since 1.0.0
     */
    public function register()
    {
        // Styles
        $styles = include \WpLanding\Plugin::getPluginDirPath('/inc/styles.php');

        if (is_array($styles) && ! empty($styles)) {
            foreach ($styles as $style) {
                // Register.
                if (isset($style['register']) && true === $style['register']) {
                    wp_register_style(
                        $style['handle'],
                        $style['file'],
                        $style['deps'],
                        $style['ver'],
                        $style['media']
                    );
                }
            }
        }

        // Scripts
        $scripts = include \WpLanding\Plugin::getPluginDirPath('/inc/scripts.php');

        if (is_array($scripts) && ! empty($scripts)) {
            foreach ($scripts as $script) {
                // Register.
                if (isset($script['register']) && true === $script['register']) {
                    wp_register_script(
                        $script['handle'],
                        $script['file'],
                        $script['deps'],
                        $script['ver'],
                        $script['in_footer']
                    );
                }
            }
        }
    }

    /**
     * Enqueue
     *
     * @since 1.0.0
     */
    public function enqueue()
    {
        // Styles
        $styles = include \WpLanding\Plugin::getPluginDirPath('/inc/styles.php');

        if (is_array($styles) && ! empty($styles)) {
            foreach ($styles as $style) {
                if (isset($style['enqueue']) && true === $style['enqueue']) {
                    wp_enqueue_style(
                        $style['handle'],
                        $style['file'],
                        $style['deps'],
                        $style['ver'],
                        $style['media']
                    );
                } elseif (! isset($style['enqueue']) && ! isset($style['register'])) {
                    wp_enqueue_style(
                        $style['handle'],
                        $style['file'],
                        $style['deps'],
                        $style['ver'],
                        $style['media']
                    );
                }
            }
        }

        // Scripts
        $scripts = include \WpLanding\Plugin::getPluginDirPath('/inc/scripts.php');

        if (is_array($scripts) && ! empty($scripts)) {
            foreach ($scripts as $script) {
                if (isset($script['enqueue']) && true === $script['enqueue']) {
                    wp_enqueue_script(
                        $script['handle'],
                        $script['file'],
                        $script['deps'],
                        $script['ver'],
                        $script['in_footer']
                    );
                } elseif (! isset($script['enqueue']) && ! isset($script['register'])) {
                    wp_enqueue_script(
                        $script['handle'],
                        $script['file'],
                        $script['deps'],
                        $script['ver'],
                        $script['in_footer']
                    );
                }
            }
        }

        /**
         * After
         *
         * @since 1.0.0
         */
        do_action('chatbot_link-after_admin_enqueue_scripts');
    }

    /**
     * Localize Scripts
     *
     * @since 1.0.0
     */
    public function localizeScript()
    {
        // Localized Scripts
        $scripts = include \WpLanding\Plugin::getPluginDirPath('/inc/localizeScripts.php');

        if (is_array($scripts) && ! empty($scripts)) {
            foreach ($scripts as $handle => $data) {
                if (wp_script_is($handle, 'registered') && wp_script_is($handle, 'enqueued')) {
                    wp_localize_script(
                        $handle,
                        $handle,
                        $data
                    );
                }
            }
        }
    }

    /**
     * Custom method
     */
    public function customMethodResources()
    {
        $currentFilter = current_filter();

        // Style
        $styles = include \WpLanding\Plugin::getPluginDirPath('/inc/customStyles.php');

        if (is_array($styles) && ! empty($styles)) {
            foreach ($styles as $style) {
                if ($currentFilter === $style['position']) {
                    $media = isset($style['media']) ? $style['media'] : 'all';

                    $pathInfo  = pathinfo($style['file']);
                    $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : 'css';

                    if (file_exists(Plugin::getPluginDirPath('/assets/css') . '/' . $pathInfo['filename'] . '.min.' . $extension)) {
                        $file = Plugin::getPluginDirUrl('/assets/css') . '/' . $pathInfo['filename'] . '.min.' . $pathInfo['extension'];
                    } else {
                        $file = $style['file'];
                    }

                    echo "<link id='{$style['handle']}-css' rel='stylesheet' href='{$file}?{$style['ver']}' type='text/css' media='{$media}'/>\n";
                }
            }
        }

        // Scripts
        $scripts = include \WpLanding\Plugin::getPluginDirPath('/inc/customScripts.php');

        if (is_array($scripts) && ! empty($scripts)) {
            foreach ($scripts as $script) {
                if ($currentFilter === $script['position']) {

                    $pathInfo  = pathinfo($script['file']);
                    $extension = isset($pathInfo['extension']) ? $pathInfo['extension'] : 'js';

                    if (file_exists(Plugin::getPluginDirPath('/assets/css') . '/' . $pathInfo['filename'] . '.min.' . $extension)) {
                        $file = Plugin::getPluginDirUrl('/assets/css') . '/' . $pathInfo['filename'] . '.min.' . $pathInfo['extension'];
                    } else {
                        $file = $script['file'];
                    }

                    // Localized scripts
                    if (! empty($script['localize'])) {
                        $data = json_encode($script['localize']['script'], true);
                        echo "<script type='text/javascript'>\n/* <![CDATA[ */\n";
                        echo $script['localize']['var'] . " = {$data}\n";
                        echo "/* ]]> */</script>\n";
                    }

                    echo "<script type='text/javascript' id='{$script['handle']}-script' src='{$file}?{$script['ver']}'></script>\n";
                }
            }
        }
    }
}
