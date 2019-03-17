jQuery(document).ready(function($) {

	// Smooth Scroll to anchor CSS Tricks
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		  var target = $(this.hash);
		  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		  if (target.length) {
		    $('html,body').animate({
		      scrollTop: target.offset().top
		    }, 1000);
		    return false;
		  }
		}
	});

	$(document).scroll(function () {
	    var y = $(this).scrollTop();
	    if (y > 800) {
	        $('.scroll-to-top').fadeIn('slow');
	    } else {
	        $('.scroll-to-top').fadeOut('slow');
	    }
	});


	/* Search & Social Toggle */
	$('.search-toggle').on('click', function(e){
		$('body').removeClass('is-social-toggled-on');
		$('body').toggleClass('is-search-toggled-on');
		if($('body').hasClass('is-search-toggled-on')){
			$('.top-bar .search-field').focus();
		}
	});
	$('.social-toggle').on('click', function(){
		$('body').removeClass('is-search-toggled-on');
		$('body').toggleClass('is-social-toggled-on');
	});
	$('.menu-toggle').on('click', function(){
		$('body').toggleClass('is-expanded-menu');
	});


	//Gallery post
	$('.flexslider').flexslider({
		animation: "fade",
		slideshow: false,
		itemMargin: 0,
		smoothHeight: true,
		rtl: true
	});

    // slider nav width fixed;
    $(window).load(function(){
		$(".flex-control-nav").each(function(){

		  var li_count = $(this).find("li").length;
		  var _width = ((li_count * $(this).find("li").outerWidth() ) * 2.5);

		  $(this).outerWidth(_width);
		  $(this).css("margin-left", -1 * (_width/2));

		});
    });


  	// tooltip-ize all links with title attributes, except Site title.
	$('.hastip').tooltipsy({
		offset: [0, 10]
	});

	$('.hastip-author').tooltipsy({
		offset: [0, 10]
	});


	// Fitvids
	// Target your .container, .wrapper, .post, etc.
	$(".post-image.video").fitVids();

});
