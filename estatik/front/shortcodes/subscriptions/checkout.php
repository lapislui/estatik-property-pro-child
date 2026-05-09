<?php
$plan = es_get_subscription_plan( es_get( 'plan' ) );
$price_period = es_get( 'period' );
$suff = es_price_suff( $price_period );
$amount = es_format_value( $plan->{$price_period . '_price'}, 'price', array( 'suff' => ' / ' . $suff ) );
$auto_start_paypal = get_current_user_id() && current_user_can( 'agent' ) && ! empty( $_GET['era_autostart_paypal'] );
$auto_start_razorpay = get_current_user_id() && current_user_can( 'agent' ) && ! empty( $_GET['era_autostart_razorpay'] );
$era = function_exists( 'era_razorpayment_addon' ) ? era_razorpayment_addon() : null;
$has_era_assets = $era && isset( $era->assets ) && is_object( $era->assets );
$has_era_ajax = $era && isset( $era->ajax ) && is_object( $era->ajax );
$has_paypal = function_exists( 'ests' ) && (bool) ests( 'is_paypal_payment_method_enabled' ) && ! $plan->is_free_plan_enabled;
$has_razorpay = $era && $era->settings->has_api_credentials() && ! $plan->is_free_plan_enabled;
$razorpay_message = '';

if ( $has_razorpay && $has_era_assets ) {
	$era->assets->enqueue_checkout_assets();
}

if ( ! $plan->get_wp_entity() )
    wp_die( __( 'Plan doesn\'t exist.', 'es' ) );

if ( ! current_user_can( 'agent' ) || ! get_current_user_id() )
    wp_die( __( 'You are not authorized for access this page', 'es' ) ); ?>

