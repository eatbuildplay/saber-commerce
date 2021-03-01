<?php

namespace SaberCommerce\Component\Timesheet;

use \SaberCommerce\Template;

class TimesheetModel {

	public $timesheetId;
	public $accountId;
	public $projectId;
	public $label;
	public $dateStart;
	public $dateEnd;
	public $table = 'timesheet';

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

	public function save() {

		if( !$this->accountId ) {
			return;
		}

		global $wpdb;
		$tableName = $wpdb->prefix . 'sacom_' . $this->table;

		if( !$this->timesheetId ) {

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
				[ 'id_timesheet' => $this->timesheetId ]
			);

		}

	}

	public function delete() {

		if( !$this->timesheetId ) {
			return;
		}

		global $wpdb;
		$wpdb->delete( $this->tableName(), [
				'id_timesheet' => $this->timesheetId
			]
		);

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
