<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Speaker_List_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-speaker-list-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Speaker List', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-call-to-action';
	}
	
	public function get_categories() {
		return [ 'uptime-elements' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_layout', [
				'label' => esc_html__( 'Layout', 'distinctivepixels-core' ),
			]
		);
		
		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'label_block' => true,
				'options' => [
					'standard'          	=> esc_html__( 'Standard', 'distinctivepixels-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'processes_content', [
				'label' => __( 'Content', 'distinctivepixels-core' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image', [
				'label'      => __( 'Speaker Image', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::MEDIA,
				'default' 	 => '',
			]
		);

		$repeater->add_control(
			'speaker_name', [
				'label'       => __( 'Speaker Name', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'speaker_role', [
				'label'       => __( 'Speaker Role', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'speaker_description', [
				'label'       => __( 'Description', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Speaker Items', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'title_field' => __( 'Speaker Item', 'distinctivepixels-core' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];
		$animation               = ( $user_selected_animation ) ? false : 'data-aos="fade-left"';
		$i 						 = 1;
		
		if( 'standard' == $settings['layout'] ) {

			echo '<div class="list-group">';
			
			foreach( $settings['list'] as $item ){
				echo '
					<div class="blog-block-small box-shadow box-shadow-hover mb-30 d-flex rounded">
                        <div class="row">
                            <div class="col-sm-4 pr-0">
                            	'. wp_get_attachment_image( $item['image']['id'], 'full', 0, array( 'class' => 'img-fluid' ) ) .'
                            </div>
                            <div class="col py-2 align-self-center">
                                <div>
                                    <h6 class="author-name mb-0 font-weight-bold"><span class="mr-3">'. $item['speaker_role'] .'</span></h6>
                                    <h5 class="h4 my-2 mb-0 d-inline-block">'. $item['speaker_name'] .'</h5>
                                    '. $item['speaker_description'] .'
                                </div>
                            </div>
                        </div>
                    </div>
				';
				$i++;
			}
			
			echo '</div>';
			
		} 
			
	}
}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Speaker_List_Block() );