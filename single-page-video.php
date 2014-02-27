<?php
/**
 * The template for displaying single post video.
 */
?>
<div class="text-container ">
	<h1 class="margin-top-none"><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?> "><?php echo get_the_title(); ?></a></h1>
	<div class="small-container clearfix">
		<div class="date"><?php echo ucfirst (get_the_date()); ?> - <?php the_time('G:i'); ?></div>
	</div>
</div>
<?php
  $youtube_vimeo = get_post_meta( $post->ID, 'mega_youtube_vimeo_url', true ); 
  $embed = get_post_meta( $post->ID, 'mega_video_embed_code', true ); 
    
  $ratio_width = get_post_meta( $post->ID, 'mega_video_ratio_width', true );
  $ratio_height = get_post_meta( $post->ID, 'mega_video_ratio_height', true );
                    
  $ratio = '';
  if ( !empty( $ratio_width ) ) 
  $ratio = ( (int)$ratio_height / (int)$ratio_width * 100 ) .'%';
 ?>

<?php if ( $youtube_vimeo !='' ) { ?>
  <div class="responsivevideo">
    <?php mega_get_video( $post->ID, 960, 538 ); ?>
  </div>
<?php } else if ( $embed !='' ) { ?>
  <div class="responsivevideo">
    <?php echo stripslashes( htmlspecialchars_decode( $embed ) );?>
  </div>
<?php } ?>
<?php the_content()?>
<div class="entry-author-info clearfix">
  <div class="author-avatar">
    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>">
      <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'travelmedia_author_bio_avatar_size', 60 ) ); ?> 
    </a>
  </div>
  <div class="author-info">
    <p><?php echo ucfirst(get_the_author_meta('display_name'))?></p>
    <span><?php echo get_the_author_meta( 'user_email' )?></span>          
  </div>
</div>
