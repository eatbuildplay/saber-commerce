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
	protected $billableRate;
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

	public function fetchOne( $timesheetId ) {

		$this->timesheetId = $timesheetId;

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_timesheet = $timesheetId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where" .
			" LIMIT 1"
		);
		$timesheet = $result[0];

		$tsem = new TimesheetEntryModel();
		$timesheet->entries = $tsem->fetch( $timesheetId );

		/* calculate totals */
		$timesheet->totals = new \stdClass;
		foreach( $timesheet->entries as $e ) {
			$timesheet->totals->minutes += $e->duration;
		}
		$timesheet->totals->hours = round( $timesheet->totals->minutes / 60, 2 );

		/* load billable rate */
		if( !$timesheet->billable_rate ) {
			// fetch billable rate from workspace
			
		}

		return $timesheet;

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
