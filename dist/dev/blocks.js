/* jshint undef: true, unused: true, browser: true, strict: true */
/* global jQuery, twitterFetcher, google */

(function($) {
	"use strict";

	// Module name: Scroll Top
	// Dependencies: no dependencies
	(function() {
		var scrollButton = $('.js-scroll-top');

		scrollButton.on("click", function(e) {
			e.preventDefault();
			$("html, body").animate({
				scrollTop: "0px"
			}, 2000);
		});
	})();

	// Module name: Scroll To
	// Dependencies: no dependencies
	(function() {
		var buttons = $('.js-scroll-to');

		buttons.each(function() {
			var button = $(this);
			var target = button.attr('href');
			var speed = button.data('speed') ? button.data('speed') : 1000;

			if (typeof target !== 'undefined' && $(target).length) {
				button.on('click', function(event) {
					event.preventDefault();

					$('html, body').animate({
						scrollTop: $(target).first().offset().top - $('.js-header').outerHeight()
					}, speed);
				});
			}
		});
	})();
	// Block name: Accordion
	// Dependencies: no dependencies
	(function() {
		$(".js-accordion").each(function() {
			var accordion = $(this);
			var select = {
				title: ".accordion__title",
				content: ".accordion__content"
			};

			var title = accordion.find(select.title);

			title.on('click', function(event) {
				event.preventDefault();
				$(this).toggleClass('accordion__title--active').parent().find(select.content).slideToggle();
			});
		});
	})();
	// Block name: Contact Form
	// Dependencies: jquery.form-validator.js
	// Docs: https://github.com/victorjonsson/jQuery-Form-Validator
	(function() {
		(function() {
			var form = $('.js-contact-form');

			if (form.length) {
				var submitForm = function($form) {
					var formURL = $form.attr("action"); // Get the form's action
					var postData = $form.serialize(); // Serialize the form's data
					var successMessage = $('.js-contact-form__modal'); // Select the success modal

					// Submit an AJAX request
					$.ajax({
						url: formURL,
						type: "POST",
						data: postData,
						success: function() {
							// On success clear the data from the inputs
							$form.find('input:text, textarea').val('');
							// Show the success modal for 2 seconds
							successMessage.fadeIn().delay(2000).fadeOut();
						}
					});

					// Prevent form default behavior
					return false;
				};

				// Validate the contact form, if succeeded, call the submitForm function
				$.validate({
					form: form,
					onSuccess: submitForm,
					errorElementClass: "has-error",
					scrollToTopOnError: false
				});
			}
		})();
	})();
	// Block name: Carousel
	// Dependencies: owl.carousel.js
	// Docs: https://github.com/OwlCarousel2/OwlCarousel2
	(function() {
		$(".js-carousel").each(function() {
			var carousel = $(this);

			carousel.on('initialized.owl.carousel', function() {
				$(this).find('.owl-item.active:first, .owl-item.active:last').addClass('has-fade');
			}).owlCarousel({
				loop: true,
				responsive: {
					0: {
						items: 3
					},
					768: {
						items: 4
					},
					991: {
						items: 5
					},
					1200: {
						items: 7
					}
				}
			}).on("drag.owl.carousel", function() {
				$(this).find('.has-fade').removeClass('has-fade');
			}).on("dragged.owl.carousel", function() {
				$(this).find('.owl-item.active:first, .owl-item.active:last').addClass('has-fade');
			});
		});

	})();
	// Block name: Header
	// Dependencies: no dependencies
	// Docs: 
	(function() {
		var header = $(".js-header").first();
		var logo = header.find('.js-logo__image');

		var updateHeader = function() {
			if ($(window).scrollTop() === 0) {
				header.removeClass('header--fixed');
				if (logo.data('switch') === true) {
					logo.attr("src", "assets/img/common/logo/logo.png");
				}
			} else {
				header.addClass('header--fixed');
				if (logo.data('switch') === true) {
					logo.attr("src", "assets/img/common/logo/logo-dark.png");
				}
			}
		};

		if (header.length) {
			updateHeader();
		}

		$(window).scroll(function() {
			updateHeader();
		});

	})();
	// Block name: Map
	// Dependencies: Google Maps API
	// Docs: https://developers.google.com/maps/
	(function() {
		var initialize = function() {
			if ($('#map').length) {
				var mapBlock = document.getElementById('map');
				var myLatlng = new google.maps.LatLng($(mapBlock).data('lon'), $(mapBlock).data('lat'));
				var mapStyle = [{
					"featureType": "all",
					"elementType": "labels.text.fill",
					"stylers": [{
						"saturation": 36
					}, {
						"color": "#000000"
					}, {
						"lightness": 40
					}]
				}, {
					"featureType": "all",
					"elementType": "labels.text.stroke",
					"stylers": [{
						"visibility": "on"
					}, {
						"color": "#000000"
					}, {
						"lightness": 16
					}]
				}, {
					"featureType": "all",
					"elementType": "labels.icon",
					"stylers": [{
						"visibility": "off"
					}]
				}, {
					"featureType": "administrative",
					"elementType": "geometry.fill",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 20
					}]
				}, {
					"featureType": "administrative",
					"elementType": "geometry.stroke",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 17
					}, {
						"weight": 1.2
					}]
				}, {
					"featureType": "landscape",
					"elementType": "geometry",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 20
					}]
				}, {
					"featureType": "poi",
					"elementType": "geometry",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 21
					}]
				}, {
					"featureType": "road.highway",
					"elementType": "geometry.fill",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 17
					}]
				}, {
					"featureType": "road.highway",
					"elementType": "geometry.stroke",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 29
					}, {
						"weight": 0.2
					}]
				}, {
					"featureType": "road.arterial",
					"elementType": "geometry",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 18
					}]
				}, {
					"featureType": "road.local",
					"elementType": "geometry",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 16
					}]
				}, {
					"featureType": "transit",
					"elementType": "geometry",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 19
					}]
				}, {
					"featureType": "water",
					"elementType": "geometry",
					"stylers": [{
						"color": "#000000"
					}, {
						"lightness": 17
					}]
				}];

				var mapOptions = {
					zoom: 15,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					styles: mapStyle,
					scrollwheel: false,
					mapTypeControl: true,
					mapTypeControlOptions: {
						style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
						position: google.maps.ControlPosition.TOP_LEFT
					},
					zoomControl: true,
					zoomControlOptions: {
						position: google.maps.ControlPosition.RIGHT_CENTER
					},
					scaleControl: true,
					streetViewControl: true,
					streetViewControlOptions: {
						position: google.maps.ControlPosition.RIGHT_TOP
					}
				};

				var map = new google.maps.Map(mapBlock, mapOptions);

				var image = {
					url: 'assets/img/common/map/pin.png'
				};

				var marker = new google.maps.Marker({
					position: myLatlng,
					icon: image
				});

				marker.setMap(map);
			}
		};

		google.maps.event.addDomListener(window, "load", initialize);
	})();
	// Block name: Menu
	// Dependencies: jquery.hoverIntent.js jquery.superfish.js
	// Docs: https://github.com/joeldbirch/superfish
	(function() {
		var menu = $('.js-menu');

		menu.superfish({
			delay: 300,
			autoArrows: false,
			speed: 'fast',
			disableHI: true
		});
	})();
	// Block name: Menu Trigger
	// Dependencies: jquery.sidr.js
	// Docs: https://github.com/artberri/sidr
	(function() {
		// Initialize Sidr plugin
		$('.js-menu-trigger').sidr({
			side: 'right',
			displace: false
		});

		// Close Sidr on click on menu anchors 
		$('.js-mobile-menu__close, #sidr a').on('click', function(event) {
			event.preventDefault();
			$.sidr('close', 'sidr');
		});

	})();
	// Block name: Preloader
	// Dependencies: no dependencies
	(function() {
		var preloader = $('.js-preloader');
		var preload = $('.js-preload-me').length;

		// Check if the preloader is active
		if (preload) {
			$(window).on("load", function() {
				preloader.fadeOut('slow', function() {
					$(this).remove();
				});
			});
		}
	})();
	// Block name: Slider
	// Dependencies: velocity.js, owl.carousel.js
	// Docs: 
	// https://github.com/julianshapiro/velocity
	// https://github.com/OwlCarousel2/OwlCarousel2
	(function() {
		$(window).load(function() {
			var sliders = $('.js-slider');

			sliders.each(function() {
				var slider = $(this);
				var duration = 1000;
				var animationOut = function(el) {
					el.find(".owl-item.active .slider__title").velocity("stop").velocity("transition.fadeOut", {
						duration: duration,
						display: null
					});

					el.find('.owl-item.active img').velocity("stop").velocity("transition.slideDownBigOut", {
						duration: duration,
						display: null,
						stagger: 100
					});
				};

				var animationIn = function(el) {
					var mySequence = [{
						e: el.find(".owl-item.active .slider__title"),
						p: "transition.fadeIn",
						display: null
					}, {
						e: el.find('.owl-item.active img.slider__image'),
						p: "transition.slideUpBigIn",
						o: {
							duration: duration,
							display: null,
							stagger: 150,
							sequenceQueue: false
						}
					}, {
						e: el.find('.owl-item.active img.slider__secondary'),
						p: "transition.slideUpBigIn",
						o: {
							delay: 150,
							duration: duration,
							display: null,
							stagger: 150,
							sequenceQueue: false
						}
					}];

					el.find(".owl-item.active .slider__title, .owl-item.active img.slider__image, .owl-item.active img.slider__secondary").velocity("stop", true);
					$.Velocity.RunSequence(mySequence);
				};

				slider.on("initialized.owl.carousel", function() {
					animationIn($(this));
				});

				slider.owlCarousel({
					items: 1,
					animateOut: "fadeOut",
					dots: true,
					mouseDrag: false,
					touchDrag: false,
					autoHeight: true,
					autoplay: true,
					autoplayTimeout: 5000
				});


				slider.on("translate.owl.carousel", function() {
					animationOut($(this));
				});

				slider.on("translated.owl.carousel", function() {
					animationIn($(this));
				});
			});
		});
	})();
	// Block name: Stats
	// Dependencies: jquery.animateNumber.js, jquery.inview.js
	// Docs: 
	// https://github.com/aishek/jquery-animateNumber
	// https://github.com/protonet/jquery.inview
	(function() {
		var numbers = $('.js-stats__number');

		numbers.each(function() {
			var number = $(this);
			var to = number.data('number');
			var units = number.data('units') ? number.data('units') : '';

			number.one("inview", function() {
				number.animateNumber({
					number: to,
					numberStep: $.animateNumber.numberStepFactories.append(units)
				}, 3000);
			});
		});
	})();
	// Block name: Tabs
	// Dependencies: jquery.easytabs.js, velocity.js
	// Docs: 
	// https://github.com/JangoSteve/jQuery-EasyTabs
	// https://github.com/julianshapiro/velocity
	(function() {
		$('.js-tabs').each(function() {
			var tabs = $(this);

			tabs.easytabs({
				tabActiveClass: "tab__title--active",
				updateHash: false
			});

			tabs.on("easytabs:before", function() {
				$(this).find('.tabs__content.active img').velocity("stop").velocity("transition.slideDownOut", {
					duration: 1500,
					display: null
				});
			});

			tabs.on("easytabs:midTransition", function(event, $clicked, $targetPanel) {
				$targetPanel.find('img').velocity("stop").velocity("transition.slideDownIn", {
					duration: 1500,
					display: null,
					stagger: 100
				});
			});
		});

	})();
	// Block name: Testimonials
	// Dependencies: jquery.easytabs.js, velocity.js
	// Docs: 
	// https://github.com/JangoSteve/jQuery-EasyTabs
	// https://github.com/julianshapiro/velocity
	(function() {
		$('.js-testimonials').each(function() {
			var tabs = $(this);

			// Initialize EasyTabs
			tabs.easytabs({
				tabActiveClass: "testimonials__title--active",
				updateHash: false
			});

			// Bind Hide Animation
			tabs.on("easytabs:before", function() {
				$(this).find('.testimonials__quote.active span').velocity("stop").velocity("transition.slideDownOut", {
					duration: 1000,
					display: null
				});
			});

			// Bind Show Animation
			tabs.on("easytabs:midTransition", function(event, $clicked, $targetPanel) {
				$targetPanel.find("span").velocity("stop").velocity("transition.slideDownIn", {
					duration: 1000,
					display: null
				});
			});
		});

	})();
	// Block name: Twitter Widget
	// Dependencies: owl.carousel.js, twitterFetcher.js
	// Docs: 	
	// https://github.com/OwlCarousel2/OwlCarousel2
	// https://github.com/jasonmayes/Twitter-Post-Fetcher
	(function() {
		// Select Twitter widget
		var widget = $(".js-twitter-widget").first();

		// Get configuration from the DOM
		var apiConfig = {
			user: widget.data("user"),
			max: widget.data("max"),
			lang: widget.data("lang")
		};

		// Render the template using fetched data
		var handleTweets = function(tweets) {
			for (var i = 0; i < tweets.length; i++) {
				$(".js-twitter-widget").first().append([
					'<div class="twitter-widget__tweet">',
					'<div class="twitter-widget__content">',
					'<div class="twitter-widget__user">' + tweets[i].author + '</div>',
					tweets[i].tweet,
					'</div>',
					'<div class="twitter-widget__date">— ' + tweets[i].time + '</div>',
					'</div>'
				].join(''));
			}

			// Initialize the slider
			$(".js-twitter-widget").first().owlCarousel({
				items: 1,
				loop: true,
				animateOut: 'fadeOutDown',
				animateIn: 'fadeInDown',
				autoplay: true,
				autoplayTimeout: 4000
			});
		};

		// Fetch Twitter Data
		twitterFetcher.fetch({
			"profile": {
				"screenName": apiConfig.user
			},
			"maxTweets": apiConfig.max,
			"enableLinks": true,
			"showUser": true,
			"showTime": true,
			"showRetweet": false,
			"dataOnly": true,
			"customCallback": handleTweets,
			"lang": apiConfig.lang
		});
	})();
	// Block name: Video
	// Dependencies: jquery.youtubepopup.js
	// Docs: https://github.com/QassimHassan/YouTube_PopUp
	(function() {
		$(".js-video").YouTubePopUp();
	})();

})(jQuery);