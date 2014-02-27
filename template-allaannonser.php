<?php
/**
 * Template Name: Alla annonser
 */

get_header(); ?>
	<div class="main row">
		<div class="large-5 columns">
			<div class="text-header"><h2>JOBBANNONSER</h2></div>
			<?php
				query_posts('posts_per_page=-1&post_type=jobads&post_status=publish');
	 		?>
			<?php $i=0;$first_post=""; if ( have_posts() ): while ( have_posts() ) : the_post(); 
				$post_id = get_the_ID();
				$sCounty = get_post_meta($post_id, "County", true);
				if($i==0){$first_post=get_permalink();$i++;}
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="margin-top-25">
				<div class="image-container">
					<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" >
				 	<?php if(get_the_post_thumbnail($post->ID, 'large')){ ?>
					        <?php echo get_the_post_thumbnail($post->ID, 'large');?>	
				    <?php } ?>
				    </a>
				</div>
				<div class="text-container">
					<h1><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>" ><?php echo get_the_title(); ?></a></h1>
					<div class="small-container">
						<div class="date"><?php echo ucfirst (get_the_date()); ?> - <?php the_time('G:i'); ?></div>
					</div>
					<p class="description"><a href="<?php echo get_permalink(); ?>"><?php the_excerpt(); ?></a></p>
				</div>
				<!--<div class="divider"></div>-->
			</article>
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
<?php get_footer(); ?>