<?php

namespace SaberCommerce\Component\Admin;

use \SaberCommerce\Template;

class AdminComponent extends \SaberCommerce\Component {

	public function init() {

		add_action( 'admin_menu', function() {

			add_menu_page(
				'Saber Commerce',
				'Saber Commerce',
				'manage_options',
				'sacom',
				[ $this, 'adminDashboardCallback' ]
			);

			add_submenu_page(
				'sacom',
				'Payments',
				'Payments',
				'manage_options',
				'sacom-payments',
				[ $this, 'adminPaymentsCallback' ]
			);

			add_submenu_page(
				'sacom',
				'Invoices',
				'Invoices',
				'manage_options',
				'sacom-invoices',
				[ $this, 'adminInvoicesCallback' ]
			);

			add_submenu_page(
				'sacom',
				'Accounts',
				'Accounts',
				'manage_options',
				'sacom-accounts',
				[ $this, 'adminAccountsCallback' ]
			);

			add_submenu_page(
				'sacom',
				'Timesheets',
				'Timesheets',
				'manage_options',
				'sacom-timesheets',
				[ $this, 'adminTimesheetsCallback' ]
			);

			add_submenu_page(
				'sacom',
				'Workspaces',
				'Workspaces',
				'manage_options',
				'sacom-workspaces',
				[ $this, 'adminWorkspacesCallback' ]
			);

		});

	}

	public function adminDashboardCallback() {

		print 'SACOM DASH...';

	}

	public function adminPaymentsCallback() {

		print '<h1>SACOM PAYMENTS</h1>';

		$paymentModel = new \SaberCommerce\Component\Payment\PaymentModel();
		$paymentList = $paymentModel->fetchAll();

		var_dump( $paymentList );

	}

	public function adminInvoicesCallback() {

		print '<h1>SACOM INVOICES</h1>';

		$invoiceModel = new \SaberCommerce\Component\Invoice\InvoiceModel();
		$invoiceList = $invoiceModel->fetchAll();

		var_dump( $invoiceList );

	}

	public function adminAccountsCallback() {

		print '<h1>SACOM INVOICES</h1>';

		$accountModel = new \SaberCommerce\Component\Account\AccountModel();
		$accountList = $accountModel->fetchAll();

		var_dump( $accountList );

	}

	public function adminTimesheetsCallback() {

		print '<h1>SACOM INVOICES</h1>';

		$timesheetModel = new \SaberCommerce\Component\Timesheet\TimesheetModel();
		$timesheetList = $timesheetModel->fetchAll();

		var_dump( $timesheetList );

	}

	public function adminWorkspacesCallback() {

		print '<h1>WORKSPACES</h1>';

		$workspaceModel = new \SaberCommerce\Component\Workspace\WorkspaceModel();
		$workspaceList = $workspaceModel->fetchAll();

		var_dump( $workspaceList );

	}

	public function addShortcodes() {

		add_shortcode('saber_commerce_admin_register', function() {

			$template = new Template();
			$template->path = 'components/Admin/templates/';
			$template->name = 'register_form';
			return $template->get();

		});

		add_shortcode('saber_commerce_admin_login', function() {

			$template = new Template();
			$template->path = 'components/Admin/templates/';
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
			SABER_COMMERCE_URL . '/components/Admin/js/parsely.min.js',
			['jquery'],
			'2.9.2',
			true
	  );

		wp_enqueue_script(
			'sacom-login-form-script',
			SABER_COMMERCE_URL . '/components/Admin/js/login-form.js',
			['jquery', 'wp-util'],
			'1.0.0',
			true
	  );


	}



}
