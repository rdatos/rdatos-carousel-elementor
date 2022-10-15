(function ($) {
	/**
	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */

	var WidgetOwlCarouselHandler = function ($scope, $) {
		var $carouselContainer = $scope.find(".js-owce-carousel-container");
		var $carousel = $carouselContainer.find(".js-owce-carousel");

		if (!$carousel.length) {
			return;
		}

		var options = $carousel.data("options");

		// $carousel.each(function () { // each not necessary
		$carousel.owlCarousel({
			margin: options.margin, // dont' delete
			center: options.center,
			lazyLoad: options.lazyLoad,
			autoHeight: options.auto_height,
			autoplay: options.autoplay,
			autoplayTimeout: options.autoplay_timeout
				? options.autoplay_timeout
				: 5000,
			autoplayHoverPause: options.autoplay_hover_pause,
			mouseDrag: options.mouse_drag,
			touchDrag: options.touch_drag,
			rewind: options.rewind,
			smartSpeed: options.smart_speed,
			slideTransition: "ease",
			animateIn: options.animate_in,
			animateOut: options.animate_out,
			navText: [
				"<i class='eicon-chevron-left' aria-hidden='true'></i>",
				"<i class='eicon-chevron-right' aria-hidden='true'></i>"
			],
			responsiveClass: true,
			responsive: {
				0: {
					items: options.items_count_mobile
						? options.items_count_mobile
						: 1,
					margin: owce_value_exists(
						options.margin_mobile,
						options.margin
					),
					nav: options.nav_mobile,
					// elementor return null sometimes for default value - a bug might be
					dots:
						options.dots_mobile === null ||
						options.dots_mobile === "yes"
							? true
							: false,
					loop: options.loop_mobile
				},
				768: {
					items: options.items_count_tablet
						? options.items_count_tablet
						: 2,
					margin: owce_value_exists(
						options.margin_tablet,
						options.margin
					),
					nav: options.nav_tablet,
					dots:
						options.dots_tablet === null ||
						options.dots_tablet === "yes"
							? true
							: false,
					loop: options.loop_tablet
				},
				1024: {
					items: options.items_count,
					margin: options.margin,
					nav: options.nav,
					dots: options.dots,
					loop: options.loop
				}
			}
		});
		// }); // end each

		if ($(".js-elementor-not-clickable").length) {
			$(".js-elementor-not-clickable")
				.parent(".owl-thumb")
				.addClass("js-elementor-not-clickable");
		}
	};

	// Make sure you run this code under Elementor.
	$(window).on("elementor/frontend/init", function () {
		elementorFrontend.hooks.addAction(
			"frontend/element_ready/owl-carousel-elementor.default",
			WidgetOwlCarouselHandler
		);
	});

	// helpers
	function owce_value_exists(val, defaultVal = "") {
		if (val || val === 0) {
			return val;
		}
		return defaultVal;
	}
})(jQuery);
