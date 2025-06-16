// Block name: Tabs
// Dependencies: jquery.easytabs.js, velocity.js
// Docs: 
// https://github.com/JangoSteve/jQuery-EasyTabs
// https://github.com/julianshapiro/velocity
(function(){
	$('.js-tabs').each(function() {
		var tabs = $(this);

		tabs.easytabs({
			tabActiveClass: "tab__title--active",
			updateHash: false
		});

		tabs.on("easytabs:before", function () {
			$(this).find('.tabs__content.active img').velocity("stop").velocity("transition.slideDownOut", {
				duration: 1500,
				display: null
			});
		});

		tabs.on("easytabs:midTransition", function (event, $clicked, $targetPanel) {
			$targetPanel.find('img').velocity("stop").velocity("transition.slideDownIn", {
				duration: 1500,
				display: null,
				stagger: 100
			});
		});
	});

})();