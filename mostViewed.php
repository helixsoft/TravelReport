<?php
/*
 * Template Name: mostViewed
 */
?>
<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Wordpress
 * @subpackage Travelmedia
 * @since
 */

get_header(); ?>

		<div class="main row">
      <div class="large-5 columns">
        <div class="text-header color_coding"><h2><?php _e('Mest l&auml;sta','TravelReport')?></h2></div>
		  <?php
        /*$sql = "SELECT p.id, p.post_title, p.post_date, p.post_content, p.post_modified, ppd.pageviews
                FROM `travelmedia`.`wp_posts` p
                  INNER JOIN travelmedia.wp_popularpostsdata ppd ON p.id = ppd.postid
                WHERE p.post_status = 'publish'
                  AND p.post_type = 'post'                  
                ORDER BY ppd.pageviews DESC
				LIMIT 40
                ";*/
		    $sql = "SELECT p.*, ppd.pageviews
                FROM `wp_posts` p
                  INNER JOIN wp_popularpostsdata ppd ON p.id = ppd.postid
                WHERE p.post_status = 'publish'
                  AND p.post_type = 'post'                  
                ORDER BY ppd.pageviews DESC
				LIMIT 20
                ";

        $result = $wpdb->get_results($sql, OBJECT);//mysql_query($sql) or die('Fr?gan misslyckades: ' . mysql_error());

        $nAlternate = 1;
        //while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		global $post;
		foreach ($result as $post){
// FROM SERGEY start
			setup_postdata($post);
			
 ?><!--
 <?php
 //print 'row -- ';print_r($post);
 ?>
 -->
        <?php if($i==0){$first_post=get_permalink();$i++;} ?>
        <?php get_template_part( 'content', get_post_format() ); ?>
        <?php } ?>
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
