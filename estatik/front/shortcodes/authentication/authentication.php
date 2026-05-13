<?php
/**
 * @var $args array
 */

$flashes = es_get_flash_instance( 'authenticate' );
$is_agent_checkout_auth = estatik_property_pro_child_should_render_agent_checkout_auth_forms( $args );
?>
<div class="es-auth js-es-auth content-font<?php echo $is_agent_checkout_auth ? ' es-auth--agent-checkout-flow' : ''; ?>">
	<?php if ( ! is_user_logged_in() ) : ?>
		<?php $flashes->render_messages(); ?>
		<?php if ( $is_agent_checkout_auth ) : ?>
			<?php
			$login_args = $args;
			$login_args['enable_buyers_register'] = false;

			estatik_property_pro_child_render_estatik_login_form(
				$login_args,
				true,
				false,
				array( 'es-auth__item--agent-checkout-login' )
			);

			estatik_property_pro_child_render_estatik_agent_register_form(
				$args,
				true,
				false,
				array( 'es-auth__item--agent-checkout-register' ),
				false
			);

			es_load_template( 'front/shortcodes/authentication/reset-form.php', $args );
			?>
		<?php else : ?>
			<?php es_load_template( 'front/shortcodes/authentication/login-buttons.php', $args ); ?>
			<?php es_load_template( 'front/shortcodes/authentication/login-form.php', $args ); ?>
			<?php es_load_template( 'front/shortcodes/authentication/reset-form.php', $args ); ?>
			<?php if ( ! empty( $args['enable_buyers_register'] ) ) : ?>
				<?php es_load_template( 'front/shortcodes/authentication/buyer-register-buttons.php', $args ); ?>
				<?php es_load_template( 'front/shortcodes/authentication/buyer-register-form.php', $args ); ?>
			<?php endif; ?>
			<?php if ( ! empty( $args['enable_agents_register'] ) ) : ?>
				<?php es_load_template( 'front/shortcodes/authentication/agent-register-form.php', $args ); ?>
				<?php es_load_template( 'front/shortcodes/authentication/agent-register-buttons.php', $args ); ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'You\'re already logged in.', 'es' ); ?></p>
		<a href="<?php echo esc_url( wp_logout_url( es_get_current_url() ) ); ?>" class="es-btn es-btn--primary"><?php esc_html_e( 'Log out', 'es' ); ?></a>
	<?php endif; ?>

	<?php do_action( 'es_after_authentication' ); ?>
</div>
