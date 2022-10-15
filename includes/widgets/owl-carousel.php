<?php

namespace Owl_Carousel_Elementor\Widgets;

defined( 'ABSPATH' ) || exit;

use Exception;
use Owl_Carousel_Elementor;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/**
 * Owl Carousel for Elementor widget
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Owl_Carousel extends \Elementor\Widget_Base {
	/**
	 * Control Settings field prefix
	 *
	 * @since 1.0.0
	 */
	const FIELD_PREFIX = 'carousel_';
	
	/**
	 * Owl_Carousel constructor.
	 *
	 * @param array $data
	 * @param null  $args
	 *
	 * @throws Exception
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
		
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );
	}
	
	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'owl-carousel-elementor';
	}
	
	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_title() {
		return __( 'Rdatos Owl Carousel', 'rdatos-owl-carousel-elementor' );
	}
	
	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_icon() {
		return 'eicon-slides';
	}
	
	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_categories() {
		return [ 'general' ];
	}
	
	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_keywords() {
		return [ 'owl carousel', 'carousel', 'slider', 'slideshow', 'rdatos' ];
	}
	
	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since  1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_script_depends() {
		wp_register_script( 'owce-carousel', OWCE_PLUGIN_ASSETS . '/js/owl.carousel.min.js', [ 'jquery' ], '2.3.4', true );
		wp_register_script( 'owce-custom', OWCE_PLUGIN_ASSETS . '/js/custom.js', [
			'jquery',
			'owce-carousel',
			'elementor-frontend'
		], OWCE_VERSION, true );
		
		wp_enqueue_script( 'owce-editor', OWCE_PLUGIN_ASSETS . '/js/editor.js', [
			'jquery',
			'elementor-editor'
		], OWCE_VERSION, true );
		
		return [
			'owce-carousel',
			'owce-custom',
			'owce-editor'
		];
	}
	
	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since  1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		wp_enqueue_script( 'owce-editor', OWCE_PLUGIN_ASSETS . '/js/editor.js', [
			'jquery',
			'elementor-editor'
		], OWCE_VERSION, true );
	}
	
	/**
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @return array Widget styles dependencies.
	 * @since  1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_style_depends() {
		wp_register_style( 'owce-carousel', OWCE_PLUGIN_ASSETS . '/css/owl.carousel.min.css', null, '2.3.4' );
		wp_register_style( 'owce-custom', OWCE_PLUGIN_ASSETS . '/css/custom.css', null, OWCE_VERSION );
		wp_register_style( 'animate', OWCE_PLUGIN_ASSETS . '/css/animate.min.css', null, '3.7.0' );
		
		return [
			'owce-carousel',
			'animate',
			'owce-custom',
			'elementor-icons-fa-solid'
		];
	}
	
	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		
		$field_prefix = self::FIELD_PREFIX;
		
		$this->start_controls_section(
			$field_prefix . 'content',
			[
				'label' => __( 'Post Items', 'rdatos-owl-carousel-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);
		
		owce_select_control( $this, 'layout', 'Layout', [
			'options' => get_carousel_layouts(),
			'default' => 'rdatos',
			'classes' => 'js_carousel_layout',
			/*'selector' => 'no-refresh'*/
		] );
		
		owce_select_control( $this, 'layout_rdatos', 'Style', [
			'options'   => get_carousel_layout_styles( 'rdatos' ),
			'default'   => 'one',
			'condition' => [
				$field_prefix . 'layout' => [ 'rdatos' ]
			]
		] );

		owce_select_control( $this, 'layout_order_by', 'Order by', [
			'options'   => [
				'none' 			=> __( 'None', 'rdatos-owl-carousel-elementor' ),
				'date' 			=> __( 'Date', 'rdatos-owl-carousel-elementor' ),
				'name' 			=> __( 'Name', 'rdatos-owl-carousel-elementor' ),
				'author' 		=> __( 'Author', 'rdatos-owl-carousel-elementor' ),
				'title' 		=> __( 'Title', 'rdatos-owl-carousel-elementor' ),
				'modified' 		=> __( 'modified', 'rdatos-owl-carousel-elementor' ),
				'ID' 			=> __( 'ID', 'rdatos-owl-carousel-elementor' ),
				'comment_count' => __( 'comment_count', 'rdatos-owl-carousel-elementor' )
			],
			'default'   => 'date',
		] );

		owce_select_control( $this, 'layout_order', 'Order', [
			'options'   => [
				'ASC' 			=> __( 'ASC', 'rdatos-owl-carousel-elementor' ),
				'DESC' 			=> __( 'DESC', 'rdatos-owl-carousel-elementor' )
			],
			'default'   => 'ASC'			
		] );

		$postCategories = get_categories(array(
			"orderby" 		=> 'id',
			"order" 		=> 'ASC'
		));

		if( ! empty( $postCategories ) ){
			$categories = array();
			$categories['0'] = __( "Todas", 'rdatos-owl-carousel-elementor' );
			foreach ( $postCategories as $cat ){		
				$categories[strval($cat->cat_ID)] = __( $cat->cat_name, 'rdatos-owl-carousel-elementor' );
			}

			owce_select_control( $this, 'layout_categories', 'Categories', [
				'options'   => $categories,
				'default'        => '0',
			]);
		}
		
		$this->start_controls_tab(
			$field_prefix . 'items_options',
			[
				'label' => __( 'Options', 'rdatos-owl-carousel-elementor' ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => $field_prefix . 'thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'owl_elementor_thumbnail'
			]
		);
		
		owce_number_control( $this, 'items_count', 'Number of Items', [
			'responsive'     => true,
			'default'        => 3,
			'tablet_default' => 2,
			'mobile_default' => 1,
			'min'            => 1,
			'max'            => 6,
			'step'           => 1,
			'description'    => 'The number of items visible on the screen at a time'
		] );

		owce_number_control( $this, 'items_load', 'Number of Post to Load', [
			'responsive'     => true,
			'default'        => 4,
			'tablet_default' => 10,
			'mobile_default' => 10,
			'min'            => 4,
			'max'            => 30,
			'step'           => 1,
			'description'    => 'The number of post to load'
		] );
		
		$this->add_control(
			$field_prefix . 'animate_in',
			[
				'label'       => esc_html__( 'Entry Animation', 'rdatos-owl-carousel-elementor' ),
				'description' => esc_html__( 'Animate works only with 1 item.', 'rdatos-owl-carousel-elementor' ),
				'type'        => 'animation',
				'label_block' => true
			]
		);
		
		$this->add_control(
			$field_prefix . 'animate_out',
			[
				'label'       => esc_html__( 'Exit Animation', 'rdatos-owl-carousel-elementor' ),
				'description' => esc_html__( 'Animate works only with 1 item.', 'rdatos-owl-carousel-elementor' ),
				'type'        => 'exit_animation',
				'label_block' => true
			]
		);
		
		owce_switcher_control( $this, 'autoplay', 'Autoplay', [
			'default'   => false
		]);
		
		owce_number_control( $this, 'autoplay_timeout', 'Autoplay timeout', [
			'default'   => 5000,
			'step'      => 50,
			'condition' => [ $field_prefix . 'autoplay' => 'yes', ]
		] );
		
		owce_switcher_control( $this, 'autoplay_hover_pause', 'Autoplay pause on hover', [
			'default'   => false,
			'condition' => [ $field_prefix . 'autoplay' => 'yes' ]
		] );
		
		owce_number_control( $this, 'smart_speed', 'Slide speed', [
			'default'     => 500,
			'step'        => 50,
			'description' => 'Duration of change of per slide'
		] );
		
		owce_switcher_control( $this, 'rewind', 'Rewind', [
			'description' => 'Go backwards when the boundary is reached.',
			'default'     => '',
			'condition'   => [ $field_prefix . 'enable_loop!' => 'yes' ]
		] );
		
		owce_switcher_control( $this, 'enable_loop', 'Loop', [
			'description'    => 'Infinity loop. Duplicate last and first items to get loop illusion.',
			'responsive'     => true,
			'default'        => true,
			'tablet_default' => '',
			'mobile_default' => '',
			'condition'      => [ $field_prefix . 'rewind!' => 'yes' ]
		] );
		
		owce_switcher_control( $this, 'show_nav', 'Show next/prev', [
			'responsive'     => true,
			'default'        => true,
			'tablet_default' => '',
			'mobile_default' => ''
		] );
		
		owce_switcher_control( $this, 'show_dots', 'Show dots', [ 
			'default'   => false,
			'responsive' => true
		] );

		owce_switcher_control( $this, 'item_center', 'Show Items in Center', [ 
			'default'   => false,
			'responsive' => true
		] );
		
		owce_switcher_control( $this, 'mouse_drag', 'Mouse drag' );
		
		owce_switcher_control( $this, 'touch_drag', 'Touch drag' );
		
		owce_switcher_control( $this, 'lazyLoad', 'LazyLoad', [ 'default' => '' ] );
		
		owce_switcher_control( $this, 'auto_height', 'Auto height', [
			'default'     => '',
			'description' => 'Works only with 1 item on screen. Calculate all visible items and change height according to heighest item.',
			'condition'   => [ $field_prefix . 'items_count' => 1 ]
		] );
		
		$this->end_controls_tab(); 
		
		$this->end_controls_section();
		
		owce_common_controls_section( $this, 'items_single', 'Items', '.item', [
			'align'                   => true,
			'tag'                     => false,
			'color'                   => false,
			'border'                  => true,
			'border_default'          => [
				'border' => [
					'default' => 'solid',
				],
				'width'  => [
					'default' => [
						'top'      => '1',
						'right'    => '1',
						'bottom'   => '1',
						'left'     => '1',
						'isLinked' => true,
					],
				],
				'color'  => [
					'default' => '#EDEDED',
				],
			],
			'box_shadow'         	  => true,
			'border_radius'           => true,
			'typography'              => false,
			'hide'                    => false,
			'margin'                  => false,
			'padding'                 => true,
			'gap'                     => 'right',
			'background'              => true,
			'background_type'         => [ 'classic' ],
			'background_exclude'      => [ 'image' ],
			'hover_animation'         => true,
			'hover_animation_default' => 'float'
		] );
		
		owce_common_controls_section( $this, 'title', 'Title', '.owl-title', [
			'default_tag' => 'h3'			
		] );
		
		owce_common_controls_section( $this, 'subtitle', 'Sub Title', '.owl-subtitle', [
			'default_tag' => 'h5'
		] );
		
		owce_common_controls_section( $this, 'image', 'Image', '.owl-thumb img', [
			'image'            => true,
			'tag'              => false,
			'color'            => false,
			'padding'          => true,
			'border'           => true,
			'border_radius'    => true,
			'typography'       => false,
			'size'             => true,
			'show_hide_button' => [ $field_prefix . 'layout' => 'rdatos' ]
		] );
		
		owce_common_controls_section( $this, 'navigation', 'Navigation', '.owl-nav i', [
			'tag'                => false,
			'background'         => true,
			'background_type'    => [ 'classic' ],
			'background_exclude' => [ 'image' ],
			'typography'         => true,
			'hide'               => false,
			'condition'          => [
				$field_prefix . 'show_nav' => 'yes',
			]
		] );
		
		owce_common_controls_section( $this, 'dots', 'Dots', '.owl-dot span', [
			'tag'                => false,
			'color'              => false,
			'background'         => true,
			'size'               => true,
			'background_type'    => [ 'classic' ],
			'background_exclude' => [ 'image' ],
			'typography'         => false,
			'hide'               => false,
			'condition'          => [
				$field_prefix . 'show_dots' => 'yes',
			]
		] );
	}
	
	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings     = $this->get_settings_for_display();
		$field_prefix = self::FIELD_PREFIX;
				
		$layout          	= $this->get_owl_settings( 'layout' );
		$layout_style    	= $this->get_owl_settings( 'layout_' . $layout ) ?? 'one';
		$show_nav        	= $this->get_owl_settings( 'show_nav' );
		$show_nav_tablet 	= $this->get_owl_settings( 'show_nav_tablet' );
		$show_nav_mobile 	= $this->get_owl_settings( 'show_nav_mobile' );
		
		$item_hover_animation_class = '';
		$item_hover_animation       = $this->get_owl_settings( 'items_single_hover_animation' );
		
		if ( ! empty( $item_hover_animation ) ) {
			$item_hover_animation_class = 'elementor-animation-' . $item_hover_animation;
		}
		
		$settings_js = [
			'field_prefix'       => $field_prefix,
			'layout'             => $layout,
			'center'       		 => $this->get_owl_settings( 'item_center' ),
			'items_count'        => $this->get_owl_settings( 'items_count' ),
			'items_count_tablet' => $this->get_owl_settings( 'items_count_tablet' ),
			'items_count_mobile' => $this->get_owl_settings( 'items_count_mobile' ),
			
			'margin'        => $this->get_owl_settings( 'items_single_gap' )['size'],
			'margin_tablet' => ! empty( $this->get_owl_settings( 'items_single_gap_tablet' ) ) ? $this->get_owl_settings( 'items_single_gap_tablet' )['size'] : 0,
			'margin_mobile' => ! empty( $this->get_owl_settings( 'items_single_gap_mobile' ) ) ? $this->get_owl_settings( 'items_single_gap_mobile' )['size'] : 0,
			
			'nav'        => $show_nav,
			'nav_tablet' => $show_nav_tablet,
			'nav_mobile' => $show_nav_mobile,
			
			'dots'        => $this->get_owl_settings( 'show_dots' ),
			'dots_tablet' => $this->get_owl_settings( 'show_dots_tablet' ),
			'dots_mobile' => $this->get_owl_settings( 'show_dots_mobile' ),
			
			'autoplay'             => $this->get_owl_settings( 'autoplay' ),
			'autoplay_timeout'     => $this->get_owl_settings( 'autoplay_timeout' ),
			'autoplay_hover_pause' => $this->get_owl_settings( 'autoplay_hover_pause' ),
			
			'animate_in'  => $this->get_owl_settings( 'animate_in' ),
			'animate_out' => $this->get_owl_settings( 'animate_out' ),
			
			'rewind'      => $this->get_owl_settings( 'rewind' ),
			'loop'        => $this->get_owl_settings( 'enable_loop' ),
			'loop_tablet' => $this->get_owl_settings( 'enable_loop_tablet' ),
			'loop_mobile' => $this->get_owl_settings( 'enable_loop_mobile' ),
			
			'smart_speed' => $this->get_owl_settings( 'smart_speed' ),
			'lazyLoad'    => $this->get_owl_settings( 'lazyLoad' ),
			'auto_height' => $this->get_owl_settings( 'auto_height' ),
			
			'mouse_drag' => $this->get_owl_settings( 'mouse_drag' ),
			'touch_drag' => $this->get_owl_settings( 'touch_drag' ),
		];
		
		$this->add_render_attribute(
			'carousel-options',
			[
				'id'           => 'owce-carousel-' . $this->get_id(),
				'class'        => 'owl-carousel owl-theme js-owce-carousel owce-carousel owce-carousel-' . $layout . ' owce-carousel-' . $layout . '-' . $layout_style,
				'data-options' => [ wp_json_encode( $settings_js ) ]
			]
		);

		$category         	= $this->get_owl_settings( 'layout_categories' );

		$argsPost = array(
			'numberposts'	=> $this->get_owl_settings( 'items_load' ),
			'category'		=> $category == '0' ? '' : $category,
			"orderby" 		=> $this->get_owl_settings( 'layout_order_by' ),
			"order" 		=> $this->get_owl_settings( 'layout_order' )
		);
		
		$posts = get_posts( $argsPost );
		
		$postLoad = array();
		$index = 0;
		if( !empty( $posts ) ){		
			foreach ( $posts as $p ){
				$cat = get_the_category( $p->ID );
				if( has_post_thumbnail($p->ID) ) {
					$image = [ 'id' => get_post_thumbnail_id($p->ID)];
				} else {
					$image = [ 'url' => \Elementor\Utils::get_placeholder_image_src()];

				}

				$postLoad[$index]= array(
					'item_title'   => __( $p->post_title, 'rdatos-owl-carousel-elementor' ),
					'item_subtitle' => __( date_format(date_create($p->post_date),"d/m/Y"), 'rdatos-owl-carousel-elementor' ),
					'item_image' => __( $image, 'rdatos-owl-carousel-elementor' ),
					'item_category_id' => __( $cat[0]->cat_ID, 'rdatos-owl-carousel-elementor' ),
					'item_category_name' => __( $cat[0]->cat_name, 'rdatos-owl-carousel-elementor' ),
					'item_category_link' => __( get_category_link( $cat[0]->cat_ID ), 'rdatos-owl-carousel-elementor' ),
					'item_link' => __( get_permalink( $p->ID ), 'rdatos-owl-carousel-elementor' ));
				$index +=1;
			}
		} else {
			$postLoad = [
				[
					'item_title'   => __( 'Item 1', 'rdatos-owl-carousel-elementor' ),
					'item_subtitle' => __( 'Lorem ipsum dolor', 'rdatos-owl-carousel-elementor' ),
					'item_image' => __( [ 'url' => \Elementor\Utils::get_placeholder_image_src()], 'rdatos-owl-carousel-elementor' ),
					'item_category_id'=> __( '1', 'rdatos-owl-carousel-elementor' ),
					'item_category_name'=> __( 'WithOut Category', 'rdatos-owl-carousel-elementor' ),
					'item_category_link'=> __( get_site_url(), 'rdatos-owl-carousel-elementor' ),
					'item_link' => __( get_site_url(), 'rdatos-owl-carousel-elementor' )
				]
			];
		}

		$settings['items_list'] = $postLoad;
		
		$css_classes = $show_nav != 'yes' ? 'owce-carousel-no-nav' : '';
		$css_classes .= $show_nav_tablet != 'yes' ? ' owce-carousel-no-nav-tablet' : '';
		$css_classes .= $show_nav_mobile != 'yes' ? ' owce-carousel-no-nav-mobile' : '';
		
		echo "<div class='js-owce-carousel-container owce-carousel-container " . esc_attr( $css_classes ) . "'>";
		echo "<div " . $this->get_render_attribute_string( 'carousel-options' ) . ">";
		require OWCE_PLUGIN_PATH . '/includes/widgets/views/' . $layout . '/' . $layout_style . '.php';
		echo "</div></div>";
	}
	
	/**
	 * Get Settings.
	 *
	 * @param string $key required. The key of the requested setting.
	 *
	 * @return string A single value.
	 * @since  1.0.0
	 * @access private
	 *
	 */
	private function get_owl_settings( $key ) {
		return $this->get_settings( self::FIELD_PREFIX . $key );
	}
}
