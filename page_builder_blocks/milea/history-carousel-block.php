<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_History_Carousel_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-history-carousel-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'History Carousel', 'distinctivepixels-core' );
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
				'label' => esc_html__( 'Testimonial Carousel Layout', 'distinctivepixels-core' ),
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
					'no-intro'          	=> esc_html__( 'No Intro Text', 'distinctivepixels-core' ),
				],
			]
		);

		$this->add_control(
			'intro_content', [
				'label'       => __( 'Intro Text', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_items_section', [
				'label' => __( 'Slider Slides', 'distinctivepixels-core' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image', [
				'label'      => __( 'Slide Image', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'content', [
				'label'       => __( 'Content', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'tab_title', [
				'label'       => __( 'Tab title', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Slide Content', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
				'title_field' => __( 'Slide Content', 'distinctivepixels-core' ),
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
                <div class="container pb-5">
                    <div class="row">
                        <div class="col-12 col-lg-4 text-center text-lg-left mb-5 mb-lg-0">
                            '. $settings['intro_content'] .'
                        </div>
                        <div class="col-12 col-lg-7 offset-lg-1 align-self-center">
                            <ul class="nav nav-tabs show-1st-tab tabs-style-1 line-active" role="tablist">';

                            	$i = 0;
                            	foreach( $filters as $filter ) {
                            		if($i == 0) {
						    			$active = 'active';
						    		} else {
						    			$active = false;
						    		}
                            		echo '
                            			<li class="nav-item">
                            				<a class="nav-link '. $active .'" href="#tab-'. sanitize_file_name( strtolower( $filter ) ) .'" role="tab" data-toggle="tab">'. $filter .'</a>
                            			</li>
                            		';
                            		$i++;
								}

                                echo '
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container-fluid plr-30">
                    <div class="tab-content">';

                    	$i = 0;
                    	foreach( $filters as $filter ) {
                    		
                			if($i == 0) {
				    			$active = 'active show';
				    		} else {
				    			$active = false;
				    		}

                			echo '
		                        <div role="tabpanel" class="tab-pane fade '. $active .'" id="tab-'. sanitize_file_name( strtolower( $filter ) ) .'">
		                            <div class="row d-block">
		                                <div class="slick-carousel fw-auto-highlight buttons-inside slick-even-sm" data-slick=\'{ "variableWidth": true, "slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 767, "settings": { "slidesToShow": 1, "variableWidth": false, "arrows": false, "dots": true } }]}\'>';

		                                	foreach( $settings['list'] as $item ) {

		                                		if( $item['tab_title'] == $filter ) {
			                                		echo '
			                                		<div class="col carousel-card d-flex pr-0 pr-sm-5">
				                                        <div class="rounded d-inline-block">
				                                        	'. wp_get_attachment_image( $item['image']['id'], 'large', 0, array( 'class' => 'img-fluid max-h-md' ) ) .'
				                                        </div>
				                                        <div class="card bg-white d-inline-block align-self-center">
				                                            '. $item['content'] .'
				                                        </div>
				                                    </div>
			                                		';
		                                		}

		                                	}                                    

		                                    echo '
		                                </div>
		                            </div>
		                        </div>
	                        ';

                    		$i++;
                    	}

                    	echo '
                    </div>
                </div>
			';

		} elseif ( 'no-intro' == $settings['layout'] ) {
	

			$filter_categories = array();

			foreach( $settings['list'] as $item ) {
				$filter_categories[] = $item['tab_title'];				
			}

			$filters = array_unique(array_filter($filter_categories));

			echo '
                <div class="container pb-5">
                    <div class="row">
                    	<div class="col-md-8 offset-md-2 align-self-center">
                            <ul class="nav nav-tabs show-1st-tab tabs-style-1 line-active tabs-center" role="tablist">';

                            	$i = 0;
                            	foreach( $filters as $filter ) {
                            		if($i == 0) {
						    			$active = 'active';
						    		} else {
						    			$active = false;
						    		}
                            		echo '
                            			<li class="nav-item">
                            				<a class="nav-link '. $active .'" href="#tab-'. sanitize_file_name( strtolower( $filter ) ) .'" role="tab" data-toggle="tab">'. $filter .'</a>
                            			</li>
                            		';
                            		$i++;
								}

								echo '
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container-fluid plr-30">
                    <div class="tab-content">';

                    	$i = 0;
                    	foreach( $filters as $filter ) {
                    		
                			if($i == 0) {
				    			$active = 'active show';
				    		} else {
				    			$active = false;
				    		}

                			echo '
		                        <div role="tabpanel" class="tab-pane fade '. $active .'" id="tab-'. sanitize_file_name( strtolower( $filter ) ) .'">
		                            <div class="row d-block">
		                                <div class="slick-carousel fw-auto-highlight buttons-inside slick-even-sm" data-slick=\'{ "variableWidth": true, "slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 767, "settings": { "slidesToShow": 1, "variableWidth": false, "arrows": false, "dots": true } }]}\'>';

		                                	foreach( $settings['list'] as $item ) {

		                                		if( $item['tab_title'] == $filter ) {
			                                		echo '
			                                		<div class="col carousel-card d-flex pr-0 pr-sm-5">
				                                        <div class="rounded d-inline-block">
				                                        	'. wp_get_attachment_image( $item['image']['id'], 'large', 0, array( 'class' => 'img-fluid max-h-md' ) ) .'
				                                        </div>
				                                        <div class="card bg-white d-inline-block align-self-center">
				                                            '. $item['content'] .'
				                                        </div>
				                                    </div>
			                                		';
		                                		}

		                                	}                                    

		                                    echo '
		                                </div>
		                            </div>
		                        </div>
	                        ';

                    		$i++;
                    	}

                    	echo '
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_History_Carousel_Block() );