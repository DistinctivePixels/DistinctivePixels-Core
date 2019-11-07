<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Maps_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-maps-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Map', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-google-maps';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_my_custom', [
				'label' => esc_html__( 'Map Details', 'distinctivepixels-core' ),
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'basic',
				'label_block' => true,
				'options' => [
					'basic'          	=> esc_html__( 'Basic', 'distinctivepixels-core' ),
					'basic-tall'		=> esc_html__( 'Basic Tall', 'distinctivepixels-core' ),
				],
			]
		);

		$this->add_control(
			'lat', [
				'label'       => __( 'Latitude (eg 40.713750)', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '40.713750',
				'label_block' => true
			]
		);

		$this->add_control(
			'long', [
				'label'       => __( 'Logitude (eg -74.007590)', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '-74.007590',
				'label_block' => true
			]
		);


		$this->add_control(
			'style_code', [
				'label'       => __( 'Map Colour Code - Available from <a href="https://snazzymaps.com/" target="_blank">here</a>', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'marker_image', [
				'label' => __( 'Choose Image', 'distinctivepixels-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => get_template_directory_uri() .'/assets/img/pin.png',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];	
		
		if( 'basic' == $settings['layout'] ) {

			echo '
				<div class="map-js h-50 rounded" data-map-style=\''. $settings['style_code'] .'\' data-map-latitude="'. $settings['lat'] .'" data-map-longitude="'. $settings['long'] .'" data-marker-image="'. $settings['marker_image']['url'] .'"></div> 
	    	';
			
		} elseif( 'basic-tall' == $settings['layout'] ) {

			echo '
				<div class="map-js h-80" data-map-style=\''. $settings['style_code'] .'\' data-map-latitude="'. $settings['lat'] .'" data-map-longitude="'. $settings['long'] .'" data-marker-image="'. $settings['marker_image']['url'] .'"></div> 
	    	';
			
		}

		if ( Plugin::$instance->editor->is_edit_mode() ) { ?>

 	 		<script>
				jQuery(document).ready(function(){
					initTemplateJS();
				});
 	 		</script>

		<?php 
		}
 
	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Maps_Block() );