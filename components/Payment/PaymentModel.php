<?php

namespace SaberCommerce\Component\Payment;

class PaymentModel {

	public $paymentId;
	public $invoices = [];
	public $invoiceModels = [];
	public $table = 'payment';

	public function save() {

		global $wpdb;

		$data = [
			'id_payment_method' => 49,
			'memo' 							=> $this->memo,
		];

		if( !$this->paymentId ) {

			$wpdb->insert( $this->tableName(), $data);

		} else {

			$wpdb->update( $tableName, $data,
				[ 'id_payment' => $this->paymentId ]
			);

		}

		/* Create and save the PaymentInvoiceModel(s) */
		$this->createPaymentInvoiceModels();

	}

	private function createPaymentInvoiceModels() {

		if( empty( $this->invoices )) {
			return false;
		}

		foreach( $this->invoices as $invoiceId ) {

			$pim                   = new PaymentInvoiceModel();
			$pim->paymentId        = $this->paymentId;
			$pim->invoiceId        = $this->invoiceId;
			$pim->amount           = $this->invoiceId;
			$this->invoiceModels[] = $pim;

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
