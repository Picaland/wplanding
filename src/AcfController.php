<?php
/**
 * AcfController.php
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

use WpLanding\Functions as F;

/**
 * Class AcfController
 *
 * @since  ${SINCE}
 * @author alfiopiccione <alfio.piccione@gmail.com>
 */
class AcfController
{
    /**
     * Get Fields Adapter
     *
     * @param        $fieldKey
     * @param bool   $echo
     * @param string $option
     * @param string $default
     *
     * @return string|null
     */
    public static function getFields($fieldKey, $echo = true, $option = '', $default = '')
    {
        if (! $fieldKey) {
            return null;
        }

        $value = F\getField($fieldKey, $option);

        if (! $value) {
            if ('' === $default) {
                return null;
            } else {
                return $default;
            }
        }

        if (! $echo) {
            return $value;
        }

        if (is_array($value) && $echo) {
            return $value;
        }

        echo $value;
    }

    /**
     * addImage
     *
     * @return string|null
     */
    public static function logo()
    {
        $logo = self::getFields('header-logo', false, '', array());
        $logo = ! empty($logo) && is_array($logo) ? $logo['sizes']['large'] : '#';

        return esc_url($logo);
    }

    /**
     * addColorPicker
     * addImage
     * addNumber
     *
     * @param bool $style
     *
     * @return object
     */
    public static function heroBackground($style = true)
    {
        $heroBackgroundColor  = self::getFields('header-hero-bgcolor', false, '', '#fff');
        $heroBackgroundImage  = self::getFields('header-hero-bg', false, '', array());
        $heroBackgroundHeight = self::getFields('header-hero-height', false, '', '');
        $heroBackgroundHeight = null === $heroBackgroundHeight ? '100%' : "{$heroBackgroundHeight}px";
        // Height
        $height = '100%' === $heroBackgroundHeight ? 'height:100vh;' : '';

        $heroBackgroundImage = ! empty($heroBackgroundImage) && is_array($heroBackgroundImage) ?
            $heroBackgroundImage['sizes']['large'] : '#';

        // Initialized data
        $data = new \stdClass();

        if ($style) {
            $heroBackground = "{$height}min-height:{$heroBackgroundHeight};background:{$heroBackgroundColor} url({$heroBackgroundImage}) no-repeat scroll bottom center;background-size:cover;";
            $data->style    = "<style id='hero-style'>.wpl-hero{{$heroBackground}}</style>";
        } else {
            $data->style = array(
                'min-height' => $heroBackgroundHeight,
                'bg-color'   => $heroBackgroundColor,
                'image'      => $heroBackgroundImage,
            );
        }

        return $data;
    }

    /**
     * addWysiwyg
     *
     * @return string|null
     */
    public static function heroText()
    {
        $heroText = self::getFields('header-text', false, '', '');

        return wp_kses_post($heroText);
    }

    /**
     * addText
     *
     * @return string|null
     */
    public static function heroCtaText()
    {
        $heroCtaText = self::getFields('header-button-text', false, '', '');

        return esc_html($heroCtaText);
    }

    /**
     * addText
     *
     * @return string|null
     */
    public static function heroCtaUrl()
    {
        $heroCtaUrl = self::getFields('header-button-url', false, '', '#');

        return esc_url($heroCtaUrl);
    }

    /**
     * addWysiwyg
     *
     * @return string|null
     */
    public static function serviceHeaderText()
    {
        $serviceHeaderText = self::getFields('services-header-text', false, '', '');

        return wp_kses_post($serviceHeaderText);
    }

