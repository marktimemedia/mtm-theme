!function($){var a=$(window).scrollTop(),l=$(".header-main");$(window).on("scroll",function(s){var e=$(this).scrollTop();$(window).width()>776?e>100?l.addClass("header-main-small"):l.removeClass("header-main-small"):(e>50&&e>a?l.addClass("header-main-small"):l.removeClass("header-main-small"),a=e)})}(jQuery);