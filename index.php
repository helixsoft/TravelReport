<?php
/**
 * The main template file.
 */

get_header(); ?>
	<div class="main row">
		<div class="large-450 columns">
			<div class="text-header color_coding"><h2><?php _e('NYHETER','TravelReport')?></h2></div>
			<?php $i=0;$first_post=""; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			 <?php if($i==0){$first_post=get_permalink();$i++;} ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile;endif; ?>
			<div class="more_posts_2 more-post-container"  style="float: left;"></div>
			<?php TravelReport_paging_nav()?>
        	<a id='view_more_posts' class='view_more_posts' href="#" onClick="_gaq.push(['_trackEvent', 'Homepage', 'Dynamic Load Posts', 'more posts 2']);"><?php _e('+ Visa Fler Artiklar','TravelReport')?></a>
	        <script type='text/javascript'>
	        /* <![CDATA[ */
	        var fangohr_dynload = {"postType":"post","startPage":"1","maxPages":"5163","nextLink":"<?php echo get_vogaye_next_link(get_next_posts_link( ''));?>","startPostPage":"1","nextPostPageLink":"<?php echo $first_post?>"};
	        /* ]]> */
	        </script>
		</div>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>