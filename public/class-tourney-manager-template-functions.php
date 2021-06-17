<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @since      1.0.0
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/public
 * @author     Michael Scholl <mls2scholl@gmail.com>
 */
class Tourney_Manager_Template_Functions
{

    /**
     * Private static reference to this class
     * Useful for removing actions declared here.
     *
     * @var 	object 		$_this
     */
    private static $_this;

    /**
     * The post meta data
     *
     * @since 		1.0.0
     * @access 		private
     * @var 		string 			$meta    			The post meta data.
     */
    private $meta;

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version 			The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        self::$_this = $this;

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    } // __construct()

    /**
     * Includes the now-hiring-job-title template
     *
     * @hooked 		now-hiring-loop-content 		10
     *
     * @param 		object 		$item 		A post object
     * @param 		array 		$meta 		The post metadata
     */
    public function content_job_title($item, $meta)
    {

        include tourney_manager_get_template('now-hiring-job-title');
    }

    /**
     * Includes the single job post title
     *
     * @hooked 		tourney-manager-single-content 		10
     */
    public function single_post_title()
    {

        include tourney_manager_get_template('content-test');
    }

    public function single_post_how_to_apply()
    {

        echo apply_filters('nowhiring_howtoapply', '');
    } // single_post_how_to_apply()

    /**
     * Returns a reference to this class. Used for removing
     * actions and/or filters declared using an object of this class.
     *
     * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
     * @return 	object 		This class
     */
    static function this()
    {

        return self::$_this;
    } // this()

} // class