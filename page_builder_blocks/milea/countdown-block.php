<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Countdown_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-countdown-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Countdown', 'distinctivepixels-core' );
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
				'label' => __( 'Countdown Content', 'distinctivepixels-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simple',
				'options' => [
					'simple'      		=> esc_html__( 'Simple', 'distinctivepixels-core' ),
					'bold'				=> esc_html__( 'Bold', 'distinctivepixels-core' ),
				],
			]
		);


		$this->add_control(
			'date', [
				'label'   => esc_html__( 'Set a Data & Time', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '',
			]
		);

		$this->add_control(
			'days_label', [
				'label'       => __( 'Days Lable', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Days',
				'label_block' => false
			]
		);

		$this->add_control(
			'hours_label', [
				'label'       => __( 'Hours Lable', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Hours',
				'label_block' => false
			]
		);

		$this->add_control(
			'mins_label', [
				'label'       => __( 'Minutes Lable', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Minutes',
				'label_block' => false
			]
		);

		$this->add_control(
			'secs_label', [
				'label'       => __( 'Seconds Lable', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Seconds',
				'label_block' => false
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
				<ul class="d-flex justify-content-left list-inline countdown-timer" data-coutdown-date="'. $settings['date'] .'" data-aos="fade-in" data-aos-delay="750">
                    <li class="list-inline mr-5"><span class="hero-1 mb-3 strong days">00</span><h6 class="days_text mt-3">'. $settings['days_label'] .'</h6></li>
                    <li class="list-inline mr-5"><span class="hero-1 mb-3 strong hours">00</span><h6 class="hours_text mt-3">'. $settings['hours_label'] .'</h6></li>
                    <li class="list-inline mr-5"><span class="hero-1 mb-3 strong minutes">00</span><h6 class="minutes_text mt-3">'. $settings['mins_label'] .'</h6></li>
                    <li class="list-inline"><span class="hero-1 mb-3 strong seconds">00</span><h6 class="seconds_text mt-3">'. $settings['secs_label'] .'</h6></li>
                </ul>
			';
		
		} elseif( 'bold' == $settings['layout'] ){
			
			echo '
				<ul class="d-flex justify-content-around list-inline countdown-timer text-center mb-5" data-coutdown-date="'. $settings['date'] .'" data-aos="fade-in" data-aos-delay="750">
                    <li class="list-inline"><span class="hero-1 mb-3 font-weight-bold days">00</span><h5 class="days_text">'. $settings['days_label'] .'</h5></li>
                    <li class="list-inline"><span class="hero-1 mb-3 font-weight-bold hours">00</span><h5 class="hours_text">'. $settings['hours_label'] .'</h5></li>
                    <li class="list-inline"><span class="hero-1 mb-3 font-weight-bold minutes">00</span><h5 class="minutes_text">'. $settings['mins_label'] .'</h5></li>
                    <li class="list-inline"><span class="hero-1 mb-3 font-weight-bold seconds">00</span><h5 class="seconds_text">'. $settings['secs_label'] .'</h5></li>
                </ul>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Countdown_Block() );