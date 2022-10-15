<?php

namespace Owl_Carousel_Elementor\Controls;

defined( 'ABSPATH' ) || exit;

use Elementor\Control_Animation;

/**
 * Elementor exit animation control.
 *
 * A control for creating exit animation. Displays a select box
 * with the available exit animation effects @see Control_Exit_Animation::get_animations() .
 *
 * @since 2.5.0
 */
class Custom_Entry_Animation extends Control_Animation {
	
	/**
	 * Get control type.
	 *
	 * Retrieve the animation control type.
	 *
	 * @return string Control type.
	 * @since  2.5.0
	 * @access public
	 *
	 */
	public function get_type() {
		// same name as elementor default 'animation' used to get select2 styles
		return 'animation';
	}
	
	/**
	 * Get animations.
	 *
	 * Retrieve all the available animations.
	 *
	 * This method is required to refresh the widget when select an option
	 *
	 * @return array Available animations.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	
	protected function get_default_settings() {
		$animations      = self::get_animations();
		$flat_animations = array_merge( array_keys( $animations ), array_values( $animations ) );
		
		return [
			'animations' => $flat_animations
		];
	}
	
	/**
	 * Get animations list.
	 *
	 * Retrieve the list of all the available animations.
	 *
	 * @return array Control type.
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 */
	public static function get_animations() {
		$animations = [
			'Fading'            => [
				'fadeIn'      => 'Fade In',
				'fadeInDown'  => 'Fade In Down',
				'fadeInLeft'  => 'Fade In Left',
				'fadeInRight' => 'Fade In Right',
				'fadeInUp'    => 'Fade In Up',
			],
			'Zooming'           => [
				'zoomIn'      => 'Zoom In',
				'zoomInDown'  => 'Zoom In Down',
				'zoomInLeft'  => 'Zoom In Left',
				'zoomInRight' => 'Zoom In Right',
				'zoomInUp'    => 'Zoom In Up',
			],
			'Bouncing'          => [
				'bounceIn'      => 'Bounce In',
				'bounceInDown'  => 'Bounce In Down',
				'bounceInLeft'  => 'Bounce In Left',
				'bounceInRight' => 'Bounce In Right',
				'bounceInUp'    => 'Bounce In Up',
			],
			'Sliding'           => [
				'slideInDown'  => 'Slide In Down',
				'slideInLeft'  => 'Slide In Left',
				'slideInRight' => 'Slide In Right',
				'slideInUp'    => 'Slide In Up',
			],
			'Rotating'          => [
				'rotateIn'          => 'Rotate In',
				'rotateInDownLeft'  => 'Rotate In Down Left',
				'rotateInDownRight' => 'Rotate In Down Right',
				'rotateInUpLeft'    => 'Rotate In Up Left',
				'rotateInUpRight'   => 'Rotate In Up Right',
			],
			'Attention Seekers' => [
				'bounce'     => 'Bounce',
				'flash'      => 'Flash',
				'pulse'      => 'Pulse',
				'rubberBand' => 'Rubber Band',
				'shake'      => 'Shake',
				'headShake'  => 'Head Shake',
				'swing'      => 'Swing',
				'tada'       => 'Tada',
				'wobble'     => 'Wobble',
				'jello'      => 'Jello',
			],
			'Light Speed'       => [
				'lightSpeedIn' => 'Light Speed In',
			],
			'Specials'          => [
				'rollIn' => 'Roll In',
			],
		];
		
		$additional_animations = [];
		
		/**
		 * Entrance animations.
		 *
		 * Filters the animations list displayed in the animations control.
		 *
		 * This hook can be used to register animations in addition to the
		 * basic Elementor animations.
		 *
		 * @param array $additional_animations Additional animations array.
		 *
		 * @since 2.4.0
		 *
		 */
		$additional_animations = apply_filters( 'elementor/controls/animations/additional_animations', $additional_animations );
		
		return array_merge( $animations, $additional_animations );
	}
	
	public static function get_assets( $setting ) {
		if ( ! $setting || 'none' === $setting ) {
			return [];
		}
		
		return [
			'styles' => [ 'e-animations' ],
		];
	}
}