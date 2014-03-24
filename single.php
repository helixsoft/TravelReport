<?php
/**
 * The Template for displaying all single posts.
 *
 */

get_header(); ?>
	<div class="main row">
		<div class="large-450 columns">
			<article class="margin-top-none new-font">
			<?php /* The loop */ ?>
			<?php //print_r(get_post_format());?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('single-page',get_post_format()); ?>
				
			<?php endwhile; ?>
				<div class="large-12 columns">
					<div class="row">
						<div class="text-header small orange color_coding"><h2>SENASTE NUMRET</h2></div>
						<div class="row related">
							<?php relatedpost($post->ID); ?>
						</div>
					</div>
				</div>
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