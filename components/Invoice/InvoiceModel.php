<?php

namespace SaberCommerce\Component\Invoice;

use \SaberCommerce\Template;

class InvoiceModel {

	public $invoiceId;
	public $accountId;
	public $title;
	public $table = 'invoice';

	public function fetch( $accountId ) {

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_account = $accountId";
		$results = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);

		foreach( $results as $index => $invoice ) {

			$results[ $index ] = $this->load( $invoice );

		}

		return $results;

	}

	/*
	 * Fetch one invoice from database
	 */
	public function fetchOne( $invoiceId ) {

		$this->invoiceId = $invoiceId;

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_invoice = $invoiceId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where" .
			" LIMIT 1"
		);
		$invoice = $result[0];

		$this->load( $invoice );

		return $invoice;

	}

	/*
	 * Loading function for single invoices
	 */
	public function load( $invoice ) {

		// load line items
		$m = new InvoiceLineModel();
		$invoice->lines = $m->fetch( $invoice->id_invoice );

		// calculate total
		$total = 0;
		foreach( $invoice->lines as $line ) {
			$total += $line->amount;
		}
		$invoice->total = round( $total, 2 );

		return $invoice;

	}

	public function save() {

		if( !$this->accountId ) {
			return;
		}

		global $wpdb;
		$tableName = $wpdb->prefix . 'sacom_' . $this->table;

		$data = [
			'id_account'  => $this->accountId,
			'title'       => $this->title,
		];

		if( !$this->invoiceId ) {

			$wpdb->insert( $tableName, $data );

		} else {

			$wpdb->update( $tableName, $data,
				[ 'id_invoice' => $this->invoiceId ]
			);

		}

	}

	public function delete() {

		if( !$this->invoiceId ) {
			return;
		}

		global $wpdb;
		$wpdb->delete( $this->tableName(), [
				'id_invoice' => $this->invoiceId
			]
		);

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
