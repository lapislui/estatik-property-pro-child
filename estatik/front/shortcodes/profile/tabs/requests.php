<?php

/**
 * @var $current_tab string
 * @var $tabs array
 */

$query       = es_profile_requests_get_wp_query();
$post_status = es_get( 'status' );
$post_status = 'draft' === $post_status ? $post_status : 'publish';
$era         = function_exists( 'era_razorpayment_addon' ) ? era_razorpayment_addon() : null;
$has_era_estatik = $era && isset( $era->estatik ) && is_object( $era->estatik );
?>

<div id="<?php echo esc_attr( $current_tab ); ?>" class="es-profile__content es-profile__content--<?php echo esc_attr( $current_tab ); ?>">
	<?php if ( ! empty( $tabs[ $current_tab ]['label'] ) ) : ?>
		<h2 class="heading-font"><?php echo esc_html( $tabs[ $current_tab ]['label'] ); ?></h2>
	<?php endif; ?>

	<?php $have_posts = $query->have_posts(); ?>

	<div class="es-search es-search--simple es-search--requests <?php echo ! $have_posts && empty( $_GET['q'] ) ? 'es-hidden' : ''; ?>">
		<form action="" method="get">
			<input type="hidden" name="tab" value="requests"/>
			<div class="es-search__address">
				<label class="es-field es-field__address">
					<input type="text" name="q" value="<?php echo esc_attr( es_get( 'q' ) ); ?>" placeholder="<?php esc_attr_e( 'Search by ID, name, message or contact', 'es' ); ?>"/>
				</label>
				<button class="es-btn es-btn--primary es-btn--icon"><span class="es-icon es-icon_search"></span></button>
			</div>
		</form>
	</div>

	<div class="js-es-no-posts <?php echo ! $have_posts ? '' : 'es-hidden'; ?>">
		<?php if ( ! empty( $_GET['q'] ) ) : ?>
			<p class="es-subtitle"><?php esc_html_e( 'No results', 'es' ); ?></p>
			<p><?php esc_html_e( 'We couldn\'t find any requests that matched your search. Please adjust your search and try again.', 'es' ); ?></p>
		<?php else : ?>
			<p class="es-subtitle"><?php esc_html_e( 'You don’t have any requests yet.', 'es' ); ?></p>
			<p><?php esc_html_e( 'As soon as a client submits a request for one of your properties you will see a request here.', 'es' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( $have_posts ) : ?>
		<ul class="es-nav-tab">
			<li class="es-nav-tab__item<?php es_active_class( $post_status, 'publish', 'es-nav-tab__item--active' ); ?>"><a href="<?php echo esc_url( add_query_arg( 'status', false ) ); ?>"><?php esc_html_e( 'Inbox', 'es' ); ?></a></li>
			<li class="es-nav-tab__item<?php es_active_class( $post_status, 'draft', 'es-nav-tab__item--active' ); ?>"><a href="<?php echo esc_url( add_query_arg( 'status', 'draft' ) ); ?>"><?php esc_html_e( 'Archived', 'es' ); ?></a></li>
		</ul>

		<div class="es-table-wrap">
			<table class="es-table es-table--requests">
				<thead>
				<tr>
					<th><?php esc_html_e( 'Date', 'es' ); ?></th>
					<th><?php esc_html_e( 'Name', 'es' ); ?></th>
					<th><?php esc_html_e( 'Email', 'es' ); ?></th>
					<th><?php esc_html_e( 'Phone', 'es' ); ?></th>
					<th><?php esc_html_e( 'Property ID', 'es' ); ?></th>
					<th><?php esc_html_e( 'Message', 'es' ); ?></th>
					<th><?php esc_html_e( 'Payment', 'estatik-razorpayment-addon' ); ?></th>
					<th><?php esc_html_e( 'Note', 'es' ); ?></th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php
					$request      = es_get_request( get_the_ID() );
					$post         = $request->get_wp_entity();
					$payment_data = $has_era_estatik ? $era->estatik->get_request_payment_button_data( get_the_ID() ) : null;
					?>
					<tr class="es-request-row es-request-row--<?php echo esc_attr( get_post_status( get_the_ID() ) ); ?> es-request-row--<?php the_ID(); es_active_class( (bool) $request->is_viewed, false, 'es-request-row--new' ); ?>">
						<td><?php echo esc_html( get_the_date() ); ?></td>
						<td><?php echo esc_html( $post->post_title ); ?></td>
						<td><?php echo esc_html( $request->email ); ?></td>
						<td><?php echo esc_html( es_get_formatted_tel( $request->tel ) ); ?></td>
						<td>
							<a target="_blank" href="<?php the_permalink( $request->property_id ); ?>">
								<?php echo esc_html( $request->property_id ); ?>
							</a>
						</td>
						<td><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></td>
						<td class="era-estatik-front-payments-cell">
							<?php if ( $payment_data ) : ?>
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
							<?php endif; ?>
						</td>
						<td><?php echo esc_html( wp_strip_all_tags( $request->note ) ); ?></td>
						<td>
							<div class="es-actions">
								<a href="#" class="es-more js-es-more"><span class="es-icon es-icon_more"></span></a>
								<div class="es-actions__dropdown">
									<ul>
										<?php
										$args = array(
											'post_ids'  => get_the_ID(),
											'action'    => 'delete',
											'_nonce'    => wp_create_nonce( 'es_entities_actions' ),
											'_redirect' => urlencode( add_query_arg( 'tab', 'requests', false ) ),
										);
										?>

										<?php if ( current_user_can( 'read_post', get_the_ID() ) ) : ?>
											<li><a href="<?php echo esc_url( es_profile_get_request_view_link( get_the_ID() ) ); ?>"><?php esc_html_e( 'View', 'es' ); ?></a></li>
										<?php endif; ?>
										<?php if ( current_user_can( 'delete_post', get_the_ID() ) ) : ?>
											<li><a href="<?php echo esc_url( add_query_arg( $args, false ) ); ?>" data-confirm-button="<?php esc_attr_e( 'Delete', 'es' ); ?>" data-confirm-button-icon="es-icon es-icon_trash" data-confirm-message data-confirm-title="<?php esc_attr_e( 'Delete request?', 'es' ); ?>"><?php esc_html_e( 'Delete', 'es' ); ?></a></li>
										<?php endif; ?>
										<?php if ( 'draft' !== get_post_status( get_the_ID() ) && current_user_can( 'draft_es_request', get_the_ID() ) ) : ?>
											<?php $args['action'] = 'draft'; ?>
											<li><a href="<?php echo esc_url( add_query_arg( $args, false ) ); ?>" data-confirm-button="<?php esc_attr_e( 'Archive', 'es' ); ?>" data-confirm-message data-confirm-title="<?php esc_attr_e( 'Archive request?', 'es' ); ?>"><?php esc_html_e( 'Archive', 'es' ); ?></a></li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
						</td>
					</tr>
				<?php endwhile; wp_reset_postdata(); ?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
</div>
