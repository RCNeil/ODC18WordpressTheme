<table class="animate">
	<thead>
		<th>DATE</th>
		<th>TIME</th>
		<th>DEPARTURE</th>
		<th>DESTINATION</th>
		<th class="controls">&nbsp;</th>
	</thead>
	<tbody>	
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
			while ( $loop->have_posts() ) : $loop->the_post();	?>	
				<tr class="dashboard-ride">
					<td><?php echo get_field('pick_up_date'); ?></td>
					<td><?php echo get_field('pick_up_time'); ?></td>
					<?php $departure = get_field('departure'); ?>
					<?php $destination = get_field('destination'); ?>
					<td><?php echo $departure['address']; ?></td>
					<td><?php echo $destination['address']; ?></td>
					<td class="controls"><a href="<?php the_permalink(); ?>" class="icon edit-ride"><i class="fas fa-edit"></i></a><?php echo delete_post(); ?></td>
				</tr>
		<?php 	endwhile; 
		else:
			echo '<td>You have no upcoming rides</td>';
		endif; 
		wp_reset_postdata();
		?>
	</tbody>
</table>