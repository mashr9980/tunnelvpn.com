// Block name: Testimonials
// Dependencies: jquery.easytabs.js, velocity.js
// Docs: 
// https://github.com/JangoSteve/jQuery-EasyTabs
// https://github.com/julianshapiro/velocity
(function(){
	$('.js-testimonials').each(function() {
		var tabs = $(this);

		// Initialize EasyTabs
		tabs.easytabs({
			tabActiveClass: "testimonials__title--active",
			updateHash: false
		});

		// Bind Hide Animation
		tabs.on("easytabs:before", function () {
			$(this).find('.testimonials__quote.active span').velocity("stop").velocity("transition.slideDownOut", {
				duration: 1000,
				display: null
			});
		});

		// Bind Show Animation
		tabs.on("easytabs:midTransition", function (event, $clicked, $targetPanel) {
			$targetPanel.find("span").velocity("stop").velocity("transition.slideDownIn", {
				duration: 1000,
				display: null
			});
		});
	});

})();