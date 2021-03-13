<?php

namespace SaberCommerce\Component\Payment;

class PaymentInvoiceModel {

	public $paymentId = 0;
	public $invoiceId = 0;
	public $amount    = 0;
	public $table     = 'payment_invoice';

	public function save() {

		global $wpdb;

		$data = [
			'id_payment_method' => 49,
			'id_invoice'				=> $this->invoiceId,
			'memo' 							=> $this->memo,
		];

		if( !$this->paymentId ) {

			$wpdb->insert( $this->tableName(), $data);

		} else {

			$wpdb->update( $tableName, $data,
				[ 'id_payment' => $this->paymentId ]
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

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
