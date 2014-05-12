$(document).ready(function() {
	
	// facebox
	$('a[rel*=facebox]').facebox();
	
	// ttTipsy
	$('.ttTipsy').tipsy();
	
	// wysiwyg
	$('#wysiwyg').wysiwyg();
	
	// notification
	$('div.notification a.close').click(function() {
		$(this).parent().fadeOut('slow');
	});
	
	// cancel button
	$('input[name=btnCancel]').click(function() {
		window.location = $(this).attr('alt');
	});
});