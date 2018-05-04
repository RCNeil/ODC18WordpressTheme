<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

if (!isset($content_width)) { $content_width = 900;	}

if (function_exists('add_theme_support')){
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_image_size('custom-size', 700, 400, true); 
    add_theme_support('automatic-feed-links');
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!
		
		wp_register_script('inview', get_template_directory_uri() . '/js/lib/jquery.inview.min.js', array('jquery'), ''); // InView
        wp_enqueue_script('inview'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

function html5blank_conditional_scripts()
{
    if (is_singular('rides')) {
		
		wp_register_script('google-maps-scripts', get_template_directory_uri() . '/js/google-maps.js', array('jquery'), ''); 
        wp_enqueue_script('google-maps-scripts'); // Enqueue it!
		
		wp_register_script('alternatives', get_template_directory_uri() . '/js/alternatives.js', array('jquery'), ''); 
        wp_enqueue_script('alternatives'); // Enqueue it!
    }
}
add_action('wp_print_scripts', 'html5blank_conditional_scripts');

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
}


function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
   // return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
    return '...';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
//add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.


/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/


function create_post_type() {

    register_post_type('rides', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Rides', 'html5blank'), // Rename these to suit
            'singular_name' => __('Ride', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New ', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit ', 'html5blank'),
            'new_item' => __('New ', 'html5blank'),
            'view' => __('View ', 'html5blank'),
            'view_item' => __('View ', 'html5blank'),
            'search_items' => __('Search ', 'html5blank'),
            'not_found' => __('No posts found', 'html5blank'),
            'not_found_in_trash' => __('No posts found in Trash', 'html5blank')
        ),
        'public' => true,
		'rewrite' => array( 'slug' => 'rides' ),
		'menu_icon' => 'dashicons-location-alt', 
		'menu_position' => 35,
        'hierarchical' => true, 
        'has_archive' => true,
		'show_in_rest' => true,
        'supports' => array(
            	'title',
				'author',
            	'editor',
				'thumbnail',
				'revisions'
        ), 
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
        ) // Add Category and Post Tags support, see custom below
    ));	
}
add_action( 'init', 'create_post_type' );  //INITIALIZE POST TYPE








/* SHORTCODE and WPQUERY example
=================================/
//[news]
function news_func( $atts ){
 ob_start(); //THIS STARTS YOUR SHORTCODE OUTPUT
  ?>		  
  
<?php
$args = array( 
			'post_type' => 'post', 
			'posts_per_page' => 10,
			'orderby'		=> 'date',
			'order'			=> 'DESC'
		);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
	
?>
	
	<div class="row news-row">
		<div class="span100">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p class="post-info"><span><?php the_author(); ?></span> &nbsp; <em><?php echo the_date(); ?></em></p>
			<?php the_excerpt(); ?>
			<p><a href="<?php the_permalink(); ?>" class="button">Read More</a></p>
		</div>
		<div class="clear"></div>
	</div>
	
<?php
	
endwhile; 

wp_reset_postdata();
  
?>
  <?PHP
  $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
}
add_shortcode( 'newsletters', 'news_func' );


*/



//REMOVE MENUS
function remove_menus(){
	
	//$user = array( 'rcneil' );
	//$current_user = wp_get_current_user();
	//if(!in_array( $current_user->user_login, $user )) {
  
		//remove_menu_page( 'index.php' );                  //Dashboard
		//remove_menu_page( 'edit.php' );                   //Posts
		//remove_menu_page( 'upload.php' );                 //Media
		//remove_menu_page( 'edit.php?post_type=page' );    //Pages
		remove_menu_page( 'edit-comments.php' );          //Comments
		//remove_menu_page( 'themes.php' );                 //Appearance
		//remove_menu_page( 'plugins.php' );                //Plugins
		//remove_menu_page( 'users.php' );                  //Users
		//remove_menu_page( 'tools.php' );                  //Tools
		//remove_menu_page( 'options-general.php' );        //Settings
		//remove_menu_page( 'edit.php?post_type=acf' );		//ACF
		//remove_menu_page( 'edit.php?post_type=acf-field-group' );		//ACF PRO
		//remove_menu_page( 'wpcf7' );						//CF7
		//remove_menu_page( 'revslider' ); 					//REVOLUTION SLIDER
	//}
}
add_action( 'admin_menu', 'remove_menus', 999 );





