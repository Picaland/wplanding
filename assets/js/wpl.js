/**
 * wpl.js
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
;(
    function ($) {

        var testimonials = document.getElementById("testimonials-list");
        if (!testimonials) {
            return;
        }

        $(testimonials.children).each(function (index) {
            this.setAttribute('data-position', index);
        });

        $(testimonials).owlCarousel({
            center: true,
            dots: false,
            nav: true,
            items: 3,
            autoplay: true,
            autoHeight: false,
            autoplayHoverPause: true,
            loop: true,
            lazyLoad: true,
            smartSpeed: 600,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            margin: 10,
            responsiveRefreshRate: 100,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    dots: false,
                },
                768: {
                    items: 3,
                }
            },
        });

        $(document).on('click', '.owl-item > div', function () {
            $(testimonials).trigger('to.owl.carousel', $(this).data('position'));
        });

    }(window.jQuery)
);