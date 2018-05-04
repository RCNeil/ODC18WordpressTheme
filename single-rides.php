<?php acf_form_head(); ?>
<?php get_header(); $user = wp_get_current_user(); ?>
<?php if(is_user_logged_in() && $user->ID == $post->post_author) :  ?>
	<?php if($_GET['created'] == 'true') : ?>
		<div class="container highlight-container animate">
			<div class="flex-box text-center">
				<h1><em>SUCCESS!</em></h1>
				<h1>YOUR RIDE HAS BEEN SCHEDULED!</h1>
				<a href="<?php echo get_page_link(9); ?>" class="button">YOUR DASHBOARD</a> &nbsp; <a href="<?php echo get_page_link(69); ?>" class="button">Book Additional Rides</a>
			</div>
		</div>
		<?php get_template_part('includes/ride-overview'); ?>
	<?php endif; ?>
	<?php if($_GET['updated'] == 'true') : ?>
		<div class="container highlight-container animate">
			<div class="flex-box text-center">
				<h1><em>SUCCESS!</em></h1>
				<h1>YOUR RIDE HAS BEEN UPDATED!</h1>
				<a href="<?php echo get_page_link(9); ?>" class="button">YOUR DASHBOARD</a>
			</div>
		</div>
		<?php get_template_part('includes/ride-overview'); ?>
<?php endif; ?>
	<div class="container">
		<div class="row">		
			<div class="span100">			
				<h2>Edit Your Ride</h2>
				<?php 
				echo '<div class="module animate">';
					acf_form(array(
						'id' => 'editing_ride',
						'form' => true, 
						'return' => add_query_arg( 'updated', 'true', get_permalink() ),
						'updated_message' => false,
						'submit_value' => 'Update Ride Request' 
					)); 
				echo '</div>';
				?>
			</div>
		</div>
	<div class="clear"></div>
	</div>
<?php else: ?>
	<div class="container error-container animate">
		<div class="flex-box text-center">
			<h2><em>SORRY!</em></h2>
			<h2>YOU DO NOT HAVE PERMISSION TO VIEW THIS RIDE INFORMATION.</h2>
			<a href="<?php echo bloginfo('url'); ?>" class="button">RETURN HOME</a>
		</div>
	</div>
<?php endif; ?>
<?php get_footer(); ?>