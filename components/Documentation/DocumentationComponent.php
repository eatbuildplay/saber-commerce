<?php

namespace SaberCommerce\Component\Documentation;

use \SaberCommerce\Template;

class DocumentationComponent extends \SaberCommerce\Component {

	public function init() {

		$this->addShortcodes();

		add_action('wp_enqueue_scripts', [$this, 'addScripts']);
		add_action('wp_enqueue_scripts', [$this, 'addStyles']);

		add_action('wp_ajax_sacom_dashboard_section_load', [$this, 'sectionLoad']);
		add_action('wp_ajax_sacom_dashboard_timesheet_load', [$this, 'timesheetLoad']);
		add_action('wp_ajax_sacom_dashboard_invoice_load', [$this, 'invoiceLoad']);

	}

	public function sectionLoad() {

		$section = $_POST['section'];

		$user = wp_get_current_user();

		// open response
		$response = new \stdClass();
		$response->code = 200;

		$response->user = $user;

		// load section main template
		$template = new Template();
		$template->path = 'components/Documentation/templates/';
		$template->name = 'section-' . $section;
		$template->data['user'] = $user;
		$response->template = $template->get();

		// send response
		wp_send_json_success( $response );

	}

	public function timesheetLoad() {

		$timesheetId = $_POST['timesheet'];

		// open response
		$response = new \stdClass();
		$response->code = 200;

		$user = wp_get_current_user();

		$m = new TimesheetModel();
		$response->timesheet = $m->fetchOne( $timesheetId );



		$response->user = $user;

		// load profile template
		$template = new Template();
		$template->path = 'components/Documentation/templates/';
		$template->name = 'timesheet-single';
		$template->data['timesheet'] = $response->timesheet;
		$response->template = $template->get();

		// send response
		wp_send_json_success( $response );

	}

	public function invoiceLoad() {

		$invoiceId = $_POST['invoice'];

		// open response
		$response = new \stdClass();
		$response->code = 200;

		$user = wp_get_current_user();

		$m = new InvoiceModel();
		$response->invoice = $m->fetchOne( $invoiceId );



		$response->user = $user;

		// load profile template
		$template = new Template();
		$template->path = 'components/Documentation/templates/';
		$template->name = 'invoice-single';
		$template->data['invoice'] = $response->invoice;
		$response->template = $template->get();

		// send response
		wp_send_json_success( $response );

	}

	public function addShortcodes() {

		add_shortcode('sacom_dashboard', function() {

			$template = new Template();
			$template->path = 'components/Documentation/templates/';
			$template->name = 'main';
			return $template->get();

		});

	}

	public function addStyles() {

		wp_enqueue_style(
			'sacom-dashboard-style',
			SABER_COMMERCE_URL . '/components/Documentation/css/dashboard.css',
			[],
			time()
	  );

	}

	public function addScripts() {

		wp_enqueue_script(
			'sacom-dashboard-script',
			SABER_COMMERCE_URL . '/components/Documentation/js/dashboard.js',
			['jquery', 'wp-util'],
			time(),
			true
	  );

	}



}
