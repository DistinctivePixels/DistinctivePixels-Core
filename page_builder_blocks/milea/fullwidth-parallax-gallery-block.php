<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Fullwidth_Parallax_Gallery_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-fullwidth-parallax-gallery-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Fullwidth Parallax Gallery', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-carousel';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'carousel_items_section', [
				'label' => __( 'Gallery Content', 'distinctivepixels-core' )
			]
		); 

		$this->add_control(
			'background_image', [
				'label'      => __( 'Background Image', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'gallery_images', [
				'label'      => __( 'Gallery Images', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::GALLERY,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'description', [
				'label'       => __( 'Description', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->add_control(
			'button_label', [
				'label'       => __( 'Button Label', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();

		$ranomizer = rand(10,10000);

		echo '
			<section class="o-hidden bg-feature jarallax text-white" data-jarallax data-speed="0.2" data-has-dark-bg>
               '. wp_get_attachment_image( $settings['background_image']['id'], 'full', 0, array( 'class' => 'jarallax-img' ) ) .'
                <div class="overlay-darker"></div>
                <div class="container align-self-center extra-padding section-padding">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 text-center">
                            <div class="text-white">
                                '. $settings['description'] .'
                                <div data-aos="fade-up" data-aos-delay="500">';

                                	if( $settings['button_label'] ) {

                                		$image = wp_get_attachment_image_src( $settings['background_image']['id'], 'full' );

                                		echo '<a class="btn btn-hero btn-white btn-circled mt-3" href="'. $image[0] .'" data-fancybox="gallery-'. $ranomizer .'">'. $settings['button_label'] .'</a>';

                                	}
                                    
                                    echo '
                                    <div class="d-none">';

                                    	foreach ( $settings['gallery_images'] as $image ) {
											echo '<a href="' . $image['url'] . '" data-fancybox="gallery-'. $ranomizer .'"></a>';
										}

                                    	echo '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </section>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Fullwidth_Parallax_Gallery_Block() );