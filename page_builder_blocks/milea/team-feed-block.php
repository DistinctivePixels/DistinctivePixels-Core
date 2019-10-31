<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Team_Feed_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-team-feed-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Team Feed', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-carousel';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {

		$social_options    		= array_values( distinctivepixels_get_social_icons() );

		foreach( $social_options as $social_option ){
			$final_social_options[$social_option] = str_replace('la-', '', $social_option);
		}

		$this->start_controls_section(
			'carousel_items_section', [
				'label' => __( 'Content', 'distinctivepixels-core' )
			]
		); 

		$this->add_control(
			'layout', [
				'label'   => __( 'Gallery Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fullwidth-carousel',
				'label_block' => true,
				'options' => [
					'fullwidth-carousel'		=> esc_html__( 'Fullwidth Carousel', 'distinctivepixels-core' ),
					'card-carousel'				=> esc_html__( 'Card Carousel', 'distinctivepixels-core' ),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image', [
				'label'      => __( 'Team Image', 'distinctivepixels-core' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'description', [
				'label'       => __( 'Description', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$repeater->add_control(
			'social_profile_1', [
				'label'   => esc_html__( 'Social Profile Icon 1', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $final_social_options,
			]
		);

		$repeater->add_control(
			'social_profile_url_1', [
				'label' => __( 'Social Profile URL 1', 'distinctivepixels-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '#', 'distinctivepixels-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$repeater->add_control(
			'social_profile_2', [
				'label'   => esc_html__( 'Social Profile Icon 2', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $final_social_options,
			]
		);

		$repeater->add_control(
			'social_profile_url_2', [
				'label' => __( 'Social Profile URL 2', 'distinctivepixels-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '#', 'distinctivepixels-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$repeater->add_control(
			'social_profile_3', [
				'label'   => esc_html__( 'Social Profile Icon 3', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $final_social_options,
			]
		);

		$repeater->add_control(
			'social_profile_url_3', [
				'label' => __( 'Social Profile URL 3', 'distinctivepixels-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '#', 'distinctivepixels-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$repeater->add_control(
			'social_profile_4', [
				'label'   => esc_html__( 'Social Profile Icon 4', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $final_social_options,
			]
		);

		$repeater->add_control(
			'social_profile_url_4', [
				'label' => __( 'Social Profile URL 4', 'distinctivepixels-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '#', 'distinctivepixels-core' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Content', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
				'title_field' => __( 'Content', 'distinctivepixels-core' ),
			]
		);		

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();

		if( 'fullwidth-carousel' == $settings['layout'] ) {

			echo '
				<div class="row d-block">
                    <div class="slick-carousel" data-slick=\'{ "slidesToShow": 4, "slidesToScroll": 1, "autoplay" : true, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 1200, "settings": { "slidesToShow": 3 } }, { "breakpoint": 1024, "settings": { "slidesToShow": 2 } }, { "breakpoint": 767, "settings": { "slidesToShow": 1, "arrows": false } }]}\'>';

			        	foreach( $settings['list'] as $item ) {

			        		$image = wp_get_attachment_image_src( $item['image']['id'], 'full' );

							echo '
								<div class="plr-0">
		                            <div class="has-static-overlay has-hover-overlay h-60" data-background-image-src="'. $image[0] .'">
		                                <div class="static-overlay align-items-end d-flex text-white">
		                                    <div class="d-block pr-lg-5">                                    
		                                        '. $item['description'] .'
		                                        <ul class="list-unstyled list-inline mt-3 social-icons-list">';

		                                        	if( $item['social_profile_1'] ) {
		                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_1'] ) .'"><i class="la '. $item['social_profile_1'] .'"></i></a></li>';
		                                        	}

		                                        	if( $item['social_profile_2'] ) {
		                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_2'] ) .'"><i class="la '. $item['social_profile_2'] .'"></i></a></li>';
		                                        	}

		                                        	if( $item['social_profile_3'] ) {
		                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_3'] ) .'"><i class="la '. $item['social_profile_3'] .'"></i></a></li>';
		                                        	}

		                                        	if( $item['social_profile_4'] ) {
		                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_4'] ) .'"><i class="la '. $item['social_profile_4'] .'"></i></a></li>';
		                                        	}

		                                        	echo '
		                                        </ul>
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

		} elseif( 'card-carousel' == $settings['layout'] ) {

			echo '
				<div class="row d-block">
                    <div class="slick-carousel" data-slick=\'{ "slidesToShow": 3, "slidesToScroll": 1, "autoplay" : true, "infinite": true, "arrows": true, "dots": false, "responsive": [{ "breakpoint": 1200, "settings": { "slidesToShow": 3 } }, { "breakpoint": 1024, "settings": { "slidesToShow": 2 } }, { "breakpoint": 767, "settings": { "slidesToShow": 1, "arrows": false } }]}\'>';

			        	foreach( $settings['list'] as $item ) {

			        		$image = wp_get_attachment_image_src( $item['image']['id'], 'full' );

							echo '
								<div class="col">
	                            	<div class="blog-block box-shadow box-shadow-hover rounded mb-30 mb-xl-0">
		                                <img src="'. $image[0] .'" alt="" class="img-fluid">
		                                <div class="card">                            
		                                    '. $item['description'] .'
		                                    <ul class="list-unstyled list-inline mt-3 social-icons-list">';
		                                        	
		                                    	if( $item['social_profile_1'] ) {
	                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_1'] ) .'"><i class="la '. $item['social_profile_1'] .'"></i></a></li>';
	                                        	}

	                                        	if( $item['social_profile_2'] ) {
	                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_2'] ) .'"><i class="la '. $item['social_profile_2'] .'"></i></a></li>';
	                                        	}

	                                        	if( $item['social_profile_3'] ) {
	                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_3'] ) .'"><i class="la '. $item['social_profile_3'] .'"></i></a></li>';
	                                        	}

	                                        	if( $item['social_profile_4'] ) {
	                                        		echo '<li class="list-inline-item"><a href="'. esc_url( $item['social_profile_url_4'] ) .'"><i class="la '. $item['social_profile_4'] .'"></i></a></li>';
	                                        	}


		                                        echo '
		                                    </ul>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Team_Feed_Block() );