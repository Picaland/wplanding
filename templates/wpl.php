<?php
/* Template Name: */
WPL_NAME_TEMPLATE;
/**/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php echo get_language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php _wp_render_title_tag(); ?>
    <?php
    // WPL head hook
    do_action('wpl_head');
    ?>
</head>
<body class="wpl-body <?php do_action('wpl_body'); ?>">
<div class="wpl-doc-wrapper">
    <?php do_action('wpl_before_hero'); ?>
    <?php
    // Scoped style
    echo \WpLanding\AcfController::heroBackground()->style; ?>
    <!-- hero  -->
    <header id="wpl_hero" class="wpl-hero">
        <div class="wpl-hero-container container">
            <h1 class="wpl-name col-md-12">
                <img src="<?php echo esc_url(\WpLanding\AcfController::logo()); ?>" alt="logo">
            </h1>
            <div class="wpl-hero-text col-md-12">
                <?php echo \WpLanding\AcfController::heroText(); ?>
                <?php if ('' !== \WpLanding\AcfController::heroCtaText()) : ?>
                    <div class="wpl-hero-cta">
                        <a class="btn wpl-button wpl-button-fill"
                           href="<?php echo esc_url(\WpLanding\AcfController::heroCtaUrl()); ?>">
                            <?php echo \WpLanding\AcfController::heroCtaText(); ?> <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <?php do_action('wpl_after_hero'); ?>
    <!-- service  -->
    <section id="wpl_service" class="wpl-service">
        <div class="wpl-service-container container">
            <header class="wpl-service-header">
                <?php echo \WpLanding\AcfController::serviceHeaderText(); ?>
            </header>
            <?php do_action('wpl_service_before_list_content'); ?>
            <?php echo \WpLanding\AcfController::servicesList(); ?>
            <?php do_action('wpl_service_after_list_content'); ?>
        </div>
    </section>
    <?php do_action('wpl_after_services'); ?>
    <!-- intro  -->
    <section id="wpl_center_page" class="wpl-center-page">
        <div class="wpl-center-page-image-wrapper">
            <img src="<?php echo \WpLanding\AcfController::centerPageImageUrl(); ?>" alt="top-banner">
            <div class="wpl-center-page-image-title">
                <h3><?php echo \WpLanding\AcfController::centerPageTitle(); ?></h3>
            </div>
        </div>
        <div class="wpl-center-page-container container">
            <div class="wpl-center-page-text col-md-12">
                <?php echo \WpLanding\AcfController::centerPageText(); ?>
            </div>
        </div>
        <div class="wpl-center-page-image-button-wrapper">
            <img src="<?php echo \WpLanding\AcfController::centerPageImageAfterTextUrl(); ?>" alt="button-banner">
        </div>
    </section>
    <?php do_action('wpl_after_intro'); ?>
    <!-- benefits  -->
    <section id="wpl_benefits" class="wpl-benefits">
        <div class="wpl-benefits-container container">
            <header class="wpl-benefits-header">
                <?php echo \WpLanding\AcfController::benefitsHeaderText(); ?>
            </header>
            <div class="wpl-benefits-list-wrapper">
                <?php do_action('wpl_benefits_before_list_content'); ?>
                <?php if ('' !== \WpLanding\AcfController::benefitsList(false)) : ?>
                    <?php echo \WpLanding\AcfController::benefitsList(); ?>
                <?php endif; ?>
                <?php do_action('wpl_benefits_after_list_content'); ?>
            </div>
            <?php if ('' !== \WpLanding\AcfController::benefitsCtaText()) : ?>
                <div class="wpl-benefits-cta">
                    <a class="btn wpl-button wpl-button-fill"
                       href="<?php echo esc_url(\WpLanding\AcfController::benefitsCtaUrl()); ?>">
                        <?php echo \WpLanding\AcfController::benefitsCtaText(); ?> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php do_action('wpl_after_benefits'); ?>
    <?php
    // Scoped style
    echo \WpLanding\AcfController::testimonialsBackground()->style; ?>
    <!-- testimonials  -->
    <section id="wpl_testimonials" class="wpl-testimonials">
        <div class="wpl-testimonials-container container">
            <header class="wpl-testimonials-title">
                <h2><?php echo \WpLanding\AcfController::testimonialsTitle(); ?></h2>
            </header>
            <div class="wpl-testimonials-list-wrapper">
                <?php do_action('wpl_testimonials_before_list_content'); ?>
                <?php if ('' !== \WpLanding\AcfController::testimonialsList(false)) : ?>
                    <?php echo \WpLanding\AcfController::testimonialsList(); ?>
                <?php endif; ?>
                <?php do_action('wpl_testimonials_after_list_content'); ?>
            </div>
        </div>
    </section>
    <?php do_action('wpl_after_testimonials'); ?>
    <?php
    // Scoped style
    echo \WpLanding\AcfController::footerBackground()->style; ?>
    <!-- footer  -->
    <footer id="wpl_footer" class="wpl-footer">
        <div id="wpl_footer_container" class="wpl-footer-container container">
            <div class="wpl-footer-title col-md-12">
                <h2><?php echo \WpLanding\AcfController::footerTitle(); ?></h2>
            </div>
            <div class="col-md-6 wpl-footer-left">
                <?php echo \WpLanding\AcfController::footerLeft(); ?>
            </div>
            <div class="col-md-6 wpl-footer-right">
                <?php echo \WpLanding\AcfController::footerRight(); ?>
            </div>
        </div>
        <?php do_action('wpl_after_footer_container'); ?>
        <div id="wpl_colophon" class="wpl-colophon">
            <p><?php echo \WpLanding\AcfController::colophon(); ?></p>
        </div>
    </footer>
</div>
<?php
// WPL footer hook
do_action('wpl_footer');
?>
</body>
</html>
