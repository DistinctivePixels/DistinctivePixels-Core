<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Twitter_Feed_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-twitter-feed-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Twitter Feed', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-number-field';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_my_custom', [
				'label' => esc_html__( 'Content', 'distinctivepixels-core' ),
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'single-carousel',
				'label_block' => true,
				'options' => [
					'single-carousel'				=> esc_html__( 'Single Carousel', 'distinctivepixels-core' ),
					'card-carousel'          		=> esc_html__( 'Card Carousel', 'distinctivepixels-core' ),
					'grid'   						=> esc_html__( 'Grid', 'distinctivepixels-core' ),
				],
			]
		);

		$this->add_control(
			'user_id', [
				'label'       => __( 'Username', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'number_of_items', [
				'label'       => __( 'Number of items', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '6',
				'label_block' => true
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();

		echo '
			<div id="twitter-feed-js" class="row" data-twitter-feed-style="'. $settings['layout'] .'" data-twitter-username="'. $settings['user_id'] .'" data-twitter-number-of-items="'. $settings['number_of_items'] .'"></div>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Twitter_Feed_Block() );