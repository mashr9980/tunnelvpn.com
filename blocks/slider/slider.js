// Block name: Slider
// Dependencies: velocity.js, owl.carousel.js
// Docs: 
// https://github.com/julianshapiro/velocity
// https://github.com/OwlCarousel2/OwlCarousel2
(function(){
	$(window).load(function() {
		var sliders = $('.js-slider');

		sliders.each(function () {
			var slider = $(this);
			var duration = 1000;
			var animationOut = function (el) {
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

			var animationIn = function (el) {
				var mySequence = [{
					e: el.find(".owl-item.active .slider__title"),
					p: "transition.fadeIn",
					display: null
				},{ 
					e: el.find('.owl-item.active img.slider__image'), 
					p:"transition.slideUpBigIn", 
					o: {
						duration: duration,
						display: null,
						stagger: 150,
				    	sequenceQueue: false
				    }
				},{ 
					e: el.find('.owl-item.active img.slider__secondary'), 
				    p:"transition.slideUpBigIn", 
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
				items:1,
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