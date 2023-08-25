jQuery(document).ready(function() {
	//jQuery.getScript(slickurl).done(function() {
		jQuery('.event_slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			dots: false,
			/* vertical: true,
			verticalSwiping: true, */
		  infinite: true,
			autoplay: true,
		  autoplaySpeed: 2000,		
		});
 // });
});