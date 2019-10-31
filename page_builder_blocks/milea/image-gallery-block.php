<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Image_Gallery_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-image-gallery-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Image Gallery', 'tr-framework' );
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
				'default' => 'image-and-title-card',
				'label_block' => true,
				'options' => [
					'image-and-title-card'						=> esc_html__( 'Image + Title Card', 'tr-framework' ),
					'filterable-image-and-title-card'			=> esc_html__( 'Filterable Image + Title Card', 'tr-framework' ),
					'filterable-image-and-title-card-2-cols'	=> esc_html__( 'Filterable Image + Title Card 2 Columns', 'tr-framework' ),
					'custom-lightbox-grid'						=> esc_html__( 'Custom Lightbox Grid', 'tr-framework' ),
					'custom-lightbox-grid-no-gutter'			=> esc_html__( 'Custom Lightbox Grid, No Gutter', 'tr-framework' ),
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
			'item_link', [
				'label' => __( 'Link Image to URL? (Used in applicable layouts)', 'tr-framework' ),
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

		$repeater->add_control(
			'grid_size', [
				'label'   => __( 'Item Size (Custom Grid Only)', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-4',
				'label_block' => true,
				'options' => [
					'col-md-6'			=> esc_html__( '6/12', 'tr-framework' ),
					'col-md-4'			=> esc_html__( '4/12', 'tr-framework' ),
					'col-md-3'			=> esc_html__( '3/12', 'tr-framework' ),
				],
			]
		);

		$repeater->add_control(
			'item_category', [
				'label'       => __( 'Item Category? (Used for filtering)', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
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

		if( 'image-and-title-card' == $settings['layout'] ) {

			$filter_categories = array();

			foreach( $settings['list'] as $item ) {

				$filter_categories[] = $item['item_category'];				

			}

			$filters = array_unique(array_filter($filter_categories));

			echo '
			<div class="isotope-wrapper mb-5">
                <div class="row" data-isotope=\'{ "itemSelector": ".col-lg-4", "masonry": { "columnWidth": ".grid-sizer" } }\'>';

        	foreach( $settings['list'] as $item ) {

				echo '
					<div class="grid-sizer col-lg-4 col-sm-6 col-md-4 mb-5 '. sanitize_file_name( strtolower( $item['item_category'] ) ) .'">
					    <div class="box-shadow box-shadow-hover rounded">
					        '. wp_get_attachment_image( $item['image']['id'], 'large', 0 ) .'
					        <div class="card"> 
					            '. $item['description'] .'
					        </div>';

					        if( $item['item_link']['url'] ) {	
						    	echo '<a class="cover-link" href="'. esc_url( $item['item_link']['url'] ) .'" target="'. $item['item_link_target'] .'"></a>';
					        }

					        echo '
					    </div>
					</div>
				';			

			}

        		echo '
        		</div>
        	</div>
        	';

		} elseif( 'filterable-image-and-title-card' == $settings['layout'] ) {

			$filter_categories = array();

			foreach( $settings['list'] as $item ) {

				$filter_categories[] = $item['item_category'];				

			}

			$filters = array_unique(array_filter($filter_categories));

			echo '
				<div class="isotope-wrapper mb-5">
	            	<div class="isotope-filter-wrapper text-center mb-5">
	            		<a href="#" class="btn btn-transparent-black mb-15 mb-lg-0 btn-circled" data-filter="*">All</a>';
			          	foreach( $filters as $filter ) {
			          		echo '<a href="#" class="btn btn-white btn-circled mb-15 mb-lg-0 ml-2" data-filter=".'. sanitize_file_name( strtolower( $filter ) ) .'">'. $filter .'</a>';	
						}

					echo '
		        	</div>
		        	<div class="row" data-isotope=\'{ "itemSelector": ".col-lg-4", "masonry": { "columnWidth": ".grid-sizer" } }\'>
	        	';

	        	foreach( $settings['list'] as $item ) {

					echo '
						<div class="grid-sizer col-lg-4 col-sm-6 col-md-4 mb-5 '. sanitize_file_name( strtolower( $item['item_category'] ) ) .'">
						    <div class="box-shadow box-shadow-hover rounded">
						        '. wp_get_attachment_image( $item['image']['id'], 'large', 0 ) .'';

						        if( $item['description'] ) {
							        echo '
							        <div class="card"> 
							            '. $item['description'] .'
							        </div>';
						        }

						        if( $item['item_link']['url'] ) {	
							    	echo '<a class="cover-link" href="'. esc_url( $item['item_link']['url'] ) .'" target="'. $item['item_link_target'] .'"></a>';
						        }

						        echo '
						    </div>
						</div>
					';				

				} 

				echo '
					</div>
				</div>
			';

		} elseif( 'filterable-image-and-title-card-2-cols' == $settings['layout'] ) {

			$filter_categories = array();

			foreach( $settings['list'] as $item ) {

				$filter_categories[] = $item['item_category'];				

			}

			$filters = array_unique(array_filter($filter_categories));

			echo '
				<div class="isotope-wrapper mb-5">
	            	<div class="isotope-filter-wrapper text-center mb-5">
	            		<a href="#" class="btn btn-transparent-black mb-15 mb-lg-0 btn-circled" data-filter="*">All</a>';
			          	foreach( $filters as $filter ) {
			          		echo '<a href="#" class="btn btn-white btn-circled mb-15 mb-lg-0 ml-2" data-filter=".'. sanitize_file_name( strtolower( $filter ) ) .'">'. $filter .'</a>';	
						}

					echo '
		        	</div>
		        	<div class="row" data-isotope=\'{ "itemSelector": ".col-lg-6", "masonry": { "columnWidth": ".grid-sizer" } }\'>
	        	';

	        	foreach( $settings['list'] as $item ) {

					echo '
						<div class="grid-sizer col-lg-6 col-sm-6 col-md-4 mb-5 '. sanitize_file_name( strtolower( $item['item_category'] ) ) .'">
						    <div class="box-shadow box-shadow-hover rounded">
						        '. wp_get_attachment_image( $item['image']['id'], 'full', 0 ) .'';
						        
						        if( $item['description'] ) {
							        echo '
							        <div class="card"> 
							            '. $item['description'] .'
							        </div>';
						        }

						        if( $item['item_link']['url'] ) {	
							    	echo '<a class="cover-link" href="'. esc_url( $item['item_link']['url'] ) .'" target="'. $item['item_link_target'] .'"></a>';
						        }

						        echo '
						    </div>
						</div>
					';				

				} 

				echo '
					</div>
				</div>
			';

		} elseif( 'custom-lightbox-grid' == $settings['layout'] ) {

			$ranomizer = rand(10,10000);

			echo '
				<div class="isotope-wrapper">
					<div class="row" data-isotope=\'{ "itemSelector": ".isotope-item", "masonry": { "columnWidth": ".grid-sizer" } }\'>';

			        	foreach( $settings['list'] as $item ) {

			        		$image = wp_get_attachment_image_src( $item['image']['id'], 'full' );

							echo '
								<div class="isotope-item grid-sizer '. $item['grid_size'] .' mb-30">
	                                <div class="has-hover-overlay">
	                                	'. wp_get_attachment_image( $item['image']['id'], 'full', 0, array( 'class' => 'img-fluid' ) ) .'
	                                    <div class="d-flex hover-overlay-panel">
	                                        <i class="la la-plus text-white align-self-center"></i>
	                                        <a class="cover-link" href="'. $image[0] .'" data-fancybox="gallery-'. $ranomizer .'" data-caption="'. $item['description'] .'"></a>
	                                    </div>
	                                </div>
	                            </div>
							';				

						} 

						echo '
					</div>
				</div>
			';

		} elseif( 'custom-lightbox-grid-no-gutter' == $settings['layout'] ) {

			$ranomizer = rand(10,10000);

			echo '
				<div class="isotope-wrapper">
					<div class="no-gutters" data-isotope=\'{ "itemSelector": ".isotope-item", "masonry": { "columnWidth": ".grid-sizer" } }\'>';

			        	foreach( $settings['list'] as $item ) {

			        		$image = wp_get_attachment_image_src( $item['image']['id'], 'full' );

							echo '
								<div class="isotope-item grid-sizer '. $item['grid_size'] .'">
	                                <div class="has-hover-overlay">
	                                	'. wp_get_attachment_image( $item['image']['id'], 'full', 0, array( 'class' => 'img-fluid' ) ) .'
	                                    <div class="d-flex hover-overlay-panel">
	                                        <i class="la la-plus text-white align-self-center"></i>
	                                        <a class="cover-link" href="'. $image[0] .'" data-fancybox="gallery-'. $ranomizer .'" data-caption="'. $item['description'] .'"></a>
	                                    </div>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Image_Gallery_Block() );