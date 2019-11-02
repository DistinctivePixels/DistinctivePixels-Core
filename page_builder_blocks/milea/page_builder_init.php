<?php 

function distinctivepixels_core_add_elementor_widget_categories( $elements_manager ) {
	
	$elements_manager->add_category(
		'milea-elements',
		array(
			'title' => 'Milea Elements'
		)
	);

}
add_action( 'elementor/elements/categories_registered', 'distinctivepixels_core_add_elementor_widget_categories', 10, 1 );

/**
 * Add option for parallax settings to Sections
 */
add_action('elementor/element/section/section_typo/after_section_end', function( $section, $args ) {
	$section->start_controls_section(
		'section_custom_class',
		[
			'label' => __( 'Parallax', 'distinctivepixels-core' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	$section->add_control(
		'enable_parallax',
		[
			'label'        => __( 'Add Parallax Effect?', 'distinctivepixels-core' ),
			'type'         => Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default' => 'no',
		]
	);

	$section->end_controls_section();

	$section->start_controls_section(
		'section_has_dark_bg',
		[
			'label' => __( 'Has Dark Background?', 'distinctivepixels-core' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	$section->add_control(
		'enable_dark_bg',
		[
			'label'        => __( 'Section Has Dark Background?', 'distinctivepixels-core' ),
			'type'         => Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default' => 'no',
		]
	);

	$section->end_controls_section();
}, 10, 2 );

/**
 * Render if parallax is enabled
 */
add_action( 'elementor/frontend/section/before_render', function( $element ) {
	// Make sure we are in a section element
	if( 'section' !== $element->get_name() ) {
		return;
	}

	$settings = $element->get_settings();

	if( 'yes' == $settings['enable_parallax'] && !empty( $settings['background_video_link'] ) ) {

		$element->add_render_attribute( '_wrapper', 'data-jarallax-video', $settings['background_video_link'] );
		$element->add_render_attribute( '_wrapper', 'data-speed', "0.5");
		$element->add_render_attribute( '_wrapper', 'class', 'jarallax' );	

	} elseif( 'yes' == $settings['enable_parallax'] ) {

		$element->add_render_attribute( '_wrapper', 'data-jarallax' );
		$element->add_render_attribute( '_wrapper', 'data-speed', "0.5");
		$element->add_render_attribute( '_wrapper', 'class', 'jarallax' );	

	}

	if( 'yes' == $settings['enable_dark_bg'] ) {

		$element->add_render_attribute( '_wrapper', 'data-has-dark-bg' );

	}
	
});

/*
 * ElementorCustomElement
 * 
 * Registeres our custom Elementor Elements
 * 
 * @since v1.0.0
 * 
 */
class ElementorCustomElement {

   private static $instance = null;

   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }

   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
   }

   public function widgets_registered() {

      if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){ 

        require_once plugin_dir_path(__FILE__).'accordion-block.php';
        require_once plugin_dir_path(__FILE__).'alert-block.php';
        require_once plugin_dir_path(__FILE__).'blog-feed-block.php';
        require_once plugin_dir_path(__FILE__).'counter-block.php';
        require_once plugin_dir_path(__FILE__).'countdown-block.php';
        require_once plugin_dir_path(__FILE__).'employment-history-list-block.php';
        require_once plugin_dir_path(__FILE__).'fullwidth-parallax-gallery-block.php';
        require_once plugin_dir_path(__FILE__).'history-carousel-block.php';
        require_once plugin_dir_path(__FILE__).'image-gallery-block.php';
        require_once plugin_dir_path(__FILE__).'image-gallery-carousel-block.php';
        require_once plugin_dir_path(__FILE__).'instagram-feed-block.php';
        require_once plugin_dir_path(__FILE__).'map-block.php';
        require_once plugin_dir_path(__FILE__).'parallax-image-block.php';
        require_once plugin_dir_path(__FILE__).'pricing-card-block.php';
        require_once plugin_dir_path(__FILE__).'pricing-table-block.php';
        require_once plugin_dir_path(__FILE__).'process-block.php';
        require_once plugin_dir_path(__FILE__).'progress-circle-block.php';
        require_once plugin_dir_path(__FILE__).'section-title-block.php';
        require_once plugin_dir_path(__FILE__).'service-box-block.php';
        require_once plugin_dir_path(__FILE__).'speaker-list-block.php';
        require_once plugin_dir_path(__FILE__).'team-feed-block.php';
        require_once plugin_dir_path(__FILE__).'testimonial-carousel-block.php';
        require_once plugin_dir_path(__FILE__).'triangle-hero-block.php';
        require_once plugin_dir_path(__FILE__).'twitter-feed-block.php';
        require_once plugin_dir_path(__FILE__).'vertical-tabbed-accordion-block.php';
        require_once plugin_dir_path(__FILE__).'video-player-block.php';

      }
   }
}

ElementorCustomElement::get_instance()->init();


/**
 * Video Lightbox Shortcode
 */
if(!( function_exists('distinctivepixels_video_lightbox_button_shortcode') )) {
	function distinctivepixels_video_lightbox_button_shortcode( $atts ) {
	    $values = shortcode_atts( 
	    	array(
	        	'media_url' 	=> '',
	        	'button_label'	=> 'Watch full video'
	    	), 
    	$atts );
    	
    	$output = '
			<a class="btn btn-hero btn-transparent-white btn-circled" href="'. esc_url( $values['media_url'] ) .'" data-fancybox>'. $values['button_label'] .' <i class="la la-play ml-2"></i></a>
		';
	    
	     
	    return $output;
	 
	}
	add_shortcode( 'distinctivepixels_video_lightbox_button', 'distinctivepixels_video_lightbox_button_shortcode' );
}

/**
 * Login Shortcode
 */
if(!( function_exists('distinctivepixels_login_shortcode') )) {
	function distinctivepixels_login_shortcode( $atts ) {
		$find = array(
			'button button-primary'
		);
		
		$replace = array(
			'btn-block btn btn-circled btn-black'
		);
		
		return str_replace($find, $replace, wp_login_form( array( 'echo' => false ) ));
	}
	add_shortcode( 'distinctivepixel_login', 'distinctivepixels_login_shortcode' );
}