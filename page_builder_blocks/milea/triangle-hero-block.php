<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Triangle_Hero_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-triangle-hero-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Dual Triangle Backgroud Hero', 'distinctivepixels-core' );
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
			'image_2', [
				'label'      => __( 'Image Two', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'content', [
				'label'       => __( 'Content', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'scroll_link', [
				'label'       => __( 'Scroll Mouse Link', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '#start',
				'label_block' => true
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		
		echo '
            <section class="h-100">
                <div class="tri-bg-one jarallax" data-jarallax data-speed="0.2">
                	'. wp_get_attachment_image( $settings['image']['id'], 'full', 0, array( 'class' => 'jarallax-img' ) ) .'
                </div>
                <div class="tri-bg-two jarallax" data-jarallax data-speed="0.2">
                    '. wp_get_attachment_image( $settings['image_2']['id'], 'full', 0, array( 'class' => 'jarallax-img' ) ) .'
                </div>
                <div class="d-flex h-100">
                    <div class="container align-self-center">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="text-center text-white">
                                    '. $settings['content'] .'
                                    <span class="scroll-btn">
                                        <a href="' . $settings['scroll_link'] . '" class="smooth-scroll"><span class="mouse"><span></span></span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>            
                </div>
            </section>
		';
		
	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Triangle_Hero_Block() );