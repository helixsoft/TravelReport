<?php
/**
 * The default template for displaying content.
 */
?>			
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="margin-top-25">
	
	<?php if(get_the_post_thumbnail($post->ID, 'thumbnail-container')){?>
	<div class="image-container">
		<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" >
        <?php echo get_the_post_thumbnail($post->ID, 'thumbnail-container'); ?>
    	</a>
	</div>
    <?php }else{ ?>
	<?php 
	 	$sFirstImage = catch_first_post_image();
	 	if ($sFirstImage != "") { ?>
	 		<div class="image-container">
				<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" >
		 		<?php
					echo "<img src=\"" . $sFirstImage . "\" class=\"\" alt=\"\" />";
				?>
				</a>
			</div>
	 	<?php }else{ ?>
	 		<!--<img src="<?php echo IMAGES?>/fallback_voyage.png">-->
	 	<?php } ?>
	<?php } ?>
	<?php wp_caption_text();?>
	<div class="text-container">
		<h1><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?> "><?php echo get_the_title(); ?></a></h1>
		<div class="small-container">
			<span class="date"><?php echo ucfirst (get_the_date()); ?> - <?php the_time('G:i'); ?></span>
			<span class="tag-container">
				<?php echo TravelReport_categorylist($post->ID,'');?>
			</span>
		</div>
		<p class="description"><span class="arrow">>></span><a href="<?php echo get_permalink(); ?>"><?php the_excerpt(); ?></a></p>
	</div>
	<!--<div class="divider"></div>-->
</article>