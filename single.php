<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="span100">
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
				<h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<?php the_content(); ?>					
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>