<?php
	// Loading child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, CHILD_DIR . '/languages' );

	// WP Pointers
	add_action('admin_enqueue_scripts', 'myHelpPointers');

	function myHelpPointers() {

	//First we define our pointers 
	$pointers = array(
		array(
			'id'       => 'xyz1', // unique id for this pointer
			'screen'   => 'options-permalink', // this is the page hook we want our pointer to show on
			'target'   => '#submit', // the css selector for the pointer to be tied to, best to use ID's
			'title'    => theme_locals("submit_permalink"),
			'content'  => theme_locals("submit_permalink_desc"),
			'position' => array( 
								'edge'   => 'top', //top, bottom, left, right
								'align'  => 'left', //top, bottom, left, right, middle
								'offset' => '0 5'
								)
			),

		array(
			'id'       => 'xyz2', // unique id for this pointer
			'screen'   => 'themes', // this is the page hook we want our pointer to show on
			'target'   => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
			'title'    => theme_locals("import_sample_data"),
			'content'  => theme_locals("import_sample_data_desc"),
			'position' => array( 
								'edge'   => 'bottom', //top, bottom, left, right
								'align'  => 'top', //top, bottom, left, right, middle
								'offset' => '0 -10'
								)
			),

		array(
			'id'       => 'xyz3', // unique id for this pointer
			'screen'   => 'toplevel_page_options-framework', // this is the page hook we want our pointer to show on
			'target'   => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
			'title'    => theme_locals("import_sample_data"),
			'content'  => theme_locals("import_sample_data_desc_2"),
			'position' => array( 
								'edge'   => 'left', //top, bottom, left, right
								'align'  => 'top', //top, bottom, left, right, middle
								'offset' => '0 18'
								)
			)
		// more as needed
		);

		//Now we instantiate the class and pass our pointer array to the constructor 
		$myPointers = new WP_Help_Pointer($pointers);
	};














add_filter( 'cherry_slider_params', 'child_slider_params' );
function child_slider_params( $params ) {
    $params['minHeight'] = '"100px"';
    $params['height'] = '"36.32%"';
return $params;
}














// Box
function box_shortcode($atts, $content = null) {

	$output = '<div class="box">';
		$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}
add_shortcode('box', 'box_shortcode');














// Info box
function info_box_shortcode($atts, $content = null) {

	$output = '<div class="info_box">';
		$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}
add_shortcode('info_box', 'info_box_shortcode');




















/**
 * Carousel
 *
 */
