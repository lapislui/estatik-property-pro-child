<?php /** @var $args array */ ?>
<?php
$active_networks = estatik_property_pro_child_get_active_auth_networks( $args );
$show_inline_form = empty( $active_networks ) && ! empty( $args['enable_login_form'] );

if ( $show_inline_form ) {
	estatik_property_pro_child_render_estatik_login_form(
		$args,
		! isset( $args['auth_item'] ) || 'login-buttons' === $args['auth_item'],
		false,
		array(
			'es-auth__login-buttons',
			'es-auth__login-buttons--inline-form',
		)
	);
	return;
}
?>
<div class="es-auth__item es-auth__login-buttons <?php echo ! isset( $args['auth_item'] ) || 'login-buttons' !== $args['auth_item'] ? 'es-auth__item--hidden' : ''; ?>">
	<?php if ( ! empty( $args['login_title'] ) ) : ?>
		<h3 class="heading-font"><?php echo esc_html( $args['login_title'] ); ?></h3>
	<?php endif; ?>

	<?php if ( ! empty( $args['login_subtitle'] ) ) : ?>
		<p><?php echo wp_kses_post( $args['login_subtitle'] ); ?></p>
	<?php endif; ?>

	<?php foreach ( $active_networks as $network ) : ?>
		<?php
		$auth = es_get_auth_instance( $network, array(
			'context' => 'login-buttons',
		) );

		if ( ! $auth instanceof Es_Authentication || ! $auth->is_valid() ) {
			continue;
		}
		?>
		<a class="es-btn es-btn--<?php echo esc_attr( $network ); ?> es-btn--auth" href="<?php echo esc_url( $auth->create_auth_url() ); ?>">
			<span class="es-icon es-icon_<?php echo esc_attr( $network ); ?>"></span>
			<?php echo esc_html( sprintf( __( 'Log in with %s', 'es' ), __( ucfirst( $network ), 'es' ) ) ); ?>
		</a>
	<?php endforeach; ?>

	<?php if ( ! empty( $args['enable_login_form'] ) ) : ?>
		<a href="#" data-auth-item="login-form" class="js-es-auth-item__switcher es-btn es-btn--default es-btn--auth">
			<?php esc_html_e( 'Log in with email', 'es' ); ?>
		</a>
	<?php endif; ?>

	<?php if ( ! empty( $args['enable_buyers_register'] ) ) : ?>
		<p class="sign-in-text"><?php _e( 'Don\'t have an account? <a href="#" data-auth-item="buyer-register-buttons" class="js-es-auth-item__switcher">Sign up</a>', 'es' ); ?></p>
	<?php endif; ?>

	<div class="es-space"></div>

	<?php es_load_template( 'front/shortcodes/authentication/footer.php' ); ?>
</div>
