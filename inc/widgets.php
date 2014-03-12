<?php

/**
 * Makes a custom Widget for for with TravelReport
 *
 * @package WordPress
 * @subpackage TravelReport
 * @since TravelReport 1.0
 */
?>
<?php 
class super extends WP_Widget {

	function super() {
		$widget_ops = array( 'classname' => 'widget_recent_super_updates', 'description' => __( 'Use this widget to display your sidebar content.', 'TravelReport' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'widget_recent_super_updates' );
		$this->WP_Widget( 'widget_recent_super_updates', __('Travel Report Super Widget', 'TravelReport'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
 		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('super', 'TravelReport') : $instance['title'], $instance, $this->id_base);
		$color = empty( $instance['color'] ) ? '#FF0000' : $instance['color'];
		$border = empty( $instance['color'] ) ? 'Small' : $instance['border'];
		$category = empty( $instance['category'] ) ? '' : $instance['category'];
		$number = empty( $instance['number'] ) ? '' : $instance['number'];
		$image_uri =empty( $instance['image_uri'] ) ? '' : $instance['image_uri'];
		$image_type =empty( $instance['image_type'] ) ? 'Use Featured Image' : $instance['image_type'];
		$setting =empty( $instance['setting'] ) ? 'Show Only Title For Each Post' : $instance['setting'];
		$excerpt = empty( $instance['excerpt'] ) ? '' : $instance['excerpt'];
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 2;
 		if ( empty( $instance['excerpt'] ) || ! $excerpt = absint( $instance['excerpt'] ) )
 			$excerpt = 50;
 		$text = empty( $instance['text'] ) ? '' : $instance['text'];
 		$widget_show = empty( $instance['widget_show'] ) ? 'Show Post' : $instance['widget_show'];

?>
		<div class="text-header <?php echo strtolower($border) ?> <?php echo strtolower($color); ?>"><h2><?php echo $title; ?></h2></div>
		<?php if($widget_show == 'Show Post'){ ?>
		<?php 
			$category_data = &get_category($category);
		?>
		<?php if($category_data->slug == 'senaste-numret' ){?>
		<div class="<?php if($category_data->slug == 'senaste-numret' ){ echo 'latest-issue' ;}?> row">
			<?php if($image_type == 'Use Custom Image' ) {?>
			<div class="large-12 small-4 columns">
				<div class="image-container margin-top-10">
					<img src="<?php echo $image_uri ?>">
				</div>
			</div>
			<?php } ?>
			<?php if($image_type == 'Use Featured Image') {?>
			<div class="large-12 small-4 columns">
				<div class="image-container margin-top-10">
					<?php
					// The Query
					$args = array(
						'post_type' => 'post',
						'category_name' => $category_data->slug,
						'posts_per_page' => $number,
					);
					$the_query = new WP_Query( $args );
					// The Loop
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
					 	$sFirstImage = catch_first_post_image();
					 	if ($sFirstImage != "") { 
							echo "<img src=\"" . $sFirstImage . "\" class=\"\" alt=\"".get_the_title()."\" />";
							break;
					 	}	
					}

					/* Restore original Post Data 
					 * NB: Because we are using new WP_Query we aren't stomping on the 
					 * original $wp_query and it does not need to be reset.
					*/
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php } ?> 
			<div class="large-12 small-8 columns">
				<ul class="link margin-top-10 clearfix">
					<?php
					// The Query
					$args = array(
						'post_type' => 'post',
						'category_name' => $category_data->slug,
						'posts_per_page' => $number,
					);
					$the_query = new WP_Query( $args );
					// The Loop
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<li><a href="'.get_permalink( $post->ID ).'" title="'.get_the_title().'">' . get_the_title() . '</a></li>';
					}

					/* Restore original Post Data 
					 * NB: Because we are using new WP_Query we aren't stomping on the 
					 * original $wp_query and it does not need to be reset.
					*/
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
		<?php } else { ?>
			<div class="travel_reports row">
				<div class="large-12 columns">
					<?php if($image_type == 'Use Custom Image' ) {?>
					<div class="large-12 small-4 columns">
						<div class="image-container margin-top-10">
							<img src="<?php echo $image_uri ?>">
						</div>
					</div>
					<?php } ?>
					<?php
					// The Query
					$args = array(
						'post_type' => 'post',
						'category_name' => $category_data->slug,
						'posts_per_page' => $number,
					);
					$the_query = new WP_Query( $args );
					// The Loop
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						?>
						
						<?php
						$sFirstImage = catch_first_post_image();
						if($image_type == 'Use Featured Image') {
							echo '<div class="image-container">';
							if(get_the_post_thumbnail($post->ID, 'thumbnail-container')){
						        echo get_the_post_thumbnail($post->ID, 'thumbnail-container');
						    }else{
								if ($sFirstImage != "") { 
									echo '<a href="'.get_permalink( $post->ID ).'"><img src="' . $sFirstImage . '" alt="'.get_the_title().'" /></a>';
							 	}else{
							 		echo '<img src="'.IMAGES.'/fallback_voyage.png">';
							 	}
						 	}
						 	echo '</div>';
					 	}
					 	if($setting =='Show Title and Excerpt For Each Post'){
					 		echo '<div class="text-container"><h6><a href="'.get_permalink( $post->ID ).'">'.get_the_title().'</a></h6><p><a href="'.get_permalink( $post->ID).'">'.get_excerpt_max_charlength($excerpt).'</a></p></div>';
						}
						if($setting =='Show Only Title For Each Post'){
							echo '<div class="text-container"><h6><a href="'.get_permalink( $post->ID ).'">'.get_the_title().'</a></h6></div>';	
						}
						?>
						
						<?php
					}

					/* Restore original Post Data 
					 * NB: Because we are using new WP_Query we aren't stomping on the 
					 * original $wp_query and it does not need to be reset.
					*/
					wp_reset_postdata();
					?>
					
				</div>
			</div>
		<?php } ?>
		<?php } ?>
		<?php if($widget_show=='Show Text/Html'){ ?>
			<?php echo $text;?>
		<?php } ?>
<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['color'] = strip_tags( $new_instance['color'] );
		$instance['border'] = strip_tags( $new_instance['border'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['number'] = absint( $new_instance['number'] );
		$instance['image_uri']= strip_tags( $new_instance['image_uri'] );
		$instance['image_type']= strip_tags( $new_instance['image_type'] );
		$instance['setting']= strip_tags( $new_instance['setting'] );
		$instance['excerpt']= absint( $new_instance['excerpt'] );
		$instance['text']= strip_tags( $new_instance['text'] );
		$instance['widget_show'] = strip_tags( $new_instance['widget_show'] );
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','number' => 2,'excerpt' => 50,'border' =>'Small' ) );
		$title = esc_attr( $instance['title'] );
		$color = esc_attr( $instance['color'] );
		$border = esc_attr( $instance['border'] );
		$category = esc_attr( $instance['category'] );
		$image_uri = esc_attr( $instance['image_uri'] );
		$image_type = esc_attr( $instance['image_type'] );
		$setting = esc_attr( $instance['setting'] );
		$excerpt = esc_attr( $instance['excerpt'] );
		$number = esc_attr( $instance['number'] );
		$text = esc_attr( $instance['text'] );
		$widget_show =esc_attr( $instance['widget_show'] );
		// Get the existing categories and build a simple select dropdown for the user.
		$categories = get_categories(array( 'hide_empty' => 0));
 
		$cat_options = array();
		$cat_options[] = '<option value="BLANK">Select one...</option>';
		foreach ($categories as $cat) {
			$selected = $category === $cat->cat_ID ? ' selected="selected"' : '';
			$cat_options[] = '<option value="' . $cat->cat_ID .'"' . $selected . '>' . $cat->name . '</option>';
		}
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: What ever title they set should be displayed in the widgets header in the admin->appearance->widgets area and also as the title of the widget on the site</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('color'); ?>">Color: Choose color from the 6 different colors we use on the site for diffrent categories<br/></label> 
			<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="Red" <?php checked( 'Red', $color ); ?>>Red<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="Violet" <?php checked( 'Violet', $color ); ?>>Violet<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="Blue" <?php checked( 'Blue', $color ); ?>>Blue<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="Green" <?php checked( 'Green', $color ); ?>>Green<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="Orange" <?php checked( 'Orange', $color ); ?>>Orange<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value="Yellow" <?php checked( 'Yellow', $color ); ?>>Yellow<br>
	 	</p>
	 	<p>
	 		<label for="<?php echo $this->get_field_id('border'); ?>">Border: Choose the size of the border<br/></label> 
			<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'border' ); ?>" name="<?php echo $this->get_field_name( 'border' ); ?>" value="Small" <?php checked( 'Small', $border ); ?>>Small<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'border' ); ?>" name="<?php echo $this->get_field_name( 'border' ); ?>" value="Big" <?php checked( 'Big', $border ); ?>>Big<br>	
	 	</p>
		<p>
			<label> Show latest Post</label>
			<label for="<?php echo $this->get_field_id('category'); ?>">
				<?php _e('From:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('category'); ?>" class="widefat" name="<?php echo $this->get_field_name('category'); ?>">
				<?php echo implode('', $cat_options); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of Posts :</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>
	      <label for="<?php echo $this->get_field_id('image_uri'); ?>">Use Custom Image</label><br />
	      <img src="<?php echo $instance['image_uri']; ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" style="width:100%;height:auto;">
	      <input type="text" class="widefat img" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" />
	      <input type="button" class="select-img" value="Select Image" />
	    </p>
	    <p>
			<label for="<?php echo $this->get_field_id('image_type'); ?>">Select Image Type :<br/></label> 
			<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'image_type' ); ?>" name="<?php echo $this->get_field_name( 'image_type' ); ?>" value="Use Featured Image" <?php checked( 'Use Featured Image', $image_type ); ?>>Use Featured Image<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'image_type' ); ?>" name="<?php echo $this->get_field_name( 'image_type' ); ?>" value="Use Custom Image" <?php checked( 'Use Custom Image', $image_type ); ?>>Use Custom Image<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'image_type' ); ?>" name="<?php echo $this->get_field_name( 'image_type' ); ?>" value="No Image" <?php checked( 'No Image', $image_type ); ?>>No Image<br>
	 	</p>
	 	<p>
			<label for="<?php echo $this->get_field_id('setting'); ?>">Post Settings :<br/></label> 
			<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'setting' ); ?>" name="<?php echo $this->get_field_name( 'setting' ); ?>" value="Show Only Title For Each Post" <?php checked( 'Show Only Title For Each Post', $setting ); ?>>Show Only Title For Each Post<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'setting' ); ?>" name="<?php echo $this->get_field_name( 'setting' ); ?>" value="Show Title and Excerpt For Each Post" <?php checked( 'Show Title and Excerpt For Each Post', $setting ); ?>>Show Title and Excerpt For Each Post<br>
        	<label for="<?php echo $this->get_field_id('excerpt'); ?>">Excerpt cutoff (default : 50 characters) :<br/><input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo $excerpt; ?>" /></label>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'setting' ); ?>" name="<?php echo $this->get_field_name( 'setting' ); ?>" value="Show No Title and No Excerpt" <?php checked( 'Show No Title and No Excerpt', $setting ); ?>>Show No Title and No Excerpt<br>
	 	</p>
	 	<p>
			<label for="<?php echo $this->get_field_id('text'); ?>">Text/Html :<br/></label> 
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
	 	</p>
	 	<p>
			<label for="<?php echo $this->get_field_id('widget_show'); ?>">Widget Show Settings:<br/></label> 
			<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'widget_show' ); ?>" name="<?php echo $this->get_field_name( 'widget_show' ); ?>" value="Show Post" <?php checked( 'Show Post', $widget_show ); ?>>Show Post<br>
        	<input class="widefat" type="radio" id="<?php echo $this->get_field_id( 'widget_show' ); ?>" name="<?php echo $this->get_field_name( 'widget_show' ); ?>" value="Show Text/Html" <?php checked( 'Show Text/Html', $widget_show ); ?>>Show Text/Html<br>    	
	 	</p>
	 	<script type="text/javascript">
	    	var image_field;
			jQuery(function($){
			  $(document).on('click', 'input.select-img', function(evt){
			    image_field = $(this).siblings('.img');
			    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			    $('#TB_title').remove();
			    return false;
			  });
			  window.send_to_editor = function(html) {
			    imgurl = $('img', html).attr('src');
			    image_field.val(imgurl);
			    tb_remove();
			  }
			});
	    </script>
