/* Popout menus (header) */

$( function () {

	$( '#sidebar-button' ).on( 'click', function () {
		if ($('#mw-site-navigation').css('display') == 'none') {
			$('#mw-site-navigation').css('display','block');
			$('#sidebar-button').css('background-image','url(https://bktt.vn/skins/Timeless/resources/images/nume.svg)');
		} else {
		        $('#mw-site-navigation').css('display','none');
			$('#sidebar-button').css('background-image','url(https://bktt.vn/skins/Timeless/resources/images/menu.svg)');
			$('#sidebar-button').blur();
		}
	} );
	
} );
