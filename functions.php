<?php
/*****************************************************************************/
/*Define Constants*/
/*****************************************************************************/

define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES',THEMEROOT. '/images');

/**
 * Sets up theme defaults and registers the various WordPress features that
 * TravelReport supports.
 */
function TravelReport_setup() {
	/*
	 * Makes voyage available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'twentythirteen' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'TravelReport', get_template_directory() . '/languages' );
	require( get_template_directory() . '/inc/widgets.php' );
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'TravelReport' ) );
	register_nav_menu( 'top-nav', __( 'Top Menu', 'TravelReport' ) );
	register_nav_menu( 'footer-nav', __( 'footer Menu', 'TravelReport' ) );
	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size( 300, 150, true );
	add_image_size( 'thumbnail-container',300, 150,true);
}

add_action( 'after_setup_theme', 'TravelReport_setup' );
/**
 * Loads a set of CSS and/or Javascript documents. 
 */
function mega_enqueue_admin_scripts($hook) {
	wp_register_style( 'ot-admin-custom', get_template_directory_uri() . '/inc/css/ot-admin-custom.css' );
	if ( $hook == 'appearance_page_ot-theme-options' ) {
		wp_enqueue_style( 'ot-admin-custom' );
	}

	wp_register_style( 'admin.custom', get_template_directory_uri() . '/inc/css/admin.custom.css' );
	wp_register_script( 'jquery.admin.custom', get_template_directory_uri() . '/inc/jquery.admin.custom.js', array( 'jquery' ) );
	if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) 
		return;
	wp_enqueue_style( 'admin.custom' );
	wp_enqueue_script( 'jquery.admin.custom' );
}
add_action( 'admin_enqueue_scripts', 'mega_enqueue_admin_scripts' );


/**
 * Load up our theme meta boxes and related code.
 */
	require( get_template_directory() . '/inc/meta-functions.php' );
	require( get_template_directory() . '/inc/meta-box-post.php' );
	
include_once( trailingslashit( get_template_directory() ) . 'inc/resize.php' );
remove_filter('the_excerpt', 'wpautop');

function custom_excerpt_length( $length ) {
	return 45;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	
function new_excerpt_more( $more ) {
	return '';
}
add_filter('excerpt_more', 'new_excerpt_more');



// Gallery
function mega_clean( $var ) {
	return sanitize_text_field( $var );
}


/**
* Enqueue Scripts and Styles for Front-End
*/

if ( ! function_exists( 'TravelReport_assets' ) ) :

function TravelReport_assets() {

	if (!is_admin()) {

		/**
		* Deregister jQuery in favour of ZeptoJS
		* jQuery will be used as a fallback if ZeptoJS is not compatible
		* @see foundation_compatibility & http://foundation.zurb.com/docs/javascript.html
		*/
		wp_deregister_script('jquery');
		wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js", false, true);
		wp_enqueue_script('jquery');
		

		// Load JavaScripts
		wp_enqueue_script( 'foundation', get_template_directory_uri() . '/js/foundation.min.js', null, '4.0', true );
		wp_enqueue_script( 'foundation tab', get_template_directory_uri() . '/js/foundation/foundation.tab.js', null, '4.0', true );
		wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/vendor/custom.modernizr.js', null, '2.1.0');
		wp_enqueue_script('plug',get_template_directory_uri().'/js/sharre.js', array('jquery'),null,true);
		wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), false, true );
		// Load Stylesheets
		wp_enqueue_style( 'normalize', get_template_directory_uri().'/css/normalize.css' );
		wp_enqueue_style( 'foundation', get_template_directory_uri().'/css/foundation.css' );
		wp_enqueue_style( 'app', get_stylesheet_uri(), array('foundation') );

		// Load Google Fonts API
		wp_enqueue_style( 'google-fonts-roboto', 'http://fonts.googleapis.com/css?family=Roboto:400,500,700' );
		wp_enqueue_style( 'google-fonts-lato', 'http://fonts.googleapis.com/css?family=Lato:400,700' );
	}
}

