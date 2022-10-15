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
class Custom_Exit_Animation extends Control_Animation {
	
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
		// same name as elementor default exit_animation used to get select2 styles
		return 'exit_animation';
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
			'Fading'      => [
				'fadeOut'      => 'Fade Out',
				'fadeOutLeft'  => 'Fade Out Left',
				'fadeOutRight' => 'Fade Out Right',
				'fadeOutDown'  => 'Fade Out Down',
				'fadeOutUp'    => 'Fade Out Up',
			],
			'Zooming'     => [
				'zoomOut'      => 'Zoom Out',
				'zoomOutLeft'  => 'Zoom Out Left',
				'zoomOutRight' => 'Zoom Out Right',
				'zoomOutUp'    => 'Zoom Out Up',
				'zoomOutDown'  => 'Zoom Out Down',
			],
			'Sliding'     => [
				'slideOutLeft'  => 'Slide Out Left',
				'slideOutRight' => 'Slide Out Right',
				'slideOutUp'    => 'Slide Out Up',
				'slideOutDown'  => 'Slide Out Down',
			],
			'Rotating'    => [
				'rotateOut'          => 'Rotate Out',
				'rotateOutUpLeft'    => 'Rotate Out Up Left',
				'rotateOutUpRight'   => 'Rotate Out Up Right',
				'rotateOutDownLeft'  => 'Rotate Out Down Left',
				'rotateOutDownRight' => 'Rotate Out Down Right',
			],
			'Light Speed' => [
				'lightSpeedOut' => 'Light Speed Out',
			],
			'Specials'    => [
				'rollOut' => 'Roll Out',
			],
		];
		
		$additional_animations = [];
		
		/**
		 * Exit animations.
		 *
		 * Filters the animations list displayed in the exit animations control.
		 *
		 * This hook can be used to register new animations in addition to the
		 * basic Elementor exit animations.
		 *
		 * @param array $additional_animations Additional animations array.
		 *
		 * @since 2.5.0
		 *
		 */
		$additional_animations = apply_filters( 'elementor/controls/exit-animations/additional_animations', $additional_animations );
		
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