<?php
/**
 * Front-end asset enqueueing: loads the Ace web component runtime
 * and exposes the club configuration via window.ACE_CONFIG.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ace_Wp_Assets {

	const HANDLE  = 'ace-elements';
	const CDN_URL = 'https://cdn.playace.de/widgets/v1/ace-elements.js';

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_widget_script' ) );
	}

	public function enqueue_widget_script() {
		wp_enqueue_script(
			self::HANDLE,
			self::CDN_URL,
			array(),
			ACE_WP_VERSION,
			true
		);

		$club_id = Ace_Wp_Settings::get_option( 'ace_club_id', '' );

		$config = array(
			'clubId' => $club_id,
		);

		wp_add_inline_script(
			self::HANDLE,
			'window.ACE_CONFIG = ' . wp_json_encode( $config ) . ';',
			'before'
		);
	}
}
