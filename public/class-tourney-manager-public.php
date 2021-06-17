<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * 
 * @link       Author Uri
 * @since      1.0.0
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/public
 * @author     Michael Scholl <mls2scholl@gmail.com>
 */
class Tourney_Manager_Public
{

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of the plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_options();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tourney_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tourney_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tourney-manager-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tourney_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tourney_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tourney-manager-public.js', array('jquery'), $this->version, false);
	}

	public function my_shortcode( $atts ) {
		return 'Hello World';
	}

		/**
	 * Adds a default single view template for a job opening
	 *
	 * @param 	string 		$template 		The name of the template
	 * @return 	mixed 						The single template
	 */
	public function single_cpt_template( $template ) {

		global $post;

		$return = $template;

	    if ( $post->post_type == 'job' ) {

			$return = tourney_manager_get_template( 'single' );

		}

		return $return;

	} // single_cpt_template()

	/**
	 * Sets the class variable $options
	 */
	private function set_options()
	{

		$this->options = get_option($this->plugin_name . '-options');
	}

	/**
	 * Override template location for custom post type
	 *
	 * If the archive template file not exist in the theme folder, then use  the plugin template.
	 * In this case, file can be overridden inside the [child] theme.
	 *
	 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/archive_template
	 * @link http://wordpress.stackexchange.com/a/116025/90212
	 */
	/* 	function get_custom_post_type_templates($template)
	{
		global $post;

		$settings = array(
			'custom_post_type' => 'exopite-portfolio',
			'templates_dir' => 'templates',
		);

		//if ( $settings['custom_post_type'] == get_post_type() && ! is_archive() && ! is_search() ) {
		if ($settings['custom_post_type'] == get_post_type() && is_single()) {

			return $this->locate_template($template, $settings, 'single');
		}

		return $template;
	}

	function locate_template($template, $settings, $page_type)
	{

		$theme_files = array(
			$page_type . '-' . $settings['custom_post_type'] . '.php',
			$this->plugin_name . DIRECTORY_SEPARATOR . $page_type . '-' . $settings['custom_post_type'] . '.php',
		);

		$exists_in_theme = locate_template($theme_files, false);

		if ($exists_in_theme != '') {

			// Try to locate in theme first
			return $template;
		} else {

			// Try to locate in plugin base folder,
			// try to locate in plugin $settings['templates'] folder,
			// return $template if non of above exist
			$locations = array(
				join(DIRECTORY_SEPARATOR, array(WP_PLUGIN_DIR, $this->plugin_name, '')),
				join(DIRECTORY_SEPARATOR, array(WP_PLUGIN_DIR, $this->plugin_name, $settings['templates_dir'], '')), //plugin $settings['templates'] folder
			);

			foreach ($locations as $location) {
				if (file_exists($location . $theme_files[0])) {
					return $location . $theme_files[0];
				}
			}

			return $template;
		}
	} */

	/* function shortcode_function( $atts ) {

		$args = shortcode_atts(
			array(
				'arg1'   => 'arg1',
				'arg2'   => 'arg2',
			),
			$atts
		);
	
		// code...
	
		$var = ( strtolower( $args['arg1']) != "" ) ? strtolower( $args['arg1'] ) : 'default';
	
		// code...
	
		return $var;
	} */

	/* 	public function define_hooks() {
		$this->loader->add_shortcode( "testShortcode", $this->plugin_name, "shortcode_function", $priority = 10, $accepted_args = 2 );
	}

	public function shortcode_function(){
		echo 'Test the plugin';
	}

	function temp_test_shortcode() {
		$templates = new Custom_Template_Loader;
		// Turn on output buffering, because it is a shortcode, content file should not echo anything out.
		// In other cases, output buffering may not required.
		ob_start();
		// Load template from PLUGIN_NAME_BASE_DIR/templates/content-header.php
		$templates->get_template_part( 'content', 'test' );
		// Return content ftom the file
		return ob_get_clean();
	}
	//add_shortcode( 'temp-test-shortcode', array( $plugin_public, 'temp_test_shortcode')  ); */
}