<?php
	}
}
class job extends WP_Widget {
	function job() {
		$widget_ops = array( 'classname' => 'widget_recent_job_updates', 'description' => __( 'Use this widget to display jobs in your sidebar content.', 'TravelReport' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'widget_recent_job_updates' );
		$this->WP_Widget( 'widget_recent_job_updates', __('Travel Report Job Widget', 'TravelReport'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
 		extract($args);
 		$title = apply_filters('widget_title', empty($instance['title']) ? __('job', 'TravelReport') : $instance['title'], $instance, $this->id_base);
 		?>
 		<div class="text-header fullcolor"><h2><?php echo $title; ?></h2></div>
					<div class="row jobs">
						<?php
							//The Query
							//query_posts('posts_per_page=10');
							$args = array(
								'post_type' => 'jobads',
								'post_status' => 'publish',
								'posts_per_page' => -1,
							);
							$the_query = new WP_Query($args);
	 					?>
	 					<?php $i=0;if ( $the_query->have_posts() ) while ( $the_query->have_posts() ) : $the_query->the_post(); 
						?>
						<div class="large-12 columns">
							<div class="row <?php echo $i%2==0 ? 'even':'odd' ?>">
								<div class="large-8 small-8 columns">
									<div class="text-container">
										<p><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" ><?php the_title(); ?></a></p>
									</div>
								</div>
								<div class="large-4 small-4 columns">
									<div class="image-container margin-top-10">
										<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_post_thumbnail($post->ID, 'large');?></a>
									</div>
								</div>
							</div>
						</div>
						<?php $i++;endwhile; ?>
						<div class="large-12 columns">
							<div class="view">
								<div class="row">
									<div class="large-6 small-6 columns">
										<div class="all_jobs_annonser"><a href="<?php echo site_url('alla-annonser');?>">vise alla annonser >></a></div>
									</div>
									<div class="large-6 small-6 columns">
										<div class="annonser"><a href="#">annonsera >></a></div>
									</div>
								</div>
							</div>
						</div>
						<?php
						/* Restore original Post Data 
						 * NB: Because we are using new WP_Query we aren't stomping on the 
						 * original $wp_query and it does not need to be reset.
						*/
						wp_reset_postdata();
						?>
					</div>
 		<?php
 	}
 	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = esc_attr( $instance['title'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: What ever title they set should be displayed in the widgets header in the admin->appearance->widgets area and also as the title of the widget on the site</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php
	}
}
class video extends WP_Widget {
	function video() {
		$widget_ops = array( 'classname' => 'widget_recent_video_updates', 'description' => __( 'Use this widget to display video in your sidebar content.', 'TravelReport' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'widget_recent_video_updates' );
		$this->WP_Widget( 'widget_recent_video_updates', __('Travel Report Video Widget', 'TravelReport'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
 		extract($args);
 		$title = apply_filters('widget_title', empty($instance['title']) ? __('job', 'TravelReport') : $instance['title'], $instance, $this->id_base);
 		$number = empty( $instance['number'] ) ? '' : $instance['number'];
 		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 2;
 		?>
 		<div class="text-header small green"><h2><?php echo $title; ?></h2></div>
					<?php 
					    // WP_Query arguments
					  $args = array (
					    'post_type'              => 'post',
					    'post_status'            => 'Published ',
					    'posts_per_page'         => '-1',
					    'showposts' 			 => $number, 	
					    'tax_query' => array(
											    array(
											      'taxonomy' => 'post_format',
											      'field' => 'slug',
											      'terms' => 'post-format-video'
											    )
											  ),
					    'operator' => 'IN',
					  );
					  // The Query
				      $the_query = new WP_Query( $args );
				     ?>
				    <div class="video row">
				    	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div class="large-12 small-6 columns">
							<div class="image-container">
								<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" rel="bookmark">
						        <?php if(get_the_post_thumbnail($post->ID, 'thumbnail-container')){?>
						        <?php echo get_the_post_thumbnail($post->ID, 'thumbnail-container'); ?>
						        <?php }else{ ?>
						        	<?php 
									 	$sFirstImage = catch_first_post_image();
									 	if ($sFirstImage != "") { ?>
									 		<?php
												echo "<img src=\"" . $sFirstImage . "\" class=\"\" alt=\"\" />";
											?>
									<?php }else{ ?>
						          		<img src="<?php echo IMAGES?>/fallback_voyage.png">
						          	<?php } ?>	
						        <?php } ?>
						        <div class="playhover"></div>
						      </a>
							</div>
							<div class="text-container">
								<h6><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></h6>
							</div>
						</div>
						<?php endwhile; ?> 
					</div>
 		<?php
 						/* Restore original Post Data 
						 * NB: Because we are using new WP_Query we aren't stomping on the 
						 * original $wp_query and it does not need to be reset.
						*/
						wp_reset_postdata();
 	}
 	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'number' => 2) );
		$title = esc_attr( $instance['title'] );
		$number = esc_attr( $instance['number'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: What ever title they set should be displayed in the widgets header in the admin->appearance->widgets area and also as the title of the widget on the site</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of Posts :</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<?php
	}
}