<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Image_Gallery_Carousel_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-image-gallery-carousel-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Image Gallery Carousel', 'tr-framework' );
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
				'label' => __( 'Gallery Content', 'tr-framework' )
			]
		); 

		$this->add_control(
			'layout', [
				'label'   => __( 'Gallery Layout', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'tall-carousel',
				'label_block' => true,
				'options' => [
					'tall-carousel'						=> esc_html__( 'Tall Carousel', 'tr-framework' ),
					'fullwidth-carousel'				=> esc_html__( 'Fullwidth Carousel', 'tr-framework' ),
					'fullwidth-lightbox-carousel'		=> esc_html__( 'Fullwidth Lightbox Carousel', 'tr-framework' ),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image', [
				'label'      => __( 'Gallery Image', 'tr-framework' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'description', [
				'label'       => __( 'Description', 'tr-framework' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'button_label', [
				'label'       => __( 'Button Label', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'button_link', [
				'label' => __( 'Button URL', 'tr-framework' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '#', 'tr-framework' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$repeater->add_control(
			'item_link_target', [
				'label'   => __( 'Link Behaviour', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '_self',
				'label_block' => true,
				'options' => [
					'_self'			=> esc_html__( 'Open in Current Window', 'tr-framework' ),
					'_blank'		=> esc_html__( 'Open in New Window', 'tr-framework' ),
				],
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Gallery Content', 'tr-framework' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
				'title_field' => __( 'Carousel Content', 'tr-framework' ),
			]
		);		

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();

		if( 'tall-carousel' == $settings['layout'] ) {

			echo '
				<div class="row d-block">
                    <div class="slick-carousel" data-slick=\'{ "slidesToShow": 4, "slidesToScroll": 1, "autoplay" : true, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 1200, "settings": { "slidesToShow": 3 } }, { "breakpoint": 1024, "settings": { "slidesToShow": 2 } }, { "breakpoint": 767, "settings": { "slidesToShow": 1, "arrows": false } }]}\'>';

			        	foreach( $settings['list'] as $item ) {

			        		$image = wp_get_attachment_image_src( $item['image']['id'], 'full' );

							echo '
								<div class="plr-0">
	                                <div class="has-static-overlay has-hover-overlay h-100" data-background-image-src="'. $image[0] .'">
	                                    <div class="static-overlay align-items-end d-flex text-white">
	                                        <div class="d-block pr-lg-5">
	                                            '. $item['description'] .'';

	                                            if( $item['button_label'] ) {
	                                            	echo '<a class="btn btn-hero btn-transparent-white btn-circled mt-3" href="'. esc_url( $item['button_link']['url'] ) .'" target="'. $item['item_link_target'] .'">'. $item['button_label'] .' <i class="ml-2 la la-arrow-right"></i></a>';
	                                            }
	                                            	
	                                            echo '
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

		} elseif( 'fullwidth-carousel' == $settings['layout'] ) {

			echo '
				<div class="plr-30" data-has-dark-bg>
                    <div class="slick-carousel buttons-inside rounded" data-slick=\'{ "variableWidth": true, "slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 767, "settings": { "slidesToShow": 1, "centerMode": true, "arrows": false, "variableWidth": false } }]}\'>';

			        	foreach( $settings['list'] as $item ) {

			        		$image = wp_get_attachment_image_src( $item['image']['id'], 'full' );
			        		$ranomizer = rand(10,10000);

							echo '
								<div class="col">
                                    <div class="rounded">
                                    	'. wp_get_attachment_image( $item['image']['id'], 'full', 0, array( 'class' => 'img-fluid max-h-md' ) ) .'
                                    </div>
                                </div>
							';				

						} 

						echo '
					</div>
				</div>
			';

		} elseif( 'fullwidth-lightbox-carousel' == $settings['layout'] ) {

			echo '
				<div class="plr-30" data-has-dark-bg>
                    <div class="slick-carousel buttons-inside rounded" data-slick=\'{ "variableWidth": true, "slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 767, "settings": { "slidesToShow": 1, "centerMode": true, "arrows": false, "variableWidth": false } }]}\'>';

			        	foreach( $settings['list'] as $item ) {

			        		$image = wp_get_attachment_image_src( $item['image']['id'], 'full' );
			        		$ranomizer = rand(10,10000);

							echo '
								<div class="col">
                                    <div class="rounded">
                                    	'. wp_get_attachment_image( $item['image']['id'], 'full', 0, array( 'class' => 'img-fluid max-h-md' ) ) .'
                                        <a class="cover-link" href="'. $image[0] .'" data-fancybox="gallery-'. $ranomizer .'"></a>
                                    </div>
                                </div>
							';				

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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Image_Gallery_Carousel_Block() );