<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array(
      array(
        'id'          => 'general',
        'title'       => 'General Settings'
      ),
      array(
        'id'          => 'social',
        'title'       => 'Social Accounts'
      ), 
    ),
    'settings'        => array( 
      array(
        'id'          => 'facebook_name',
        'label'       => 'Facebook Name',
        'desc'        => '',
        'std'         => 'voyage',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'facebook_url',
        'label'       => 'Facebook Address (URL)',
        'desc'        => '',
        'std'         => 'http://www.facebook.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'twitter_handler',
        'label'       => 'Twitter Handler',
        'desc'        => '',
        'std'         => 'voyage',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'twitter_url',
        'label'       => 'Twitter Address (URL)',
        'desc'        => '',
        'std'         => 'https://twitter.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'gplus_url',
        'label'       => 'Google Plus Address (URL)',
        'desc'        => '',
        'std'         => 'https://plus.google.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'pinterest_url',
        'label'       => 'Pinterest Address (URL)',
        'desc'        => '',
        'std'         => 'http://pinterest.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tumblr_url',
        'label'       => 'Tumblr Address (URL)',
        'desc'        => '',
        'std'         => 'https://www.tumblr.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'mailchimp_action_url',
        'label'       => 'MailChimp Action (URL)',
        'desc'        => '',
        'std'         => '#',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'feed_url',
        'label'       => 'RSS Address (URL)',
        'desc'        => '',
        'std'         => '#',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'disqus_shortname',
        'label'       => 'Disqus Shortname',
        'desc'        => '',
        'std'         => '<example>',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'fallback_image',
        'label'       => 'Fallback Image',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}