add_action( 'wp_enqueue_scripts', 'TravelReport_assets' );

endif;


	/**
 * Get Vimeo & YouTube Thumbnail.
 */
function mega_get_video_image($url){
	if(preg_match('/youtube/', $url)) {			
		if(preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches)) {
			return "http://img.youtube.com/vi/".$matches[1]."/default.jpg";  
		}
	}
	elseif(preg_match('/vimeo/', $url)) {			
		if(preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $url, $matches))	{
				$id = $matches[1];	
				if (!function_exists('curl_init')) die('CURL is not installed!');
				$url = "http://vimeo.com/api/v2/video/".$id.".php";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				$output = unserialize(curl_exec($ch));
				$output = $output[0]["thumbnail_medium"]; 
				curl_close($ch);
				return $output;
		}
	}		
}

/**
 * Retrieve YouTube/Vimeo iframe code from URL.
 */
function mega_get_video( $postid, $width = 940, $height = 308 ) {	
	$video_url = get_post_meta( $postid, 'mega_youtube_vimeo_url', true );	
	if(preg_match('/youtube/', $video_url)) {			
		if(preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches)) {
			$output = '<iframe width="'. $width .'" height="'. $height .'" src="http://www.youtube.com/embed/'.$matches[1].'?wmode=transparent&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe> ';
		}
		else {
			$output = __( 'Sorry that seems to be an invalid YouTube URL.', 'mega' );
		}			
	}
	elseif(preg_match('/vimeo/', $video_url)) {			
		if(preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $video_url, $matches))	{				
			$output = '<iframe src="http://player.vimeo.com/video/'. $matches[1] .'?title=0&amp;byline=0&amp;portrait=0" width="'. $width .'" height="'. $height .'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';         	
		}
		else {
			$output = __( 'Sorry that seems to be an invalid Vimeo URL.', 'mega' );
		}			
	}
	else {
		$output = __( 'Sorry that seems to be an invalid YouTube or Vimeo URL.', 'mega' );
	}	
	echo $output;	
}


/**
* Initialise Foundation JS
* @see: http://foundation.zurb.com/docs/javascript.html
*/

if ( ! function_exists( 'TravelReport_js_init' ) ) :

function TravelReport_js_init () {
    echo '<script>jQuery(document).foundation();</script>';
}

add_action('wp_footer', 'TravelReport_js_init', 50);

endif;

/**
* ZeptoJS and jQuery Fallback
* @see: http://foundation.zurb.com/docs/javascript.html
*/

if ( ! function_exists( 'TravelReport_comptability' ) ) :

function TravelReport_comptability () {

echo "<script>";
echo "document.write('<script src=' +";
echo "('__proto__' in {} ? '" . get_template_directory_uri() . "/js/vendor/zepto" . "' : '" . get_template_directory_uri() . "/js/vendor/jquery" . "') +";
echo "'.js><\/script>')";
echo "</script>";

}

add_action('wp_footer', 'TravelReport_comptability', 10);

endif;

