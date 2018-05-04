<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="span100">
			<main role="main">
				<section>
					<h1><?php the_title(); ?></h1>
					<article  id="post-404">
							<h1><?php _e( '404. Page not found', 'html5blank' ); ?></h1>
							<h2>
								<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>
							</h2>
					</article>				
				</section>
			</main>		
		</div>
	</div>
<div class="clear"></div>
</div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>