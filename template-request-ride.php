<?php /* Template Name: Request A Ride Template */ acf_form_head(); get_header(); ?>
<?php if(is_user_logged_in()) :  $user = wp_get_current_user(); ?>
	<div class="container">
		<div class="row">
			<div class="span100">
				<h2>REQUEST A RIDE</h2>
				<?php
				echo '<div class="module animate">';
					acf_form(array(
						'id' => 'request_ride',
						'post_id'		=> 'new_post',
						'post_title'	=> false,
						'new_post'		=> array(
							'post_type'		=> 'rides',
							'post_status'	=> 'publish'
						),
						'return' => add_query_arg( 'created', 'true', '%post_url%' ),
						'updated_message' => false,
						'submit_value' => 'Request A Ride'
					));
				echo '</div>';
				?>	
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
<?php else: ?>
	<div class="container error-container animate">
		<div class="flex-box text-center">
			<h2><em>SORRY!</em></h2>
			<h2>YOU MUST BE LOGGED IN TO REQUEST A RIDE</h2>
			<a href="<?php echo bloginfo('url'); ?>" class="button">RETURN HOME</a>
		</div>
	</div>
<?php endif; ?>
<?php get_footer(); ?>