if (!function_exists('shortcode_carousel')) {
	function shortcode_carousel($atts, $content = null) {
		wp_enqueue_script('elastislide', CHERRY_PLUGIN_URL . 'includes/assets/js/jquery.elastislide.js', array('jquery'), '1', true);
		wp_enqueue_script('easing', CHERRY_PLUGIN_URL . 'includes/assets/js/jquery.easing.1.3.js', array('jquery'), '1.3', true);

		extract(shortcode_atts(array(
			'title'            => '',
			'num'              => '8',
			'type'             => '',
			'thumb'            => 'true',
			'thumb_width'      => '220',
			'thumb_height'     => '180',
			'more_text_single' => __('Read more', CHERRY_PLUGIN_DOMAIN),
			'category'         => '',
			'custom_category'  => '',
			'excerpt_count'    => '12',
			'date'             => '',
			'author'           => '',
			'min_items'        => '3',
			'spacer'           => '18',
			'custom_class'     => ''
		), $atts));

		$template_url = get_stylesheet_directory_uri();
		
		// check what type of post user selected
		switch ($type) {
			case 'blog':
				$type_post = 'post';
				break;
			case 'portfolio':
				$type_post = 'portfolio';
				break;
			case 'testimonial':
				$type_post = 'testi';
				break;
		}

		$output = '<div class="carousel-wrap '.$custom_class.'">';
		if ($title != '') {
			$output .= '<h2>'.$title.'</h2>';
		}
		$output .= '<div id="carousel-'. $type .'" class="es-carousel-wrapper">';
		$output .= '<div class="es-carousel">';
		$output .= '<ul class="es-carousel_list unstyled">';
		
		global $post;
		global $my_string_limit_words;

		// WPML filter
		$suppress_filters = get_option('suppress_filters');
		
		$args = array(
			'post_type'              => $type_post,
			'category_name'          => $category,
			$type_post . '_category' => $custom_category,
			'numberposts'            => $num,
			'orderby'                => 'post_date',
			'order'                  => 'DESC',
			'suppress_filters'       => $suppress_filters
		);

		$latest = get_posts($args);
		$i = 0;
		
		foreach($latest as $key => $post) {
			// Unset not translated posts
			if ( function_exists( 'wpml_get_language_information' ) ) {
				global $sitepress;

				$check              = wpml_get_language_information( $post->ID );
				$language_code      = substr( $check['locale'], 0, 2 );
				if ( $language_code != $sitepress->get_current_language() ) unset( $latest[$key] );

				// Post ID is different in a second language Solution
				if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, $type_post, true ) );
			}
			setup_postdata($post);
			$excerpt         = get_the_excerpt();
			$format          = get_post_format();
			$attachment_url  = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$url             = $attachment_url['0'];
			$image           = aq_resize($url, $thumb_width, $thumb_height, true);
			$link_format_url = get_post_meta(get_the_ID(), 'tz_link_url', true);

			$output .= '<li class="es-carousel_li '.$format.'">';
				
				if ($thumb == 'true') {
					if (has_post_thumbnail($post->ID) && $format == 'image') {

						$output .= '<figure class="featured-thumbnail">';
						$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
						$output .= '<img  src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
						$output .= '</a></figure>';

					} elseif ( $format != 'video' && $format != 'audio') {

						$thumbid = 0;
						$thumbid = get_post_thumbnail_id($post->ID);
						$images = get_children( array(
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
							'post_type'      => 'attachment',
							'post_parent'    => $post->ID,
							'post_mime_type' => 'image',
							'post_status'    => null,
							'numberposts'    => -1
						) ); 

						if ( $images ) {

							$k = 0;
							//looping through the images
							foreach ( $images as $attachment_id => $attachment ) {
								//if( $attachment->ID == $thumbid ) continue;

								$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
								$img              = aq_resize($image_attributes[0], $thumb_width, $thumb_height, true);  //resize & crop img
								$alt              = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
								$image_title      = $attachment->post_title;

								if ( $k == 0 ) {
									$output .= '<div class="framing"><figure class="featured-thumbnail">';
									$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
									$output .= '<img src="'.$img.'" alt="'.get_the_title($post->ID).'" />';
									$output .= '</a></figure>';
									
									$output .= '<h5><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
									$output .= get_the_title($post->ID);
									$output .= '</a></h5></div>';
								} else {
									$output .= '<figure class="featured-thumbnail" style="display:none;">';
									$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
									$output .= '<img src="'.$img.'" alt="'.get_the_title($post->ID).'" />';
								}
								$output .= '</a></figure>';
								$k++;
							}
						} elseif (has_post_thumbnail($post->ID)) {
							$output .= '<div class="framing"><figure class="featured-thumbnail">';
							$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= '<img src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
							$output .= '</a></figure>';
							
							$output .= '<h5><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= get_the_title($post->ID);
							$output .= '</a></h5></div>';
						} /*else {
							// empty_featured_thumb.gif - for post without featured thumbnail
							$output .= '<figure class="featured-thumbnail">';
							$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= '<img  src="'.$template_url.'/images/empty_thumb.gif" alt="'.get_the_title($post->ID).'" />';
							$output .= '</a></figure>';
						}*/
					} else {
						if (has_post_thumbnail($post->ID)) {
							// for Video and Audio post format - no lightbox
							$output .= '<div class="framing"><figure class="featured-thumbnail"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= '<img  src="'.$image.'" alt="'.get_the_title($post->ID).'" />';
							$output .= '</a></figure>';
							
							$output .= '<h5><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= get_the_title($post->ID);
							$output .= '</a></h5></div>';
						} /*else {
							// empty_featured_thumb.gif - for post without featured thumbnail
							$output .= '<figure class="featured-thumbnail">';
							$output .= '<a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
							$output .= '<img  src="'.$template_url.'/images/empty_thumb.gif" alt="'.get_the_title($post->ID).'" />';
							$output .= '</a></figure>';
						}*/
					}
				}

				$output .= '<div class="desc">';
				if ($date == "yes") {
					$output .= '<time datetime="'.get_the_time('Y-m-d\TH:i:s', $post->ID).'">' .get_the_date().'</time>';
				}

				if ($author == "yes") {
					$output .= '<em class="author">, '.__('by ', CHERRY_PLUGIN_DOMAIN).' <a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author_meta('display_name').'</a></em>';
				}
				
				//Link format
				if ($format == "link") {
					$output .= '<h5><a href="'.$link_format_url.'" title="'.get_the_title($post->ID).'">';
					$output .= get_the_title($post->ID);
					$output .= '</a></h5>';

				//Other formats
				} else {
					$output .= '<h5><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
					$output .= get_the_title($post->ID);
					$output .= '</a></h5>';
				}
				
				if($excerpt_count >= 1){
					$output .= '<p class="excerpt">';
					$output .= my_string_limit_words($excerpt,$excerpt_count);
					$output .= '</p>';
				}
				
				if($more_text_single!=""){
					$output .= '<a href="'.get_permalink($post->ID).'" class="btn btn-primary" title="'.get_the_title($post->ID).'">';
					$output .= $more_text_single;
					$output .= '</a>';
				}
				$output .= '</div>';
				
			$output .= '</li>';

		}
		wp_reset_postdata(); // restore the global $post variable
		
		$output .= '</ul>';
		$output .= '</div></div>';
		$output .= '<script>
		jQuery(document).ready(function(){
			jQuery("#carousel-'. $type .'").elastislide({
					imageW 		: '.$thumb_width.',
					minItems	: '.$min_items.',
					speed		: 600,
					easing		: "easeOutQuart",
					margin		: '.$spacer.',
					border		: 0,
					onClick		: function() {}
			});
		})';
		$output .= '</script>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('carousel', 'shortcode_carousel');
}




















