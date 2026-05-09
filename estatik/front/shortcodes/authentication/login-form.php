<?php /** @var $args array */ ?>
<?php
estatik_property_pro_child_render_estatik_login_form(
	$args,
	! isset( $args['auth_item'] ) || 'login-form' === $args['auth_item'],
	true
);

