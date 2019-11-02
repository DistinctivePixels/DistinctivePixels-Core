<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Progress_Circle_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-progress-circle-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Progress Circle', 'distinctivepixels-core' );
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
				'label' => __( 'Content', 'distinctivepixels-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$icons = distinctivepixels_get_icons();
		foreach( $icons as $icon ){
			$available_icons[$icon] = str_replace( 'la-', '', $icon );
		}

		$this->add_control(
			'perecentage', [
				'label'       => __( 'Percentage', 'distinctivepixels-core' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 90,
			]
		);

		$this->add_control(
			'title', [
				'label'       => __( 'Percentage', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];
			
		echo '
			<div class="text-center">
                <div class="radial-progress mx-auto mb-4" data-value=\''. $settings['perecentage'] .'\'>
                    <span class="progress-left">
                        <span class="progress-bar" style="border-color: ' . $settings['color'] . ';"></span>
                    </span>
                    <span class="progress-right">
                        <span class="progress-bar" style="border-color: ' . $settings['color'] . ';""></span>
                    </span>
                    <div class="progress-value rounded-circle d-flex align-items-center justify-content-center">
                        <div><span class="h3 font-weight-bold counter-slow">'. $settings['perecentage'] .'</span><sup class="small">%</sup></div>
                    </div>
                </div>
                <h4>'. $settings['title'] .'</h4>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Progress_Circle_Block() );