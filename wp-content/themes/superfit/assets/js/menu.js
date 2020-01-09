jQuery(function($) {
	$('.navbar .dropdown').hover(function() {
	jQuery(this).find('.dropdown-menu').first().stop(true, true).addClass('show-menu');

	}, function() {
	jQuery(this).find('.dropdown-menu').first().stop(true, true).removeClass('show-menu');

	});

	jQuery('.desktop-nav .dropdown > a').click(function(){
	location.href = this.href;
	});

});