//Recent Testimonials
if (!function_exists('shortcode_recenttesti')) {

	function shortcode_recenttesti($atts, $content = null) {
		extract(shortcode_atts(array(
				'num'           => '5',
				'thumb'         => 'true',
				'excerpt_count' => '30',
				'custom_class'  => '',
		), $atts));

		// WPML filter
		$suppress_filters = get_option('suppress_filters');

		$args = array(
				'post_type'        => 'testi',
				'numberposts'      => $num,
				'orderby'          => 'post_date',
				'suppress_filters' => $suppress_filters
			);
		$testi = get_posts($args);

		$output = '<div class="testimonials '.$custom_class.'">';
		
		global $post;
		global $my_string_limit_words;

		foreach ($testi as $k => $post) {
			// Unset not translated posts
			if ( function_exists( 'wpml_get_language_information' ) ) {
				global $sitepress;

				$check              = wpml_get_language_information( $post->ID );
				$language_code      = substr( $check['locale'], 0, 2 );
				if ( $language_code != $sitepress->get_current_language() ) unset( $testi[$k] );

				// Post ID is different in a second language Solution
				if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, 'testi', true ) );
			}
			setup_postdata($post);
			$excerpt        = get_the_excerpt();
			$testiname      = get_post_meta(get_the_ID(), 'my_testi_caption', true);
			$testiurl       = get_post_meta(get_the_ID(), 'my_testi_url', true);
			$testiinfo      = get_post_meta(get_the_ID(), 'my_testi_info', true);
			$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			$url            = $attachment_url['0'];
			$image          = aq_resize($url, 280, 240, true);

			$output .= '<div class="testi-item">';
				$output .= '<blockquote class="testi-item_blockquote">';
					if ($thumb == 'true') {
						if ( has_post_thumbnail($post->ID) ){
							$output .= '<figure class="featured-thumbnail">';
							$output .= '<img src="'.$image.'" alt="" />';
							$output .= '</figure>';
						}
					}
					$output .= '<a href="'.get_permalink($post->ID).'">';
						$output .= my_string_limit_words($excerpt,$excerpt_count);
					$output .= '</a><div class="clear"></div>';

				$output .= '</blockquote>';

				$output .= '<small class="testi-meta">';
					if( isset($testiname) ) { 
						$output .= '<span class="user">';
							$output .= $testiname;
						$output .= '</span>';
					}
					
				$output .= '</small>';
					
			$output .= '</div>';

		}
		$output .= '</div>';
		return $output;
	}
	add_shortcode('recenttesti', 'shortcode_recenttesti');

}















?>