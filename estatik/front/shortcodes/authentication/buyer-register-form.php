<?php /** @var $args array */ ?>
<?php
estatik_property_pro_child_render_estatik_buyer_register_form(
	$args,
	! isset( $args['auth_item'] ) || 'buyer-register-form' === $args['auth_item'],
	true
);

