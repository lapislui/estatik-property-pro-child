<?php
/**
 * Estatik request form override owned by Estatik Razorpayment Addon.
 *
 * @var $args array
 * @var $shortcode_instance Es_Request_Form_Shortcode
 * @var $attributes array
 */

$id                    = uniqid();
$post_id               = ! empty( $attributes['post_id'] ) ? absint( $attributes['post_id'] ) : get_the_ID();
$property_price        = $post_id ? (float) get_post_meta( $post_id, 'es_property_price', true ) : 0;
$property_title        = $post_id ? get_the_title( $post_id ) : get_bloginfo( 'name' );
$property_image        = $post_id && function_exists( 'es_get_the_featured_image_url' ) ? es_get_the_featured_image_url( 'full', $post_id ) : '';
$payment_error_message = '';
$payment_button_attrs  = '';
$era                   = function_exists( 'era_razorpayment_addon' ) ? era_razorpayment_addon() : null;
$has_era_settings      = $era && isset( $era->settings ) && is_object( $era->settings );
$has_era_ajax          = $era && isset( $era->ajax ) && is_object( $era->ajax );
$has_era_assets        = $era && isset( $era->assets ) && is_object( $era->assets );

if ( ! $has_era_settings || ! $era->settings->has_api_credentials() ) {
	$payment_error_message = __( 'Please configure Razorpay API keys first.', 'estatik-razorpayment-addon' );
}

if ( ! $payment_error_message && $property_price <= 0 ) {
	$payment_error_message = __( 'A valid property price is required before checkout can open.', 'estatik-razorpayment-addon' );
}

if ( $payment_error_message ) {
	$payment_button_attrs = ' disabled="disabled" aria-disabled="true"';
}

$payment_data = $has_era_ajax ? $era->ajax->build_payment_data(
	array(
		'amount'        => $property_price,
		'currency'      => 'INR',
		'description'   => sprintf( 'Request payment for property: %s', $property_title ),
		'name'          => '',
		'email'         => '',
		'contact'       => '',
		'message'       => '',
		'product_image' => $property_image,
		'property_id'   => $post_id,
		'request_id'    => 0,
	)
) : array();

if ( $has_era_assets ) {
	$era->assets->enqueue_checkout_assets();
}
?>
<div class="es-component era-estatik-request-wrap">
	<form method="post" class="es-request-form era-estatik-request-form">
		<?php do_action( 'es_before_request_form', $args ); ?>

		<div class="es-request-form__fields">
			<?php if ( $fields = $shortcode_instance->get_fields_config() ) : ?>
				<?php foreach ( $fields as $field_key => $field_config ) : ?>
					<?php
					if ( 'name' === $field_key && ! empty( $attributes['disable_name'] ) ) {
						continue;
					}
					if ( 'phone' === $field_key && ! empty( $attributes['disable_tel'] ) ) {
						continue;
					}
					if ( 'email' === $field_key && ! empty( $attributes['disable_email'] ) ) {
						continue;
					}
					es_framework_field_render( $field_key, $field_config );
					?>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php wp_nonce_field( 'es_submit_request_form', 'es_request_form_nonce_' . $id ); ?>
			<?php do_action( 'es_recaptcha', 'request_form' ); ?>

			<input type="hidden" name="uniqid" value="<?php echo esc_attr( $id ); ?>">
			<input type="hidden" name="action" value="es_submit_request_form">
			<input type="hidden" name="era_request_id" value="0">

			<?php if ( ! empty( $attributes['post_id'] ) ) : ?>
				<input type="hidden" name="post_id" value="<?php echo esc_attr( $attributes['post_id'] ); ?>">
			<?php endif; ?>

			<?php if ( ! empty( $attributes['subject'] ) ) : ?>
				<input type="hidden" name="subject" value="<?php echo esc_attr( $attributes['subject'] ); ?>">
			<?php endif; ?>

			<input type="hidden" name="recipient_type" value="<?php echo esc_attr( $attributes['recipient_type'] ); ?>">

			<?php if ( ! empty( $attributes['custom_email'] ) ) : ?>
				<input type="hidden" name="send_to_emails" value="<?php echo esc_attr( $attributes['custom_email'] ); ?>">
			<?php endif; ?>

			<?php do_action( 'es_before_request_form_submit_button', $args ); ?>
			<?php do_action( 'es_privacy_policy', 'request_form' ); ?>

			<div class="es-btn-wrapper es-btn-wrapper--center es-btn-wrapper-submit--margin era-razorpay-wrap">
				<button type="submit" class="es-btn es-btn--primary">
					<?php echo esc_html( $attributes['button_text'] ); ?>
				</button>

				<button type="button"
						class="era-razorpay-button"
						style="display:none;"
						data-payment="<?php echo esc_attr( wp_json_encode( $payment_data ) ); ?>"<?php echo $payment_button_attrs; ?>>
				</button>

				<div class="era-razorpay-message"><?php echo esc_html( $payment_error_message ); ?></div>
			</div>

			<?php do_action( 'es_after_request_form', $args ); ?>
		</div>
	</form>
</div>

<div id="era-payment-result-modal" class="era-payment-result-modal" aria-hidden="true">
	<div class="era-payment-result-modal__overlay js-era-payment-result-overlay-close"></div>
	<div class="era-payment-result-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="era-payment-result-title">
		<button type="button" class="era-payment-result-modal__close js-era-payment-result-close" aria-label="<?php echo esc_attr__( 'Close payment result', 'estatik-razorpayment-addon' ); ?>">&times;</button>
		<h3 id="era-payment-result-title" class="era-payment-result-modal__title"></h3>
		<div id="era-payment-result-body" class="era-payment-result-modal__body"></div>
		<div id="era-payment-result-actions" class="era-payment-result-modal__actions"></div>
	</div>
</div>
