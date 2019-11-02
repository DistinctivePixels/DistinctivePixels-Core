<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Accordion_Block extends Widget_Base {

	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-accordion-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Accordion', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-accordion';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'carousel_items_section', [
				'label' => __( 'Accordion', 'distinctivepixels-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Panel Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'label_block' => true,
				'options' => [
					'standard'          	=> esc_html__( 'Standard', 'distinctivepixels-core' ),
					'alternative'          	=> esc_html__( 'Alternative', 'distinctivepixels-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_items_section', [
				'label' => __( 'Accordions', 'distinctivepixels-core' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'accordion_title', [
				'label'       => __( 'Accordion Title', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'accordion_content', [
				'label'       => __( 'Accordion Content', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Accordion Content', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
				'title_field' => __( 'Accordion Content', 'distinctivepixels-core' ),
			]
		);		

		$this->end_controls_section();

	}

	protected function render() {
	
		$settings   = $this->get_settings_for_display();
		$title      = $settings['accordion_title'];
		$attr_title = sanitize_title_with_dashes( $title );
		
		$user_selected_animation = (bool) $settings['_animation'];

		if( 'standard' == $settings['layout'] ) {

			$i = rand(0,100000);

			echo '<div class="card-group-custom card-group-classic" id="accordion-'.$i.'" role="tablist" aria-multiselectable="false">';

				$x = 0;
	    		foreach( $settings['list'] as $item ) {

	        		if( $item['tab_title'] == $filter ) {

	        			if($x == 0) {
			    			$show 		= 'show';
			    			$expanded 	= 'true';
			    		} else {
			    			$show 		= false;
			    			$expanded 	= 'false';
			    		}
	            		
	            		echo '
	            		<article class="card mb-4 box-shadow-hover rounded box-shadow">
	                        <div class="accordion-header" id="accordion-'.$i.'-heading-'.$x.'" role="tab">
	                            <h5 class="mb-0 card-title">
	                                <a class="card-link" role="button" data-toggle="collapse" href="#accordion-'.$i.'-collapse-'.$x.'" aria-controls="accordion-'.$i.'-collapse-'.$x.'" aria-expanded="'.$expanded.'">'. $item['accordion_title'] .'
	                                <span class="card-arrow"><i class="la la-arrow-down"></i></span></a>
	                            </h5>
	                        </div>
	                        <div class="collapse '.$show.'" id="accordion-'.$i.'-collapse-'.$x.'" role="tabpanel" aria-labelledby="accordion-'.$i.'-collapse-'.$x.'" data-parent="#accordion-'.$i.'">
	                            <div class="pt-3">
	                                '. do_shortcode( $item['accordion_content'] ) .'
	                            </div>
	                        </div>
	                    </article>
	            		';
	        		}

	        		$x++;

	        	}  

			echo '</div>';

		} elseif( 'alternative' == $settings['layout'] ) {

			$i = rand(0,100000);

			echo '<div id="accordion-'. $i .'">';

				$x = 0;
				foreach( $settings['list'] as $item ) {

					if( $item['tab_title'] == $filter ) {

						if($x == 0) {
							$show 		= 'show';
							$expanded 	= 'true';
						} else {
							$show 		= false;
							$expanded 	= 'false';
						}
						
						echo '
						<div class="mb-3 box-shadow-hover rounded box-shadow">
							<div class="card accordion-header" id="heading-'. $x .'">
								<a href="#" data-toggle="collapse" data-target="#collapse-'. $x .'" aria-expanded="'.$expanded.'" aria-controls="collapse-'. $x .'">
									<h5 class="mb-0">'. $item['accordion_title'] .'</h5>                                  
								</a>                                  
							</div>

							<div id="collapse-'. $x .'" class="collapse '.$show.'" aria-labelledby="heading'. sanitize_file_name( $attr_title ) .'" data-parent="#accordion-'. $i .'">
								<div class="card">
									'. do_shortcode( $item['accordion_content'] ) .'
								</div>
							</div>
						</div>
						';
					}

					$x++;

				}  

			echo '
			</div>';
		} 

	}
	
}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Accordion_Block() );