if ( ! function_exists( 'TravelReport_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 */
function TravelReport_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav id="nav-below" class="nav-pagination clearfix">
          	<?php if ( get_previous_posts_link() ) : ?>
          	<div class="nav-previous">
            	<?php previous_posts_link(__('Föregående sida','TravelReport')); ?>  
          	</div>
      		<?php endif;?>
          	<?php if ( get_next_posts_link() ) : ?>
          	<div class="nav-next">
            	<?php next_posts_link(__('Nästa sida','TravelReport')); ?>  
          	</div>
      		<?php endif;?>
        </nav> 
	<?php
}
endif;

if ( ! function_exists( 'TravelReport_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*/
function TravelReport_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav id="nav-below" class="nav-pagination single clearfix">
        <div class="thin-line"></div>
        <div class="nav-previous">
          	<?php previous_post_link( '%link', _x('Föregående','test1','TravelReport' ) ); ?>
        </div>
        <div class="nav-next">
           	<?php next_post_link( '%link', _x( 'Nästa','test2','TravelReport' ) ); ?>
        </div>
    </nav> 
	<?php
}
endif;

function get_vogaye_next_link($html){
	preg_match('/<a href="(.+)" >/', $html, $match);
	if(isset($match[1])){
		$url=$match[1];
		return $url;
	}
}
/**
 * Register our sidebars and widgetized areas.
 */
function TravelReport_widgets_init() {

	register_widget( 'super' );
	register_widget( 'job' );
	register_widget( 'video' );
	register_sidebar( array(
		'name' => __( 'Left Sidebar', 'TravelReport' ),
		'id' => 'left-sidebar',
		'description' => __( 'This is Main Left widget area for your page', 'TravelReport' ),
		'before_widget' => '',
		'after_widget' => "",
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Right Sidebar', 'TravelReport' ),
		'id' => 'right-sidebar',
		'description' => __( 'This is Main Right widget area for your page', 'TravelReport' ),
		'before_widget' => '',
		'after_widget' => "",
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'TravelReport_widgets_init' );




function relatedpost($postid){

    $max_articles = 5;  // How many articles to display
    $cnt = 0;
    
    $article_tags = get_the_tags($postid);
    $tags_string = '';
    if ($article_tags) {
        foreach ($article_tags as $article_tag) {
            $tags_string .= $article_tag->slug . ',';
        }
    }
    $tag_related_posts = get_posts('exclude=' . $postid . '&numberposts=' . $max_articles . '&tag=' . $tags_string);
    
    if ($tag_related_posts) {
        foreach ($tag_related_posts as $related_post) {
            $cnt++;

            echo '<div class="large-12 columns"><div class="text-container">';
            echo '<h6>';
            echo '<a href="' . get_permalink($related_post->ID) . '" title="' .$related_post->post_title .'">';
            echo $related_post->post_title;
            echo '</a>';
            echo '</h6>';
            echo '<div class="small-container clearfix">';
	        echo '<div class="date">'.get_the_time( 'F j, Y', $related_post->ID ).'</div>';
			echo '<p>';
			echo '<a href="' . get_permalink($related_post->ID) . '" title="' .$related_post->post_title .'">';
			echo $related_post->post_excerpt;
			echo '</a>';
			echo '</p>';
			echo '</div>';
            echo '</div></div>';
        }
    }


    // Only if there's not enough tag related articles,
    // we add some from the same category
    
    if ($cnt < $max_articles) {
        
        $article_categories = get_the_category($postid);
        $category_string = '';
        foreach($article_categories as $category) { 
            $category_string .= $category->cat_ID . ',';
        }
        
        $cat_related_posts = get_posts('exclude=' . $postid . '&numberposts=' . $max_articles . '&category=' . $category_string);
        
        if ($cat_related_posts) {
            foreach ($cat_related_posts as $related_post) {
                $cnt++; 
                if ($cnt > $max_articles) break;
				echo '<div class="large-12 columns"><div class="text-container">';
	            echo '<h6>';
	            echo '<a href="' . get_permalink($related_post->ID) . '" title="' .$related_post->post_title .'">';
	            echo $related_post->post_title;
	            echo '</a>';
	            echo '</h6>';
	            echo '<div class="small-container clearfix">';
		        echo '<div class="date">'.get_the_time( 'F j, Y', $related_post->ID ).'</div>';
				echo '<p>';
				echo '<a href="' . get_permalink($related_post->ID) . '" title="' .$related_post->post_title .'">';
				echo $related_post->post_excerpt;
				echo '</a>';
				echo '</p>';
				echo '</div>';
	            echo '</div></div>';
            }
        }
    }     
}

function limit_words($string, $word_limit)
{
$words = explode(" ",$string);
return implode(" ",array_splice($words,0,$word_limit));
}

function TravelReport_categorylist($postid,$separator){
	$categories = get_the_category($postid);
	$output = '';
	if($categories){
		foreach($categories as $category) {
			if ($category !== end($categories)){
				$output .= '<li><a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "%s" ), $category->name ) ) . '">'.$category->cat_name.'</a></li>'.$separator;
			}else{
				$output .= '<li><a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "%s" ), $category->name ) ) . '">'.$category->cat_name.'</a></li>';
			}
		}
		return $output;
	}
}
function TravelReport_categorylistfirstArray($postid){
	$categories = get_the_category($postid);
	$output = array();
	if($categories){
		$i=0;
		foreach($categories as $category) {
			$output[$i]=$category->cat_name;
			$i++;
		}
		return $output;
	}
}


// Get URL of first image in a post
function catch_first_post_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  if(isset($matches[1][0])){
  	$first_img = $matches [1][0];
  	$width = 150;                                                                  // Optional. Defaults to '150'
	$height = 150;                                                                 // Optional. Defaults to '150'
	$crop = true;                                                                  // Optional. Defaults to 'true'
	$retina = false;                                                               // Optional. Defaults to 'false'

	// Call the resizing function (returns an array)
	$image = matthewruddy_image_resize( $first_img, $width, $height, $crop, $retina );
	//print_r($image);
	if ( is_wp_error( $image ) ) {
	    echo $image->get_error_message();        // Displays error message returned from resizing function
	} else {
	   return $image['url'];          // Everything appears to have gone well. Continue as normal!
	}
  }
}

function wp_caption_text(){
	global $post, $posts;
	$name='';
	ob_start();
    ob_end_clean();
	if ($c=preg_match_all ('/caption=\"(.*?)\"/s', $post->post_content, $matches))
	{
	    $tag1=$matches[1][0];
	    $name="<p class=\"wp-caption-text\">".$tag1."</p>";
	    echo $name;
	}
}

function get_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			return rtrim(mb_substr( $subex, 0, $excut )).'...';
		} else {
			return $subex;
		}
		return '[...]';
	} else {
		return $excerpt;
	}
}

