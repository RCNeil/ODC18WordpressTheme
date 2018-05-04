<?php /* Template Name: Dashboard Template */ get_header(); ?>
<?php if(is_user_logged_in()) :  $user = wp_get_current_user(); ?>
	<div class="container">
		<div class="row">
			<div class="span100">
				<h2>MY DASHBOARD
					<a href="javascript:void(0);" class="toggle-view blocks active" data-view="blocks"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
					<a href="javascript:void(0);" class="toggle-view rows" data-view="rows"><i class="fa fa-bars" aria-hidden="true"></i></a>
				</h2>
				<div class="module animate">
					<h3>My Upcoming Rides</h3>
					<div class="views blocks active"><?php get_template_part('includes/blocks-rides'); ?></div>		
					<div class="views rows"><?php get_template_part('includes/table-rides'); ?></div>			
					<hr />					
					<h3>Past Rides</h3>
					<div class="views blocks active"><?php get_template_part('includes/blocks-past-rides'); ?></div>
					<div class="views rows"><?php get_template_part('includes/table-past-rides'); ?></div>
					<div class="clear">
						<p class="text-center">
							<a href="<?php echo get_page_link(69); ?>" class="button">Request Paratransit Ride</a>
							<a href="<?php echo get_page_link(37); ?>" class="button">Update Your Profile</a>
							<a id="wp-submit" href="<?php echo wp_logout_url( site_url() ); ?>" class="button">Log Out</a>
						</p>
					</div>
				</div>
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