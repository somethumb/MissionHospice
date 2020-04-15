<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo esc_html( $form['title'] ); ?></title>
<?php do_action( 'gfiframe_head', $form_id, $form ); ?>
</head>
<body>
<?php gravity_form( $form_id, $display_title, $display_description, false, null, true ); ?>
<?php wp_footer(); ?>
</body>
</html>