function RemoveSwedishLetters($sString) {
  $sString = htmlentities($sString);
  $arrRemove  = array ("&aring;", "&Aring;", "&auml;", "&Auml;", "&ouml;", "&Ouml;");
  $arrReplace = array ("a",       "A",       "a",      "A",      "o",      "O");

  return str_replace ($arrRemove, $arrReplace, $sString);
}

function GetFirstMenuItem($menu) {
  global $wpdb;

  $sQueryFirstMenuItem = "SELECT p.ID
                          FROM $wpdb->prefix"."wp_term_taxonomy tt
                            INNER JOIN $wpdb->prefix"."terms t ON tt.term_id = t.term_id
                            INNER JOIN $wpdb->prefix"."term_relationships tr ON tr.term_taxonomy_id = t.term_id
                            INNER JOIN $wpdb->prefix"."posts p ON tr.object_id = p.ID
                          WHERE tt.taxonomy = 'nav_menu'
                            AND t.name = '{$menu}'
                          ORDER BY p.menu_order
                          LIMIT 0, 1;";

  return $wpdb->get_var($sQueryFirstMenuItem);
}


function GetMenuItemForCategory($menu, $cat) {
  global $wpdb;

  $sQueryMenuItem = "SELECT pm1.post_id, pm2.meta_value AS menu_item_parent
                     FROM $wpdb->prefix"."postmeta pm1
                       INNER JOIN $wpdb->prefix"."postmeta pm2 ON pm1.post_id = pm2.post_id
                       INNER JOIN $wpdb->prefix"."term_relationships tr ON pm1.post_id = tr.object_id
                       INNER JOIN $wpdb->prefix"."terms t ON term_taxonomy_id = t.term_id
                     WHERE pm1.meta_key = '_menu_item_object_id'
                       AND pm1.meta_value = {$cat}
                       AND pm2.meta_key = '_menu_item_menu_item_parent'
                       AND t.name = '{$menu}'
                     ORDER BY menu_item_parent;";

  return $wpdb->get_var($sQueryMenuItem);
}

