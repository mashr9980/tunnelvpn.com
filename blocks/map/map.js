// Block name: Map
// Dependencies: Google Maps API
// Docs: https://developers.google.com/maps/
(function(){
	var initialize = function() {
		if($('#map').length){
			var	mapBlock = document.getElementById('map');
			var myLatlng = new google.maps.LatLng($(mapBlock).data('lon'), $(mapBlock).data('lat'));
			var mapStyle = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}];
			
			var	mapOptions = {
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

			var	map = new google.maps.Map(mapBlock, mapOptions);

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