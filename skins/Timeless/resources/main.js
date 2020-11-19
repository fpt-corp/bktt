$( function () {
	$( '#sidebar-button' ).on( 'click', function () {
		if ($('#mw-site-navigation').css('display') == 'none') {
			$('#mw-site-navigation').css('display','block')
		} else {
		        $('#mw-site-navigation').css('display','none')
		}
	} );
} );
