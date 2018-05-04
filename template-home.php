<?php /* Template Name: Home Page Template */ get_header(); ?>
<div class="container intro-container animate">
	<img src="<?php echo bloginfo('template_url'); ?>/images/mobile-de-bluegreen.png" alt="" />
	<div class="flex-box text-center">
		<h1>DELAWARE'S PARATRANSIT PORTAL<br /><em>BOOK YOUR TRIP TODAY</em></h1>
	</div>
</div>

<?php 
global $user_login;
if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
	<div class="container message error-message animate">
		<div class="span100 text-center">
			<h2>SORRY! LOGIN FAILED, PLEASE TRY AGAIN.</h2>
		</div>
		<div class="clear"></div>
	</div>
<?php endif; ?>


<div class="container login-form-container animate" style="animation-delay:.2s;">
	<?php if ( is_user_logged_in() ) : $user = wp_get_current_user(); ?>
		<h2>Welcome, <?php echo $user->user_firstname; ?></h2>
		<a id="wp-submit" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout" class="button">Logout</a>
		<a href="<?php echo get_page_link(9); ?>" class="button">YOUR DASHBOARD</a>
		<a href="<?php echo get_page_link(37); ?>" class="button">EDIT YOUR PROFILE</a>
	<?php else: 
		echo '<h2>LOG INTO YOUR PROFILE</h2>'; 
		$args = array(
			'echo'           => true,
			'redirect'       => site_url('/dashboard/'), 
			'form_id'        => 'loginform',
			'label_username' => __( 'Email' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( 'Remember Me' ),
			'label_log_in'   => __( 'Log In' ),
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'remember'       => true,
			'value_username' => NULL,
			'value_remember' => true
		); 
		wp_login_form( $args );
		echo '<a href="' . get_page_link(37) . '" class="button">CREATE A PROFILE</a>';
	endif; ?> 
</div>

<div class="container home-button-container animate" style="animation-delay:.5s;">
	<a href="<?php echo get_page_link(69); ?>" class="button gray-button">Service Hours</a>
	<a href="<?php echo get_page_link(69); ?>" class="button gray-button">ADA Service Areas</a>
	<a href="<?php echo get_page_link(69); ?>" class="button gray-button">Automated Phone Access</a>
	<a href="<?php echo get_page_link(69); ?>" class="button gray-button">Fare Information</a>
	<a href="<?php echo get_page_link(69); ?>" class="button gray-button">Strip Tickets</a>
	<a href="<?php echo get_page_link(69); ?>" class="button gray-button">Visitor Registration Form</a>
	<a href="<?php echo get_page_link(69); ?>" class="button big-button">Apply For Paratransit</a>
</div>

<?php get_footer(); ?>