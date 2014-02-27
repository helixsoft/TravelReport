<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 */

get_header(); ?>
	<div class="main row">
		<div class="large-5 columns">
		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="text-container">
					<h1><a href="#"><?php the_title(); ?></a></h1>
					<div class="small-container clearfix">
						<div class="date"><?php the_date('F j, Y')?> <?php echo get_the_time();?></div>
					</div>
				</div>
				<div class="text-container">
					<?php the_content();?>
				</div>
			</article>
		<?php endwhile;?>
		</div>
		<?php get_sidebar();?>
	</div>
<?php get_footer();?>