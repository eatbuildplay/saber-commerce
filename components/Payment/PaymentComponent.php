<?php

namespace SaberCommerce\Component\Payment;

use \SaberCommerce\Template;

class PaymentComponent extends \SaberCommerce\Component {

	public function init() {

		$this->addShortcodes();

		add_action('wp_enqueue_scripts', [$this, 'addScripts']);

		add_action('wp_ajax_sacom_login_form_process', [$this, 'loginFormProcess']);

		add_filter("page_template", function( $page_template ) {

			$id = substr($page_template, strrpos($page_template, '/') + 1);
			if ( is_page('checkout-session') ) {
				$page_template = SABER_COMMERCE_PATH . 'components/Payment/Methods/Stripe/templates/checkout-session.php';
			}

			return $page_template;

		});

	}

	public function addShortcodes() {

		add_shortcode('saber_commerce_account_register', function() {

			$template = new Template();
			$template->path = 'components/Account/templates/';
			$template->name = 'register_form';
			return $template->get();

		});

	}

	public function addScripts() {

		wp_enqueue_script(
			'sacom-stripe',
			'https://js.stripe.com/v3/',
			[],
			'3.0.0',
			true
	  );

		wp_enqueue_script(
			'sacom-stripe-client',
			SABER_COMMERCE_URL . '/components/Payment/Methods/Stripe/script/client.js',
			[],
			time(),
			true
	  );

	}

	public function activation() {

		global $wpdb;
		$charsetCollate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		/* Install Payment Table */
		$tableName = $wpdb->prefix . 'sacom_payment';
		$sql = "CREATE TABLE $tableName (
			id_payment mediumint(9) NOT NULL AUTO_INCREMENT,
			id_account mediumint(9) NOT NULL,
			id_payment_method mediumint(9) NOT NULL,
			memo tinytext NOT NULL,
			amount decimal(10, 2) NOT NULL,
			PRIMARY KEY (id_payment)
		) $charsetCollate;";
		dbDelta( $sql );

	}


}