<div class="es-checkout content-font">
    <h2 class="heading-font"><?php _e( 'Payment details', 'es' ); ?></h2>

    <p>
        <b><?php echo __( $plan->name, 'es' ); ?></b>
        <?php if ( ! $plan->is_free_plan_enabled ) : ?>
            <b><?php echo $amount; ?></b>
        <?php endif; ?>
    </p>
    <?php if ( $plan->is_basic_listings_limited ) : ?>
        <p class="es-checkout__info"><?php printf( _n( '%s basic listing', '%s basic listings', $plan->basic_listings_limit ), $plan->basic_listings_limit ); ?></p>
    <?php else : ?>
        <p class="es-checkout__info"><?php _e( 'Unlimited basic listings', 'es' ); ?></p>
    <?php endif; ?>

    <?php if ( $plan->is_featured_listings_limited ) : ?>
        <p class="es-checkout__info"><?php printf( _n( '%s featured listing', '%s featured listings', $plan->featured_listings_limit ), $plan->featured_listings_limit ); ?></p>
    <?php else : ?>
        <p class="es-checkout__info"><?php _e( 'Unlimited featured listings', 'es' ); ?></p>
    <?php endif; ?>

    <?php if ( $plan->is_agencies_limited ) : ?>
        <p class="es-checkout__info"><?php printf( _n( '%s agencies', '%s featured agencies', $plan->agencies_limit ), $plan->agencies_limit ); ?></p>
    <?php else : ?>
        <p class="es-checkout__info"><?php _e( 'Unlimited featured agencies', 'es' ); ?></p>
    <?php endif; ?>

    <form method="post" class="era-subscription-checkout-form">
        <div class="es-checkout__bottom">
	        <?php if ( ! $plan->is_free_plan_enabled ) : ?>
                <b class="es-total heading-font"><?php _ex( 'Total:', 'subscriptions total label', 'es' ); ?> <span><?php echo $amount; ?></span></b>
            <?php endif; ?>

	        <?php if ( get_current_user_id() ) : ?>
		        <?php if ( ! $plan->is_free_plan_enabled ) : ?>
                    <div class="era-checkout-actions">
			            <?php if ( $has_paypal ) : ?>
                            <button type="submit" class="es-btn es-btn--primary es-btn--buy">
				                <?php _e( 'Pay with PayPal', 'es' ); ?>
                            </button>
			            <?php endif; ?>
			            <?php if ( $has_razorpay ) : ?>
                            <?php
                            $payment_data = $has_era_ajax ? $era->ajax->build_payment_data( array(
                            	'amount'       => (float) $plan->get_amount( $price_period ),
                            	'currency'     => ests( 'currency' ),
                            	'description'  => sprintf( 'Subscription payment for %s (%s)', $plan->name, ucfirst( $price_period ) ),
                            	'payment_type' => 'razorpay-subscriptions',
                            ) ) : array();
                            $payment_data['checkoutContext'] = 'subscription';
                            $payment_data['planId'] = $plan->get_id();
                            $payment_data['period'] = $price_period;
                            ?>
                            <?php if ( $has_era_ajax ) : ?>
                                <button type="button"
                                        class="es-btn es-btn--buy era-razorpay-subscription-button"
                                        data-payment="<?php echo esc_attr( wp_json_encode( $payment_data ) ); ?>">
						            <?php esc_html_e( 'Pay with Razorpay', 'estatik-razorpayment-addon' ); ?>
                                </button>
                            <?php endif; ?>
			            <?php endif; ?>
                    </div>
			        <?php if ( $has_razorpay && $has_era_ajax ) : ?>
                        <div class="era-razorpay-message"><?php echo esc_html( $razorpay_message ); ?></div>
			        <?php endif; ?>
			        <?php if ( ! $has_paypal && ! ( $has_razorpay && $has_era_ajax ) ) : ?>
                        <div class="era-razorpay-message"><?php esc_html_e( 'No payment method is currently enabled. Please contact the site administrator.', 'estatik-razorpayment-addon' ); ?></div>
			        <?php endif; ?>
		        <?php else : ?>
                    <button type="submit" class="es-btn es-btn--primary es-btn--buy">
				        <?php _e( 'Activate', 'es' ); ?>
                    </button>
		        <?php endif; ?>
            <?php else : ?>
                <?php if ( $url = es_get_page_url( 'login' ) ) : ?>
                    <a href="<?php echo add_query_arg( 'redirect_url', rawurlencode( es_get_current_url() ), $url ); ?>" class="es-btn es-btn--primary es-btn--buy"><?php _e( 'Buy now', 'es' ); ?></a>
                <?php else : ?>
                    <a href="#es-authentication-popup" class="es-btn es-btn--primary es-btn--buy js-es-popup-link">
				        <?php _e( 'Pay now', 'es' ); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <input type="hidden" name="plan_id" value="<?php esc_attr_e( $plan->get_id() ); ?>"/>
            <input type="hidden" name="period" value="<?php esc_attr_e( $price_period ); ?>"/>
            <input name="payment_type" type="hidden" value="plans"/>
            <input name="payment_method" type="hidden" value="<?php echo esc_attr( $has_paypal ? 'paypal-subscriptions' : '' ); ?>"/>
            <?php wp_nonce_field( 'es_submit_payment', 'es_submit_payment' ); ?>
        </div>
    </form>
</div>

<?php if ( $has_razorpay && $has_era_ajax ) : ?>
<div id="era-payment-result-modal" class="era-payment-result-modal" aria-hidden="true">
	<div class="era-payment-result-modal__overlay js-era-payment-result-overlay-close"></div>
	<div class="era-payment-result-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="era-payment-result-title">
		<button type="button" class="era-payment-result-modal__close js-era-payment-result-close" aria-label="<?php echo esc_attr__( 'Close payment result', 'estatik-razorpayment-addon' ); ?>">&times;</button>
		<h3 id="era-payment-result-title" class="era-payment-result-modal__title"></h3>
		<div id="era-payment-result-body" class="era-payment-result-modal__body"></div>
		<div id="era-payment-result-actions" class="era-payment-result-modal__actions"></div>
	</div>
</div>
<?php endif; ?>

<?php if ( $auto_start_paypal || $auto_start_razorpay ) : ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	<?php if ( $auto_start_paypal ) : ?>
	var form = document.querySelector('.era-subscription-checkout-form');
	if (form && form.dataset.autosubmitted !== '1') {
		form.dataset.autosubmitted = '1';
		form.submit();
	}
	<?php elseif ( $auto_start_razorpay ) : ?>
	var button = document.querySelector('.era-razorpay-subscription-button');
	if (button && button.dataset.autostarted !== '1') {
		button.dataset.autostarted = '1';
		button.click();
	}
	<?php endif; ?>
});
</script>
<?php endif; ?>
