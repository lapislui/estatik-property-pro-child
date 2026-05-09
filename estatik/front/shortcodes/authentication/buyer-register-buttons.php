<?php /** @var $args array */ ?>
<?php
$active_networks = estatik_property_pro_child_get_active_auth_networks_by_context( $args, 'buyer-register-buttons' );
$show_inline_form = empty( $active_networks ) && ! empty( $args['enable_login_form'] );

if ( $show_inline_form ) {
	estatik_property_pro_child_render_estatik_buyer_register_form(
		$args,
		! isset( $args['auth_item'] ) || 'buyer-register-buttons' === $args['auth_item'],
		false,
		array(
			'es-auth__buyer-register-buttons',
			'es-auth__buyer-register-buttons--inline-form',
		)
	);
	return;
}
?>
<div class="es-auth__item es-auth__buyer-register-buttons <?php echo ! isset( $args['auth_item'] ) || 'buyer-register-buttons' !== $args['auth_item'] ? 'es-auth__item--hidden' : ''; ?>">
	<?php if ( ! empty( $args['buyer_register_title'] ) ) : ?>
		<h3 class="heading-font"><?php echo esc_html( $args['buyer_register_title'] ); ?></h3>
	<?php endif; ?>

	<?php if ( ! empty( $args['buyer_register_subtitle'] ) ) : ?>
		<p><?php echo wp_kses_post( $args['buyer_register_subtitle'] ); ?></p>
	<?php endif; ?>

	<?php foreach ( $active_networks as $network ) : ?>
		<?php
		$auth = es_get_auth_instance( $network, array(
			'context' => 'buyer-register-buttons',
		) );

		if ( ! $auth instanceof Es_Authentication || ! $auth->is_valid() ) {
			continue;
		}
		?>
		<a class="es-btn es-btn--<?php echo esc_attr( $network ); ?> es-btn--auth" href="<?php echo esc_url( $auth->create_auth_url() ); ?>">
			<span class="es-icon es-icon_<?php echo esc_attr( $network ); ?>"></span>
			<?php echo esc_html( sprintf( __( 'Sign up with %s', 'es' ), __( ucfirst( $network ), 'es' ) ) ); ?>
		</a>
	<?php endforeach; ?>

	<?php if ( ! empty( $args['enable_login_form'] ) ) : ?>
		<a href="#" data-auth-item="buyer-register-form" class="js-es-auth-item__switcher es-btn es-btn--default es-btn--auth"><?php esc_html_e( 'Sign up with email', 'es' ); ?></a>
	<?php endif; ?>

	<p class="sign-in-text"><?php _e( 'Already have an account? <a href="#" data-auth-item="login-buttons" class="js-es-auth-item__switcher">Log in</a>', 'es' ); ?></p>
	<div class="es-space"></div>
	<?php es_load_template( 'front/shortcodes/authentication/footer.php' ); ?>
</div>
