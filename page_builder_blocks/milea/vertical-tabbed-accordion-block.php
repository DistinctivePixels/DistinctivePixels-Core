<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Vertical_Tabbed_Accordion_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-vertical-tabbed-accordion-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Vertical Tabbed Accordions', 'distinctivepixels-core' );
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
				'label' => esc_html__( 'Content', 'distinctivepixels-core' ),
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
			'content', [
				'label'       => __( 'Accordion Content', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'tab_title', [
				'label'       => __( 'Tab Title it belongs to?', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
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
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];		
		
		if ( 'standard' == $settings['layout'] ) {
	
			$filter_categories = array();

			foreach( $settings['list'] as $item ) {
				$filter_categories[] = $item['tab_title'];				
			}

			$filters = array_unique(array_filter($filter_categories));

			echo '
                <div class="vertical-tabs col-12" id="tabs-faq">
                    <div class="row">
                        <div class="tab-buttons-wrapper col-lg-3 pt-3">
                            <div class="vertical-tabs-navbar navbar" id="navba">
                            	<div class="navbar-inner">
                                	<ul class="nav nav-tabs" id="tabs-faq-nav">';

		                            	$i = 0;
		                            	foreach( $filters as $filter ) {
		                            		if($i == 0) {
								    			$active = 'active show';
								    		} else {
								    			$active = false;
								    		}
		                            		echo '
		                            			<li class="nav-item" role="presentation"><a class="nav-link h4 font-weight-bold '. '. $active .' .'" href="#tabs-'. sanitize_file_name( strtolower( $filter ) ) .'" data-toggle="tab"><span>'. $filter .'</span></a>
	                            				</li>
		                            		';
		                            		$i++;
										}

                                		echo '
                            		</ul>
                                </div>
                            </div>
                        </div>

		                <div class="tab-content col-lg-8 offset-lg-1">';

                    		$i = 0;
	                    	foreach( $filters as $filter ) {
	                    		
	                			if($i == 0) {
					    			$active = 'active show';
					    		} else {
					    			$active = false;
					    		}

	                			echo '
                					<div class="tab-pane fade '. $active .'" id="tabs-'. sanitize_file_name( strtolower( $filter ) ) .'">
                						<div class="card-group-custom card-group-classic" id="accordion-'.$i.'" role="tablist" aria-multiselectable="false">';

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
		                                                <div class="accordion-header" id="accordion-heading-'.$i.'-collapse-'.$x.'" role="tab">
		                                                    <h5 class="mb-0 card-title">
		                                                        <a class="card-link" role="button" data-toggle="collapse" href="#accordion-'.$i.'-collapse-'.$x.'" aria-controls="accordion-'.$i.'-collapse-'.$x.'" aria-expanded="'.$expanded.'">'. $item['accordion_title'] .'
		                                                        <span class="card-arrow"><i class="la la-arrow-down"></i></span></a>
		                                                    </h5>
		                                                </div>
		                                                <div class="collapse '.$show.'" id="accordion-'.$i.'-collapse-'.$x.'" role="tabpanel" aria-labelledby="accordion-'.$i.'-collapse-'.$x.'" data-parent="#accordion-'.$i.'">
		                                                    <div class="pt-3">
		                                                        '. $item['content'] .'
		                                                    </div>
		                                                </div>
		                                            </article>
			                                		';
		                                		}

		                                		$x++;

		                                	}                                    

	                                    	echo '
			                        	</div>
			                        </div>
		                        ';

	                    		$i++;
	                    	}

                    		echo '
                    	</div>
                    </div>
                </div>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Vertical_Tabbed_Accordion_Block() );