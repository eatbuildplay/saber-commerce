<?php

namespace SaberCommerce\Component\Payment;

use \SaberCommerce\Template;

class PaymentComponent extends \SaberCommerce\Component {

	public function init() {

		$this->addShortcodes();

		add_action('wp_enqueue_scripts', [$this, 'addScripts']);
		add_action('wp_enqueue_scripts', [$this, 'addStyles']);

		/* Initiate each payment method */
		$stripePayments = new \SaberCommerce\Component\Payment\Methods\Stripe\StripePayments();
		$stripePayments->init();

	}

	public function addShortcodes() {


	}

	public function addScripts() {


	}

	public function addStyles() {


	}

	public function calculatePaymentAmount( array $invoices ): int {

		$invoiceModel = new \SaberCommerce\Component\Invoice\InvoiceModel;
		$invoice = $invoiceModel->fetchOne( $invoices[0] );
		return $invoice->total * 100;

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

		/* Install Payment Invoice Table */
		$tableName = $wpdb->prefix . 'sacom_payment_invoice';
		$sql = "CREATE TABLE $tableName (
			id_payment_invoice mediumint(9) NOT NULL AUTO_INCREMENT,
			id_payment mediumint(9) NOT NULL,
			id_invoice mediumint(9) NOT NULL,
			amount decimal(10, 2) NOT NULL,
			PRIMARY KEY (id_payment_invoice)
		) $charsetCollate;";
		dbDelta( $sql );

	}


}
