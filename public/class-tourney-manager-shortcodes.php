<?php

/**
 * The public-facing shortcode functions
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
class Tourney_Manager_Shortcodes
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

    public function my_shortcode($atts)
    {
        return 'Hello World';
    }

    /* shortcode for registration form */
    function tourney_get_form($atts = [], $content = null)
    {

        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);

        $a = shortcode_atts(array(
            'backlink' => null,
            'class' => null,
            'css' => null,
            'css_id' => null,
            'disabled' => null,
            'email' => null,
            'tournament_id' => null,
        ), $atts);

        /* error if tournament id is missing */
        if (empty($a['tournament_id'])) {

            return sprintf(__('%sERROR: Missing %s in shortcode %s!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', '<kbd>tournament_id</kbd>', '<kbd>wptournregform</kbd>', '</strong>');
        } else {
            $tournament = '<input type="hidden" name="tournament_id" value="' . $a['tournament_id'] . '">';
        }

        /* Honeypot */
        $noscript = '<noscript><div><strong>' .   __('Enable JavaScript!') . '</strong></div></noscript>';

        /* E-mail */
        $email = (empty($a['email'])) ? '' : '<input type="hidden" name="cc" value="' . trim($a['email']) . '">';

        /* set action URL */
        $action = ' method="POST" action="' . esc_url(admin_url('admin-post.php')) . '"';

        $disabled = (!isset($a['disabled'])) ? '' : ' disabled';

        /* add custom CSS */
        $css = (empty($a['css'])) ? '' : ' style="' . trim(esc_attr($a['css'])) . '"';
        $class = ' class="wptournreg-form' . (empty($a['class']) ? '' :  ' ' . trim(esc_attr($a['class']))) . '"';
        $id = (empty($a['css_id'])) ? '' : ' id="' . trim(esc_attr($a['css_id'])) . '"';

        /*$backlink = '';
        if (!empty($a['backlink'])) {
            require_once WP_TOURNREG_HTML_PATH . 'backlink.php';
            $backlink = wptournreg_get_backlink('form');
        }
        // With backlink
        return "<form$id$class$css$action>$noscript$tournament" . do_shortcode($content, false) . '<input type="hidden" name="action" value="wptournreg_add_participant"><input type="submit"' . $disabled . '><input type="reset"' . $disabled . '></form>' . $backlink;
        */
        return "<form$id$class$css$action>$noscript$tournament" . do_shortcode($content, false) . '<input type="hidden" name="action" value="wptournreg_add_participant"><input type="submit"' . $disabled . '><input type="reset"' . $disabled . '></form>';
    }

    /* stores the form data (no params) */
    function tourney_get_fields($atts = [])
    {

        require_once WP_TOURNREG_DATABASE_PATH . 'scheme.php';
        $scheme = wptournreg_get_field_list();

        global $wpdb;

        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);

        $a = shortcode_atts(array(
            'checked' => null,
            'class' => null,
            'css' => null,
            'css_id' => null,
            'disabled' => null,
            'field' => null,
            'label' => null,
            'placeholder' => null,
            'required' => null,
        ), $atts);

        $field = trim($a['field']);
        $checked = (empty($a['checked'])) ? '' : ' required="checked"';
        $label = '<label for="' . $a['field'] . '">' . (empty($a['label']) ? $a['field'] :  $a['label']) . '</label>';
        $name = ' name="' . $a['field'] . '"';
        $placeholder = (empty($a['placeholder'])) ? '' : ' placeholder="' . $a['placeholder'] . '"';
        $required = (!isset($a['required'])) ? '' : ' required';
        $disabled = (!isset($a['disabled'])) ? '' : ' disabled';

        /* add custom CSS */
        $css = (empty($a['css'])) ? '' : ' style="' . trim(esc_attr($a['css'])) . '"';
        $class = ' class="wptournreg-field' . (!isset($a['required']) ? '' : ' wptourn-required') . (empty($a['class']) ? '' : ' ' . trim(esc_attr($a['class']))) . '"';
        $id = (empty($a['css_id'])) ? '' : ' id="' . trim(esc_attr($a['css_id'])) . '"';

        /* sizes */
        $bigsize = 50;
        $smallsize = 15;

        if ($field == 'id' || $field == 'time') {

            return sprintf(__('%sERROR: The field value of %s is generated automatically!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', "<kbd>$field</kbd>", '</strong>');
        }

        if (!isset($scheme[$field])) {

            return sprintf(__('%sERROR: There is not a field %s!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', "<kbd>$field</kbd>", '</strong>');
        } else if ($field == 'email') {

            return "<p$id$class$css>$label<input$id$class$name$required$disabled$placeholder type='email' size='$bigsize'></p>";
        } else if (preg_match('/^phone\d+/i', $scheme[$field])) {

            return "<p$id$class$style>$label<input$id$class$name$required$disabled$placeholder type='tell' size='$mallsize'></p>";
        } else if ($scheme[$field] == 'text') {

            return "<p$id$class$css>$label<textarea$name$required$disabled$placeholder cols='$bigsize' rows='8'></textarea></p>";
        } else if (preg_match('/char|string|text/i', $scheme[$field])) {

            return "<p$id$class$css>$label<input$id$class$name$required$disabled$placeholder type='text' size='$bigsize'></p>";
        } else if (preg_match('/bool|int\(1\)/i', $scheme[$field])) {

            return "<p$id$class$css>$label<input$id$class$name$checked$disabled type='checkbox'></span>";
        } else if (preg_match('/int/i', $scheme[$field])) {

            return "<p$id$class$css>$label<input$id$class$name$required$disabled$placeholder type='text size='$smallsize'></p>";
        } else {

            return sprintf(__('%sERROR: Missing format for field %s!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', "<kbd>$field</kbd>", '</strong>');
        }
    }

    /**
     * Sets the class variable $options
     */
    private function set_options()
    {
        $this->options = get_option($this->plugin_name . '-options');
    }
}
