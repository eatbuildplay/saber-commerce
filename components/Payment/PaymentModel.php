<?php

namespace SaberCommerce\Component\Payment;

class PaymentModel {

	public $table = 'payment';

	public function save() {

		global $wpdb;

		$data = [
			'id_payment_method' => 49,
			'memo' => $this->memo,
		];

		if( !$this->paymentId ) {

			$wpdb->insert( $this->tableName(), $data);

		} else {

			$wpdb->update( $tableName, $data,
				[ 'id_payment' => $this->paymentId ]
			);

		}

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}