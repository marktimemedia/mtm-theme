(function( $ ){

	/* Scroll Header */

	var lastScrollTop = $(window).scrollTop(); // reset variable any time it reloads
	var siteHeader = $('.header-main');

	$(window).on('scroll', (function(event) {
		var scrollPosition = $(this).scrollTop();

		if($(window).width() > 776 ) { // we're mobile first so this is anything larger than our mobile breakpoint

			if (scrollPosition > 100) { // once you get far enough down, shrink the header
		    	
		        siteHeader.addClass('header-main-small'); 

		    } else { // bring it back up again when we get back to the top

		    	siteHeader.removeClass('header-main-small');
		    }

		} else { // this is mobile breakpoint or smaller

			if (scrollPosition > 50 && scrollPosition > lastScrollTop) { // once you get far enough down, hide the header
		    	
		        siteHeader.addClass('header-main-small'); 

		    } else { // bring it back up again if we scroll up at all

		    	// console.log('up');

		    	siteHeader.removeClass('header-main-small');
		    }

		    lastScrollTop = scrollPosition;

		}

	}));


})( jQuery );