//CUSTOM ACF MIN HEIGHT ROWS AND GOOGLE MAPS KEY
add_filter('admin_head','textarea_temp_fix');
function textarea_temp_fix() {
	echo '<style type="text/css">.acf_postbox .field textarea {min-height:0 !important;}</style>';
}
function my_acf_init() {	
	acf_update_setting('google_api_key', 'AIzaSyD2fH9I5T33edk1gjMXWFhMFQ2YY2lq6og');
}
add_action('acf/init', 'my_acf_init');

function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyD2fH9I5T33edk1gjMXWFhMFQ2YY2lq6og';
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

//USE FONT AWESOME IN THEME
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
	wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.0.11/css/all.css' );
	//wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}












//LOGIN FAILED FRONT END
add_action( 'wp_login_failed', 'my_front_end_login_fail' );
function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		if(!strstr($referrer,'?login=failed')) :
			wp_redirect( $referrer . '?login=failed' );
			exit;
		else :
			wp_redirect( $referrer );
			exit;
		endif;
   }
}
























//CREATE USERS
function generate_new_user_id( $post_id, $form ) {
	// Check that we are targeting the right form. I do this by checking the acf_form ID.
	if ( ! isset( $form['id'] ) || 'register_new_user' != $form['id'] ) {
		return $post_id;
	}

	$user_fields = array();

	// Check for the fields we need in our postdata, and add them to the $user_fields array if they exist
	if ( isset( $_POST['acf']['field_5adf4f166ae5f'] ) ) {
		$user_fields['first_name'] = sanitize_text_field( $_POST['acf']['field_5adf4f166ae5f'] );
	}

	if ( isset( $_POST['acf']['field_5adf4f2d6ae60'] ) ) {
		$user_fields['last_name'] = sanitize_text_field( $_POST['acf']['field_5adf4f2d6ae60'] );
	}

	if ( isset( $_POST['acf']['field_5adf4f6e6ae62'] ) ) {
		$user_fields['user_email'] = sanitize_email( $_POST['acf']['field_5adf4f6e6ae62'] );
	}
	
	if ( isset( $_POST['acf']['field_5adf6372c85f3'] ) ) {
		$user_fields['user_pass'] = $_POST['acf']['field_5adf6372c85f3'];
	}

	if ( isset( $_POST['acf']['field_5a83681ec4d01'], $_POST['acf']['field_5adf4f2d6ae60'] ) ) {
		$user_fields['display_name'] = sanitize_text_field( $_POST['acf']['field_5a83681ec4d01'] . ' ' . $_POST['acf']['field_5adf4f2d6ae60'] );
		
	}
	
	$user_fields['user_login'] = strtolower(sanitize_text_field( $_POST['acf']['field_5adf4f166ae5f'])) . strtolower(sanitize_text_field( $_POST['acf']['field_5adf4f2d6ae60'] )); 
	
	$user_id = wp_insert_user( $user_fields );
	wp_new_user_notification( $user_id, 'user' );
	

	if ( is_wp_error( $user_id ) ) {
		wp_die( $user_id->get_error_message() );
	} else {
		return 'user_' . $user_id;
	}
}
add_action( 'acf/pre_save_post', 'generate_new_user_id', 10, 2 );
















