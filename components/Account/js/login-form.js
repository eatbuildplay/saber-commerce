(function($) {

	/* setup parsely validation */
	$('#sacom_login_form').parsley();

	$('#sacom_login_form').submit( function( e ) {

		e.preventDefault();
		var values = {}
		values.username = $('#field-username').val();
		values.password = $('#field-password').val();

		wp.ajax.post('sacom_login_form_process', ).done( function( response ) {

			console.log( response );

			/* redirect user to dashboard */

		});

	});





})( jQuery );
