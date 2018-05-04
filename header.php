<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

<link href="//www.google-analytics.com" rel="dns-prefetch">
<link href="<?php bloginfo('template_url'); ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="<?php bloginfo('template_url'); ?>/images/favicon.ico" rel="icon" type="image/x-icon">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php bloginfo('description'); ?>">

<?php wp_head(); ?>
<script>
// conditionizr.com
// configure environment tests
conditionizr.config({
assets: '<?php echo get_template_directory_uri(); ?>',
tests: {}
});
</script>

</head>
<body <?php body_class(); ?>>


<div class="container header">
	<div class="span100 text-center logo-container">
		<a href="<?php echo bloginfo('url'); ?>"><img src="<?php echo bloginfo('template_url'); ?>/images/mobile-de-white.png" alt="" /></a>
		<?php if(is_user_logged_in()) : $user = wp_get_current_user(); ?>
			<p class="text-center"><a href="<?php echo get_page_link(9); ?>"><?php echo $user->user_firstname .' '. $user->user_lastname; ?><br /><em>Dart ID #<?php echo get_field('dart_id', 'user_'.$user->ID); ?></em></a></p>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
<div class="clear"></div>
</div>
