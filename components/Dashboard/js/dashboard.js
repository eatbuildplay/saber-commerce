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


	/* Load invoice on button click */
	$( document ).on('click', '.button-invoice-view', function() {

		let invoiceId = $(this).data('id');
		var data = {
			invoice: invoiceId
		}
		wp.ajax.post( 'sacom_dashboard_invoice_load', data ).done( function( response ) {

			console.log( response );

			let template = $( response.template );
			$('#invoice-single-canvas').html( template );

		});

	});

	/* Load payment screen on button click. */
	$( document ).on('click', '.button-invoice-pay', function() {

		let invoiceId = $(this).data('id');
		var data = {
			invoice: invoiceId
		}
		wp.ajax.post( 'sacom_dashboard_checkout_load', data ).done( function( response ) {

			console.log( response );

			let template = $( response.template );
			$('#invoice-single-canvas').html( template );

			$('#sacom-invoices-table').hide();

			setupStripe( response.invoice.invoiceId );

		});

	});

})( jQuery );
