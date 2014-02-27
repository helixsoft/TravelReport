<div class="text-container">
	<h1 class="margin-top-none"><a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?> "><?php echo get_the_title(); ?></a></h1>
	<div class="small-container clearfix">
		<div class="date"><?php echo ucfirst (get_the_date()); ?> - <?php the_time('G:i'); ?></div>
	</div>
</div>
<?php the_content();?>