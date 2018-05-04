<?php /* Template Name: Password Change Template */ get_header(); ?>
<div class="container highlight-container">
	<div class="flex-box text-center">
		<h1><em>SUCCESS!</em></h1>
		<h1>YOUR PASSWORD HAS BEEN UPDATED!</h1>
		<p>You will need to sign back in.</p>
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