    /**
     * addNumber
     * addRepeater:
     * - addImage
     * - addText
     * - addWysiwyg
     *
     * @param bool $echo
     *
     * @return bool
     */
    public static function servicesList($echo = true)
    {
        $fields = self::getFields('services-repeater', false, '', array());
        $cols   = self::getFields('services-repeater-cols', false, '', 4);

        switch (intval($cols)) {
            case 3 :
                $clear = 4;
                break;
            case 4 :
                $clear = 3;
                break;
            case 6 :
                $clear = 2;
                break;
            default:
                $clear = 2;
                break;
        }

        if (is_array($fields) && empty($fields)) {
            return false;
        }

        $i = 0;
        if ($echo) {
            if (! empty($fields) && is_array($fields)) :
                echo '<div class="row service-lists">';
                foreach ($fields as $key => $service) :
                    $i++;
                    echo sprintf('<div class="col-md-%s"><div class="service-card">%s %s %s</div></div>',
                        $cols,
                        "<div class='service-icon'><img src='{$service['service-icon']['sizes']['large']}'></div>",
                        "<div class='service-title'><h4>{$service['service-title']}</h4></div>",
                        "<div class='service-text'>{$service['service-text']}</div>"
                    );

                    if ($i % intval($clear) === 0) {
                        echo '<div class="clearfix"></div>';
                    }
                endforeach;
                echo '</div>';
            endif;
        } else {
            return ! empty($fields) && is_array($fields) ? true : false;
        }
    }

    /**
     * addImage
     *
     * @return string
     */
    public static function centerPageImageUrl()
    {
        $centerPageImage = self::getFields('center-page-image', false, '', array());

        $centerPageImage = ! empty($centerPageImage) && is_array($centerPageImage) ?
            $centerPageImage['sizes']['large'] : '#';

        return esc_url($centerPageImage);
    }

    /**
     * addText
     *
     * @return string|null
     */
    public static function centerPageTitle()
    {
        $centerPageTitle = self::getFields('center-page-title', false, '', '');

        return wp_kses($centerPageTitle, array('br' => true));
    }

    /**
     * addWysiwyg
     *
     * @return string|null
     */
    public static function centerPageText()
    {
        $centerPageText = self::getFields('center-page-text', false, '', '');

        return wp_kses_post($centerPageText);
    }

    /**
     * addText
     *
     * @return string
     */
    public static function centerPageImageAfterTextUrl()
    {
        $centerPageImageAfterTextUrl = self::getFields('center-page-image-button', false, '', array());

        $centerPageImageAfterTextUrl = ! empty($centerPageImageAfterTextUrl) && is_array($centerPageImageAfterTextUrl) ?
            $centerPageImageAfterTextUrl['sizes']['large'] : '#';

        return esc_url($centerPageImageAfterTextUrl);
    }

    /**
     * addWysiwyg
     *
     * @return string|null
     */
    public static function benefitsHeaderText()
    {
        $benefitsHeaderText = self::getFields('benefits-header-text', false, '', '');

        return wp_kses_post($benefitsHeaderText);
    }

    /**
     * addText
     *
     * @return string|null
     */
    public static function benefitsCtaText()
    {
        $benefitsCtaText = self::getFields('benefits-button-text', false, '', '');

        return esc_html($benefitsCtaText);
    }

    /**
     * addText
     *
     * @return string|null
     */
    public static function benefitsCtaUrl()
    {
        $benefitsCtaUrl = self::getFields('benefits-button-url', false, '', '#');

        return esc_url($benefitsCtaUrl);
    }

    /**
     * addRepeater:
     * - addWysiwyg
     *
     * @param bool $echo
     *
     * @return bool
     */
    public static function benefitsList($echo = true)
    {
        $fields = self::getFields('benefits-repeater', false, '', array());

        if (is_array($fields) && empty($fields)) {
            return false;
        }

        $i = 0;
        if ($echo) {
            if (! empty($fields) && is_array($fields)) :
                echo '<ul class="benefit-lists">';
                foreach ($fields as $key => $benefit) :
                    $i++;
                    echo sprintf(
                        '<li class="benefit-item"><div class="benefit">%s</div></li>',
                        $benefit['benefits-item']);
                endforeach;
                echo '</ul>';
            endif;
        } else {
            return ! empty($fields) && is_array($fields) ? true : false;
        }
    }

    /**
     * addText
     *
     * @return string
     */
    public static function testimonialsTitle()
    {
        $testimonialsTitle = self::getFields('testimonials-title', false, '', '');

        return wp_kses($testimonialsTitle, array('br' => true));
    }

