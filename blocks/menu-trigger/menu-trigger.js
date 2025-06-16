// Block name: Menu Trigger
// Dependencies: jquery.sidr.js
// Docs: https://github.com/artberri/sidr
(function(){
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