//EDITING USERS
function my_acf_save_post( $post_id ) {
	// bail early if no ACF data
	if( empty($_POST['acf']) ) {
		return;
	}	
	// bail early if editing in admin
	if( is_admin() ) {
		return;
	}
	if( !is_user_logged_in() ) {
		return;
	}	
	if( $_POST['post_id'] != 'new' ) {	
		$current_user = wp_get_current_user();
		$emailField = $_POST['acf']['field_5adf4f6e6ae62'];
		$pwField = $_POST['acf']['field_5adf6372c85f3'];
		$wp_user_id = str_replace("user_", "", $post_id);		
		if (isset($emailField)) {
			if (email_exists( $emailField )){
				update_field('field_5adf4f6e6ae62', get_the_author_meta('user_email',$wp_user_id), $post_id);
			} else {
				$args = array(
					'ID'         => $wp_user_id,
					'user_email' => esc_attr( $emailField )
				);            
				wp_update_user( $args );
			}  
		}
		if (isset($pwField)) {
			if ( !wp_check_password($pwField, $current_user->user_pass, $current_user->ID) ) {
				wp_set_password( $pwField, $current_user->ID );
				wp_redirect(get_page_link(62));
				exit;
			} 
		}
	}	
	return $post_id;
}
add_action('acf/save_post', 'my_acf_save_post', 20);






//VALIDATE PASSWORD FIELD
add_filter('acf/validate_value/key=field_5adf6461c85f4', 'my_validated_password_filter', 10, 4);
function my_validated_password_filter($valid, $value, $field, $input) {
  if (!$valid) {
    return $valid;
  }
  // field key of the field you want to validate against
  $password_field = 'field_5adf6372c85f3';
  if ($value != $_POST['acf'][$password_field]) {
    $valid = 'Passwords do not match!';
  }
  return $valid;
}



 



//VALIDATE GOOGLE MAPS INSIDE DELAWARE
add_filter('acf/validate_value/key=field_5ae114cff4b26', 'google_map_delaware', 10, 4);
add_filter('acf/validate_value/key=field_5ae11f9376302', 'google_map_delaware', 10, 4);
add_filter('acf/validate_value/key=field_5add3f066fe0c', 'google_map_delaware', 10, 4);
function google_map_delaware($valid, $value, $field, $input) {
	if (!$valid) {
		return $valid;
	}  
	$address = $value['address'];
	$addresssplit = preg_split("/[\s,-\/]+/", $address);
	if (in_array('DE',$addresssplit)) {
		return $valid;
	} else {
		$valid = "You must select a location in Delaware.";
	}  
	return $valid;
}




//REQUEST A RIDE - SAVE TITLE
function generate_new_ride_title( $post_id, $form ) {
	if ( ! isset( $form['id'] ) || 'request_ride' != $form['id'] ) {
		return $post_id;
	}
	$user = wp_get_current_user();
	$username =  $user->user_firstname . ' ' . $user->user_lastname; 
	$dartID = get_field('dart_id', 'user_' . $user->ID);; 
	$destination = $_POST['acf']['field_5add3f066fe0c']; 
	$pickupfield = $_POST['acf']['field_5add43486596f']; 
	$pickup = date('F j, Y', strtotime($pickupfield)); 
	$title = 'Dart ID # ' . $dartID . ' - ' . $username . ', Ride Date: ' . $pickup;
    $content = array(
        'ID' => $post_id,
        'post_title' => $title 
    );
    wp_update_post($content);
	return $post_id;	
}
add_action( 'acf/pre_save_post', 'generate_new_ride_title', 10, 2 );










//DASHBOARD CHECK DELETE
// Delete post
function delete_post(){
    global $post;
    $deletepostlink= add_query_arg( 'frontend', 'true', get_delete_post_link( get_the_ID() ) );
    if (current_user_can('edit_post', $post->ID)) {
        echo '<a href="' . $deletepostlink .'" class="icon delete-ride" onclick="return confirm(\'Are you sure you want to delete this ride reservation?\')"><i class="fa fa-times" aria-hidden="true"></i></a>';
    }
}

//Redirect after delete post in frontend
add_action('trashed_post','trash_redirection_frontend');
function trash_redirection_frontend($post_id) {
    if ( filter_input( INPUT_GET, 'frontend', FILTER_VALIDATE_BOOLEAN ) ) {
        wp_redirect( get_option('siteurl').'/dashboard/' );
        exit;
    }
}







?>
