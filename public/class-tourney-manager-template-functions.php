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

        //include tourney_manager_get_template('now-hiring-job-title');
    }

    /* Action hook of registration form */
    function wptournreg_add_participant()
    {

        require_once WP_TOURNREG_DATABASE_PATH . 'insert.php';

        echo '<html><head></head><body><header style="min-height:50px"></header>';

        if (isset($_POST['touched'])) {

            if (wptournreg_insert_data() === 1) {

                printf(__('%sThank you for your registration.%s', 'wp-tournament-registration'), '<strong class="wptournreg-thanks">', '</strong>');

                /* send E-mail notification */
                if (isset($_POST['cc'])) {

                    require_once WP_TOURNREG_DATABASE_PATH . 'escape.php';
                    $addressee = preg_split('/\s*,\s*/', wptournreg_escape($_POST['cc']));
                    $to = [];

                    foreach ($addressee as $email) {

                        $user = get_user_by('login', $addressee);
                        if ($user !== false) {

                            $to[] = $user->user_email;
                        }
                    }

                    if (count($to) > 0) {

                        foreach ($_POST as $key => $value) {

                            if ($key == 'touched') {
                                continue;
                            }

                            if (strcmp($key, 'action') != 0) {

                                $mailbody .= "\n" . strtoupper($key) . ': ' . $value;
                            }
                        }

                        wp_mail($to, __('New participant'), $mailbody);
                    }
                }
            } else {

                global $wpdb;
                if (strpos($wpdb->last_error, 'Duplicate entry') == 0) {

                    printf(__('%sFailed: this looks like a duplicate!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', '</strong>');
                } else {

                    printf(__('%sRegistration failed!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', '</strong>');
                }
            }
        } else {

            printf(__('%sRegistration failed!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', '</strong>');
        }

        echo '</p>';
        require_once WP_TOURNREG_HTML_PATH . 'backbutton.php';
        echo '</body></html>';
    }



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