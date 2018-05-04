<?php /* Template Name: Profile Page Template */ acf_form_head(); get_header(); global $current_user, $wp_roles; ?>
<?php if($_GET['updated'] == 'true') : ?>
	<div class="container highlight-container animate">
		<div class="flex-box text-center">
			<h1><em>SUCCESS!</em></h1>
			<h1>YOUR PROFILE HAS BEEN UPDATED!</h1>
			<a href="<?php echo get_page_link(9); ?>" class="button">VIEW YOUR DASHBOARD</a>
		</div>
	</div>
<?php endif; ?>
<div class="container">
	<div class="row">
		<div class="span100">
			<?php if(is_user_logged_in()) : $user = wp_get_current_user(); ?>
				<h2>Edit Your Profile</h2>
				<?php 
				echo '<div class="module animate">';
					acf_form(array(
						'id' => 'editing_user_profile',
						'post_id' => 'user_' . get_current_user_id(),
						'field_groups' => array(7),
						'form' => true, 
						'return' => add_query_arg( 'updated', 'true', get_permalink() ),
						'updated_message' => false,
						'submit_value' => 'Update Profile' 
					)); 
				echo '</div>';
			else: ?>
				<h2>Create Your Profile</h2>
				<?php 	
				echo '<div class="module animate">';
					acf_form( array(
						'id'				=> 'register_new_user',
						'post_id'			=> 'creating_new_user',
						'field_groups'			=> array(7),
						'return' => home_url('/welcome/'),
						'submit_value' => 'Create Profile'
					));
				echo '</div>';
			endif; ?>				
		</div>
	</div>
</div>
<div class="clear"></div>

<?php get_footer(); ?>