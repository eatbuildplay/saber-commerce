<?php

/**
 *
 * Plugin Name: Saber Commerce
 * Plugin URI: https://eatbuildplay.com/plugins/saber-commerce/
 * Description: Powerful ecommerce software for WordPress sites.
 * Version: 1.0.0
 * Author: Eat/Build/Play
 * Author URI: https://eatbuildplay.com/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace SaberCommerce;

define('SABER_COMMERCE_PLUGIN_NAME', 'Saber Commerce');
define('SABER_COMMERCE_VERSION', '0.0.1');
define('SABER_COMMERCE_PATH', plugin_dir_path(__FILE__));
define('SABER_COMMERCE_URL', plugin_dir_url(__FILE__));

class Plugin {

	public function __construct() {

		$this->registerAutoloader();

		$c = new Component\Account\AccountComponent();
		$c->init();

		$c = new Component\Admin\AdminComponent();
		$c->init();

		$c = new Component\Dashboard\DashboardComponent();
		$c->init();

		$c = new Component\Timesheet\TimesheetComponent();
		$c->init();

		$c = new Component\Workspace\WorkspaceComponent();
		$c->init();

		$c = new Component\Invoice\InvoiceComponent();
		$c->init();

		$c = new Component\Payment\PaymentComponent();
		$c->init();

	}

	public function registerAutoloader() {

		spl_autoload_register( [$this, 'autoload'] );

	}

	public function autoload( $className ) {

		// Load from /component
		if( substr( $className, 0, 24 ) == 'SaberCommerce\Component\\' ) {

			$classFileName = str_replace( 'SaberCommerce\Component\\', '', $className );
			require( SABER_COMMERCE_PATH . 'components/' . $classFileName . '.php' );
			return;

		}

		// Load from /inc
		if( substr( $className, 0, 13 ) == 'SaberCommerce' ) {

			$classFileName = str_replace( 'SaberCommerce\\', '', $className );
			require( SABER_COMMERCE_PATH . 'inc/' . $classFileName . '.php' );
			return;

		}


	}

	public static function activation() {

		$c = new Component\Timesheet\TimesheetComponent();
		$c->activation();

		$c = new Component\Workspace\WorkspaceComponent();
		$c->activation();

		$c = new Component\Invoice\InvoiceComponent();
		$c->activation();

		$c = new Component\Payment\PaymentComponent();
		$c->activation();

	}

	public static function deactivation() {

	}

}

new Plugin();

/*
 * Activation and deactivation hooks
 */
register_activation_hook(__FILE__, '\SaberCommerce\Plugin::activation');
register_deactivation_hook(__FILE__, '\SaberCommerce\Plugin::deactivation');
