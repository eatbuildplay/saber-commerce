<?php

namespace SaberCommerce\Component\Payment\Methods\Stripe;

class StripePayments extends \SaberCommerce\Component\Payment\PaymentMethod {

	public function getTitle() {
		return "Stripe";
	}

	public function init() {

		require SABER_COMMERCE_PATH . 'components/Payment/Methods/Stripe/vendor/autoload.php';

		add_action('wp_enqueue_scripts', [$this, 'addScripts']);
		add_action('wp_enqueue_scripts', [$this, 'addStyles']);

		add_filter("page_template", function( $page_template ) {

			$id = substr($page_template, strrpos($page_template, '/') + 1);
			if ( is_page('checkout-session') ) {
				$page_template = SABER_COMMERCE_PATH . 'components/Payment/Methods/Stripe/templates/checkout-session.php';
			}

			return $page_template;

		});

		add_action('wp_ajax_sacom_stripe_checkout', function() {

			\Stripe\Stripe::setApiKey('sk_test_4QKQNDPyqtbt7AvgoWd3uK2o');

			$response = new \stdClass();

			try {
			  // retrieve JSON from POST body
			  $invoices = $_POST['invoices'];
				$paymentComponent = new \SaberCommerce\Component\Payment\PaymentComponent();
				$amount = $paymentComponent->calculatePaymentAmount( $invoices );

			  $paymentIntent = \Stripe\PaymentIntent::create([
					'amount'   => $amount,
					'currency' => 'usd',
				]);

				/* Record Payment Intent as a SACOM Payment */
				$paymentModel = new \SaberCommerce\Component\Payment\PaymentModel();
				$paymentModel->paymentMethod = 'stripe';
				$paymentModel->memo = $paymentIntent->id;
				$paymentModel->save();

				$response->clientSecret = $paymentIntent->client_secret;

				// send response
				$response->code = 200;
				wp_send_json_success( $response );

			} catch (Error $e) {

				http_response_code( 500 );
				echo json_encode(
					[ 'error' => $e->getMessage() ]
				);

			}

			wp_die();

		});

	}

	public function addScripts() {

		wp_enqueue_script(
			'sacom-stripe',
			'https://js.stripe.com/v3/',
			[],
			'3.0.0',
			true
	  );

		wp_enqueue_script(
			'sacom-stripe-client',
			SABER_COMMERCE_URL . '/components/Payment/Methods/Stripe/script/client.js',
			[],
			time(),
			true
	  );

	}

	public function addStyles() {

		wp_enqueue_style(
			'sacom-stripe-form',
			SABER_COMMERCE_URL . '/components/Payment/Methods/Stripe/css/stripe-form.css',
			[],
			time()
	  );

	}

}
