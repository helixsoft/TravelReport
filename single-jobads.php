<?php
/**
 * The Template for displaying all single jobads.
 *
 */

get_header(); ?>
	<div class="main row">
		<div class="large-450 columns">
			<article class="margin-top-none">
			<?php /* The loop */ ?>
			<?php //print_r(get_post_format());?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('single-page-jobads'); ?>
			<?php endwhile; ?>
			</article>
			<?php TravelReport_post_nav()?>
				<script type='text/javascript'>
	        /* <![CDATA[ */
	        var fangohr_dynload = {"postType":"post","startPage":"1","maxPages":"5163","nextLink":"<?php echo get_vogaye_next_link(get_next_posts_link( ''));?>","startPostPage":"1","nextPostPageLink":"<?php the_permalink()?>"};
	        /* ]]> */
	        </script>
		</div>
		<?php get_sidebar();?>
	</div>
<?php get_footer(); ?>