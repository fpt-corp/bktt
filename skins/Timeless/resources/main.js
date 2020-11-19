$( function () {
	$( '#sidebar-button' ).on( 'click', function () {
		if ($('#mw-site-navigation').css('display') == 'none') {
			console.log('ddd')
			$('#mw-site-navigation').css('display','block')
		} else {
			console.log('bbbb')
		        $('#mw-site-navigation').css('display','none')
		}
	} );
} );
