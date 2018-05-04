<?php
$user = wp_get_current_user();
$args = array( 
	'post_type' => 'rides', 
	'posts_per_page' => -1,
	'author' => $user->ID,
	'meta_key'		=> 'pick_up_date',
	'meta_query' =>  array(
		array(
			'key' => 'pick_up_date',
			'value' => date('Ymd'),
			'type' => 'DATE',
			'compare' => '>='
		)
	),
	'orderby'		=> 'meta_value_num',
	'order'			=> 'ASC'
);
$loop = new WP_Query( $args );
if($loop->have_posts()) :
	echo '<div class="dashboard-rides">';
		while ( $loop->have_posts() ) : $loop->the_post();	?>	
			<div class="flex-box dashboard-ride animate">
				<a href="<?php the_permalink(); ?>" class="icon edit-ride"><i class="fas fa-edit"></i></a>
				<?php echo delete_post(); ?>
				<h2><?php echo get_field('pick_up_date'); ?></h2>
				<?php $departure = get_field('departure'); ?>
				<?php $destination = get_field('destination'); ?>
				<p><span>From:</span><?php echo $departure['address']; ?></p>
				<p><span>To:</span><?php echo $destination['address']; ?></p>
			</div>
<?php 	endwhile; 
	echo '</div>';
else:
	echo '<h2>You have no upcoming rides</h2>';
endif; 
wp_reset_postdata();
?>