<?php
/**
 * Settings page: Settings > Ace Integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ace_Wp_Settings {

	const OPTION_GROUP = 'ace_wp_settings_group';
	const OPTION_NAME  = 'ace_wp_options';
	const PAGE_SLUG    = 'ace-wp-integration';

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'admin_menu', array( $this, 'register_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Get a saved option value.
	 *
	 * @param string $key     Option key.
	 * @param mixed  $default Fallback value.
	 * @return mixed
	 */
	public static function get_option( $key, $default = '' ) {
		$options = get_option( self::OPTION_NAME, array() );
		return isset( $options[ $key ] ) ? $options[ $key ] : $default;
	}

	public function register_settings_page() {
		add_options_page(
			__( 'Ace Integration', 'ace-wp-integration' ),
			__( 'Ace Integration', 'ace-wp-integration' ),
			'manage_options',
			self::PAGE_SLUG,
			array( $this, 'render_settings_page' )
		);
	}

	public function register_settings() {
		register_setting(
			self::OPTION_GROUP,
			self::OPTION_NAME,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_options' ),
				'default'           => array(),
			)
		);

		add_settings_section(
			'ace_wp_main_section',
			__( 'Club Settings', 'ace-wp-integration' ),
			'__return_false',
			self::PAGE_SLUG
		);

		add_settings_field(
			'ace_club_id',
			__( 'Ace Club ID', 'ace-wp-integration' ),
			array( $this, 'render_club_id_field' ),
			self::PAGE_SLUG,
			'ace_wp_main_section'
		);
	}

	/**
	 * Sanitize submitted options.
	 *
	 * @param array $input Raw input.
	 * @return array
	 */
	public function sanitize_options( $input ) {
		$output = array();

		if ( isset( $input['ace_club_id'] ) ) {
			$output['ace_club_id'] = sanitize_text_field( wp_unslash( $input['ace_club_id'] ) );
		}

		return $output;
	}

	public function render_club_id_field() {
		$value = self::get_option( 'ace_club_id', '' );
		?>
		<input
			type="text"
			id="ace_club_id"
			name="<?php echo esc_attr( self::OPTION_NAME ); ?>[ace_club_id]"
			value="<?php echo esc_attr( $value ); ?>"
			class="regular-text"
			placeholder="e.g. 12345"
		/>
		<p class="description">
			<?php esc_html_e( 'Your unique Ace Club ID, provided by the Ace platform.', 'ace-wp-integration' ); ?>
		</p>
		<?php
	}

	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Ace Integration', 'ace-wp-integration' ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( self::OPTION_GROUP );
				do_settings_sections( self::PAGE_SLUG );
				submit_button( __( 'Save Changes', 'ace-wp-integration' ) );
				?>
			</form>
		</div>
		<?php
	}
}
