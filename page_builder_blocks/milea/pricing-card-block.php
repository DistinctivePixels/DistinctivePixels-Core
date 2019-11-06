<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_DistinctivePixels_Pricing_Card_Block extends Widget_Base {
	
	//Return Class Name
	public function get_name() {
		return 'distinctivepixels-pricing-card-block';
	}
	
	//Return Block Title (for blocks list)
	public function get_title() {
		return esc_html__( 'Pricing Card', 'distinctivepixels-core' );
	}
	
	//Return Block Icon (for blocks list)
	public function get_icon() {
		return 'eicon-product-price';
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
			'section_my_custom', [
				'label' => esc_html__( 'Content', 'distinctivepixels-core' ),
			]
		);

		$this->add_control(
			'layout', [
				'label'   => __( 'Style', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'card-and-feature-list',
				'label_block' => true,
				'options' => [
					'card-and-feature-list'				=> esc_html__( 'Card & Feature List', 'distinctivepixels-core' ),
					'card-and-feature-list-dark'		=> esc_html__( 'Card & Feature List, Dark Background', 'distinctivepixels-core' ),
					'card'								=> esc_html__( 'Card', 'distinctivepixels-core' ),
					'card-dark'							=> esc_html__( 'Card, Dark Background', 'distinctivepixels-core' ),
				],
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
			'title', [
				'label'       => __( 'Title', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true
			]
		);

		$this->add_control(
			'content', [
				'label'       => __( 'Content', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => ''
			]
		);

		$this->add_control(
			'link_text', [
				'label'       => __( 'Link Label', 'distinctivepixels-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Choose this plan',
				'label_block' => true
			]
		);
		
		$this->add_control(
			'url', [
				'label'         => esc_html__( 'Link URL', 'distinctivepixels-core' ),
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

		$this->start_controls_section(
			'pricing_table_items_section', [
				'label' => __( 'Pricing Features', 'distinctivepixels-core' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_title', [
				'label'       => __( 'Feature Text', 'distinctivepixels-core' ),
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
				'label'   => __( 'Pricing Features', 'distinctivepixels-core' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
				'title_field' => __( 'Pricing Feature', 'distinctivepixels-core' ),
			]
		);	

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings                = $this->get_settings_for_display();
		$target   = $settings['url']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['url']['nofollow']    ? ' rel="nofollow"'  : '';
		$link     = 'href="'. esc_url( $settings['url']['url'] ) .'"' . $target . $nofollow;
		$user_selected_animation = (bool) $settings['_animation'];

		if( 'card-and-feature-list' == $settings['layout'] ) {

			echo '
				<div>
				    <div class="card d-block pricing-block basic-pricing bg-white box-shadow rounded box-shadow-hover">
				        <div class="row">
				            <div class="col-sm-6 align-self-center">
				                <div class="price-header">
				                    <span class="price h1"><small>'. $settings['currency'] .'</small>'. $settings['price'] .'</span>
				                    <h5 class="mb-15">'. $settings['title'] .'</h5>
				                    '. $settings['content'] .'
				                    <a '. $link .' class="mt-4 d-block arrow-link color-primary">'. $settings['link_text'] .'<i class="la la-arrow-right ml-2"></i></a>
				                </div>  
				            </div>
				            <div class="col-sm-6 align-self-center">                       
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
				            </div>
				        </div> 
				    </div>
				</div>
        	';

		} elseif( 'card-and-feature-list-dark' == $settings['layout'] ) {

			echo '
				<div>
				    <div class="card d-block pricing-block basic-pricing bg-feature text-white box-shadow rounded box-shadow-hover">
				        <div class="row">
				            <div class="col-sm-6 align-self-center">
				                <div class="price-header">
				                    <span class="price h1"><small>'. $settings['currency'] .'</small>'. $settings['price'] .'</span>
				                    <h5 class="mb-15">'. $settings['title'] .'</h5>
				                    '. $settings['content'] .'
				                    <a '. $link .' class="mt-4 d-block arrow-link color-primary">'. $settings['link_text'] .'<i class="la la-arrow-right ml-2"></i></a>
				                </div>  
				            </div>
				            <div class="col-sm-6 align-self-center">                       
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
				            </div>
				        </div> 
				    </div>
				</div>
        	';

		} elseif( 'card' == $settings['layout'] ) {

			echo '
				<div class="d-flex">
                    <div class="card flex pricing-block basic-pricing box-shadow rounded flex-grow-1 justify-content-around box-shadow-hover">
                        <div class="row">
                            <div class="col-sm-12 align-self-center">
                                <div class="price-header">
                                    <span class="price h1"><small>'. $settings['currency'] .'</small>'. $settings['price'] .'</span>
                                    <h5 class="mb-15">'. $settings['title'] .'</h5>
                                    '. $settings['content'] .'
                                    <a '. $link .' class="mt-4 d-block arrow-link color-primary">'. $settings['link_text'] .'<i class="la la-arrow-right ml-2"></i></a>
                                </div>  
                            </div>
                        </div> 
                    </div>
                </div>
        	';

		} elseif( 'card-dark' == $settings['layout'] ) {

			echo '
				<div class="d-flex h-100-pc">
                    <div class="card flex pricing-block basic-pricing box-shadow rounded bg-feature text-white flex-grow-1 justify-content-around box-shadow-hover">
                        <div class="row">
                            <div class="col-sm-12 align-self-center">
                                <div class="price-header">
                                    <span class="price h1"><small>'. $settings['currency'] .'</small>'. $settings['price'] .'</span>
                                    <h5 class="mb-15">'. $settings['title'] .'</h5>
                                    '. $settings['content'] .'
                                    <a '. $link .' class="mt-4 d-block arrow-link color-primary">'. $settings['link_text'] .'<i class="la la-arrow-right ml-2"></i></a>
                                </div>  
                            </div>
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
Plugin::instance()->widgets_manager->register_widget_type( new Widget_DistinctivePixels_Pricing_Card_Block() );