<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Parallax_Image_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-parallax-image-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Parallax Image', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-photo-library';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content', [
				'label' => esc_html__( 'Content', 'distinctivepixels-core' ),
			]
		);
		
		$this->add_control(
			'image', [
				'label'      => __( 'Image', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'image-offset', [
				'label'       => __( 'Parallax Offset (eg -80)', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '-80',
				'label_block' => true
			]
		);

		$this->add_control(
			'image-speed', [
				'label'       => __( 'Parallax Speed (eg 0.2)', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '0.2',
				'label_block' => true
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		
		echo '
			<div data-jarallax-element="'. $settings['image-offset'] .'" data-speed="'. $settings['image-speed'] .'">
				'. wp_get_attachment_image( $settings['image']['id'], 'full', 0, array( 'class' => 'img-fluid' ) ) .'
            </div>
		';

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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Parallax_Image_Block() );