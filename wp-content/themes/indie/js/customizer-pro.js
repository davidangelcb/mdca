( function( $ ) {

	// Add Discovery Pro message
	upgrade = $('<a class="indie-customize-plus"></a>')
		.attr('href', 'https://www.templateexpress.com/indie-pro-theme')
		.attr('target', '_blank')
		.text(pro_object.pro_message);
	;
	$('.preview-notice').append(upgrade);
	// Remove accordion click event
	$('.indie-customize-plus').on('click', function(e) {
		e.stopPropagation();
	});

} )( jQuery );
