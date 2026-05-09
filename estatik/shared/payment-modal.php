<style>
	.era-estatik-payment-modal { max-width:960px; margin:0 auto; background:#fff; border:1px solid #dcdcde; box-shadow:0 24px 60px rgba(0,0,0,.18); font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; }
	.era-estatik-payment-modal__header { display:flex; align-items:center; justify-content:space-between; padding:18px 28px; border-bottom:1px solid #e5e7eb; gap:16px; }
	.era-estatik-payment-modal__title { margin:0; font-size:17px; line-height:1.3; font-weight:700; color:#111827; }
	.era-estatik-payment-modal__actions { display:flex; align-items:center; gap:12px; }
	.era-estatik-payment-modal__close { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; text-decoration:none; color:#374151; font-size:24px; line-height:1; background:transparent; }
	.era-estatik-payment-modal__status { display:inline-flex; align-items:center; justify-content:center; padding:7px 14px; border-radius:4px; font-size:12px; font-weight:600; text-transform:capitalize; background:#efe3a9; color:#6f5312; }
	.era-estatik-payment-modal__status--captured, .era-estatik-payment-modal__status--paid { background:#d9f0d8; color:#216a1e; }
	.era-estatik-payment-modal__grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:36px; padding:28px 28px 24px; border-bottom:1px solid #e5e7eb; }
	.era-estatik-payment-modal__card h3 { margin:0 0 18px; font-size:18px; font-weight:700; color:#111827; }
	.era-estatik-payment-modal__stack { display:grid; gap:24px; }
	.era-estatik-payment-modal__row label { display:block; margin:0 0 6px; font-size:13px; font-weight:600; color:#111827; }
	.era-estatik-payment-modal__row div, .era-estatik-payment-modal__row a { font-size:15px; line-height:1.5; color:#4b5563; word-break:break-word; }
	.era-estatik-payment-modal__row a { color:#1d4ed8; text-decoration:none; }
	.era-estatik-payment-modal__row--address div { white-space:pre-line; }
	.era-estatik-payment-modal__summary { display:grid; grid-template-columns:1.6fr .8fr .8fr .8fr; gap:20px; padding:18px 28px 20px; border-bottom:1px solid #e5e7eb; background:#fff; }
	.era-estatik-payment-modal__summary-head { font-size:13px; font-weight:600; color:#111827; margin-bottom:10px; }
	.era-estatik-payment-modal__summary-value { font-size:15px; font-weight:500; color:#4b5563; line-height:1.5; }
	.era-estatik-payment-modal__empty { padding:48px 24px; text-align:center; color:#6b7280; font-size:14px; }
	@media (max-width:782px) { .era-estatik-payment-modal__grid, .era-estatik-payment-modal__summary { grid-template-columns:1fr; } }
</style>
<div class="era-estatik-payment-modal">
	<div class="era-estatik-payment-modal__header">
		<h1 class="era-estatik-payment-modal__title"><?php echo esc_html( $order ? sprintf( __( 'Order #%s', 'estatik-razorpayment-addon' ), $order['order_id'] ?? '' ) : $property_label ); ?></h1>
		<div class="era-estatik-payment-modal__actions">
			<?php if ( $order ) : ?><span class="era-estatik-payment-modal__status era-estatik-payment-modal__status--<?php echo esc_attr( $status ); ?>"><?php echo esc_html( ucfirst( $status ) ); ?></span><?php endif; ?>
			<a href="#" class="era-estatik-payment-modal__close" onclick="if (typeof tb_remove === 'function') { tb_remove(); } else if (window.jQuery) { window.jQuery('#era-estatik-front-payments-modal').removeClass('is-visible'); window.jQuery('body').removeClass('era-estatik-front-payments-open'); } return false;" aria-label="<?php echo esc_attr__( 'Close', 'estatik-razorpayment-addon' ); ?>">&times;</a>
		</div>
	</div>
	<?php if ( empty( $order ) ) : ?>
		<div class="era-estatik-payment-modal__empty"><?php echo esc_html__( 'No completed payment found for this item.', 'estatik-razorpayment-addon' ); ?></div>
	<?php else : ?>
		<div class="era-estatik-payment-modal__grid">
			<div class="era-estatik-payment-modal__card"><h3><?php echo esc_html__( 'Billing details', 'estatik-razorpayment-addon' ); ?></h3><div class="era-estatik-payment-modal__stack">
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Customer', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( $customer_name ); ?></div></div>
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Email', 'estatik-razorpayment-addon' ); ?></label><div><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></div></div>
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Request', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( $request_label ); ?></div></div>
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Payment via', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( $payment_type ); ?><?php if ( $payment_id ) : ?> (<?php echo esc_html( $payment_id ); ?>)<?php endif; ?></div></div>
				<div class="era-estatik-payment-modal__row era-estatik-payment-modal__row--address"><label><?php echo esc_html__( 'Message', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( $address ); ?></div></div>
			</div></div>
			<div class="era-estatik-payment-modal__card"><h3><?php echo esc_html__( 'Related details', 'estatik-razorpayment-addon' ); ?></h3><div class="era-estatik-payment-modal__stack">
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Property', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( $view->get_property_label( absint( $order['property_id'] ?? 0 ) ) ); ?></div></div>
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Order ID', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( $order['order_id'] ?? '' ); ?></div></div>
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Payment ID', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( $payment_id ); ?></div></div>
				<div class="era-estatik-payment-modal__row"><label><?php echo esc_html__( 'Status', 'estatik-razorpayment-addon' ); ?></label><div><?php echo esc_html( ucfirst( $status ) ); ?></div></div>
			</div></div>
		</div>
		<div class="era-estatik-payment-modal__summary">
			<div><div class="era-estatik-payment-modal__summary-head"><?php echo esc_html__( 'Product', 'estatik-razorpayment-addon' ); ?></div><div class="era-estatik-payment-modal__summary-value"><?php echo esc_html( $view->get_property_label( absint( $order['property_id'] ?? 0 ) ) ); ?></div></div>
			<div><div class="era-estatik-payment-modal__summary-head"><?php echo esc_html__( 'Quantity', 'estatik-razorpayment-addon' ); ?></div><div class="era-estatik-payment-modal__summary-value">1</div></div>
			<div><div class="era-estatik-payment-modal__summary-head"><?php echo esc_html__( 'Request', 'estatik-razorpayment-addon' ); ?></div><div class="era-estatik-payment-modal__summary-value"><?php echo esc_html( $request_id ? '#' . absint( $request_id ) : '-' ); ?></div></div>
			<div><div class="era-estatik-payment-modal__summary-head"><?php echo esc_html__( 'Total', 'estatik-razorpayment-addon' ); ?></div><div class="era-estatik-payment-modal__summary-value"><?php echo esc_html( $total ); ?></div></div>
		</div>
	<?php endif; ?>
</div>
