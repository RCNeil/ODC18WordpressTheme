<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<div class="container ride-overview">
	<div class="row">
		<div class="span100">
			<h2>Your Ride Summary</h2>
			<div class="module summary animate">
				<div class="flex-box dashboard-ride ride-overview">
					<h2><?php echo get_field('pick_up_date'); ?></h2>
					<?php $departure = get_field('departure'); ?>
					<?php $destination = get_field('destination'); ?>
					<p><span>From:</span><?php echo $departure['address']; ?></p>
					<p><span>To:</span><?php echo $destination['address']; ?></p>
				</div>
				<div class="flex-box map-container" id="map-route">
					<script type="text/javascript">
						acf.add_action('load', function( $el ){
							
							//MAKE SURE ASSETS ARE LOADED FIRST
							var id = <?php echo $post->ID; ?>; 
							var deplat = <?php echo $departure['lat']; ?>;
							var deplng = <?php echo $departure['lng']; ?>;
							var destlat = <?php echo $destination['lat']; ?>;
							var destlng = <?php echo $destination['lng']; ?>;
							
							//LOAD MAP FOR ROUTE OVERVIEW
							googleMaps(deplat,deplng,destlat,destlng);	

							//FETCH ALTERNATIVE ROUTES
							alternatives(id,deplat,deplng,destlat,destlng);														
						});
					</script>
				</div>
				<div class="flex-box confirm-ride">
					<a href="<?php echo get_page_link(9); ?>" class="button">CONFIRM THIS RIDE</a>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="row">
		<div class="span100 text-center">
			<h1>YOUR RIDE ALTERNATIVES</h1>
		</div>
	</div>
	<div class="clear"></div>
	<div class="row">
		<div class="span100">
			<h2>Taxis</h2>
			<div class="module alternatives taxis"></div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="row">
		<div class="span100">
			<h2>Other Carriers</h2>
			<div class="module alternatives carriers"></div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="row">
		<div class="span100">
			<h2>Public Transit</h2>
			<div class="module alternatives public-transits"></div>
		</div>
	</div>
	<div class="row">
		<div class="span100">
			<h2>EXPLORE MORE OPTIONS WITH:</h2>
			<div class="row text-center">
				<div class="flex-box alternative ride-hailing">
					<a href="http://www.uber.com" target="_blank"><i class="fab fa-uber"></i></a>
					<h2><a href="http://www.uber.com" target="_blank"><span>RIDE HAILING</span>UBER</a></h2>
				</div>
				<div class="flex-box alternative ride-hailing">
					<a href="http://www.lyft.com" target="_blank"><i class="fab fa-lyft"></i></a>
					<h2><a href="http://www.lyft.com" target="_blank"><span>RIDE HAILING</span>LYFT</a></h2>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php endwhile; endif; ?>