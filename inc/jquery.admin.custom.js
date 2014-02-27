jQuery(document).ready(function() {

	/** Post Admin - Show Approprite Metaboxes when Post Format selected **/
	
	var videoMetabox = jQuery('#mega-meta-box-post-video');
	var videoTrigger = jQuery('#post-format-video');	
	videoMetabox.css('display', 'none');
	
	jQuery('#post-formats-select input').change( function() {	
		if (jQuery(this).val() == 'video') {
			hideAllExcept(videoMetabox);
		} else {
			videoMetabox.css('display', 'none');
		}		
	});
	
		
	if (videoTrigger.is(':checked'))
		videoMetabox.css('display', 'block');
		
	function hideAllExcept(metabox) {
		videoMetabox.css('display', 'none');
		metabox.css('display', 'block');
	}

	/** Show Appropriate Metaboxes when Template selected **/
	
	/** Gallery Admin - Switch between Image Gallery/Full Width Slider/Slider/Video Gallery/Gallery with Visible Nearby Images **/
	
  
	
});