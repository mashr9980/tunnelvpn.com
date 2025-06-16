// Block name: Accordion
// Dependencies: no dependencies
(function(){
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