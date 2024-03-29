<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_TommusRhodus_Video_Player_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-video-lightbox-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Video', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-play';
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
				'label'   => __( 'Video Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'inline-local',
				'label_block' => true,
				'options' => [
					'inline-local'          		=> esc_html__( 'Inline Local Video', 'distinctivepixels-core' ),
					'inline-embed-vimeo'         	=> esc_html__( 'Inline Embedded Vimeo Video', 'distinctivepixels-core' ),
					'inline-embed-youtube'         	=> esc_html__( 'Inline Embedded Youtube Video', 'distinctivepixels-core' ),
				],
			]
		);

		$this->add_control(
			'image', [
				'label'      => __( 'Poster Image (Local only)', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'video_url', [
				'label'       => __( 'Youtube/Vimeo Video URL - If using "inline-embed" layout, enter video ID instead', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'mp4_url', [
				'label'       => __( 'Local Video .mp4 URL', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'webm_url', [
				'label'       => __( 'Local Video .webm URL', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$image_url 		 		 = wp_get_attachment_url( $settings['image']['id'] );

		if( 'inline-local' == $settings['layout'] ) {

			echo '
				<div class="rounded">
					<video poster="'. esc_url( $image_url ) .'" class="plyr-js" playsinline controls preload="none">
						<source src="'. esc_url( $settings['mp4_url'] ) .'" type="video/mp4">
						<source src="'. esc_url( $settings['webm_url'] ) .'" type="video/webm">
					</video>
				</div>
			';	

		} elseif( 'inline-embed-vimeo' == $settings['layout'] ) {

			echo '
				<div class="rounded">
              		<div class="plyr-js" data-plyr-provider="vimeo" data-plyr-embed-id="'. $settings['video_url'] .'"></div>
            	</div>
			';	

		} elseif( 'inline-embed-youtube' == $settings['layout'] ) {

			echo '
				<div class="rounded">
              		<div class="plyr-js" data-plyr-provider="youtube" data-plyr-embed-id="'. $settings['video_url'] .'"></div>
            	</div>	
			';	

		}
			
	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_TommusRhodus_Video_Player_Block() );