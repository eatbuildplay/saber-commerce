<?php

namespace SaberCommerce\Component\Dashboard;

use \SaberCommerce\Template;

class DashboardComponent extends \SaberCommerce\Component {

	public function init() {

		$this->addShortcodes();

		add_action('wp_enqueue_scripts', [$this, 'addScripts']);
		add_action('wp_enqueue_scripts', [$this, 'addStyles']);


		add_action('wp_ajax_sacom_dashboard_section_load', [$this, 'sectionLoad']);

	}

	public function sectionLoad() {

		$section = $_POST['section'];

		$user = wp_get_current_user();

		// open response
		$response = new \stdClass();
		$response->code = 200;

		$response->user = $user;

		// load profile template
		$template = new Template();
		$template->path = 'components/Dashboard/templates/';
		$template->name = 'section-' . $section;
		$template->data['user'] = $user;
		$response->template = $template->get();

		// send response
		wp_send_json_success( $response );

	}

	public function addShortcodes() {

		add_shortcode('sacom_dashboard', function() {

			$template = new Template();
			$template->path = 'components/Dashboard/templates/';
			$template->name = 'main';
			return $template->get();

		});

	}

	public function addStyles() {

		wp_enqueue_style(
			'sacom-dashboard-style',
			SABER_COMMERCE_URL . '/components/Dashboard/css/dashboard.css',
			[],
			time()
	  );

	}

	public function addScripts() {

		wp_enqueue_script(
			'sacom-dashboard-script',
			SABER_COMMERCE_URL . '/components/Dashboard/js/dashboard.js',
			['jquery', 'wp-util'],
			time(),
			true
	  );

	}



}
