// Block name: Twitter Widget
// Dependencies: owl.carousel.js, twitterFetcher.js
// Docs: 	
// https://github.com/OwlCarousel2/OwlCarousel2
// https://github.com/jasonmayes/Twitter-Post-Fetcher
(function(){
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
			items:1,
			loop:true,
			animateOut: 'fadeOutDown',
		    animateIn: 'fadeInDown',
			autoplay: true,
			autoplayTimeout: 4000
		});
	};

	// Fetch Twitter Data
	twitterFetcher.fetch({
		"profile": {"screenName": apiConfig.user},
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