<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Service_Box_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-service-box-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Service Box', 'tr-framework' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-icon-box';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}
	
	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'layout_section', [
				'label' => __( 'Icon Styling', 'tr-framework' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'layout', [
				'label'   => __( 'Service Box Layout', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'card-icon-bg',
				'options' => [
					'card-icon-bg'      				=> esc_html__( 'Card with Background Icon', 'tr-framework' ),
					'card-icon-bg-icon-top'				=> esc_html__( 'Card with Background Icon & Icon Top', 'tr-framework' ),
					'card-centered-icon-and-link'      	=> esc_html__( 'Card with Centered Icon & Link', 'tr-framework' ),
					'icon-left-text-right'      		=> esc_html__( 'Icon Left & Text Right', 'tr-framework' ),
				],
			]
		);

		$icons = distinctivepixels_get_icons();
		foreach( $icons as $icon ){
			$available_icons[$icon] = str_replace( 'la-', '', $icon );
		}

		$this->add_control(
			'icon_font', [
				'label'   => esc_html__( 'Icon', 'tr-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'card',
				'options' => $available_icons,
			]
		);
		
		$this->add_control(
			'icon', [
				'label'      => __( 'Icon Image, Replaces Icon Font', 'tr-framework' ),
				'type'       => Controls_Manager::MEDIA,
				'default' 	 => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'is_svg',
			[
				'label' => __( 'Using and SVG file?', 'tr-framework' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'tr-framework' ),
				'label_off' => __( 'No', 'tr-framework' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content', [
				'label' => esc_html__( 'Icon & Text Content', 'tr-framework' ),
			]
		);

		$this->add_control(
			'title', [
				'label'       => __( 'Title', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => __( 'Content', 'tr-framework' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->add_control(
			'link_label', [
				'label'       => __( 'Link Label', 'tr-framework' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'link', [
				'label' => __( 'Link', 'tr-framework' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => '',
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$user_selected_animation = (bool) $settings['_animation'];

		if( $settings['is_svg'] == 'yes' ) {
			$inject_svg = 'inject-svg';
		} else {
			$inject_svg = false;
		}
		
		if( !$user_selected_animation ){
			echo '<div data-aos="fade-up" data-aos-delay="100">';
		}
		
		if( 'card-icon-bg' == $settings['layout'] ){
			
			echo '
		 	<div class="service-box text-center box-shadow box-shadow-hover o-hidden">';

		 		if( $settings['icon']['id']) {
		 			echo wp_get_attachment_image( $settings['icon']['id'], 'large', 0, ['class' => $inject_svg . ' icon-primary img-fluid service-bg-icon'] );
		 		} else {
		 			echo '<span class="la '. $settings['icon_font'] .' icon-primary img-fluid service-bg-icon"></span>';
		 		}

			 	echo'
                <div class="service-inner">
                	<h4 class="mb-30 font-weight-bold">'. $settings['title'] .'</h4>
                    '. $settings['content'] .'
                </div>
        	</div>
			';
		
		} elseif( 'card-icon-bg-icon-top' == $settings['layout'] ){
			
			echo '
			<div>
				<div class="service-box text-left box-shadow box-shadow-hover o-hidden">';

					if( $settings['icon']['id']) {
		 			echo wp_get_attachment_image( $settings['icon']['id'], 'large', 0, ['class' => $inject_svg . ' icon-primary img-fluid service-bg-icon'] );
			 		} else {
			 			echo '<span class="la '. $settings['icon_font'] .' icon-primary img-fluid service-bg-icon"></span>';
			 		}

			 		echo '
				    <div class="service-inner">';

					    if( $settings['icon']['id']) {
			 			echo wp_get_attachment_image( $settings['icon']['id'], 'large', 0, ['class' => $inject_svg . ' icon-primary img-fluid mb-20 service-icon'] );
				 		} else {
				 			echo '<span class="la '. $settings['icon_font'] .' icon-primary img-fluid mb-20 service-icon"></span>';
				 		}

				    	echo '
				        <h5 class="font-weight-bold mb-3">'. $settings['title'] .'</h5>
				        '. $settings['content'] .'
				    </div>
				</div>
			</div>
			';
		
		} elseif( 'card-centered-icon-and-link' == $settings['layout'] ){
			
			echo '
			<div class="service-box box-shadow box-shadow-hover">
                <div>';

                	if( $settings['icon']['id']) {
			 			echo wp_get_attachment_image( $settings['icon']['id'], 'large', 0, ['class' => $inject_svg . ' icon-primary img-fluid service-icon'] );
			 		} else {
			 			echo '<span class="la '. $settings['icon_font'] .' icon-primary img-fluid service-icon"></span>';
			 		}

                	echo '
                </div>
                <div class="service-inner">
                	<h5 class="font-weight-bold">'. $settings['title'] .'</h5>
                    '. $settings['content'] .'
                    <a class="mt-4 d-block arrow-link" href="'. esc_url( $settings['link']['url'] ) .'">'. $settings['link_label'] .' <i class="la la-arrow-right ml-2"></i></a>
                </div>
            </div>
			';
		
		} elseif( 'icon-left-text-right' == $settings['layout'] ){
			
			echo '
			<div class="service-icon-left mb-30">';

				if( $settings['icon']['id']) {
		 			echo wp_get_attachment_image( $settings['icon']['id'], 'large', 0, ['class' => $inject_svg . ' service-icon-left-icon la la-compass la-4x mb-3 mb-sm-0'] );
		 		} else {
		 			echo '<span class="la '. $settings['icon_font'] .' service-icon-left-icon la-4x mb-3 mb-sm-0"></span>';
		 		}

				echo '                           
                <div class="service-icon-left-content">
                    <h5 class="font-weight-bold mb-3">'. $settings['title'] .'</h5>
                    '. $settings['content'] .'
                </div>
            </div>
			';
		
		}
		
		if( !$user_selected_animation ){
			echo '</div>';
		}
		
	}

}

// Register our new widget
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Service_Box_Block() );