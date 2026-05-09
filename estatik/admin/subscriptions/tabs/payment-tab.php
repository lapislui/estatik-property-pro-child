<?php
/**
 * Estatik subscriptions payment settings override.
 * Keeps native PayPal fields and adds Razorpay bridge credentials in the same area.
 */
?>
<?php
$paypal_mode_options = array(
	'sandbox' => __( 'Sandbox (test mode)', 'es' ),
	'live'    => __( 'Live', 'es' ),
);
?>

<h3><?php _e( 'PayPal Settings', 'es' ); ?></h3>

<div class="es-fields-wrap">
	<form method="post" class="js-es-settings-form">
		<?php es_settings_field_render( 'is_paypal_payment_method_enabled', array(
			'label' => __( 'Enable PayPal payment method', 'es' ),
			'type'  => 'switcher',
			'attributes' => array(
				'data-toggle-container' => '#es-paypal-settings',
			),
		) ); ?>

		<div id="es-paypal-settings">
			<?php
			es_settings_field_render( 'paypal_mode', array(
				'label'   => __( 'PayPal mode', 'es' ),
				'type'    => 'select',
				'options' => $paypal_mode_options,
			) );

			es_settings_field_render( 'paypal_client_id', array(
				'label' => __( 'Client ID', 'es' ),
				'type'  => 'text',
			) );

			es_settings_field_render( 'paypal_client_secret', array(
				'label' => __( 'Client Secret', 'es' ),
				'type'  => 'text',
			) );
			?>
		</div>

		<hr style="margin:24px 0;">
		<h4 style="margin:0 0 16px;"><?php esc_html_e( 'Razorpay Bridge Settings', 'estatik-razorpayment-addon' ); ?></h4>
		<p style="margin:0 0 18px;"><?php esc_html_e( 'These fields are used by the custom request-payment bridge, not by native PayPal subscriptions.', 'estatik-razorpayment-addon' ); ?></p>

		<?php
		es_settings_field_render( 'is_razorpay_payment_method_enabled', array(
			'label' => __( 'Enable Razorpay payment method', 'estatik-razorpayment-addon' ),
			'type'  => 'switcher',
			'attributes' => array(
				'data-toggle-container' => '#es-razorpay-settings',
			),
		) );
		?>

		<div id="es-razorpay-settings">
		<?php
		es_settings_field_render( 'razorpay_key_id', array(
			'label' => __( 'Razorpay API Key ID', 'estatik-razorpayment-addon' ),
			'type'  => 'text',
		) );

		es_settings_field_render( 'razorpay_key_secret', array(
			'label' => __( 'Razorpay API Key Secret', 'estatik-razorpayment-addon' ),
			'type'  => 'password',
		) );

		es_settings_field_render( 'razorpay_show_requests_payments_section', array(
			'label' => __( 'Show Payments menu in Estatik', 'estatik-razorpayment-addon' ),
			'type'  => 'switcher',
		) );
		?>
		</div>

		<?php wp_nonce_field( 'es_save_settings' ); ?>

		<input type="hidden" name="action" value="es_save_settings"/>
		<input type="submit" style="margin-top: 24px;" class="es-btn es-btn--primary es-btn--large es-btn--save js-es-save-settings" value="<?php _e( 'Save changes', 'es' ); ?>"/>
	</form>
</div>
