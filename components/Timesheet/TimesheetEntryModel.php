<?php

namespace SaberCommerce\Component\Timesheet;

class TimesheetEntryModel {

	public $timesheetEntryId;
	public $timesheetId;
	public $memo;
	public $timeStart;
	public $timeEnd;
	public $duration;
	public $table = 'timesheet_entry';

	public function fetch( $timesheetId ) {

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_timesheet = $timesheetId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);
		return $result;

	}

	public function save() {

		if( !$this->timesheetId ) {
			return;
		}

		global $wpdb;

		$data = [
			'id_timesheet' => $this->accountId,
			'memo'         => $this->memo,
			'time_start'   => $this->timeStart,
			'time_end'     => $this->timeEnd,
			'duration'     => $this->duration
		];

		if( !$this->timesheetId ) {

			$wpdb->insert( $this->tableName(), $data);

		} else {

			$wpdb->update( $tableName, $data,
				[ 'id_timesheet_entry' => $this->timesheetEntryId ]
			);

		}

	}

	public function delete() {

		if( !$this->timesheetEntryId ) {
			return;
		}

		global $wpdb;
		$wpdb->delete( $this->tableName(), [
				'id_timesheet_entry' => $this->timesheetEntryId
			]
		);

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
