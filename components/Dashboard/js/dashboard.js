(function($) {


	$('#sacom-dashboard-menu li').on('click', function() {


		let section = $(this).data('section');


		console.log('menu click...'+ section)

		loadSection( section );

	});


	function loadSection( section ) {

		var data = {
			section: section
		}
		wp.ajax.post( 'sacom_dashboard_section_load', data ).done( function( response ) {

			console.log( response );

			let template = $( response.template );
			$('#dashboard-canvas').html( template );

		});

	}

	/* Load timesheet on button click */
	$( document ).on('click', '.button-timesheet-view', function() {

		let timesheet = $(this).data('timesheet');
		var data = {
			timesheet: timesheet
		}
		wp.ajax.post( 'sacom_dashboard_timesheet_load', data ).done( function( response ) {

			console.log( response );

			let template = $( response.template );
			$('#timesheet-single-canvas').html( template );

		});

	});





})( jQuery );
