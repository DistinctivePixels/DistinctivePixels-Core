<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Counter_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-counter-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Counter', 'tr-framework' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-icon-box';
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
				'label' => __( 'Counter Content', 'tr-framework' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => [
					'simple'      				=> esc_html__( 'Simple', 'tr-framework' ),
					'large'				=> esc_html__( 'Large', 'tr-framework' ),
				],
			]
		);

		$icons = distinctivepixels_get_icons();
		foreach( $icons as $icon ){
			$available_icons[$icon] = str_replace( 'la-', '', $icon );
		}

		$this->add_control(
			'icon_font', [
				'label'   => esc_html__( 'Icon', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $available_icons,
			]
		);
		
		$this->add_control(
			'icon', [
				'label'      => __( 'Icon Image, Replaces Icon Font', 'tr-framework' ),
				'type'       => Controls_Manager::MEDIA,
				'default' 	 => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'is_svg',
			[
				'label' => __( 'Using and SVG file?', 'tr-framework' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'tr-framework' ),
				'label_off' => __( 'No', 'tr-framework' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'title', [
				'label'       => __( 'Title', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'number', [
				'label'       => __( 'Number to Count to', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];

		if( $settings['is_svg'] == 'yes' ) {
			$inject_svg = 'inject-svg';
		} else {
			$inject_svg = false;
		}
		
		if( 'simple' == $settings['layout'] ){
			
			echo '
				<div>
                    <div class="counter-stat text-center mb-50 mb-sm-0">';

                		if( $settings['icon']['id']) {
				 			echo wp_get_attachment_image( $settings['icon']['id'], 'large', 0, ['class' => $inject_svg . ' counter-icon'] );
				 		} elseif( $settings['icon_font'] ) {
				 			echo '<span class="la '. $settings['icon_font'] .' counter-icon"></span>';
				 		}

                    	echo '
                        <span class="counter">'. $settings['number'] .'</span>
                        <h5 class="mt-2">'. $settings['title'] .'</h5>
                    </div>
                </div>
			';
		
		} elseif( 'large' == $settings['layout'] ){
			
			echo '
				<div>';

					if( $settings['icon']['id']) {
			 			echo wp_get_attachment_image( $settings['icon']['id'], 'large', 0, ['class' => $inject_svg . ' counter-icon'] );
			 		} elseif( $settings['icon_font'] ) {
			 			echo '<span class="la '. $settings['icon_font'] .' counter-icon"></span>';
			 		}

			 		echo '
                    <div class="counter-stat text-center">
                        <span class="hero-1 counter">'. $settings['number'] .'</span>
                        <h5 class="mt-2">'. $settings['title'] .'</h5>
                    </div>
                </div>
			';
		
		}
		
	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Counter_Block() );