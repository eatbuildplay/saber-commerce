<?php

namespace SaberCommerce\Component\Payment;

class PaymentInvoiceModel {

	public $paymentInvoiceId = 0;
	public $paymentId        = 0;
	public $invoiceId        = 0;
	public $amount           = 0;
	public $table            = 'payment_invoice';

	public function save() {

		global $wpdb;

		$data = [
			'id_payment'        => $this->paymentId,
			'id_invoice'				=> $this->invoiceId,
			'amount' 					  => $this->amount,
		];

		if( !$this->paymentInvoiceId ) {

			$wpdb->insert( $this->tableName(), $data);
			$this->paymentInvoiceId = $wpdb->insert_id;

		} else {

			$wpdb->update( $this->tableName(), $data,
				[ 'id_payment_invoice' => $this->paymentId ]
			);

		}

	}

	public function fetchAll() {

		global $wpdb;
		$where = '1=1';
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);
		return $result;

	}

	public function fetchByInvoice( $invoiceId ) {

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_invoice = $invoiceId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);
		return $result;

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
