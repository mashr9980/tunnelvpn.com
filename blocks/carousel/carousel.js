// Block name: Carousel
// Dependencies: owl.carousel.js
// Docs: https://github.com/OwlCarousel2/OwlCarousel2
(function(){
	$(".js-carousel").each(function() {
		var carousel = $(this);

		carousel.on('initialized.owl.carousel', function() {
			$(this).find('.owl-item.active:first, .owl-item.active:last').addClass('has-fade');
		}).owlCarousel({
			loop:true,
			responsive: {
				0:    { items: 3 },
				768:  { items: 4 },
				991:  { items: 5 },
				1200: { items: 7 }
			}
		}).on("drag.owl.carousel", function() {
			$(this).find('.has-fade').removeClass('has-fade');
		}).on("dragged.owl.carousel", function() {
			$(this).find('.owl-item.active:first, .owl-item.active:last').addClass('has-fade');
		});
	});

})();