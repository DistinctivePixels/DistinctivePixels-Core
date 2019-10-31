<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Employment_History_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'tommusrhodus-employment-history-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Employment History', 'tr-framework' );
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
				'label' => esc_html__( 'Layout', 'tr-framework' ),
			]
		);
		
		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'label_block' => true,
				'options' => [
					'standard'          	=> esc_html__( 'Standard', 'tr-framework' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'processes_content', [
				'label' => __( 'Content', 'tr-framework' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_title', [
				'label'       => __( 'Title', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);
		
		$repeater->add_control(
			'item_subtitle', [
				'label'       => __( 'Subtitle', 'tr-framework' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'item_description', [
				'label'       => __( 'Description', 'tr-framework' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'item_year', [
				'label'       => __( 'Year', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Processes Items', 'tr-framework' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'title_field' => __( 'Processes Item', 'tr-framework' ),
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
					<a href="#" class="list-group-item list-group-item-action flex-column align-items-start card bordered mb-3">
                        <div class="d-flex w-100 justify-content-between mb-2">
                            <div class="pl-0 col">
                                <h5 class="h4 mb-1">'. $item['item_title'] .'</h5>
                                <small>'. $item['item_subtitle'] .'</small>
                            </div>
                            <small class="font-weight-bold">'. $item['item_year'] .'</small>
                        </div>
                        <div class="mb-1">'. $item['item_description'] .'</div>
                    </a>
				';
				$i++;
			}
			
			echo '</div>';
			
		} 
			
	}
}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Employment_History_Block() );