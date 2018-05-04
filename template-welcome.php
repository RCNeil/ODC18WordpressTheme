<?php /* Template Name: Welcome Page Template */ get_header(); ?>
<div class="container highlight-container">
	<div class="flex-box text-center">
		<h1><em>WELCOME!</em></h1>
		<h1>YOUR PROFILE HAS BEEN CREATED!</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="span100 text-center">
			<a href="<?php echo get_bloginfo('url'); ?>" class="button">Log In</a>			
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<?php get_footer(); ?>