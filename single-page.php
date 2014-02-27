<div class="text-container">
	<h1 class="margin-top-none"><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?> "><?php echo get_the_title(); ?></a></h1>
	<div class="small-container clearfix">
		<div class="date"><?php echo ucfirst (get_the_date()); ?> - <?php the_time('G:i'); ?></div>
	</div>
</div>
<?php
    the_content();
?>
<div class="entry-author-info clearfix">
  <div class="author-avatar">
    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>">
      <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'travelmedia_author_bio_avatar_size', 60 ) );?>
    </a>
  </div>
  <div class="author-info">
    <p><?php echo ucfirst(get_the_author_meta('display_name')) ?></p>
    <span><?php echo get_the_author_meta( 'user_email' ) ?></span>          
  </div>
</div>