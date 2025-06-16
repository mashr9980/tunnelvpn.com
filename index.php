<?php
session_start();
include_once 'include/guest_head.php';
?>

<body class="js-preload-me ">
	<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
	<!-- Preloader -->
	<div class="preloader js-preloader ">
		<span class="preloader__circle preloader__circle--primary"></span>
		<span class="preloader__circle preloader__circle--secondary"></span>
		<span class="preloader__circle preloader__circle--tertiary"></span>
	</div>
	<!-- End of Preloader -->
	<!-- Page -->
	<div class="">
		<!-- Mobile Menu -->
		<div id="sidr">
			<div class="mobile-menu__close js-mobile-menu__close"></div>
			<ul class="mobile-menu js-mobile-menu ">
				<li class="mobile-menu__item ">
					<a href="index.php" class="mobile-menu__link">Home</a>

				</li>
				<li class="mobile-menu__item ">
					<a href="#features" class="mobile-menu__link js-scroll-to">Features</a>
				</li>
				<li class="mobile-menu__item ">
					<a href="#screenshot" class="mobile-menu__link">Screenshot</a>

				</li>
				<li class="mobile-menu__item ">
					<a href="#plans" class="mobile-menu__link js-scroll-to">Pricing</a>
				</li>
				<li class="mobile-menu__item ">
					<a href="#contacts" class="mobile-menu__link js-scroll-to">Contacts</a>
				</li>
				<?php
                if (isset($_SESSION['login_id'])) {
                ?>
                    <li class="mobile-menu__item ">
                        <!--<a href="logout.php" class="mobile-menu__link js-scroll-to">Logout</a>-->
                        <a href="javascript:void(0);" onclick="window.location.href='logout.php';" class="mobile-menu__link">Logout</a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="mobile-menu__item ">
                        <!--<a href="login.php" class="mobile-menu__link">Login</a>-->
                        <a href="javascript:void(0);" onclick="window.location.href='login.php';" class="mobile-menu__link">Login</a>
                    </li>
                <?php
                }
                ?>
			</ul>
		</div>
		<!-- End of Mobile Menu -->
		<!-- Header -->
		<header class="header js-header ">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-12">
						<!-- Logo -->
						<div class="logo ">
							<a href="index.php" class="logo__link" id="footer-logo">
								<img src="assets/img-1/bg.png" alt="Logo" class="logo__image js-logo__image" style="margin-top: -10px;" id="footer-logo" data-switch="true"></a>
							<a href="index.php" class="logo-name" style="color: black ; font-weight: 700;  margin-top: -40px">TunnelVPN</a>
						</div>
						<!-- End of Logo -->
					</div>
					<div class="col-md-20 col-sm-20 col-xs-12">
						<!-- Menu -->
						<nav>
							<ul class="menu menu--right js-menu sf-menu ">
								<li class="menu__item ">
									<a href="index.php" class="menu__link">Home</a>
								</li>
								<li class="menu__item ">
									<a href="#features" class="menu__link js-scroll-to">Features</a>
								</li>
								<li class="menu__item ">
									<a href="#screenshot" class="menu__link js-scroll-to">Screenshot</a>
								</li>
								<li class="menu__item ">
									<a href="#plans" class="menu__link js-scroll-to">Pricing Plans</a>
								</li>
								<li class="menu__item ">
									<a href="#contacts" class="menu__link js-scroll-to">Contacts</a>
								</li>
								<?php
                                if (isset($_SESSION['login_id'])) {
                                ?>
                                    <li class="menu__item">
                                        <a href="logout.php" class="menu__link js-scroll-to">Logout</a>
                                    </li>
                                <?php
                                } else {
                                ?>
                                    <li class="menu__item">
                                        <a href="login.php" class="menu__link">Login</a>
                                    </li>
                                <?php
                                }
                                ?>
								<li class="menu__item menu__item--button">
									<a href="tunnelvpn.exe" class="menu__link js-scroll-to">Download</a>
								</li>

							</ul>
						</nav>
						<!-- End of Menu -->
						<!-- Menu Trigger -->
						<a class="menu-trigger js-menu-trigger " href='sidr'> </a>
						<!-- End of Menu Trigger -->
					</div>
				</div>
			</div>
		</header>
		<!-- End of Header -->
		<!-- Hero -->
		<div class="hero ">
			<!-- Slider -->
			<div class="slider js-slider owl-carousel ">
				<div class="slider__slide">
					<h2 class="slider__title">
						<span class='slider__highlight'>Welcome to TunnelVPN</span>
					</h2>
					<div class="slider__content">
						<img src="assets/screenshots/1.jpg" class="slider__secondary" alt="Slider Image">
						<img src="assets/screenshots/3.jpg" class="slider__secondary slider__secondary--right" alt="Slider Image">
						<img src="assets/screenshots/2.jpg" class="slider__image" alt="Slider Image">
					</div>
				</div>
			</div>
			<!-- End of Slider -->
		</div>
		<!-- End of Hero -->
		<!-- Section -->
		<section class="section section--grey " id='download'>
			<div class="container">
				<div class="row">
					<div class="col-md-24">
						<!-- Section Title -->
						<h2 class="section-title section-title--center "> Download this
							<span class='section-title__highlight'>awesome</span> app
						</h2>
						<!-- End of Section Title -->
						<!-- Section Subtitle -->
						<p class="section-subtitle section-subtitle--center "> available on all modern operating systems
						</p>
						<!-- End of Section Subtitle -->
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-8 col-lg-offset-2">
						<!-- Download Button -->
						<a class="download-button" href="#">
							<img src="assets/img-1/paly.png" class="download-button__icon" alt="Platform Icon">
							<span class="download-button__platform">Android app on</span>
							<span class="download-button__store">Google Play</span>
						</a>
						<!-- End of Download Button -->
					</div>
					<div class="col-lg-6 col-md-8 col-lg-offset-1">
						<!-- Download Button -->
						<a class="download-button  " href="tunnelvpn.exe">
							<img src="assets/img-1/laptop.png" class="download-button__icon" alt="Platform Icon">
							<span class="download-button__platform">Desktop app on</span>
							<span class="download-button__store">Window</span>
						</a>
						<!-- End of Download Button -->
					</div>
					<div class="col-lg-6 col-md-8 col-lg-offset-1">
						<!-- Download Button -->
						<a class="download-button  " href="#">
							<img src="assets/img-1/macos.png" class="download-button__icon" alt="Platform Icon">
							<span class="download-button__platform">IOS app on</span>
							<span class="download-button__store">App Store</span>
						</a>
						<!-- End of Download Button -->
					</div>
				</div>
			</div>
		</section>
		<!-- End of Section -->
		<!-- Section -->
		<section class="section section--skin-1 " id='features'>
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<!-- Push -->
						<div class="push push--60  "> </div>
						<!-- End of Push -->
						<!-- Section Title -->
						<h2 class="section-title "> Features for Our App</h2>
						<!-- End of Section Title -->
						<!-- Section Subtitle -->
						<p class="section-subtitle "> Discover the powerful features of TunnelVPN designed to provide you with secure, private, and seamless internet access.</p>
						<!-- End of Section Subtitle -->
						<!-- List -->
						<ul class="list list--check  ">
							<li class="list__item">Protect your data with our cutting-edge encryption technology, ensuring your online activities remain private.</li>
							<li class="list__item">Experience ultra-fast connection speeds for seamless browsing, streaming, and downloading</li>
							<li class="list__item">Access content from anywhere in the world, bypassing geo-restrictions and censorship.</li>
							<li class="list__item">Your privacy is our priority. We maintain a strict no-logs policy to ensure your data is never tracked or stored.</li>
							<li class="list__item">Secure all your devices with a single subscription. Compatible with Windows, MacOS, Android, iOS, and more.</li>
							<li class="list__item">Get assistance anytime with our dedicated 24/7 customer support team.</li>
						</ul>
						<!-- End of List -->
						<!-- List -->

						<!-- End of List -->
					</div>
					<div class="col-lg-12 col-md-11 col-md-offset-1 col-lg-offset-0">
						<!-- Screens Preview -->
						<div class="screens-preview screens-preview--right  ">
						    <img src="assets/screenshots/2.jpg" class="screens-preview__primary" alt="Secondary Screenshot">
							<img src="assets/img-1/tunnel-3.jpg" class="screens-preview__secondary" alt="Primary Screenshot">
						</div>
						<!-- End of Screens Preview -->
					</div>
				</div>
				<div class="row">
					<div class="col-lg-13 col-md-13">
						<!-- Screens Preview -->
						<div class="screens-preview mac-img" style="max-width: 600px;">
							<img src="assets/img-1/mac-preview.png" class="screens-preview__primary" alt="Primary Screenshot">
							<!-- <img src="http://placehold.it/500x880" class="screens-preview__secondary" alt="Secondary Screenshot"> -->
						</div>
						<!-- End of Screens Preview -->
					</div>
					<div class="col-lg-11 col-md-10 col-lg-offset-0 col-md-offset-1">
						<!-- Push -->
						<div class="push push--100"></div>
						<!-- End of Push -->
						<!-- Section Title -->
						<h2 class="section-title">Secure Your Online Privacy with TunnelVPN</h2>
						<!-- End of Section Title -->
						<!-- Section Subtitle -->
						<p class="section-subtitle">Protect your data and browse anonymously with our top-rated VPN service.</p>
						<!-- End of Section Subtitle -->
						<!-- Accordion -->
						<ul class="accordion js-accordion">
							<li class="accordion__item">
								<h3 class="accordion__title">
									<img src="assets/svg/encrypted.svg" class="accordion__icon" alt="Accordion Icon">
									Advanced Encryption for Ultimate Security
								</h3>
								<div class="accordion__content">
									<p>TunnelVPN employs state-of-the-art encryption protocols to ensure that your data remains secure from hackers and surveillance. Our VPN service provides military-grade protection, safeguarding your online activities and sensitive information.</p>
								</div>
							</li>
							<li class="accordion__item">
								<h3 class="accordion__title">
									<img src="assets/svg/speedometer.svg" class="accordion__icon" alt="Accordion Icon">
									High-Speed Connections Worldwide
								</h3>
								<div class="accordion__content">
									<p>Enjoy lightning-fast internet speeds without compromising security. TunnelVPN offers a global network of high-speed servers, allowing you to stream, browse, and download with ease, no matter where you are.</p>
								</div>
							</li>
							<li class="accordion__item">
								<h3 class="accordion__title">
									<img src="assets/svg/responsive.svg" class="accordion__icon" alt="Accordion Icon">
									Easy-to-Use Apps for All Devices
								</h3>
								<div class="accordion__content">
									<p>Our user-friendly apps are available for Windows, macOS, iOS, Android, and more. With TunnelVPN, you can protect all your devices with a single account, ensuring seamless and secure browsing across platforms.</p>
								</div>
							</li>
						</ul>
						<!-- End of Accordion -->
					</div>

				</div>
			</div>
		</section>
		<!-- End of Section -->
		<!-- Section -->

		<!-- End of Section -->
		<!-- Section -->
		<section class="section section--large" id='screenshot'>
			<div class="container">
				<div class="row">
					<div class="col-md-24">
						<!-- Section Title -->
						<h2 class="section-title section-title--center ">Our App screenshot</h2>
						<!-- End of Section Title -->
						<!-- Section Subtitle -->
						<p class="section-subtitle section-subtitle--center "> Take a look at some of the screens from TunnelVPN and see how it can enhance your online experience</p>
						<!-- End of Section Subtitle -->
					</div>
				</div>
			</div>
			<!-- Carousel -->
			<div class="carousel  ">
				<div class="carousel__outer">
					<div class="carousel__inner js-carousel owl-carousel">
						<div class="carousel__slide">
							<img src="assets/img-1/Tunnel-1.jpg" class="carousel__image" alt="Carousel Slide Image">

						</div>
						<div class="carousel__slide">
							<img src="assets/img-1/Tunnel-3.jpg" class="carousel__image" alt="Carousel Slide Image">

						</div>
						<div class="carousel__slide">
							<img src="assets/screenshots/1.jpg" class="carousel__image" alt="Carousel Slide Image">

						</div>
						<div class="carousel__slide">
							<img src="assets/screenshots/2.jpg" class="carousel__image" alt="Carousel Slide Image">

						</div>
						<div class="carousel__slide">
							<img src="assets/screenshots/3.jpg" class="carousel__image" alt="Carousel Slide Image">

						</div>
						<div class="carousel__slide">
							<img src="assets/screenshots/4.jpg" class="carousel__image" alt="Carousel Slide Image">

						</div>
						<div class="carousel__slide">
							<img src="assets/screenshots/5.jpg" class="carousel__image" alt="Carousel Slide Image">

						</div>
					</div>
				</div>
			</div>
			<!-- End of Carousel -->
		</section>
		<!-- End of Section -->
		<!-- Section -->
		<section class="section section--large " id='plans'>
			<div class="container">
				<div class="row">
					<div class="col-md-24">
						<!-- Section Title -->
						<h2 class="section-title section-title--center "> Our awesome
							<span class='section-title__highlight'>pricing plans</span>
						</h2>
						<!-- End of Section Title -->
						<!-- Section Subtitle -->
						<p class="section-subtitle section-subtitle--center "> Select the perfect plan for your needs and enjoy secure, private internet access with TunnelVPN. </p>
						<!-- End of Section Subtitle -->
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-16 col-sm-offset-4 col-md-offset-0">
						<!-- Pricing -->
						<div class="pricing  ">
							<h3 class="pricing__title">Basic</h3>
							<h4 class="pricing__price">
								<span class="pricing__placeholder">
									<span class="pricing__currency">$</span>12.95
									<span class="pricing__frequency">/month</span>
								</span>
							</h4>
							<ul class="pricing__features">
								<li class="pricing__feature"><span class="pricing__highlight">1</span> Month</li>
							</ul>

							<!-- Button -->
							<div class="button button--small button--shadow button--dark  ">
								<button onclick="buyPlan('standard_monthly')" class="button__link">Purchase</button>
							</div>
							<!-- End of Button -->
						</div>
						<!-- End of Pricing -->
					</div>
					<div class="col-md-8 col-sm-16 col-sm-offset-4 col-md-offset-0">
						<!-- Pricing -->
						<div class="pricing pricing--featured  ">
							<h3 class="pricing__title">Popular</h3>
							<h4 class="pricing__price">
								<span class="pricing__placeholder">
									<span class="pricing__currency">$</span>6.67
									<span class="pricing__frequency">/month</span>
								</span>
							</h4>
							<ul class="pricing__features">
								<li class="pricing__feature"><span class="pricing__highlight">12</span> Month</li>
							</ul>

							<!-- Button -->
							<div class="button button--small button--shadow button--dark  ">
								<button onclick="buyPlan('premium_yearly')" class="button__link">Purchase</button>
							</div>
							<!-- End of Button -->
						</div>
						<!-- End of Pricing -->
					</div>
					<div class="col-md-8 col-sm-16 col-sm-offset-4 col-md-offset-0">
						<!-- Pricing -->
						<div class="pricing">
							<h3 class="pricing__title">Startup</h3>
							<h4 class="pricing__price">
								<span class="pricing__placeholder">
									<span class="pricing__currency">$</span> 9.99
									<span class="pricing__frequency">/month</span>
								</span>
							</h4>
							<ul class="pricing__features">
								<li class="pricing__feature"><span class="pricing__highlight">6</span> Month</li>
							</ul>
							<!-- Button -->
							<div class="button button--small button--shadow button--dark  ">
								<button onclick="buyPlan('standard_halfyear')" class="button__link">Purchase</button>
							</div>
							<!-- End of Button -->
						</div>
						<!-- End of Pricing -->
					</div>
				</div>
			</div>
		</section>
		<!-- End of Section -->

		<!-- Section -->
		<section class="section section--large section--no-pb " id='contacts'>
			<div class="container">
				<div class="row">
					<div class="col-md-24">
						<!-- Section Title -->
						<h2 class="section-title section-title--center "> Get in touch
							<span class='section-title__highlight'>with us</span>
						</h2>
						<!-- End of Section Title -->
						<!-- Section Subtitle -->
						<p class="section-subtitle section-subtitle--center "> Reach out to us for any questions, feedback, or assistance. We're here to help! </p>
						<!-- End of Section Subtitle -->
					</div>
				</div>
				<div class="row">
					<div class="col-lg-20 col-lg-offset-2 col-md-24 col-md-offset-0">
						<!-- Contact Form -->
						<div class="contact-form  ">
							<form class="contact-form__form js-contact-form">
								<div class="contact-form__modal js-contact-form__modal">
									<h3 class="contact-form__message"> Your message was sent
										<span>successfully</span>
										<br>Thank you!
									</h3>
								</div>
								<div class="row">
									<p id="error-msg" style="opacity: 1; display: none;" class="alert alert-warning"></p>
									<div id="simple-msg" style="display: none;" class="alert alert-success"></div>
									<div class="col-md-12">
										<label class="contact-form__label" for="name-input">Your name</label>
										<!-- Input -->
										<div class="input input--contact  ">
											<input type="text" name="name-input" class="input__field" placeholder="" id="name" data-validation="required">
										</div>
										<!-- End of Input -->
										<label class="contact-form__label" for="email-input">Your e-mail</label>
										<!-- Input -->
										<div class="input input--contact  ">
											<input type="text" name="email-input" class="input__field" placeholder="" id="email" data-validation="required email">
										</div>
										<!-- End of Input -->
										<label class="contact-form__label" for="subject-input">Subject</label>
										<!-- Input -->
										<div class="input input--contact  ">
											<input type="text" name="subject-input" class="input__field" placeholder="" id="subject" data-validation="required">
										</div>
										<!-- End of Input -->
									</div>
									<div class="col-md-12">
										<label class="contact-form__label" for="message-input">Your Message</label>
										<textarea name="message-input" id="comments" class="contact-form__textarea" data-validation="required"></textarea>
										<!-- Button -->
										<div class="button button--small button--shadow  ">
											<input type="submit" id="submit" class="button__input" value="Send us the message">
										</div>
										<!-- End of Button -->
									</div>
								</div>
							</form>
						</div>
						<!-- End of Contact Form -->
					</div>
				</div>
			</div>
			<!-- Map -->
			<!-- <div class="map  " id="map" data-lon="40.799645" data-lat="-73.952437"> </div> -->
			<!-- End of Map -->
		</section>
		<!-- End of Section -->
		<!-- Footer -->
		<footer class="footer">
			<div class="footer-container">
				<div class="footer-row">
					<div class="footer-col">
						<div class="logo ">
							<a href="index.php" class="logo__link" id="footer-logo">
								<img src="assets/img-1/bg.png" alt="Logo" class="logo__image js-logo__image" id="footer-logo" data-switch="true"></a>
							<a href="index.php" class="logo-name" style="color: rgb(255, 255, 255); font-weight: 700;  font-size: 20px;">TunnelVPN</a>
						</div>
						<p>Discover seamless privacy and security with TunnelVPN. Protect your online activities with advanced encryption and enjoy
							unrestricted access worldwide.</p>
					</div>
					<div class="footer-col">
						<h4>Tunnel VPN</h4>
						<ul>
							<li><a href="#features">Features</a></li>
							<li><a href="#screenshot">Get App</a></li>
							<li><a href="#plans">Pricing</a></li>
							<li><a href="#contacts">Contact</a></li>
						</ul>
					</div>

					<div class="footer-col">
						<h4>policies</h4>
						<ul>
							<li><a href="privacy-policy.html">Privacy Policy</a></li>
							<li><a href="#">Marketplace</a></li>
							<li><a href="terms.html">Term & Condition</a></li>
							<li><a href="#">Collection</a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<!-- End of Footer -->
	</div>
	<!-- End of Page -->
	<!-- Scripts -->
	<script src="https://maps.googleapis.com/maps/api/js"></script>
	<script src="dist/script.js"></script>
	<script>
		function buyPlan(plan) {
			window.location.href = 'buy.php?plan=' + plan;
		}
	</script>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script>
		$(document).ready(function() {
			var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

			$.ajax({
				url: 'backend/controller/save-timezone.php',
				type: 'POST',
				data: {
					timezone: timezone,
					action: 'savetime'
				},
				success: function(response) {
					if (response != true) {
						console.log('Failed to save timezone');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
				}
			})
		})

		$(document).ready(function() {
			$("#submit").on('click', function(e) {
				e.preventDefault();

				var name = $("#name").val();
				var email = $("#email").val();
				var subject = $("#subject").val();
				var comments = $("#comments").val();
				var errorMsg = $("#error-msg");

				errorMsg.hide().text('');

				// Simple validation
				if (name == '' || email == '' || subject == '' || comments == '') {
					errorMsg.show().text('Please fill all the fields.');
					return false;
				}

				if (!validateEmail(email)) {
					errorMsg.show().text('Please enter a valid email address.');
					return false;
				}

				// AJAX request
				$.ajax({
					url: 'backend/contact/contact-form-handler.php',
					type: 'POST',
					contentType: 'application/json',
					data: JSON.stringify({
						name: name,
						email: email,
						subject: subject,
						comments: comments
					}),
					beforeSend: function() {
						$("#submit").attr('disabled', 'disabled');
						$("#submit").val('Sending...');
					},
					success: function(response) {
						// console.log(response);
						if (response.status === true) {
							$("#simple-msg").show().text('Message sent successfully!');
							$("#name").val('');
							$("#email").val('');
							$("#subject").val('');
							$("#comments").val('');
							$("#submit").removeAttr('disabled').val('Done');
						} else {
							$("#submit").removeAttr('disabled');
							$("#submit").val('Send Message');
							errorMsg.show().text(response.message);
						}
					},
					error: function(xhr, status, error) {
						console.error('Error:', error);
						errorMsg.show().text('An error occurred. Please try again later.');
					}
				});
			});

			function validateEmail(email) {
				var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
				return re.test(email);
			}
		});
	</script>
</body>

</html>