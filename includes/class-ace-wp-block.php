<?php
/**
 * Gutenberg block registration: "Ace Widget".
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ace_Wp_Block {

	const HANDLE = 'ace-wp-block-editor';

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	public function register_block() {
		wp_register_script(
			self::HANDLE,
			ACE_WP_PLUGIN_URL . 'blocks/ace-widget/index.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
			ACE_WP_VERSION,
			true
		);

		register_block_type(
			ACE_WP_PLUGIN_DIR . 'blocks/ace-widget',
			array(
				'editor_script' => self::HANDLE,
			)
		);
	}
}