function GetMenuParent($menu, $menu_id) {
  global $wpdb;

  $sQueryMenuParent = "SELECT pm2.meta_value AS menu_item_parent
                       FROM $wpdb->prefix"."postmeta pm1
                         INNER JOIN $wpdb->prefix"."postmeta pm2 ON pm1.post_id = pm2.post_id
                         INNER JOIN $wpdb->prefix"."term_taxonomy t2
                         INNER JOIN $wpdb->prefix"."terms t ON t2.term_taxonomy_id = t.term_id
                       WHERE pm1.meta_key = '_menu_item_object_id'
                         AND pm1.meta_value = {$menu_id}
                         AND pm2.meta_key = '_menu_item_menu_item_parent'
                         AND t.name = '{$menu}';";
  /*$sQueryMenuParent = "SELECT t2.term_taxonomy_id AS menu_item_parent
                       FROM $wpdb->prefix"."term_taxonomy t1
                         INNER JOIN $wpdb->prefix"."term_taxonomy t2 ON t2.term_id=t1.parent AND t1.taxonomy='category'
                       WHERE t1.term_id= {$menu_id};";*/

  return $wpdb->get_var($sQueryMenuParent);
}

function TravelReport_navigation(){
	$sMenu = "Huvudmeny";
	$arrMenuItems = wp_get_nav_menu_items($sMenu);
	$arrMenuItemsMod = array();
	//print_r((array)$arrMenuItems);
	$i=0;
	$m=0;
	$t=0;
	foreach($arrMenuItems as $key=>$value){
		$id = $value->ID;
		$id = $value->object_id;
		$parent = $value->menu_item_parent;
		if($parent==0){
			$parent_list_id[$i]=$value->ID;
			$i++;
			$m=0;
		}else{
			if($parent_list_id[$i-1]==$parent){
				$child_list_id[$parent][$m]=$value->ID;
				$per=$parent;
				$m++;
				$t=0;
			}else{
				if($child_list_id[$per][$m-1]==$parent)
				{
					$sub_child_list_id[$parent][$t]=$value->ID;
					$t++;
				}
			}
		}
	}
	//print_r($parent_list_id);
	//print_r($child_list_id);
	//print_r($sub_child_list_id);
	if (is_single()) {
		global $wp_query;
		$nPostId = $wp_query->post->ID;
		$sPostType = get_post_type($nPostId);
      	$arrCurrentCategory = get_the_category($nPostId);
      	$nCurrentCategory = $arrCurrentCategory[0]->cat_ID;
      	if ($nCurrentCategory == 843) {
        	$nCurrentCategory = "";
        	$fnCurrentCategory = $nCurrentCategory;
      	}
      	$fnCurrentCategory = $nCurrentCategory;
      	
    } else if(is_page()){
      	global $wp_query;
      	$nPostId = $wp_query->post->ID;
	  	
      	$sPostType = get_post_type($nPostId);
	  	$nCurrentCategory = $nPostId;
	  	$fnCurrentCategory = $nCurrentCategory;
	  	$p = isset($arrMenuItemsMod[$nCurrentCategory]) ? $arrMenuItemsMod[$nCurrentCategory]['item']->object : '';
	  	if($p!='page'){
			$nCurrentCategory = '';
			$fnCurrentCategory = '';
	  	}
	  	
	} else {
		
      	$nCurrentCategory = get_query_var('cat');
      	$fnCurrentCategory = $nCurrentCategory;
      	if (str_replace ("/new/", "", $_SERVER['REQUEST_URI']) == "alla-annonser/") {
        	$nCurrentCategory = 30;
        	$fnCurrentCategory =30;
      	}	
    }
    if ($nCurrentCategory == '') {
		$fnCurrentCategory = 77;
	}
	if ($nCurrentCategory == 18) {
		$fnCurrentCategory = 71;		        
	}
	if ($nCurrentCategory == 22) {
		$fnCurrentCategory = 64;
	}				
    if ($sPostType == "jobads") {
      	$fnCurrentCategory = 48;
    }
    if ($nCurrentCategory == 30) {
      	$fnCurrentCategory = 48;
    }
    if ($nCurrentCategory == 34) {
      	$fnCurrentCategory = 63;
    }
    if ($nCurrentCategory == 45) {
      	$fnCurrentCategory = 52;
    }
	echo "<ul class=\"main_menu\">";
	foreach ($parent_list_id as $key) {
		$menu=search($arrMenuItems,'ID', $key);
		if($key==77){
			$home_url = home_url();
			echo "<li id=\"menu-item-{$key}\" class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-{$key}\"><a href=\"{$home_url}\">{$menu->title}</a></li>";
		}else{
			echo "<li id=\"menu-item-{$key}\" class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-{$key}\"><a href=\"{$menu->url}\">{$menu->title}</a></li>";
		}
	}
	echo "</ul>";
	echo "<nav class=\"cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left\" id=\"cbp-spmenu-s1\"><h3>Menu</h3>";
	foreach ($parent_list_id as $key) {
		$menu=search($arrMenuItems,'ID', $key);
		if($key==77){
			$home_url = home_url();
			echo "<a href=\"{$home_url}\">{$menu->title}</a>";
		}else{
			echo "<a href=\"{$menu->url}\">{$menu->title}</a>";
		}
	}
	echo "</nav>";
	echo "<ul id=\"sub_menu-{$fnCurrentCategory}\" class=\"sub_menu\">";
	foreach ($child_list_id[$fnCurrentCategory] as $key) {
		$menu=search($arrMenuItems,'ID', $key);
		echo "<li id=\"menu-item-{$key}\" class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-{$key}\"><a href=\"{$menu->url}\">{$menu->title}</a></li>";
	}
	echo "</ul>";
	foreach ($parent_list_id as $key) {
		$menu=search($arrMenuItems,'ID', $key);
		echo "<ul class=\"sub_menu_hover\" id=\"sub_menu_hover-{$key}\">";
			echo "<div class=\"cat_area\"><h3>I den här sektionen</h3>";
			echo	"<ul class=\"cat_name\">";
			foreach ($child_list_id[$key] as $childkey) {
				$smenu=search($arrMenuItems,'ID', $childkey);
				echo "<li id=\"menu-item-{$childkey}\" class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-{$childkey}\"><a href=\"{$smenu->url}\">{$smenu->title}</a></li>";
			}
			echo "</ul>";
			echo "</div>";
			$args = array ( 'cat' => $nCurrentCategory, 'posts_per_page' => 5 );
			$the_query = new WP_Query( $args );
			$dta="";
			$dta_more="";
			// The Loop
			$first_post=0;
			
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;  // Add this line and you're golden
				$cat_array=TravelReport_categorylistfirstArray($post->ID);
				$cat_intersect=array_intersect ( $act_cat,$cat_array );
				$cat_name=array_shift($cat_intersect);
				$cat_link=get_category_link(get_cat_ID( $cat_name ));
				if($first_post==0){
					if(get_the_post_thumbnail($post->ID, 'thumbnail-container')){
						$dta.= '<div class="box">
								<div class="image_container">
									<a href="'.get_permalink( $post->ID ).'">
										<img src="'.wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) ).'">
									</a>
								</div>
								<div class="box_info">
									<div class="cat"><a href="'.$cat_link.'" title="'.$cat_name.'">'.$cat_name.'</a></div>
									<div class="date">'.ucfirst (get_the_date()).' - '.get_the_time('G:i').'</div>
									<h4><a href="'.get_permalink( $post->ID ).'">'.get_the_title().'</a></h4>
									<p>'.get_the_excerpt().'</p>
								</div>
							</div>';
					}else{
						$sFirstImage = catch_first_post_image();
						if($sFirstImage!=''){
							$dta.= '<div class="box">
								<div class="image_container">
									<a href="'.get_permalink( $post->ID ).'">
										<img src="'.$sFirstImage.'">
									</a>
								</div>
								<div class="box_info">
									<div class="cat"><a href="'.$cat_link.'" title="'.$cat_name.'">'.$cat_name.'</a></div>
									<div class="date">'.ucfirst (get_the_date()).' - '.get_the_time('G:i').'</div>
									<h4><a href="'.get_permalink( $post->ID ).'">'.get_the_title().'</a></h4>
									<p>'.get_the_excerpt().'</p>
								</div>
							</div>';
						}else{
							$dta.= '<div class="box">
								<div class="image_container">
									<a href="'.get_permalink( $post->ID ).'">
										<img src="'.IMAGES.'/fallback_voyage.png">
									</a>
								</div>
								<div class="box_info">
									<div class="cat"><a href="'.$cat_link.'" title="'.$cat_name.'">'.$cat_name.'</a></div>
									<div class="date">'.ucfirst (get_the_date()).' - '.get_the_time('G:i').'</div>
									<h4><a href="'.get_permalink( $post->ID ).'">'.get_the_title().'</a></h4>
									<p>'.get_the_excerpt().'</p>
								</div>
							</div>';
						}
					}
				}else{
					$dta_more.='<div class="box_info">
							<div class="cat"><a href="'.$cat_link.'" title="'.$cat_name.'">'.$cat_name.'</a></div>
							<div class="date">'.ucfirst (get_the_date()).' - '.get_the_time('G:i').'</div>
							<h4 ><a href="'.get_permalink( $post->ID ).'">'.get_the_title().'</a></h4>
						</div>';
				}
				$first_post++;
			}
			/* Restore original Post Data 
			 * NB: Because we are using new WP_Query we aren't stomping on the 
			 * original $wp_query and it does not need to be reset.
			*/
			wp_reset_postdata();
		
			// Reset Query
			wp_reset_query();
			echo "<div class=\"latest_area\">
			<h3>Senaste från {$sMenuItemTitle}</h3>
			{$dta}</div>
			<div class=\"more\">
			<h3>Mer från {$sMenuItemTitle}</h3>
			<div class=\"box\">{$dta_more}</div>
			</div>";
		echo "</ul>";
	}
}
function search($array, $key, $value)
{
    $results = array();
    foreach ($array as $subarray) {
		if($subarray->$key == $value)
		{
			return $subarray;
		}        
    }
    
}

