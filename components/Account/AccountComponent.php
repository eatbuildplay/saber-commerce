<?php

namespace SaberCommerce\Component\Account;

use \SaberCommerce\Template;

class AccountComponent extends \SaberCommerce\Component {

	public function init() {

		add_shortcode('saber_commerce_account_register', function() {

			$template = new Template();
			$template->path = 'components/Account/templates/';
			$template->name = 'register_form';
			return $template->get();

		});


	}



}
