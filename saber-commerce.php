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
define('ESABER_COMMERCE_URL', plugin_dir_url(__FILE__));

class Plugin {

	public function __construct() {

		$this->registerAutoloader();

		new Component;

	}

	public function registerAutoloader() {

		spl_autoload_register( [$this, 'autoload'] );

	}

	public function autoload( $className ) {

		// var_dump( substr( $className, 0, 13 ) );

		if( substr( $className, 0, 13 ) == 'SaberCommerce' ) {

			$classFileName = str_replace( 'SaberCommerce\\', '', $className );
			require( SABER_COMMERCE_PATH . 'inc/' . $classFileName . '.php' );

		}


	}

	public static function activation() {

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