    /**
     * addRepeater:
     * - addImage
     * - addText
     * - addWysiwyg
     *
     * @param bool $echo
     *
     * @return bool
     */
    public static function testimonialsList($echo = true)
    {
        $fields = self::getFields('testimonials-repeater', false, '', array());

        if (is_array($fields) && empty($fields)) {
            return false;
        }

        $i = 0;
        if ($echo) {
            if (! empty($fields) && is_array($fields)) :
                echo '<div id="testimonials-list" class="owl-carousel">';
                foreach ($fields as $key => $testimonial) :
                    $i++;
                    echo sprintf(
                        '<div class="item"><div class="testimonial">%s <div class="testimonial-card">%s</div></div></div>',
                        "<div class='testimonials-avatar'><img src='{$testimonial['testimonials-avatar']['sizes']['large']}' alt='avatar'></div>",
                        "<div class='testimonial-item-text'>{$testimonial['testimonials-text']}" .
                        "<cite class='testimonial-item-name'>{$testimonial['testimonials-name']}</cite></div>"
                    );
                endforeach;
                echo '</div>';
            endif;
        } else {
            return ! empty($fields) && is_array($fields) ? true : false;
        }
    }

    /**
     * addColorPicker
     * addImage
     * addNumber
     *
     * @param bool $style
     *
     * @return object
     */
    public static function testimonialsBackground($style = true)
    {
        $testimonialsBackgroundColor = self::getFields('testimonials-bgcolor', false, '', '#fff');
        $testimonialsBackgroundImage = self::getFields('testimonials-bg', false, '', array());

        $testimonialsBackgroundImage = ! empty($testimonialsBackgroundImage) && is_array($testimonialsBackgroundImage) ?
            $testimonialsBackgroundImage['sizes']['large'] : '#';

        // Initialized data
        $data = new \stdClass();

        if ($style) {
            $testimonialsBackground = "background:{$testimonialsBackgroundColor} url({$testimonialsBackgroundImage}) no-repeat scroll top center;background-size:cover;";
            $data->style            = "<style id='testimonials-style'>.wpl-testimonials{{$testimonialsBackground}}</style>";
        } else {
            $data->style = array(
                'bg-color' => $testimonialsBackgroundColor,
                'image'    => $testimonialsBackgroundImage,
            );
        }

        return $data;
    }

    /**
     * @param bool $style
     *
     * @return \stdClass
     */
    public static function footerBackground($style = true)
    {
        $footerBackgroundColor = self::getFields('footer-bgcolor', false, '', '#fff');
        $footerColor           = self::getFields('footer-text-color', false, '', '#fff');
        $footerBackgroundImage = self::getFields('footer-bg', false, '', array());

        $footerBackgroundImage = ! empty($footerBackgroundImage) && is_array($footerBackgroundImage) ?
            $footerBackgroundImage['sizes']['large'] : '#';

        // Initialized data
        $data = new \stdClass();

        if ($style) {
            $footerBackground = "background: {$footerBackgroundColor} url({$footerBackgroundImage}) no-repeat scroll top center;background-size:cover;";
            $data->style      = "<style id='footer-style'>" .
                                ".wpl-footer{{$footerBackground}}" .
                                ".wpl-footer .wpl-footer-title, .wpl-footer .wpl-footer-left * {color:{$footerColor}!important;}" .
                                ".wpl-footer .wpl-footer-right * {color:{$footerColor}" .
                                "</style>";
        } else {
            $data->style = array(
                'color'    => $footerColor,
                'bg-color' => $footerBackgroundColor,
                'image'    => $footerBackgroundImage,
            );
        }

        return $data;
    }

    /**
     * addText
     *
     * @return string
     */
    public static function footerTitle()
    {
        $footerTitle = self::getFields('footer-title', false, '', '');

        return wp_kses($footerTitle, array('br' => true));
    }

    /**
     * addWysiwyg
     *
     * @return string|null
     */
    public static function footerLeft()
    {
        $footerLeft = self::getFields('footer-left', false, '', '');

        return wp_kses_post($footerLeft);
    }

    /**
     * addWysiwyg
     *
     * @return string|null
     */
    public static function footerRight()
    {
        $footerRight = self::getFields('footer-right', false, '', '');

        // Use apply filter for render short-code
        return apply_filters('the_content', $footerRight);
    }

    /**
     * addText
     *
     * @return string
     */
    public static function colophon()
    {
        $colophon = self::getFields('colophon-text', false, '', '');

        return wp_kses($colophon,
            array(
                'a'  => array(
                    'href'   => true,
                    'target' => true,
                    'class'  => true,
                ),
                'br' => true,
            )
        );
    }
}
