<?php

namespace SaberCommerce\Component\Invoice;

class InvoiceEntryModel {

	public $invoiceLineId;
	public $invoiceId;
	public $memo;
	public $amount;
	public $table = 'invoice_line';

	public function fetch( $invoiceId ) {

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

	public function save() {

		if( !$this->invoiceId ) {
			return;
		}

		global $wpdb;

		$data = [
			'id_invoice' => $this->accountId,
			'memo'         => $this->memo,
			'amount'      => $this->amount
		];

		if( !$this->invoiceId ) {

			$wpdb->insert( $this->tableName(), $data);

		} else {

			$wpdb->update( $tableName, $data,
				[ 'id_invoice_entry' => $this->invoiceEntryId ]
			);

		}

	}

	public function delete() {

		if( !$this->invoiceEntryId ) {
			return;
		}

		global $wpdb;
		$wpdb->delete( $this->tableName(), [
				'id_invoice_entry' => $this->invoiceEntryId
			]
		);

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
