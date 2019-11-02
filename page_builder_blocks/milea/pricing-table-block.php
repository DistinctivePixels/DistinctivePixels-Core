<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Pricing_Table_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-pricing-table-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Pricing Table', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-price-table';
	}
	
	public function get_categories() {
		return [ 'milea-elements' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'layout_section', [
				'label' => __( 'Pricing Table Layout', 'distinctivepixels-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'layout', [
				'label'   => __( 'Pricing Table Layout', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'basic',
				'options' => [
					'basic'				=> esc_html__( 'Basic', 'distinctivepixels-core' ),
					'featured'       	=> esc_html__( 'Featured', 'distinctivepixels-core' ),
					'tilted-left'		=> esc_html__( 'Tilted Left', 'distinctivepixels-core' ),
					'tilted-right'		=> esc_html__( 'Tilted Right', 'distinctivepixels-core' )
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content', [
				'label' => esc_html__( 'Pricing Table Titles', 'distinctivepixels-core' ),
			]
		);
		
		$this->add_control(
			'title', [
				'label'       => __( 'Title', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Unlimited',
				'label_block' => true
			]
		);
		
		$this->add_control(
			'currency', [
				'label'       => __( 'Currency', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$',
				'label_block' => true
			]
		);
		
		$this->add_control(
			'price', [
				'label'       => __( 'Price', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '9',
				'label_block' => true
			]
		);
		
		$this->add_control(
			'small_text', [
				'label'       => __( 'Small Text', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'per user / month',
				'label_block' => true
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'pricing_table_items_section', [
				'label' => __( 'Pricing Table Details', 'distinctivepixels-core' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_title', [
				'label'       => __( 'Detail Text', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Unlimited projects',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'item_style', [
				'label'   => __( 'Add tick next to feature?', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'add_tick',
				'label_block' => true,
				'options' => [
					'add_tick'		=> esc_html__( 'Yes', 'distinctivepixels-core' ),
					'no_tick'		=> esc_html__( 'No thanks', 'distinctivepixels-core' ),
				],
			]
		);

		$this->add_control(
			'list', [
				'label'   => __( 'Pricing Table Details', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
				'title_field' => __( 'Pricing Table Detail', 'distinctivepixels-core' ),
			]
		);		

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_button', [
				'label' => esc_html__( 'Pricing Table Button', 'distinctivepixels-core' ),
			]
		);
		
		$this->add_control(
			'button_text', [
				'label'       => __( 'Button Text', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Sign Up Now',
				'label_block' => true
			]
		);
		
		$this->add_control(
			'url', [
				'label'         => esc_html__( 'Button URL', 'distinctivepixels-core' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default' => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();

		$target   = $settings['url']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['url']['nofollow']    ? ' rel="nofollow"'  : '';
		$link     = 'href="'. esc_url( $settings['url']['url'] ) .'"' . $target . $nofollow;
		
		if( 'basic' == $settings['layout'] ){
			
			echo '		
				<div>
                    <div class="card d-block pricing-block basic-pricing bg-white box-shadow box-shadow-hover rounded">
                        <div class="price-header">
                            <h4 class="h3 mb-3">'. $settings['title'] .'</h4>
                            <span class="price h1"><small>'. $settings['currency'] .'</small>'. $settings['price'] .'</span>
                            <h5>'. $settings['small_text'] .'</h5>
                        </div>
                        <div class="line"></div>
                        <ul class="text-left">';

                        	foreach( $settings['list'] as $item ){
								if( 'add_tick' == $item['item_style'] ) {
									echo '<li><i class="la la-check text-success"></i> '. $item['item_title'] .'</li>';
								} else {
									echo '<li>'. $item['item_title'] .'</li>';
								}
								
							}

							echo '
                        </ul>
                        <a '. $link .' class="btn btn-block btn-hero btn-circled">'. $settings['button_text'] .'</a>
                    </div>
                </div>	
			';
		
		} elseif( 'featured' == $settings['layout'] ){
			
			echo '		
				<div class="z-2">
                    <div class="featured-grow">
	                    <div class="card d-block pricing-block basic-pricing bg-white box-shadow box-shadow-hover rounded">
	                        <div class="price-header">
	                            <h4 class="h3 mb-3">'. $settings['title'] .'</h4>
	                            <span class="price h1"><small>'. $settings['currency'] .'</small>'. $settings['price'] .'</span>
	                            <h5>'. $settings['small_text'] .'</h5>
	                        </div>
	                        <div class="line"></div>
	                        <ul class="text-left">';

	                        	foreach( $settings['list'] as $item ){
									if( 'add_tick' == $item['item_style'] ) {
										echo '<li><i class="la la-check text-success"></i> '. $item['item_title'] .'</li>';
									} else {
										echo '<li>'. $item['item_title'] .'</li>';
									}
									
								}

								echo '
	                        </ul>
	                        <a '. $link .' class="btn btn-block btn-hero btn-circled">'. $settings['button_text'] .'</a>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Pricing_Table_Block() );