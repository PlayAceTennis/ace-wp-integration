<?php
/**
 * [ace_widget] shortcode: outputs the <ace-widget> custom element.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ace_Wp_Shortcode {

	const TAG = 'ace_widget';

	const ALLOWED_TYPES = array( 'booking', 'news', 'calendar' );

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_shortcode( self::TAG, array( $this, 'render' ) );
	}

	/**
	 * Shortcode callback. Returns markup, does not echo.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function render( $atts ) {
		$atts = shortcode_atts(
			array(
				'type' => 'booking',
			),
			$atts,
			self::TAG
		);

		$type = in_array( $atts['type'], self::ALLOWED_TYPES, true ) ? $atts['type'] : 'booking';

		return sprintf(
			'<ace-widget type="%s"></ace-widget>',
			esc_attr( $type )
		);
	}
}
