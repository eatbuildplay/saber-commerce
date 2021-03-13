<?php

namespace SaberCommerce\Component\Workspace;

use \SaberCommerce\Template;

class WorkspaceModel {

	public $workspaceId;
	public $accountId;
	public $title;
	public $table = 'workspace';

	public function fetch( $accountId ) {

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_account = $accountId";
		$results = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);

		foreach( $results as $index => $workspace ) {

			$results[ $index ] = $this->load( $workspace );

		}

		return $results;

	}

	public function fetchAll() {

		global $wpdb;
		$where = '1=1';
		$results = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where"
		);

		foreach( $results as $index => $workspace ) {

			$results[ $index ] = $this->load( $workspace );

		}

		return $results;

	}

	/*
	 * Fetch one workspace from database
	 */
	public function fetchOne( $workspaceId ) {

		$this->workspaceId = $workspaceId;

		global $wpdb;
		$where = '1=1';
		$where .= " AND id_workspace = $workspaceId";
		$result = $wpdb->get_results(
			"SELECT * FROM " .
			$this->tableName() .
			" WHERE $where" .
			" LIMIT 1"
		);
		$workspace = $result[0];

		$this->load( $workspace );

		return $workspace;

	}

	/*
	 * Loading function for single workspaces
	 */
	public function load( $workspace ) {

		return $workspace;

	}

	public function save() {

		if( !$this->accountId ) {
			return;
		}

		global $wpdb;
		$tableName = $wpdb->prefix . 'sacom_' . $this->table;

		$data = [
			'id_account'  => $this->accountId,
			'id_project'  => $this->projectId,
			'title'       => $this->title,
		];

		if( !$this->workspaceId ) {

			$wpdb->insert( $tableName, $data );

		} else {

			$wpdb->update( $tableName, $data,
				[ 'id_workspace' => $this->workspaceId ]
			);

		}

	}

	public function delete() {

		if( !$this->workspaceId ) {
			return;
		}

		global $wpdb;
		$wpdb->delete( $this->tableName(), [
				'id_workspace' => $this->workspaceId
			]
		);

	}

	protected function tableName() {

		global $wpdb;
		return $wpdb->prefix . 'sacom_' . $this->table;

	}


}
