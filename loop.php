<?php if (have_posts()): while (have_posts()) : the_post(); ?>

<div class="row loop-row">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="span35">
		<?php if ( has_post_thumbnail()) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('thumbnail');  ?>
			</a>
		<?php endif; ?>
	</div>
	<div class="span65">
		<h2 class="loop-header"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<span class="date"><?php the_time('F j, Y'); ?></span>
		<!-- <span class="author"><?php //_e( 'Published by', 'html5blank' ); ?> <?php //the_author_posts_link(); ?></span> -->
		<!-- <span class="comments"><?php //if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'html5blank' ), __( '1 Comment', 'html5blank' ), __( '% Comments', 'html5blank' )); ?></span> -->
		<!-- /post details -->

		<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>
		
		<a href="<?php the_permalink(); ?>" class="button">Read More</a>
	</div>	
	
	</article>



<div class="clear"></div>
</div>
<?php endwhile; ?>
<?php else: ?>
<?php endif; ?>
