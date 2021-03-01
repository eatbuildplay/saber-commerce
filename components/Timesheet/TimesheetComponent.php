<?php

namespace SaberCommerce\Component\Timesheet;

use \SaberCommerce\Template;

class TimesheetComponent extends \SaberCommerce\Component {

	public function init() {

		$this->addShortcodes();

		add_action('wp_enqueue_scripts', [$this, 'addScripts']);

		add_action('wp_ajax_sacom_login_form_process', [$this, 'loginFormProcess']);

		$m = new TimesheetModel();

		/* Fetch Timesheets
		$tss = $m->fetch(17);
		*/

		/* Delete Timesheet
		$m->timesheetId = 3;
		$m->delete();
		*/

		/* Save Timesheet
		$m->timesheetId = 1;
		$m->accountId = 17;
		$m->projectId = 254;
		$m->label = "Last Week Timesheet";
		$m->dateStart = '2020-02-15';
		$m->dateEnd = '2020-02-22';
		$m->save();
		*/

	}

	public function loginFormProcess() {

		// send response
		$response = new \stdClass();
		$response->code = 200;
		wp_send_json_success( $response );

	}

	public function addShortcodes() {

		add_shortcode('saber_commerce_account_register', function() {

			$template = new Template();
			$template->path = 'components/Account/templates/';
			$template->name = 'register_form';
			return $template->get();

		});

		add_shortcode('saber_commerce_account_login', function() {

			$template = new Template();
			$template->path = 'components/Account/templates/';
			$template->name = 'login_form';
			return $template->get();

		});


	}

	public function addScripts() {

		wp_enqueue_script(
			'bootstrap',
			'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js',
			['jquery'],
			'5.0.0',
			true
	  );

		wp_enqueue_script(
			'sacom-parsely',
			SABER_COMMERCE_URL . '/components/Account/js/parsely.min.js',
			['jquery'],
			'2.9.2',
			true
	  );

		wp_enqueue_script(
			'sacom-login-form-script',
			SABER_COMMERCE_URL . '/components/Account/js/login-form.js',
			['jquery', 'wp-util'],
			'1.0.0',
			true
	  );


	}

	public function activation() {

		global $wpdb;
		$charsetCollate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		/* Install Timesheet Table */
		$tableName = $wpdb->prefix . 'sacom_timesheet';
		$sql = "CREATE TABLE $tableName (
			id_timesheet mediumint(9) NOT NULL AUTO_INCREMENT,
			id_account mediumint(9) NOT NULL,
			id_project mediumint(9) NOT NULL,
			label tinytext NOT NULL,
			date_start datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			date_end datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PRIMARY KEY (id_timesheet)
		) $charsetCollate;";
		dbDelta( $sql );

		/* Install sacom_timesheet Entry Table */
		$tableName = $wpdb->prefix . 'sacom_timesheet_entry';
		$sql = "CREATE TABLE $tableName (
			id_timesheet_entry mediumint(9) NOT NULL AUTO_INCREMENT,
			id_timesheet mediumint(9) NOT NULL,
			memo tinytext NOT NULL,
			time_start datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			time_end datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			duration tinyint(4) NOT NULL,
			PRIMARY KEY (id_timesheet_entry)
		) $charsetCollate;";

		dbDelta( $sql );

	}


}
