<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Instagram_Feed_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'tommusrhodus-instagram-feed-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Instagram Feed', 'tr-framework' );
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
				'label' => esc_html__( 'Content', 'tr-framework' ),
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple',
				'label_block' => true,
				'options' => [
					'grid'   					=> esc_html__( 'Grid', 'tr-framework' ),
					'carousel'          		=> esc_html__( 'Carousel', 'tr-framework' ),
					'fullwidth-carousel'   		=> esc_html__( 'Fullwidth Carousel', 'tr-framework' ),
				],
			]
		);

		$this->add_control(
			'user_id', [
				'label'       => __( 'User ID', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'access_token', [
				'label'       => __( 'Access Token', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'number_of_items', [
				'label'       => __( 'Number of items', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '6',
				'label_block' => true
			]
		);

		$this->add_control(
			'number_of_slides', [
				'label'       => __( 'Number slides to show on Carousel?', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '4',
				'label_block' => true
			]
		);

		$this->add_control(
			'show_arrows', [
				'label'   => __( 'Show Arrows on Carousel?', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'yes',
				'label_block' => true,
				'options' => [
					'data-instagram-show-arrows'		=> esc_html__( 'Show Arrows', 'tr-framework' ),
					'no-data-instagram-show-arrows'		=> esc_html__( 'No Arrows', 'tr-framework' ),
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();

		if( 'grid' == $settings['layout'] ) {

			echo '
				<div class="instagram-feed" data-instagram-username="'. $settings['user_id'] .'" data-instagram-number-of-items="'. $settings['number_of_items'] .'" data-instagram-access-token="'. $settings['access_token'] .'">
				     <div class="instagram-feed-gallery row"></div>
				</div>
			';

		} elseif( 'carousel' == $settings['layout'] ) {

			echo '
				<div class="instagram-feed-carousel" data-instagram-username="'. $settings['user_id'] .'" data-instagram-number-of-items="'. $settings['number_of_items'] .'" data-instagram-slides-to-show="'. $settings['number_of_slides'] .'" '. $settings['show_arrows'] .' data-instagram-access-token="'. $settings['access_token'] .'">
                     <div class="instagram-feed-gallery">
                     </div>
                </div>
			';

		} elseif( 'fullwidth-carousel' == $settings['layout'] ) {

			echo '
				<div class="instagram-feed-carousel" data-instagram-username="'. $settings['user_id'] .'" data-instagram-number-of-items="'. $settings['number_of_items'] .'" data-instagram-slides-to-show="'. $settings['number_of_slides'] .'" '. $settings['show_arrows'] .' data-has-dark-bg data-instagram-access-token="'. $settings['access_token'] .'">
				     <div class="instagram-feed-gallery"></div>
				</div>
			';

		}

	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Instagram_Feed_Block() );