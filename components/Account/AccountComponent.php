<?php

namespace SaberCommerce\Component\Account;

use \SaberCommerce\Template;

class AccountComponent extends \SaberCommerce\Component {

	public function init() {

		$this->addShortcodes();

		add_action('wp_enqueue_scripts', [$this, 'addScripts']);

		add_action('wp_ajax_sacom_login_form_process', [$this, 'loginFormProcess']);

	}

	public function loginFormProcess() {

		// send response
		$response = new \stdClass();
		$response->code = 200;
		wp_send_json_success( $response );

	}

	public function addShortcodes() {

		add_shortcode('saber_commerce_account_register', function() {

			$template = new Template();
			$template->path = 'components/Account/templates/';
			$template->name = 'register_form';
			return $template->get();

		});

		add_shortcode('saber_commerce_account_login', function() {

			$template = new Template();
			$template->path = 'components/Account/templates/';
			$template->name = 'login_form';
			return $template->get();

		});


	}

	public function addScripts() {

		wp_enqueue_script(
			'bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js',
			['jquery'],
			'5.0.0',
			true
	  );

		wp_enqueue_script(
			'sacom-parsely',
			SABER_COMMERCE_URL . '/components/Account/js/parsely.min.js',
			['jquery'],
			'2.9.2',
			true
	  );

		wp_enqueue_script(
			'sacom-login-form-script',
			SABER_COMMERCE_URL . '/components/Account/js/login-form.js',
			['jquery', 'wp-util'],
			'1.0.0',
			true
	  );


	}



}
