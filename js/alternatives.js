function alternatives(id,deplat,deplng,destlat,destlng) {
	
	
	//FOR PUBLIC TRANSIT
	jQuery.ajax({
		url: 'http://tempdump.com/Projects/ODC18/wp-content/themes/ODC/includes/opendata-query.php',
		type: 'POST',
		dataType: 'json',
		data: jQuery.param({ 
			id: id, 
			deplat: deplat,
			deplng: deplng,
			destlat: destlat,
			destlng: destlng
		}),
		beforeSend:function(){
			jQuery('.module.alternatives.public-transits').addClass('loading');
		}
	}).done(function(data) {
		if (!jQuery.trim(data)) {   
			jQuery('.module.alternatives.public-transits').removeClass('loading').append('<h2 class="text-center">Sorry there are no public transit options available.</h2>');
		} else {
			var html = '';
			jQuery.each(data, function(key, val) { 
				html += buildHTML('public-transit','DELAWARE PUBLIC TRANSIT',val.attributes.LINENAME,'bus','http://opendata.firstmap.delaware.gov/datasets/delaware-bus-routes/data?where=LINEID%20%3E%3D%20' + val.attributes.LINEID + '%20AND%20LINEID%20%3C%3D%20' + val.attributes.LINEID);
				
			});
			jQuery('.module.alternatives.public-transits').removeClass('loading').append(html);
			jQuery('.animate').on('inview', function(event, isInView) {
				if (isInView) {
					jQuery(this).addClass('animation');
				}
			});
		}
	}).fail(function() {
		console.log('Error!!');
	});	
	
	
	
	
	
	//FOR TAXIS
	jQuery.ajax({
		url: 'http://tempdump.com/Projects/ODC18/DATA/taxis/',
		type: 'get',
		dataType: 'json',
		beforeSend:function(){
			jQuery('.module.alternatives.taxis').addClass('loading');
		}
	}).done(function(data) {
		var html = '';
		var counter = 0;
		jQuery.each(data, function(key, val) { 
			html += buildHTML('taxi','TAXI SERVICE',val.name,'taxi','https://dartfirststate.com/information/programs/scat/ScatProviders.pdf?020218');
			counter++;
			if(counter > 3) {
				return false; 
			}
		});
		jQuery('.module.alternatives.taxis').removeClass('loading').append(html);
		jQuery('.animate').on('inview', function(event, isInView) {
			if (isInView) {
				jQuery(this).addClass('animation');
			}
		});
	}).fail(function() {
		console.log('Error!!');
	});	
	
	
	
	
	
	//GET REVERSE GEO CODE COUNTY FOR CARRIERS TO TEST AGAINST							
	jQuery.ajax({
		url: 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + deplat + ',' + deplng + '&sensor=false',
		type: 'get',
		dataType: 'json',
		timeout: 3000,
		beforeSend:function(){
			jQuery('.module.alternatives.carriers').addClass('loading');
		}
	}).done(function(data) {
		jQuery.each(data.results, function(key, val) { 
			if(val.types[0] == 'administrative_area_level_2') {
				var county = val.address_components[0].long_name;
				getCarriers(county); 
			}
		});
	}).fail(function() {
		console.log('Error!!');
	});
	
	
	//FOR CARRIERS
	function getCarriers(county) {
		jQuery.ajax({
			url: 'http://tempdump.com/Projects/ODC18/DATA/carriers/',
			type: 'get',
			dataType: 'json'
		}).done(function(data) {
			var html = '';
			var counter = 0;
			jQuery.each(data, function(key, val) { 
				if(val.county == county) {
					html += buildHTML('carrier','CERTIFIED LICENSED CARRIER',val.name,'exclamation','https://dartfirststate.com/PublicCarrier/index.shtml');
					counter++;
				}
				if(counter > 3) {
					return false; 
				}
			});
			jQuery('.module.alternatives.carriers').removeClass('loading').append(html);
			jQuery('.animate').on('inview', function(event, isInView) {
				if (isInView) {
					jQuery(this).addClass('animation');
				}
			});
		}).fail(function() {
			console.log('Error!!');
		});
	}
	
	
	function buildHTML(type,title,name,icon,link) {
		return '<div class="flex-box alternative ' + type + ' animate">' + 
			'<i class="fa fa-' + icon + '" aria-hidden="true"></i>' + 
			'<h2><span>' + title + '</span>' + name + '</h2>' + 
			'<p>Interested?' + 
				'<a href="' + link + '" class="button" target="_blank">Learn More</a>' + 
			'</p>' + 
		'</div>';
	}
	
}