/**
 * Registering a post type called "jobbannonser".
 */
function create_jobads_type() {
	register_post_type( 'jobads',
		array(
			'labels' => array(
				'name' => __( 'Jobbannonsers', 'TravelReport' ),
				'singular_name' => __( 'Jobbannonser', 'TravelReport' ),
				'add_new' => _x( 'Add New', 'Jobbannonser', 'TravelReport' ),
				'add_new_item' => __( 'Add New Jobbannonser', 'TravelReport' ),
				'edit_item' => __( 'Edit Jobbannonser', 'TravelReport' ),
				'new_item' => __( 'New Jobbannonser', 'TravelReport' ),
				'all_items' => __( 'All Jobbannonser', 'TravelReport' ),
				'view_item' => __( 'View Jobbannonser', 'TravelReport' ),
				'search_items' => __( 'Search Jobbannonser', 'TravelReport' ),
				'not_found' =>  __( 'No Issues Jobbannonser', 'TravelReport' ),
				'not_found_in_trash' => __( 'No Jobbannonser found in Trash', 'TravelReport' )
			),
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'jobads', 'with_front' => false ),
			'capability_type' => 'post',
			'has_archive' => true,
			'public' => true,
			'hierarchical' => false,
			'menu_position' => 5,
			'exclude_from_search' => false,
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' )
		)
	);
}
add_action( 'init', 'create_jobads_type' );

