<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Process_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'tommusrhodus-process-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Process', 'tr-framework' );
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
				'label' => esc_html__( 'Process Content', 'tr-framework' ),
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Style', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'card',
				'label_block' => true,
				'options' => [
					'card'								=> esc_html__( 'Card', 'tr-framework' ),
					'card-dark'							=> esc_html__( 'Card, Dark Background', 'tr-framework' ),
				],
			]
		);
		

		$this->add_control(
			'upper_text', [
				'label'       => __( 'Upper Text', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$this->add_control(
			'title', [
				'label'       => __( 'Title', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$this->add_control(
			'description', [
				'label'       => __( 'Description', 'tr-framework' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];		
		
		if( 'card' == $settings['layout'] ) {

			echo '
                <div>
                    <div class="card box-shadow-hover rotate-hover rounded bordered">
                        <span>'. $settings['upper_text'] .'</span>
                        <h4 class="font-weight-bold mb-15">'. $settings['title'] .'</h4>
                        '. do_shortcode( $settings['description'] ) .'
                    </div>
                </div>
			';

		} elseif( 'card-dark' == $settings['layout'] ) {

			echo '
                <div>
                    <div class="card box-shadow-hover rotate-hover bg-feature text-white rounded">
                        <span>'. $settings['upper_text'] .'</span>
                        <h4 class="text-white font-weight-bold mb-15">'. $settings['title'] .'</h4>
                        '. do_shortcode( $settings['description'] ) .'
                    </div>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Process_Block() );