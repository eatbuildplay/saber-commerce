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

			$wpdb->update( $this->tableName(), $data,
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

	public function fetch( $accountId ) {

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_account = $accountId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);
		return $result;

	}

	public function fetchOne( $paymentId ) {

		$this->paymentId = $paymentId;

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_payment = $paymentId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where" .
			" LIMIT 1"
		);

		$paymentData = $result[0];

		$payment = new PaymentModel();
		$payment->paymentId = $paymentData->id_payment;
		$payment->memo = $paymentData->memo;
		return $payment;

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
