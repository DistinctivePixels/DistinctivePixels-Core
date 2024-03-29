<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Alert_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-alert-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Alert', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-alert';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}
	
	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'layout_section', [
				'label' => __( 'Alert Layout', 'distinctivepixels-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'dismiss', [
				'label'   => __( 'Show Dismiss Button?', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no'  => 'No',
					'yes' => 'Yes'
				],
			]
		);
		
		$this->add_control(
			'style', [
				'label'   => __( 'Colour Style', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'alert-primary',
				'options' => [
					'alert-primary'   => 'Primary',
					'alert-secondary' => 'Secondary',
					'alert-success'   => 'Success',
					'alert-danger'    => 'Danger',
					'alert-warning'   => 'Warning',
					'alert-info'      => 'Info',
					'alert-light'     => 'Light',
					'alert-dark'      => 'Dark',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_my_custom', [
				'label' => esc_html__( 'Alert Content', 'distinctivepixels-core' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => __( 'Content', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		
		if( 'no' == $settings['dismiss'] ){
			
			echo '<div class="alert '. $settings['style'] .'" role="alert">'. $settings['content'] .'</div>';
		} else {
			
			echo '
				<div class="alert '. $settings['style'] .' alert-dismissible fade show" role="alert">
					'. $settings['content'] .'
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
			';
			
		}
		
	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Alert_Block() );