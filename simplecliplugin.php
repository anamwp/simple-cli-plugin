<?php
/**
 * Plugin Name:     Simple CLI plugin
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Anam
 * Author URI:      https://anam.rocks
 * Text Domain:     simple-cli-plugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Simplecliplugin
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class SIMPLE_CLI_PLUGIN {

	/**
	 * plugin version
	 */
	const SIMPLE_CLI_PLUGIN_VERSION = '1.0';
	private $level_one;
	private $level_two;
	// private $level_one;
	// private $level_one;
	/**
	 * construction of this plugin
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_resources' ) );
		add_action('cli_init', array( $this, 'anam_cli_register_command' ));
	}
	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public static function init() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}
		return $instance;
	}
	/**
	 * Load plugin text domain
	 *
	 * @return void
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'sample-cli-plugin' );
	}
	/**
	 * define plugin
	 * default constants
	 *
	 * @return void
	 */
	public function define_constants() {
		/**
		 * return plugin version
		 */
		define( 'SIMPLE_CLI_PLUGIN_VERSION', self::SIMPLE_CLI_PLUGIN_VERSION );
		/**
		 * return the main file name
		 * C:\xampp\htdocs\devplugin\wp-content\plugins\gutenberg-starter\gutenberg-starter.php
		 */
		define( 'SIMPLE_CLI_PLUGIN_FILE', __FILE__ );
		/**
		 * return the plugin director
		 * C:\xampp\htdocs\devplugin\wp-content\plugins\gutenberg-starter
		 */
		define( 'SIMPLE_CLI_PLUGIN_PATH', __DIR__ );
		/**
		 * return the plugin directory with host
		 * http://localhost/devplugin/wp-content/plugins/gutenberg-starter
		 */
		define( 'SIMPLE_CLI_PLUGIN_URL', plugins_url( '', SIMPLE_CLI_PLUGIN_FILE ) );
		define( 'SIMPLE_CLI_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
		/**
		 * return the asset folder director
		 * http://localhost/devplugin/wp-content/plugins/gutenberg-starter/assets
		 */
		define( 'SIMPLE_CLI_PLUGIN_ASSETS', SIMPLE_CLI_PLUGIN_URL . '/build' );
		define( 'SIMPLE_CLI_PLUGIN_DIR_ASSETS', SIMPLE_CLI_PLUGIN_DIR_URL . 'build' );

	}
	/**
	 * add installation time
	 * and plugin version
	 * while active the plugin
	 *
	 * @return void
	 */
	public function activate() {
		if ( ! get_option( 'simple_cli_plugin_installed' ) ) {
			update_option( 'simple_cli_plugin_installed', time() );
		}
		update_option( 'simple_cli_plugin_version', SIMPLE_CLI_PLUGIN_VERSION );
	}
	/**
	 * Load plugin resources
	 *
	 * @return void
	 */
	public function load_plugin_resources() {
		// new Anam\SimpleCLIPlugin\Level_One();
		if (!defined('WP_CLI') || !WP_CLI || !class_exists('\WP_CLI')) {
			return;
		}
		$this->level_one = new Anam\SimpleCLIPlugin\Level_One();
		// \WP_CLI::add_command('l1', $level_one );
		$this->level_two = new Anam\SimpleCLIPlugin\Level_Two();
		// \WP_CLI::add_command('l2', $level_two );
		
	}
	public function anam_cli_register_command(){
		\WP_CLI::add_command('l1', $this->level_one );
		\WP_CLI::add_command('l2', $this->level_two );
	}
	
}

/**
 * Initilize the main plugin
 *
 * @return \SIMPLE_CLI_PLUGIN
 */
function simple_cli_plugin() {
	 return SIMPLE_CLI_PLUGIN::init();
}
/**
 * kick start the plugin
 */
simple_cli_plugin();