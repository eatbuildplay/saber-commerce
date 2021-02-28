(function($) {


	$('#sacom-dashboard-menu li').on('click', function() {


		let section = $(this).data('section');


		console.log('menu click...'+ section)

		loadSection( section );

	});


	function loadSection( section ) {

		var data = {}
		wp.ajax.post( 'sacom_dashboard_section_load', data ).done( function( response ) {

			console.log( response );

			let template = $( response.template );
			$('#dashboard-canvas').html( template );

		});

	}





})( jQuery );
