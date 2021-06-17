<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       Author Uri
 * @since      1.0.0
 *
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>Plugin Name <?php esc_attr_e('Options', 'plugin_name'); ?></h2>

    <form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
        <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        $example_select = (isset($options['example_select']) && !empty($options['example_select'])) ? esc_attr($options['example_select']) : '1';
        $example_text = (isset($options['example_text']) && !empty($options['example_text'])) ? esc_attr($options['example_text']) : 'default';
        $example_textarea = (isset($options['example_textarea']) && !empty($options['example_textarea'])) ? sanitize_textarea_field($options['example_textarea']) : 'default';
        $example_checkbox = (isset($options['example_checkbox']) && !empty($options['example_checkbox'])) ? 1 : 0;

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);

        ?>

        <!-- Select -->
        <fieldset>
            <p><?php esc_attr_e('Example Select.', 'plugin_name'); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Example Select', 'plugin_name'); ?></span>
            </legend>
            <label for="example_select">
                <select name="<?php echo $this->plugin_name; ?>[example_select]" id="<?php echo $this->plugin_name; ?>-example_select">
                    <option <?php if ($example_select == 'first') echo 'selected="selected"'; ?> value="first">First</option>
                    <option <?php if ($example_select == 'second') echo 'selected="selected"'; ?> value="second">Second</option>
                </select>
            </label>
        </fieldset>

        <!-- Text -->
        <fieldset>
            <p><?php esc_attr_e('Example Text.', 'plugin_name'); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Example Text', 'plugin_name'); ?></span>
            </legend>
            <input type="text" class="example_text" id="<?php echo $this->plugin_name; ?>-example_text" name="<?php echo $this->plugin_name; ?>[example_text]" value="<?php if (!empty($example_text)) echo $example_text;
                                                                                                                                                                        else echo 'default'; ?>" />
        </fieldset>

        <!-- Textarea -->
        <fieldset>
            <p><?php esc_attr_e('Example Text.', 'plugin_name'); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Example Text', 'plugin_name'); ?></span>
            </legend>
            <textarea class="example_textarea" id="<?php echo $this->plugin_name; ?>-example_textarea" name="<?php echo $this->plugin_name; ?>[example_textarea]" rows="4" cols="50">
            <?php if (!empty($example_textarea)) echo $example_textarea;
            else echo 'default'; ?>
        </textarea>
        </fieldset>

        <!-- Checkbox -->
        <fieldset>
            <p><?php esc_attr_e('Example Checkbox.', 'plugin_name'); ?></p>
            <legend class="example-Checkbox">
                <span><?php esc_attr_e('Example Checkbox', 'plugin_name'); ?></span>
            </legend>
            <label for="<?php echo $this->plugin_name; ?>-example_checkbox">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-example_checkbox" name="<?php echo $this->plugin_name; ?>[example_checkbox]" value="1" <?php checked($example_checkbox, 1); ?> />
                <span><?php esc_attr_e('Example Checkbox', 'plugin_name'); ?></span>
            </label>
        </fieldset>

        <?php submit_button(__('Save all changes', 'plugin_name'), 'primary', 'submit', TRUE); ?>
    </form>
</div>