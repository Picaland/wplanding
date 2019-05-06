<?php
/**
 * acf-template-fields.php
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

use StoutLogic\AcfBuilder\FieldsBuilder;

// Initialized acf fields
$acfFields = array();

// Set Location Fields ----------------------------------------------------------------------------------------------- //
$wpLanding = new FieldsBuilder('wpl_landing', array('title' => esc_html__('Wp Landing options', WPL_TEXTDOMAIN)));
$wpLanding->setLocation('page_template', '==', 'templates/wpl.php');

// Header Fields ----------------------------------------------------------------------------------------------------- //
$header = new FieldsBuilder('header', array('title' => esc_html__('Header', WPL_TEXTDOMAIN)));
$header->addTab('Header Hero', ['placement' => 'left'])
       ->addImage('header-logo', ['label' => esc_html__('Logo', WPL_TEXTDOMAIN)])
       ->setInstructions(esc_html__('Add the image logo for this page', WPL_TEXTDOMAIN))
       ->addColorPicker('header-hero-bgcolor', ['label' => esc_html__('Hero background color', WPL_TEXTDOMAIN)])
       ->setInstructions(esc_html__('Set the hero background color', WPL_TEXTDOMAIN))
       ->addImage('header-hero-bg', ['label' => esc_html__('Hero background image', WPL_TEXTDOMAIN)])
       ->setInstructions(esc_html__('Add the hero background image', WPL_TEXTDOMAIN))
       ->addNumber('header-hero-height', ['label' => 'Hero min height', 'min' => '100'])
       ->setInstructions(esc_html__('Set hero min height (min: 100) (default: 100vh)', WPL_TEXTDOMAIN))
       ->addWysiwyg('header-text', ['label' => 'Hero text'])
       ->setInstructions(esc_html__('Add the text for the section', WPL_TEXTDOMAIN))
       ->addColorPicker('header-text-color', ['label' => esc_html__('Hero text color', WPL_TEXTDOMAIN)])
       ->setInstructions(esc_html__('Set the hero text color (for all text)', WPL_TEXTDOMAIN))
       ->addText('header-button-text', ['label' => 'CTA button text'])
       ->setInstructions(esc_html__('Add the text for the button', WPL_TEXTDOMAIN))
       ->addText('header-button-url', ['label' => 'CTA Button url'])
       ->setInstructions(esc_html__('Add the url for the button', WPL_TEXTDOMAIN));

$wpLanding->addFields($header);

// Service Fields ---------------------------------------------------------------------------------------------------- //
$service = new FieldsBuilder('service', array('title' => esc_html__('Service', WPL_TEXTDOMAIN)));
$service->addTab('Service', ['placement' => 'left'])
        ->addWysiwyg('services-header-text', ['label' => 'Service header text']);

// ACF pro fields
if (class_exists('acf_pro')) {
    $service->addNumber('services-repeater-cols', ['label' => 'Services list cols', 'min' => 3, 'max' => 6])
            ->setInstructions(esc_html__('Set list column (3: 4 cols | 4: 3 cols | 6: 2 cols)', WPL_TEXTDOMAIN))
            ->addRepeater('services-repeater', ['label' => 'Your services'])
            ->setInstructions(esc_html__('Add service', WPL_TEXTDOMAIN))
            ->addImage('service-icon')
            ->setInstructions(esc_html__('Add the service icon', WPL_TEXTDOMAIN))
            ->addText('service-title')
            ->setInstructions(esc_html__('Add the service title', WPL_TEXTDOMAIN))
            ->addWysiwyg('service-text')
            ->setInstructions(esc_html__('Add the service text', WPL_TEXTDOMAIN));
}

$wpLanding->addFields($service);

// Center page Fields -------------------------------------------------------------------------------------------------//
$centerPage = new FieldsBuilder('center_page', array('title' => esc_html__('Center page', WPL_TEXTDOMAIN)));
$centerPage->addTab('Center page', ['placement' => 'left'])
           ->addImage('center-page-image', ['label' => esc_html__('Center page image', WPL_TEXTDOMAIN)])
           ->setInstructions(esc_html__('Add the image for the section', WPL_TEXTDOMAIN))
           ->addText('center-page-title', ['label' => 'Center page title'])
           ->setInstructions(esc_html__('Add the title for the section', WPL_TEXTDOMAIN))
           ->addWysiwyg('center-page-text', ['label' => 'Center page  text'])
           ->setInstructions(esc_html__('Add the text for the section', WPL_TEXTDOMAIN))
           ->addImage('center-page-image-button', ['label' => esc_html__('Image after text', WPL_TEXTDOMAIN)])
           ->setInstructions(esc_html__('Add the image after text', WPL_TEXTDOMAIN));

$wpLanding->addFields($centerPage);

// Benefits Fields --------------------------------------------------------------------------------------------------- //
$benefits = new FieldsBuilder('benefits', array('title' => esc_html__('Benefits', WPL_TEXTDOMAIN)));
$benefits->addTab('Benefits', ['placement' => 'left'])
         ->addWysiwyg('benefits-header-text', ['label' => 'Benefits text'])
         ->setInstructions(esc_html__('Add the text for the section', WPL_TEXTDOMAIN));

// ACF pro fields
if (class_exists('acf_pro')) {
    $benefits->addRepeater('benefits-repeater', ['label' => 'Your benefits list'])
             ->addWysiwyg('benefits-item')
             ->setInstructions(esc_html__('Add the benefits text', WPL_TEXTDOMAIN));
}

$benefits->addText('benefits-button-text', ['label' => 'Benefits button text'])
         ->setInstructions(esc_html__('Add the text for the button', WPL_TEXTDOMAIN))
         ->addText('benefits-button-url', ['label' => 'Benefits button url'])
         ->setInstructions(esc_html__('Add the url for the button', WPL_TEXTDOMAIN));

$wpLanding->addFields($benefits);

// Testimonials Fields ----------------------------------------------------------------------------------------------- //
$testimonials = new FieldsBuilder('testimonials', array('title' => esc_html__('Testimonials', WPL_TEXTDOMAIN)));
$testimonials->addTab('Testimonials', ['placement' => 'left'])
             ->addColorPicker('testimonials-bgcolor',
                 ['label' => esc_html__('Testimonials background color', WPL_TEXTDOMAIN)])
             ->setInstructions(esc_html__('Set the testimonials background color', WPL_TEXTDOMAIN))
             ->addImage('testimonials-bg', ['label' => esc_html__('Testimonials background image', WPL_TEXTDOMAIN)])
             ->setInstructions(esc_html__('Add the testimonials background image', WPL_TEXTDOMAIN))
             ->addText('testimonials-title', ['label' => 'Testimonials title']);

// ACF pro fields
if (class_exists('acf_pro')) {
    $testimonials->addRepeater('testimonials-repeater', ['label' => 'Your testimonials list'])
                 ->addImage('testimonials-avatar')
                 ->setInstructions(esc_html__('Add the testimonials avatar', WPL_TEXTDOMAIN))
                 ->addText('testimonials-name')
                 ->setInstructions(esc_html__('Add the testimonials name', WPL_TEXTDOMAIN))
                 ->addWysiwyg('testimonials-text')
                 ->setInstructions(esc_html__('Add the testimonials text', WPL_TEXTDOMAIN));
}

$wpLanding->addFields($testimonials);

// Footer Fields ----------------------------------------------------------------------------------------------------- //
$footer = new FieldsBuilder('footer', array('title' => esc_html__('Footer', WPL_TEXTDOMAIN)));
$footer->addTab('Footer', ['placement' => 'left'])
       ->addColorPicker('footer-bgcolor', ['label' => esc_html__('Footer background color', WPL_TEXTDOMAIN)])
       ->setInstructions(esc_html__('Set the footer background color', WPL_TEXTDOMAIN))
       ->addImage('footer-bg', ['label' => esc_html__('Footer background image', WPL_TEXTDOMAIN)])
       ->setInstructions(esc_html__('Add the footer background image', WPL_TEXTDOMAIN))
       ->addColorPicker('footer-text-color', ['label' => esc_html__('Footer text color', WPL_TEXTDOMAIN)])
       ->setInstructions(esc_html__('Set the footer text color (for all text)', WPL_TEXTDOMAIN))
       ->addText('footer-title')
       ->setInstructions(esc_html__('Add the footer title', WPL_TEXTDOMAIN))
       ->addWysiwyg('footer-left')
       ->setInstructions(esc_html__('Add the footer left text', WPL_TEXTDOMAIN))
       ->addWysiwyg('footer-right')
       ->setInstructions(esc_html__('Add the footer right text', WPL_TEXTDOMAIN));

$wpLanding->addFields($footer);

// Colophon Fields --------------------------------------------------------------------------------------------------- //
$colophon = new FieldsBuilder('colophon', array('title' => esc_html__('Colophon', WPL_TEXTDOMAIN)));
$colophon->addTab('Colophon', ['placement' => 'left'])
         ->addText('colophon-text', ['label' => 'Colophon line'])
         ->setInstructions(esc_html__('Add the colophon text', WPL_TEXTDOMAIN));

$wpLanding->addFields($colophon);

// Add fields
$acfFields[] = $wpLanding;
add_action('init', function () use ($acfFields) {
    foreach ($acfFields as $field) {
        if ($field instanceof FieldsBuilder && function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group($field->build());
        }
    }
});