// add filter to ensure the text jobbannonser, or jobbannonser, is displayed when user updates a jobbannonser
function jobads_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['jobads'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Jobbannonser updated. <a href="%s">View issue</a>', 'TravelReport'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'TravelReport'),
    3 => __('Custom field deleted.', 'TravelReport'),
    4 => __('Jobbannonser updated.', 'TravelReport'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Jobbannonser restored to revision from %s', 'TravelReport'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Jobbannonser published. <a href="%s">View Jobbannonser</a>', 'TravelReport'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Jobbannonser saved.', 'TravelReport'),
    8 => sprintf( __('Jobbannonser submitted. <a target="_blank" href="%s">Preview issue</a>', 'TravelReport'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Jobbannonser scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Jobbannonser</a>', 'TravelReport'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', 'TravelReport' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Jobbannonser draft updated. <a target="_blank" href="%s">Preview issue</a>', 'TravelReport'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'jobads_updated_messages' );


function first_paragraph($content){
  return preg_replace('/<p([^>]+)?>/', '<p$1 class="intro">', $content, 1);
}
add_filter('the_content', 'first_paragraph');

function TravelReport_Footer_submenu($item){
	print_r($GLOBALS['footer_menu'][$item]);
}
function TravelReport_Footer_menulink($item){
	print_r($GLOBALS['footer_menu_link'][$item]);
}
function TravelReport_Footer_menutitle($item){
	print_r($GLOBALS['footer_menu_title'][$item]);
}
function TravelReport_Footer_lastmenu(){
	$sMenu = "Toppmeny";
    $arrMenuItems = wp_get_nav_menu_items($sMenu);
    $new_menu="";
    $nParentID = 0;
    foreach($arrMenuItems as $key=>$value){
      	if ($value->menu_item_parent == $nParentID) {
        	$sMenuItemID    = $value->ID;
        	$sMenuItemTitle = $value->title;
        	$sMenuItemUrl   = $value->url;
           	$new_menu.="<li><a href=\"{$sMenuItemUrl}\">{$sMenuItemTitle}</a></li>";
        		
      	}
    }
    print_r($new_menu);
}

//Insert ads after second paragraph of single post content.

add_filter( 'the_content', 'prefix_insert_post_ads' );

function prefix_insert_post_ads( $content ) {
	$myadcode ='<div class="additional-content">';
            $myadcode .='<p>Fler artiklar om:</p>';   
            $myadcode .='<div class="news">'.TravelReport_categorylist($post->ID,'<li>&nbsp;,&nbsp;</li>').'</div>';
            $myadcode .='<div id="example">';
              $myadcode .='<div id="js-share-area-2" class="share-area clearfix" data-text="'.get_the_title($post->ID).'" data-url="'.get_permalink($post->ID).'" data-counturl="'.get_permalink($post->ID).'"></div>';
            $myadcode .='</div>';
            $myadcode .='<div class="tip clearfix">';
              $myadcode .='<div class="mic"></div>';
              $myadcode .='<p>Tipsa oss om nyheter!</p>';
            $myadcode .='</div>';
          $myadcode .='</div>';
	
	$ad_code = $myadcode;
	if ( is_single() && get_post_format( $post->ID )!='video') {
		return prefix_insert_after_paragraph( $ad_code, 2, $content );
	}
	
	return $content;
}
 
// Parent Function that makes the magic happen
 
function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );
	foreach ($paragraphs as $index => $paragraph) {

		if ( trim( $paragraph ) ) {
			$paragraphs[$index] .= $closing_p;
		}

		if ( $paragraph_id == $index + 1 ) {
			$paragraphs[$index] .= $insertion;
		}
	}
	
	return implode( '', $paragraphs );
}