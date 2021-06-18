<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       Author Uri
 * @since      1.0.0
 *
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/includes
 * @author     Michael Scholl <mls2scholl@gmail.com>
 */
class Tourney_Manager
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Tourney_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('TOURNEY_MANAGER_VERSION')) {
			$this->version = TOURNEY_MANAGER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'tourney-manager';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_template_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Tourney_Manager_Loader. Orchestrates the hooks of the plugin.
	 * - Tourney_Manager_i18n. Defines internationalization functionality.
	 * - Tourney_Manager_Admin. Defines all hooks for the admin area.
	 * - Tourney_Manager_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-tourney-manager-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-tourney-manager-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-tourney-manager-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-tourney-manager-public.php';

		/**
		 * The class responsible for defining all shortcode functions.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-tourney-manager-shortcodes.php';

		/**
		 * Custom Post Types
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-tourney-manager-post_types.php';

		/**
		 * The class responsible for defining all templates.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-tourney-manager-template-loader.php';

		/**
		 * Class responsible for adding template hooks.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-tourney-manager-template-functions.php';

		$this->loader = new Tourney_Manager_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tourney_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Tourney_Manager_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Tourney_Manager_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		// Save/Update our plugin options
		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');

		// Add menu item
		$this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename(plugin_dir_path(__DIR__) . $this->plugin_name . '.php');

		$this->loader->add_filter('plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links');

		$plugin_post_types = new Tourney_Manager_Post_Types();

		$this->loader->add_action('init', $plugin_post_types, 'create_custom_post_type', 999);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$test = new Tourney_Template_Loader();

		$plugin_public = new Tourney_Manager_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

		$plugin_shortcodes = new Tourney_Manager_Shortcodes($this->get_plugin_name(), $this->get_version());
		$this->loader->add_shortcode('my_shortcode_tag', $plugin_shortcodes, 'my_shortcode');
		$this->loader->add_shortcode('tourney_form', $plugin_shortcodes, 'tourney_get_form');
		$this->loader->add_shortcode('tourney_field', $plugin_shortcodes, 'tourney_get_fields');
	}

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks()
	{

		$plugin_templates = new Tourney_Manager_Template_Functions($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_post_nopriv_wptournreg_add_participant', $plugin_templates, 'wptournreg_add_participant');

		//$this->loader->add_action( 'plugins_loaded', $template_loader, 'get_instance', 10 );

		// Loop
		//$this->loader->add_action('now-hiring-loop-content', $plugin_templates, 'content_job_title', 10, 2);

		// Single
		//$this->loader->add_action('tourney-manager-single-content', $plugin_templates, 'single_post_title', 10);
	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tourney_Manager_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
