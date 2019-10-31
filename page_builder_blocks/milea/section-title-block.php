<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Section_Title_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-section-title-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Section Title', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-blockquote';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_my_custom', [
				'label' => esc_html__( 'Section Title Content', 'distinctivepixels-core' ),
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'centered',
				'label_block' => true,
				'options' => [
					'centered'          	=> esc_html__( 'Centered', 'distinctivepixels-core' ),
					'left'					=> esc_html__( 'Left', 'distinctivepixels-core' ),
				],
			]
		);

		$this->add_control(
			'upper_text', [
				'label'       => __( 'Upper Text', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$this->add_control(
			'title', [
				'label'       => __( 'Title', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$this->add_control(
			'description', [
				'label'       => __( 'Description', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];		
			
		if( 'centered' == $settings['layout'] ) {

			echo '
				<div class="section-heading mb-0 text-center">
		            <h6 class="h4 mb-3">'. $settings['upper_text'] .'</h6>
		            <h2>'. $settings['title'] .'</h2>
		            '. do_shortcode( $settings['description'] ) .'
		        </div>
			';

		} elseif( 'left' == $settings['layout'] ) {

			echo '
				<div class="section-heading plr-xs-0">
				    <span class="line-before">'. $settings['upper_text'] .'</span>
				    <h4 class="section-title">'. $settings['title'] .'</h4>
				   	'. do_shortcode( $settings['description'] ) .'
				</div>
			';

		}

		if ( Plugin::$instance->editor->is_edit_mode() ) { ?>

 	 		<script>
				jQuery(document).ready(function(){

				});
 	 		</script>

		<?php 
		}

	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Section_Title_Block() );