<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Testimonial_Carousel_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'tommusrhodus-testimonial-carousel-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Testimonial Carousel', 'tr-framework' );
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
				'label' => esc_html__( 'Testimonial Carousel Layout', 'tr-framework' ),
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Layout', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'single-carousel',
				'label_block' => true,
				'options' => [
					'single-carousel'          	=> esc_html__( 'Single Carousel', 'tr-framework' ),
					'card-carousel'          	=> esc_html__( 'Card Carousel', 'tr-framework' ),
					'card-single-carousel'		=> esc_html__( 'Card Single Carousel', 'tr-framework' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_items_section', [
				'label' => __( 'Slider Slides', 'tr-framework' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image', [
				'label'      => __( 'Slide Image', 'tr-framework' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'content', [
				'label'       => __( 'Testimonial Content', 'tr-framework' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'author', [
				'label'       => __( 'Author', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'role', [
				'label'       => __( 'Role', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Slide Content', 'tr-framework' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
				'title_field' => __( 'Slide Content', 'tr-framework' ),
			]
		);		

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];		
		
		if ( 'single-carousel' == $settings['layout'] ) {

			echo '
				 <div class="d-block">
                    <div>
                        <div class="slick-carousel" data-slick=\'{ "slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 1024, "settings": { "slidesToShow": 1, , "arrows": true, "dots": false } }, { "breakpoint": 767, "settings": { "slidesToShow": 1, "arrows": false, "dots": true } }]}\'>';

							foreach( $settings['list'] as $item ){

								echo '
									<div class="plr-15">
	                                    <div class="blog-block">
	                                        <div class="px-5 testimonial-content text-center">                                        
	                                            <div class="row mb-3">
	                                                <div class="col-12 mb-5 align-self-center">
	                                                	'. wp_get_attachment_image( $item['image']['id'], 'thumbnail', 0, array( 'class' => 'avatar avatar-lg d-inline img-fluid' ) ) .'
	                                                </div>
	                                                <p><i class="icofont icofont-quote-left"></i>'. do_shortcode( $item['content'] ) .'<i class="icofont icofont-quote-right"></i></p>
	                                                <div class="col-12 mt-3 align-self-center">
	                                                    <h6 class="h5 mb-0 font-weight-bold"><span>'. $item['author'] .'	</span></h6> <span>- '. $item['role'] .'</span>
	                                                </div>                                            
	                                            </div>                                        
	                                        </div>
	                                    </div>
	                                </div>
								';

							}

							echo '
						</div>
					</div>
				</div>
			';
		
		} elseif ( 'card-carousel' == $settings['layout'] ) {

			echo '
				 <div class="d-block">
                    <div class="slick-carousel" data-slick=\'{ "slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "arrows": true, "dots": true, "responsive": [{ "breakpoint": 1024, "settings": { "slidesToShow": 2 } }, { "breakpoint": 767, "settings": { "slidesToShow": 1, "arrows": false, "dots": true } }]}\'>';

						foreach( $settings['list'] as $item ){

							echo '
								<div class="plr-15 mb-5">
	                                <div class="blog-block box-shadow box-shadow-hover rounded mb-30 mb-xl-0">
	                                    <div class="card testimonial-content">   
	                                        <p><i class="icofont icofont-quote-left"></i>'. do_shortcode( $item['content'] ) .'<i class="icofont icofont-quote-right"></i></p>
	                                        <div class="row mb-15">
	                                            <div class="col-auto pr-0 align-self-center">
	                                            	'. wp_get_attachment_image( $item['image']['id'], 'thumbnail', 0, array( 'class' => 'avatar avatar-sm d-inline img-fluid' ) ) .'
	                                            </div>
	                                            <div class="col-auto align-self-center">
	                                                <h6 class="author-name mb-0 font-weight-bold"><span class="mr-3">'. $item['role'] .'</span></h6>
	                                                by <span class="h6 author-name font-weight-bold">'. $item['author'] .'</span>
	                                            </div>                                            
	                                        </div>	                                        
	                                    </div>
	                                </div>
	                            </div>
							';

						}

						echo '
					</div>
				</div>
			';
		
		} elseif ( 'card-single-carousel' == $settings['layout'] ) {

			echo '
				<div class="carousel slide testimonials-carousel box-shadow" id="testimonials-carousel">
				    <div class="carousel-inner indicators-outside">
				    	<ol class="carousel-indicators">';

				    	$i = 0;
				    	foreach( $settings['list'] as $item ) {
				    		if($i == 0) {
				    			$active = 'active';
				    		} else {
				    			$active = false;
				    		}
				    		echo '<li data-target="#testimonials-carousel" data-slide-to="'. $i .'" class="'. $active .'"></li>';
				    		$i++;
				    	}

				    	echo '
				    	</ol>';

				    	$i = 0;
				    	foreach( $settings['list'] as $item ) { 
				    		if($i == 0) {
				    			$active = 'active';
				    		} else {
				    			$active = false;
				    		}
				    		echo '
						        <div class="carousel-item '. $active .'">
						            <div class="row">
						                <div class="col-lg-12 col-sm-12">
						                    <div class="d-flex testimonial-content bordered rounded">
						                        <div class="card">
						                            <p><i class="icofont icofont-quote-left"></i>'. do_shortcode( $item['content'] ) .'<i class="icofont icofont-quote-right"></i></p>  
						                            <div class="row">
						                                <div class="col-auto pr-0 align-self-center">
						                                	'. wp_get_attachment_image( $item['image']['id'], 'thumbnail', 0, array( 'class' => 'avatar d-inline img-fluid' ) ) .'
						                                </div>
						                                <div class="col-auto align-self-center">
						                                    <h5 class="mb-0 font-weight-bold">'. $item['author'] .'</h5>
						                                    <small>'. $item['role'] .'</small> 
						                                </div>                                            
						                            </div>
						                        </div>
						                    </div>
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

				});
 	 		</script>

		<?php 
		}

	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Testimonial_Carousel_Block() );