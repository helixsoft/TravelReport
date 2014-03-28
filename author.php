<?php
/**
 * The template for displaying Author archive pages.
 */

get_header(); ?>
	<div class="main row">
		<div class="large-450 columns">
			<?php if ( have_posts() ) : ?>
			<?php
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>
			<div class="text-header"><h2><a class="url fn n author-headline" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>" title="<?php echo esc_attr( get_the_author() ) ?>" rel="me"><?php echo get_the_author() ?></a></h2></div>
			<?php endif; ?>
			<?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>
			<?php $i=0;$first_post=""; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php if($i==0){$first_post=get_permalink();$i++;} ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile;endif; ?>
			<div class="large-12 columns">
				<div class="more_posts_2 more-post-container" ></div>
				<?php TravelReport_paging_nav()?>
	        	<a id='view_more_posts' class='view_more_posts' href="#" onClick="_gaq.push(['_trackEvent', 'Homepage', 'Dynamic Load Posts', 'more posts 2']);"><?php _e('+ Visa Fler Artiklar','TravelReport')?></a>
		        <script type='text/javascript'>
		        /* <![CDATA[ */
		        var fangohr_dynload = {"postType":"post","startPage":"1","maxPages":"5163","nextLink":"<?php echo get_vogaye_next_link(get_next_posts_link( ''));?>","startPostPage":"1","nextPostPageLink":"<?php echo $first_post?>"};
		        /* ]]> */
		        </script>
			</div>
		</div>
		<?php get_sidebar();?>
	</div>
<?php get_footer(); ?>