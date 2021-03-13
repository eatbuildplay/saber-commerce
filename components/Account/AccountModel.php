<?php

namespace SaberCommerce\Component\Account;

use \SaberCommerce\Template;

class AccountModel {

	public $accountId;
	public $projectId;
	public $label;
	public $dateStart;
	public $dateEnd;
	protected $billableRate;
	public $table = 'account';

	public function fetch( $accountId ) {

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_account = $accountId";
		$tss = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);

		foreach( $tss as $index => $account ) {

			$tss[ $index ] = $this->load( $account );

		}

		return $tss;

	}

	public function fetchAll() {

		global $wpdb;
		$where = '1=1';
		$tss = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);

		foreach( $tss as $index => $account ) {

			$tss[ $index ] = $this->load( $account );

		}

		return $tss;

	}

	/*
	 * Fetch one account from database
	 */
	public function fetchOne( $accountId ) {

		$this->accountId = $accountId;

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_account = $accountId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where" .
			" LIMIT 1"
		);
		$account = $result[0];

		$this->load( $account );

		return $account;

	}

	/*
	 * Loading function for single accounts
	 */
	public function load( $account ) {

		return $account;

	}

	public function save() {

		if( !$this->accountId ) {
			return;
		}

		global $wpdb;
		$tableName = $wpdb->prefix . 'sacom_' . $this->table;

		if( !$this->accountId ) {

			$wpdb->insert( $tableName, [
				'id_account'  => $this->accountId,
				'id_project'  => $this->projectId,
				'label'       => $this->label,
				'date_start'  => $this->dateStart,
				'date_end'    => $this->dateEnd
			]);

		} else {

			$wpdb->update( $tableName,
				[
					'id_account'  => $this->accountId,
					'id_project'  => $this->projectId,
					'label'       => $this->label,
					'date_start'  => $this->dateStart,
					'date_end'    => $this->dateEnd
				],
				[ 'id_account' => $this->accountId ]
			);

		}

	}

	public function delete() {

		if( !$this->accountId ) {
			return;
		}

		global $wpdb;
		$wpdb->delete( $this->tableName(), [
				'id_account' => $this->accountId
			]
		);

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
