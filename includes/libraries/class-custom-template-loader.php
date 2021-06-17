<?php
/**
 * Custom Template Loader
 *
 * 
 * @link       Author Uri
 * @since      1.0.0
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/includes/libraries
 * @author     Michael Scholl <mls2scholl@gmail.com>
 */

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
  require plugin_dir_path( __FILE__ ) . 'includes/libraries/class-gamajo-template-loader.php';
}

/**
 * Template loader for Test.
 *
 * Only need to specify class properties here.
 *
 * @package Tourney_Manager
 * @author  Michael Scholl <mls2scholl@gmail.com>
 */
class Custom_Template_Loader extends Gamajo_Template_Loader {
  /**
   * Prefix for filter names.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $filter_prefix = 'temp_load_test';

  /**
   * Directory name where custom templates for this plugin should be found in the theme.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $theme_template_directory = 'temp-load-test';

  /**
   * Reference to the root directory path of this plugin.
   * 
   * @since 1.0.0
   * 
   * @var string
   */
  protected $plugin_directory = TOURNEY_MANAGER_BASE_DIR;

  /**
   * Directory name where templates are found in this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * e.g. 'templates' or 'includes/templates', etc.
   *
   * @since 1.1.0
   *
   * @var string
   */
  protected $plugin_template_directory = 'templates';
}