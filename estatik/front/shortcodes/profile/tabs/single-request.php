<?php

/**
 * @var $current_tab string
 */

$request_id = es_get( 'request_id', 'intval' );
$era        = function_exists( 'era_razorpayment_addon' ) ? era_razorpayment_addon() : null;
$has_era_estatik = $era && isset( $era->estatik ) && is_object( $era->estatik );

es_current_user_can_or_die( 'read_post', $request_id );

$query = new WP_Query(
	array(
		'post_type'   => 'request',
		'p'           => $request_id,
		'post_status' => array( 'draft', 'publish' ),
	)
);

$request      = es_get_request( $request_id );
$request_post = $request->get_wp_entity();
$payment_data = $has_era_estatik ? $era->estatik->get_request_payment_button_data( $request_id ) : null;

if ( ! $request->is_viewed ) {
	$request->save_field_value( 'is_viewed', 1 );
}

if ( $query->have_posts() ) :
	add_action( 'es_after_property_content', 'es_property_content_extended' );
	?>

	<div id="single-request" class="es-profile__content es-profile__content--single-request">
		<div class="es-single-request">
			<?php if ( $request->post_id ) : ?>
				<div class="es-single-request__listing">
					<?php
					$listings = es_get_shortcode_instance(
						'es_my_listing',
						array(
							'prop_id'         => $request->post_id,
							'ignore_search'   => true,
							'layout'          => 'grid-1',
							'disable_navbar'  => true,
						)
					);
					echo $listings->get_content();
					?>
				</div>
			<?php endif; ?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php $request = es_get_request( get_the_ID() ); ?>
				<div class="es-single-request__content">
					<div class="es-single-request__content-inner">
						<div class="es-flex es-flex--align-center es-flex--justify-between es-single-request__header">
							<span class="es-request-meta"><?php esc_html_e( 'Request ID', 'es' ); ?>: <?php echo esc_html( get_the_ID() ); ?></span>
							<?php the_date( '', '<span class="es-request-meta">', '</span>' ); ?>
						</div>

						<div class="es-flex es-flex--justify-between">
							<h3 class="es-single-request__title"><?php the_title(); ?></h3>
							<div class="es-single-request__contacts">
								<?php if ( $request->email ) : ?>
									<a href="mailto:<?php echo esc_attr( $request->email ); ?>" class="es-secondary-color es-leave-border"><?php echo esc_html( $request->email ); ?></a>
								<?php endif; ?>
								<?php if ( $tel = es_get_formatted_tel( $request->tel ) ) : ?>
									<a href="tel:<?php echo esc_attr( $tel ); ?>" class="es-secondary-color es-leave-border"><?php echo esc_html( $tel ); ?></a>
								<?php endif; ?>
							</div>
						</div>

						<?php if ( $payment_data ) : ?>
							<div style="margin: 0 0 20px;">
								<a href="#" class="era-estatik-front-payments-trigger js-era-estatik-front-payments-view" data-request-id="<?php echo esc_attr( $payment_data['request_id'] ); ?>" data-property-id="<?php echo esc_attr( $payment_data['property_id'] ); ?>">
									<?php esc_html_e( 'View payment', 'estatik-razorpayment-addon' ); ?>
								</a>
								<?php if ( $payment_data['status'] || $payment_data['total'] ) : ?>
									<div class="era-estatik-front-payments-status">
										<?php if ( $payment_data['status'] ) : ?>
											<strong><?php echo esc_html( $payment_data['status'] ); ?></strong><br>
										<?php endif; ?>
										<?php if ( $payment_data['total'] ) : ?>
											<span><?php echo esc_html( $payment_data['total'] ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<div class="es-single-request__message">
							<?php the_excerpt(); ?>
						</div>

						<form action="" method="post" class="js-es-ajax-form js-es-form-enable-on-change">
							<?php
							es_framework_field_render(
								'note',
								array(
									'label' => __( 'My note', 'es' ),
									'type'  => 'textarea',
									'value' => esc_textarea( $request->note ),
								)
							);
							?>

							<input type="hidden" name="request_id" value="<?php the_ID(); ?>"/>
							<input type="hidden" name="action" value="es_request_save_note"/>
							<?php wp_nonce_field( 'es_request_save_note' ); ?>

							<div style="text-align: right">
								<input class="es-btn es-btn--secondary es-btn--bordered" type="submit" value="<?php esc_attr_e( 'Add note', 'es' ); ?>"/>
							</div>
						</form>
					</div>
					<div class="es-single-request__manage-links">
						<?php
						$args = array(
							'post_ids'  => get_the_ID(),
							'action'    => 'delete',
							'_nonce'    => wp_create_nonce( 'es_entities_actions' ),
							'_redirect' => add_query_arg( 'tab', 'requests', false ),
						);
						?>

						<?php if ( current_user_can( 'delete_post', get_the_ID() ) ) : ?>
							<a href="<?php echo esc_url( add_query_arg( $args, false ) ); ?>" data-confirm-button-icon="es-icon es-icon_trash" data-confirm-button="<?php esc_attr_e( 'Delete', 'es' ); ?>" data-confirm-message data-confirm-title="<?php esc_attr_e( 'Delete request?', 'es' ); ?>" class="es-secondary-color"><?php esc_html_e( 'Delete request', 'es' ); ?></a>
						<?php endif; ?>
						<?php if ( 'draft' !== get_post_status( get_the_ID() ) && current_user_can( 'draft_es_request', get_the_ID() ) ) : ?>
							<?php $args['action'] = 'draft'; ?>
							<a href="<?php echo esc_url( add_query_arg( $args, false ) ); ?>" data-confirm-button="<?php esc_attr_e( 'Archive', 'es' ); ?>" data-confirm-message data-confirm-title="<?php esc_attr_e( 'Archive request?', 'es' ); ?>" class="es-secondary-color"><?php esc_html_e( 'Archive', 'es' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>

	<?php
	remove_action( 'es_after_property_content', 'es_property_content_extended' );
endif;
