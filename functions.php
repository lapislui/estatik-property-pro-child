<?php
/**
 * Setup Child Theme Styles
 */
function estatik_property_pro_child_enqueue_styles() {
	wp_enqueue_style( 'estatik_property_pro_child-style', get_stylesheet_directory_uri() . '/style.css', false, '1.0' );
}
// add_action( 'wp_enqueue_scripts', 'estatik_property_pro_child_enqueue_styles', 20 );


/**
 * Setup Child Theme Palettes
 *
 * @param string $palettes registered palette json.
 * @return string
 */
function estatik_property_pro_child_change_palette_defaults( $palettes ) {
	$palettes = '{"palette":[{"color":"#2B6CB0","slug":"palette1","name":"Palette Color 1"},
				{"color":"#215387","slug":"palette2","name":"Palette Color 2"},
				{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},
				{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},
				{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},
				{"color":"#718096","slug":"palette6","name":"Palette Color 6"},
				{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},
				{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},
				{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"},
				{"color":"#FfFfFf","slug":"palette10","name":"Palette Color Complement"},
				{"color":"#13612e","slug":"palette11","name":"Palette Color Success"},
				{"color":"#1159af","slug":"palette12","name":"Palette Color Info"},
				{"color":"#b82105","slug":"palette13","name":"Palette Color Alert"},
				{"color":"#f7630c","slug":"palette14","name":"Palette Color Warning"},
				{"color":"#f5a524","slug":"palette15","name":"Palette Color Rating"}],
				"second-palette":[{"color":"#2B6CB0","slug":"palette1","name":"Palette Color 1"},
				{"color":"#215387","slug":"palette2","name":"Palette Color 2"},
				{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},
				{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},
				{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},
				{"color":"#718096","slug":"palette6","name":"Palette Color 6"},
				{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},
				{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},
				{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"},
				{"color":"#FfFfFf","slug":"palette10","name":"Palette Color Complement"},
				{"color":"#13612e","slug":"palette11","name":"Palette Color Success"},
				{"color":"#1159af","slug":"palette12","name":"Palette Color Info"},
				{"color":"#b82105","slug":"palette13","name":"Palette Color Alert"},
				{"color":"#f7630c","slug":"palette14","name":"Palette Color Warning"},
				{"color":"#f5a524","slug":"palette15","name":"Palette Color Rating"}],
				"third-palette":[{"color":"#2B6CB0","slug":"palette1","name":"Palette Color 1"},
				{"color":"#215387","slug":"palette2","name":"Palette Color 2"},
				{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},
				{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},
				{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},
				{"color":"#718096","slug":"palette6","name":"Palette Color 6"},
				{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},
				{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},
				{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"},
				{"color":"#FfFfFf","slug":"palette10","name":"Palette Color Complement"},
				{"color":"#13612e","slug":"palette11","name":"Palette Color Success"},
				{"color":"#1159af","slug":"palette12","name":"Palette Color Info"},
				{"color":"#b82105","slug":"palette13","name":"Palette Color Alert"},
				{"color":"#f7630c","slug":"palette14","name":"Palette Color Warning"},
				{"color":"#f5a524","slug":"palette15","name":"Palette Color Rating"}],
				"active":"palette"}';
	return $palettes;
}
add_filter( 'kadence_global_palette_defaults', 'estatik_property_pro_child_change_palette_defaults', 20 );

/**
 * Setup Child Theme Defaults
 *
 * @param array $defaults registered option defaults with kadence theme.
 * @return array
 */
function estatik_property_pro_child_change_option_defaults( $defaults ) {
	$new_defaults = '{"initial_version":"1.4.5"}';
	$new_defaults = json_decode( $new_defaults, true );
	return wp_parse_args( $new_defaults, $defaults );
}
add_filter( 'kadence_theme_options_defaults', 'estatik_property_pro_child_change_option_defaults', 20 );
/**
 * Setup Child Theme Starter
 *
 * @param array $data registered custom templates.
 * @return array
 */
function estatik_property_pro_child_child_add_starter_templates( $data ) {
	$data['estatik_real_estate_demo'] = array(
		'slug'                => 'estatik_real_estate_demo',
		'name'                => 'Estatik Real Estate Demo',
		'local_content'       => get_stylesheet_directory() . '/starter/content.xml',
		'local_widget_data'   => get_stylesheet_directory() . '/starter/widget_data.json',
		'local_theme_options' => get_stylesheet_directory() . '/starter/theme_options.json',
		'url'                 => '',
		'image'               => get_stylesheet_directory_uri() . '/starter/preview.png',
		'ecommerce'           => false,
		'homepage'            => '',
		'blogpage'            => '',
		'type'                => 'blocks',
		'plugins'             => array(
			'estatik4-pro/estatik.php','kadence-blocks-pro/kadence-blocks-pro.php','kadence-blocks/kadence-blocks.php','kadence-pro/kadence-pro.php','wp-mail-smtp-pro/wp_mail_smtp.php',
		),
		'menus'       => array(
			
		),
	);
	return $data;
}
add_filter( 'kadence_starter_templates_custom_array', 'estatik_property_pro_child_child_add_starter_templates', 20 );

add_filter( 'kadence_custom_child_starter_templates_enable', '__return_true' );

/**
 * Setup Child Theme Starter Brand
 *
 * @param string $name the brand name.
 * @return string
 */
function estatik_property_pro_child_child_add_starter_templates_name( $name ) {
	return 'Pro Design';
}
add_filter( 'kadence_custom_child_starter_templates_name', 'estatik_property_pro_child_child_add_starter_templates_name', 20 );

function estatik_property_pro_child_era_asset_path( $relative_path ) {
	return trailingslashit( get_stylesheet_directory() ) . ltrim( $relative_path, '/' );
}

function estatik_property_pro_child_era_asset_url( $relative_path ) {
	return trailingslashit( get_stylesheet_directory_uri() ) . ltrim( $relative_path, '/' );
}

function estatik_property_pro_child_get_era_key_id() {
	if ( function_exists( 'era_razorpayment_addon' ) ) {
		$plugin = era_razorpayment_addon();

		if ( $plugin && isset( $plugin->settings ) ) {
			return $plugin->settings->get_setting( 'key_id' );
		}
	}

	return '';
}

function estatik_property_pro_child_register_era_assets() {
	$checkout_path = estatik_property_pro_child_era_asset_path( 'assets/js/checkout.js' );
	$payments_path = estatik_property_pro_child_era_asset_path( 'assets/js/estatik-payments.js' );
	$style_path    = estatik_property_pro_child_era_asset_path( 'assets/css/style.css' );

	if ( file_exists( $checkout_path ) ) {
		wp_register_script(
			'era-razorpay-checkout',
			estatik_property_pro_child_era_asset_url( 'assets/js/checkout.js' ),
			array( 'jquery' ),
			(string) filemtime( $checkout_path ),
			true
		);
		wp_localize_script( 'era-razorpay-checkout', 'eraRazorpay', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'era_razorpay_nonce' ),
			'keyId'   => estatik_property_pro_child_get_era_key_id(),
		) );
	}

	wp_register_script( 'razorpay-checkout', 'https://checkout.razorpay.com/v1/checkout.js', array(), null, true );

	if ( file_exists( $payments_path ) ) {
		wp_register_script(
			'era-estatik-payments',
			estatik_property_pro_child_era_asset_url( 'assets/js/estatik-payments.js' ),
			array( 'jquery' ),
			(string) filemtime( $payments_path ),
			true
		);
	}

	if ( file_exists( $style_path ) ) {
		wp_register_style(
			'era-razorpay-style',
			estatik_property_pro_child_era_asset_url( 'assets/css/style.css' ),
			array(),
			(string) filemtime( $style_path )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'estatik_property_pro_child_register_era_assets', 5 );
add_action( 'admin_enqueue_scripts', 'estatik_property_pro_child_register_era_assets', 5 );

function estatik_property_pro_child_override_estatik_template( $real_template_path, $template_path ) {
	if ( ! is_string( $template_path ) || '' === $template_path ) {
		return $real_template_path;
	}

	$relative_template_path = ltrim( $template_path, '/' );

	// Authentication templates are especially sensitive because recursive shortcode
	// calls can fatally crash the request. Only override them when a concrete file
	// exists in the child theme.
	if ( 0 === strpos( $relative_template_path, 'shortcodes/authentication/' ) ) {
		$auth_template_paths = array(
			estatik_property_pro_child_era_asset_path( 'estatik4/' . $relative_template_path ),
			estatik_property_pro_child_era_asset_path( 'estatik/' . $relative_template_path ),
		);

		foreach ( $auth_template_paths as $auth_template_path ) {
			if ( file_exists( $auth_template_path ) ) {
				return $auth_template_path;
			}
		}

		return $real_template_path;
	}

	$theme_template_paths   = array(
		estatik_property_pro_child_era_asset_path( 'estatik4/' . $relative_template_path ),
		estatik_property_pro_child_era_asset_path( 'estatik/' . $relative_template_path ),
	);

	foreach ( $theme_template_paths as $theme_template_path ) {
		if ( file_exists( $theme_template_path ) ) {
			return $theme_template_path;
		}
	}

	return $real_template_path;
}
if ( function_exists( 'add_filter' ) ) {
	add_filter( 'es_locate_template', 'estatik_property_pro_child_override_estatik_template', 5, 2 );
}

function estatik_property_pro_child_get_era_plugin() {
	if ( ! function_exists( 'era_razorpayment_addon' ) ) {
		return null;
	}

	$plugin = era_razorpayment_addon();

	return $plugin ?: null;
}

function estatik_property_pro_child_enqueue_era_profile_assets() {
	$plugin = estatik_property_pro_child_get_era_plugin();

	if ( ! $plugin || ! isset( $plugin->estatik ) || ! is_object( $plugin->estatik ) || is_admin() ) {
		return;
	}

	if ( ! method_exists( $plugin->estatik, 'is_estatik_profile_requests_screen' ) || ! $plugin->estatik->is_estatik_profile_requests_screen() ) {
		return;
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'era-estatik-payments' );
	wp_enqueue_style( 'era-razorpay-style' );
	wp_localize_script( 'era-estatik-payments', 'ERA_EstatikPayments', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'era_estatik_payments_modal' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'estatik_property_pro_child_enqueue_era_profile_assets', 20 );

function estatik_property_pro_child_has_shortcode_in_content( $shortcode_tag ) {
	if ( ! is_singular() ) {
		return false;
	}

	$post = get_queried_object();

	if ( ! $post || empty( $post->post_content ) ) {
		return false;
	}

	return has_shortcode( $post->post_content, $shortcode_tag );
}

function estatik_property_pro_child_enqueue_auth_assets() {
	if ( is_admin() || ! wp_style_is( 'era-razorpay-style', 'registered' ) ) {
		return;
	}

	if ( estatik_property_pro_child_has_shortcode_in_content( 'es_authentication' ) ) {
		wp_enqueue_style( 'era-razorpay-style' );
	}
}
add_action( 'wp_enqueue_scripts', 'estatik_property_pro_child_enqueue_auth_assets', 25 );

function estatik_property_pro_child_get_active_auth_networks( $args ) {
	$active_networks = array();

	if ( ! function_exists( 'es_get_auth_networks_list' ) ) {
		return $active_networks;
	}

	foreach ( es_get_auth_networks_list() as $network ) {
		if ( empty( $args[ 'enable_' . $network ] ) ) {
			continue;
		}

		$auth = es_get_auth_instance( $network, array(
			'context' => 'login-buttons',
		) );

		if ( $auth instanceof Es_Authentication && $auth->is_valid() ) {
			$active_networks[] = $network;
		}
	}

	return $active_networks;
}

function estatik_property_pro_child_get_active_auth_networks_by_context( $args, $context ) {
	$active_networks = array();

	if ( ! function_exists( 'es_get_auth_networks_list' ) ) {
		return $active_networks;
	}

	foreach ( es_get_auth_networks_list() as $network ) {
		if ( empty( $args[ 'enable_' . $network ] ) ) {
			continue;
		}

		$auth = es_get_auth_instance( $network, array(
			'context' => $context,
		) );

		if ( $auth instanceof Es_Authentication && $auth->is_valid() ) {
			$active_networks[] = $network;
		}
	}

	return $active_networks;
}

function estatik_property_pro_child_normalize_redirect_url( $redirect_url ) {
	if ( ! is_string( $redirect_url ) || '' === $redirect_url ) {
		return '';
	}

	$redirect_url = trim( wp_unslash( $redirect_url ) );

	for ( $i = 0; $i < 3; $i++ ) {
		$decoded_redirect_url = rawurldecode( $redirect_url );

		if ( $decoded_redirect_url === $redirect_url ) {
			break;
		}

		$redirect_url = $decoded_redirect_url;
	}

	return wp_validate_redirect( $redirect_url, '' );
}

function estatik_property_pro_child_get_requested_redirect_url() {
	$redirect_url = filter_input( INPUT_POST, 'redirect_url', FILTER_UNSAFE_RAW );

	if ( ! $redirect_url ) {
		$redirect_url = filter_input( INPUT_GET, 'redirect_url', FILTER_UNSAFE_RAW );
	}

	return estatik_property_pro_child_normalize_redirect_url( $redirect_url );
}

function estatik_property_pro_child_filter_success_auth_redirect_url( $url ) {
	$redirect_url = estatik_property_pro_child_get_requested_redirect_url();

	return $redirect_url ? $redirect_url : $url;
}
add_filter( 'es_get_success_auth_redirect_url', 'estatik_property_pro_child_filter_success_auth_redirect_url', 20 );

function estatik_property_pro_child_preserve_auth_redirect_url( $location, $status ) {
	if ( empty( $location ) || 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return $location;
	}

	$redirect_url = estatik_property_pro_child_get_requested_redirect_url();

	if ( ! $redirect_url || false === strpos( $location, 'auth_item=login-form' ) ) {
		return $location;
	}

	$login_page_url = function_exists( 'es_get_page_url' ) ? es_get_page_url( 'login' ) : '';

	if ( $login_page_url && 0 !== strpos( $location, $login_page_url ) ) {
		return $location;
	}

	$query = wp_parse_url( $location, PHP_URL_QUERY );

	if ( is_string( $query ) ) {
		parse_str( $query, $query_args );

		if ( ! empty( $query_args['redirect_url'] ) ) {
			return $location;
		}
	}

	return add_query_arg( 'redirect_url', rawurlencode( $redirect_url ), $location );
}
add_filter( 'wp_redirect', 'estatik_property_pro_child_preserve_auth_redirect_url', 20, 2 );

function estatik_property_pro_child_render_estatik_login_form( $args = array(), $is_visible = true, $show_back_link = false, $extra_classes = array() ) {
	$classes = array_merge(
		array(
			'es-auth__item',
			'js-es-auth__login-form',
			'es-auth__login-form',
		),
		(array) $extra_classes
	);

	if ( ! $is_visible ) {
		$classes[] = 'es-auth__item--hidden';
	}
	?>
	<div class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>">
		<?php if ( ! empty( $args['login_title'] ) ) : ?>
			<h3 class="heading-font"><?php echo esc_html( $args['login_title'] ); ?></h3>
		<?php endif; ?>

		<?php if ( ! empty( $args['login_subtitle'] ) ) : ?>
			<p><?php echo wp_kses_post( $args['login_subtitle'] ); ?></p>
		<?php endif; ?>

		<?php if ( $show_back_link ) : ?>
			<div class="all-login-back">
				<a href="#" data-auth-item="login-buttons" class="js-es-auth-item__switcher">
					<span class="es-icon es-icon_chevron-left"></span><?php esc_html_e( 'All log in options', 'es' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<form action="" method="POST">
			<?php
			$redirect_url = estatik_property_pro_child_get_requested_redirect_url();

			if ( $redirect_url ) {
				es_framework_field_render( 'redirect_url', array(
					'type'  => 'hidden',
					'value' => $redirect_url,
					'attributes' => array(
						'id' => sprintf( '%s-%s', 'redirect_url', uniqid() ),
					),
				) );
			}

			es_framework_field_render( 'es_user_login', array(
				'label'      => _x( 'Username or email address', 'authenticate form', 'es' ),
				'attributes' => array(
					'required'     => 'required',
					'autocomplete' => 'username',
					'id'           => sprintf( '%s-%s', 'es_user_login', uniqid() ),
				),
			) );

			es_framework_field_render( 'es_user_password', array(
				'label'      => _x( 'Password', 'authenticate form', 'es' ),
				'type'       => 'password',
				'skeleton'   => "{before}
					<div class='es-field es-field__{field_key} es-field--{type} {wrapper_class}'>
						<label for='{id}'>{label}{caption}</label>
						<div class='es-input__wrap'>{input}</div>
						{description}
					</div>
				{after}",
				'attributes' => array(
					'required'     => 'required',
					'autocomplete' => 'current-password',
					'id'           => sprintf( '%s-%s', 'es_user_password', uniqid() ),
				),
			) );

			if ( ! empty( $args['is_popup'] ) ) {
				es_framework_field_render( 'is_popup', array(
					'type'  => 'hidden',
					'value' => 1,
					'attributes' => array(
						'id' => sprintf( '%s-%s', 'is_popup', uniqid() ),
					),
				) );
			}

			$uniqid = uniqid();
			?>
			<input type="hidden" name="uniqid" value="<?php echo esc_attr( $uniqid ); ?>"/>
			<?php wp_nonce_field( 'es_authenticate', 'es_auth_nonce_' . $uniqid ); ?>
			<?php do_action( 'es_recaptcha', 'sign_in_form' ); ?>

			<div class="es-auth__actions-row">
				<button type="submit" class="es-btn es-btn--primary js-es-btn--login es-btn--login" disabled><?php esc_html_e( 'Log in', 'es' ); ?></button>
			</div>

			<div class="forgot-pwd">
				<a href="#" data-auth-item="reset-form" class="js-es-auth-item__switcher"><?php esc_html_e( 'Lost your password?', 'es' ); ?></a>
			</div>
		</form>

		<?php if ( ! empty( $args['enable_buyers_register'] ) ) : ?>
			<p class="sign-in-text"><?php _e( 'Don\'t have an account? <a href="#" class="js-es-auth-item__switcher" data-auth-item="buyer-register-buttons">Sign up</a>', 'es' ); ?></p>
		<?php endif; ?>

		<div class="es-space"></div>
	</div>
	<?php
}

function estatik_property_pro_child_render_estatik_buyer_register_form( $args = array(), $is_visible = true, $show_back_link = false, $extra_classes = array() ) {
	$classes = array_merge(
		array(
			'es-auth__item',
			'es-auth__buyer-register-form',
		),
		(array) $extra_classes
	);

	if ( ! $is_visible ) {
		$classes[] = 'es-auth__item--hidden';
	}
	?>
	<div class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>">
		<?php if ( ! empty( $args['buyer_register_title'] ) ) : ?>
			<h3 class="heading-font"><?php echo esc_html( $args['buyer_register_title'] ); ?></h3>
		<?php else : ?>
			<h3 class="heading-font"><?php esc_html_e( 'Register', 'es' ); ?></h3>
		<?php endif; ?>

		<?php if ( ! empty( $args['buyer_register_subtitle'] ) ) : ?>
			<p><?php echo wp_kses_post( $args['buyer_register_subtitle'] ); ?></p>
		<?php endif; ?>

		<?php if ( $show_back_link ) : ?>
			<div class="all-login-back">
				<a href="#" class="js-es-auth-item__switcher" data-auth-item="buyer-register-buttons">
					<span class="es-icon es-icon_chevron-left"></span><?php esc_html_e( 'All sign up options', 'es' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<form action="" method="POST">
			<?php
			$uniqid = uniqid();
			?>
			<input type="hidden" name="uniqid" value="<?php echo esc_attr( $uniqid ); ?>"/>
			<?php wp_nonce_field( 'es_register', 'es_register_nonce_' . $uniqid ); ?>
			<?php
			es_framework_field_render( 'redirect_url', array(
				'type'       => 'hidden',
				'value'      => estatik_property_pro_child_get_requested_redirect_url(),
				'attributes' => array(
					'id' => sprintf( '%s-%s', 'redirect_url', uniqid() ),
				),
			) );

			es_framework_field_render( 'es_type', array(
				'type'       => 'hidden',
				'value'      => 'buyer',
				'attributes' => array(
					'id' => sprintf( '%s-%s', 'es_type', uniqid() ),
				),
			) );

			if ( ! empty( $args['is_popup'] ) ) {
				es_framework_field_render( 'is_popup', array(
					'type'       => 'hidden',
					'value'      => 1,
					'attributes' => array(
						'id' => sprintf( '%s-%s', 'is_popup', uniqid() ),
					),
				) );
			}

			es_framework_field_render( 'es_extra_info', array(
				'type'       => 'text',
				'value'      => '',
				'attributes' => array(
					'id' => sprintf( '%s-%s', 'es_extra_info', uniqid() ),
				),
			) );

			es_framework_field_render( 'es_user_email', array(
				'type'        => 'email',
				'label'       => _x( 'Email address', 'authenticate form', 'es' ),
				'attributes'  => array(
					'required'     => 'required',
					'autocomplete' => 'username',
					'id'           => sprintf( '%s-%s', 'es_user_email', uniqid() ),
				),
				'description' => __( 'Email address will be verified in the next step.', 'es' ),
			) );

			es_framework_field_render( 'es_user_password', array(
				'label'       => _x( 'Password', 'authenticate form', 'es' ),
				'type'        => 'password',
				'attributes'  => array(
					'required'     => 'required',
					'minlength'    => '8',
					'autocomplete' => 'new-password',
					'class'        => 'js-es-password-field',
					'id'           => sprintf( '%s-%s', 'es_user_password', uniqid() ),
				),
				'skeleton'    => "{before}
					<div class='es-field es-field__{field_key} es-field--{type} {wrapper_class}'>
						<label for='{id}'>{label}{caption}</label>
						<div class='es-input__wrap'>{input}</div>
						{description}
					</div>
				{after}",
				'description' => "<ul class='es-field__validate-list es-field__validate-list--compact'>
					<li class='es-validate-item es-validate-item__contain'>" . esc_html__( 'Can\'t contain the name or email address', 'es' ) . "</li>
					<li class='es-validate-item es-validate-item__length'>" . esc_html__( 'At least 8 characters', 'es' ) . "</li>
					<li class='es-validate-item es-validate-item__char'>" . esc_html__( 'Contains a number or symbol', 'es' ) . "</li>
				</ul>",
			) );
			?>

			<?php do_action( 'es_recaptcha', 'sign_up_form' ); ?>
			<div class="es-auth__actions-row">
				<button type="submit" disabled class="es-btn es-btn--primary es-btn--signup"><?php esc_html_e( 'Register', 'es' ); ?></button>
			</div>
			<?php do_action( 'es_privacy_policy', 'sign_up_form' ); ?>
			<p class="sign-in-text"><?php _e( 'Already have an account? <a href="#" class="js-es-auth-item__switcher" data-auth-item="login-buttons">Log in</a>', 'es' ); ?></p>
		</form>
		<div class="es-space"></div>
		<?php es_load_template( 'front/shortcodes/authentication/footer.php' ); ?>
	</div>
	<?php
}

function estatik_property_pro_child_is_subscription_checkout_redirect_url( $redirect_url ) {
	if ( ! $redirect_url || ! is_string( $redirect_url ) ) {
		return false;
	}

	$query = wp_parse_url( $redirect_url, PHP_URL_QUERY );

	if ( ! is_string( $query ) || '' === $query ) {
		return false;
	}

	parse_str( $query, $query_args );

	return ! empty( $query_args['screen'] ) && 'checkout' === $query_args['screen'] && ! empty( $query_args['plan'] );
}

function estatik_property_pro_child_should_render_agent_checkout_auth_forms( $args = array() ) {
	if ( is_user_logged_in() || empty( $args['enable_agents_register'] ) ) {
		return false;
	}

	$auth_item = ! empty( $args['auth_item'] ) ? sanitize_key( $args['auth_item'] ) : sanitize_key( (string) filter_input( INPUT_GET, 'auth_item' ) );

	if ( ! in_array( $auth_item, array( 'agent-register-form', 'login-form' ), true ) ) {
		return false;
	}

	return estatik_property_pro_child_is_subscription_checkout_redirect_url( estatik_property_pro_child_get_requested_redirect_url() );
}

function estatik_property_pro_child_render_estatik_agent_register_form( $args = array(), $is_visible = true, $show_back_link = true, $extra_classes = array(), $show_login_link = true ) {
	$classes = array_merge(
		array(
			'es-auth__item',
			'es-auth__agent-register-form',
		),
		(array) $extra_classes
	);

	if ( ! $is_visible ) {
		$classes[] = 'es-auth__item--hidden';
	}
	?>
	<div class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>">
		<?php if ( ! empty( $args['agent_register_title'] ) ) : ?>
			<h3 class="heading-font"><?php echo esc_html( $args['agent_register_title'] ); ?></h3>
		<?php else : ?>
			<h3 class="heading-font"><?php esc_html_e( 'Register', 'es' ); ?></h3>
		<?php endif; ?>

		<?php if ( ! empty( $args['agent_register_subtitle'] ) ) : ?>
			<p><?php echo wp_kses_post( $args['agent_register_subtitle'] ); ?></p>
		<?php endif; ?>

		<?php if ( $show_back_link ) : ?>
			<div class="all-login-back">
				<a href="#" class="js-es-auth-item__switcher" data-auth-item="agent-register-buttons">
					<span class="es-icon es-icon_chevron-left"></span><?php esc_html_e( 'All sign up options', 'es' ); ?>
				</a>
			</div>
		<?php endif; ?>

		<form action="" method="POST">
			<?php
			$uniqid = uniqid();
			?>
			<input type="hidden" name="uniqid" value="<?php echo esc_attr( $uniqid ); ?>"/>
			<?php wp_nonce_field( 'es_register', 'es_register_nonce_' . $uniqid ); ?>
			<?php
			es_framework_field_render( 'redirect_url', array(
				'type'       => 'hidden',
				'value'      => estatik_property_pro_child_get_requested_redirect_url(),
				'attributes' => array(
					'id' => sprintf( '%s-%s', 'redirect_url', uniqid() ),
				),
			) );

			es_framework_field_render( 'es_type', array(
				'type'       => 'hidden',
				'value'      => 'agent',
				'attributes' => array(
					'id' => sprintf( '%s-%s', 'es_type', uniqid() ),
				),
			) );

			if ( ! empty( $args['is_popup'] ) ) {
				es_framework_field_render( 'is_popup', array(
					'type'       => 'hidden',
					'value'      => 1,
					'attributes' => array(
						'id' => sprintf( '%s-%s', 'is_popup', uniqid() ),
					),
				) );
			}

			es_framework_field_render( 'es_extra_info', array(
				'type'       => 'text',
				'value'      => '',
				'attributes' => array(
					'id' => sprintf( '%s-%s', 'es_extra_info', uniqid() ),
				),
			) );

			es_framework_field_render( 'es_user_email', array(
				'type'        => 'email',
				'label'       => _x( 'Email address', 'authenticate form', 'es' ),
				'attributes'  => array(
					'required'     => 'required',
					'autocomplete' => 'username',
					'id'           => sprintf( '%s-%s', 'es_user_email', uniqid() ),
				),
				'description' => __( 'Email address will be verified in the next step.', 'es' ),
			) );

			es_framework_field_render( 'es_user_password', array(
				'label'       => _x( 'Password', 'authenticate form', 'es' ),
				'type'        => 'password',
				'attributes'  => array(
					'required'     => 'required',
					'minlength'    => '8',
					'autocomplete' => 'new-password',
					'class'        => 'js-es-password-field',
					'id'           => sprintf( '%s-%s', 'es_user_password', uniqid() ),
				),
				'skeleton'    => "{before}
					<div class='es-field es-field__{field_key} es-field--{type} {wrapper_class}'>
						<label for='{id}'>{label}{caption}</label>
						<div class='es-input__wrap'>{input}</div>
						{description}
					</div>
				{after}",
				'description' => "<ul class='es-field__validate-list es-field__validate-list--compact'>
					<li class='es-validate-item es-validate-item__contain'>" . esc_html__( 'Can\'t contain the name or email address', 'es' ) . "</li>
					<li class='es-validate-item es-validate-item__length'>" . esc_html__( 'At least 8 characters', 'es' ) . "</li>
					<li class='es-validate-item es-validate-item__char'>" . esc_html__( 'Contains a number or symbol', 'es' ) . "</li>
				</ul>",
			) );

			es_framework_field_render( 'es_phone', array(
				'label'                    => __( 'Phone', 'es' ),
				'type'                     => 'phone',
				'is_country_code_disabled' => ests( 'is_tel_code_disabled' ),
				'codes'                    => es_esc_json_attr( es_get_phone_data( 'dial_code' ) ),
				'icons'                    => es_esc_json_attr( es_get_phone_data( 'icon' ) ),
				'code_config'              => array(
					'options'    => es_get_phone_data( 'country' ),
					'attributes' => array(
						'id' => 'es-field-code-' . uniqid(),
					),
				),
				'tel_config'               => array(
					'attributes' => array(
						'pattern' => '+?[0-9]+',
						'id'      => 'es-field-tel-' . uniqid(),
					),
				),
				'description'              => __( 'We\'ll use it to contact you.', 'es' ),
			) );
			?>

			<?php do_action( 'es_recaptcha', 'sign_up_form' ); ?>
			<div class="es-auth__actions-row">
				<button type="submit" disabled class="es-btn es-btn--primary es-btn--signup"><?php esc_html_e( 'Register', 'es' ); ?></button>
			</div>
			<?php do_action( 'es_privacy_policy', 'sign_up_form' ); ?>
			<?php if ( $show_login_link ) : ?>
				<p class="sign-in-text"><?php _e( 'Already have an account? <a href="#" class="js-es-auth-item__switcher" data-auth-item="login-buttons">Log in</a>', 'es' ); ?></p>
			<?php endif; ?>
		</form>
		<div class="es-space"></div>
	</div>
	<?php
}

function estatik_property_pro_child_render_era_profile_modal() {
	$plugin = estatik_property_pro_child_get_era_plugin();

	if ( ! $plugin || ! isset( $plugin->estatik ) || ! is_object( $plugin->estatik ) || is_admin() ) {
		return;
	}

	if ( ! method_exists( $plugin->estatik, 'is_estatik_profile_requests_screen' ) || ! $plugin->estatik->is_estatik_profile_requests_screen() ) {
		return;
	}

	if ( method_exists( $plugin->estatik, 'render_frontend_modal_shell' ) ) {
		$plugin->estatik->render_frontend_modal_shell();
	}
}
add_action( 'wp_footer', 'estatik_property_pro_child_render_era_profile_modal', 20 );
