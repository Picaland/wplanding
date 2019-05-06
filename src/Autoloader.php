<?php
/**
 * Autoloader.php
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

namespace WpLanding;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Class Autoloader
 *
 * @link    http://www.php-fig.org/psr/psr-4/
 * @link    https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
 */
final class Autoloader
{
    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     *
     * @var array
     */
    protected $prefixes = array();

    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @since  1.0.0
     * @access public
     *
     * @param string $prefix        The namespace prefix.
     * @param string $relativeClass The relative class name.
     *
     * @return mixed Boolean false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
    protected function loadMappedFile($prefix, $relativeClass)
    {
        // Are there any base directories for this namespace prefix?
        if (false === isset($this->prefixes[$prefix])) {
            return false;
        }

        // Set the base dir path.
        $base_dir = $this->prefixes[$prefix];
        // Remove the prefix from the relative class name.
        $relativeClass = str_replace($prefix, '', $relativeClass);
        // Build the file path.
        $file = $base_dir . str_replace('\\', '/', $relativeClass) . '.php';

        // Get the absoluted path of the file class.
        $file = Plugin::getPluginDirPath($file);

        // If the mapped file exists, require it.
        if ($this->requireFile($file)) {
            // Yes, we're done.
            return $file;
        }

        // Never found it.
        return false;
    }

    /**
     * If a file exists, require it from the file system.
     *
     * @since  1.0.0
     * @access public
     *
     * @param string $file The file to require.
     *
     * @return bool True if the file exists, false if not.
     */
    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;

            return true;
        }

        return false;
    }

    /**
     * Register loader with SPL auto-loader stack.
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Add NameSpaces
     *
     * Add multiple namespaces at once
     *
     * @since  1.0.0
     * @access public
     *
     * @param array $array The list of the namespaces to add.
     *
     * @return void
     */
    public function addNamespaces(array $array)
    {
        foreach ($array as $ns => $path) {
            $this->addNamespace($ns, $path);
        }
    }

    /**
     * Adds a base directory for a namespace prefix.
     *
     * @since  1.0.0
     * @access public
     *
     * @param string $prefix   The namespace prefix.
     * @param string $baseDir  A base directory for class files in the
     *                         namespace.
     *
     * @return void
     */
    public function addNamespace($prefix, $baseDir)
    {
        // Normalize namespace prefix.
        $prefix = trim($prefix, '\\') . '\\';

        // Normalize the base directory with a trailing separator.
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';

        // Initialize the namespace prefix array.
        if (false === isset($this->prefixes[$prefix])) {
            $this->prefixes[$prefix] = array();
        }

        $this->prefixes[$prefix] = $baseDir;
    }

    /**
     * Loads the class file for a given class name.
     *
     * @since  1.0.0
     * @access public
     *
     * @param string $class The fully-qualified class name.
     *
     * @return mixed The mapped file name on success, or boolean false on
     * failure.
     */
    public function loadClass($class)
    {
        $mapped = false;

        foreach ($this->prefixes as $prefix => $path) {
            if (false !== strpos($class, $prefix)) {
                $mapped = $this->loadMappedFile($prefix, $class);
                break;
            }
        }

        return $mapped;
    }
}
