<?php

/**
 * Fired during plugin activation
 *
 * @link       Author Uri
 * @since      1.0.0
 *
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tourney_Manager
 * @subpackage Tourney_Manager/includes
 * @author     Michael Scholl <mls2scholl@gmail.com>
 */
class Tourney_Manager_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{

		/**
		 * Custom Post Types
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-tourney-manager-post_types.php';
		$plugin_post_types = new Tourney_Manager_Post_Types();

		$plugin_post_types->create_custom_post_type();

		self::create_db();
	}

	public static function create_db()
	{

		global $wpdb;
		$mnm_core_db_version = get_option('mnm_core_db_version', '1.0');
		$charset_collate = $wpdb->get_charset_collate();
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


		/**
		 * Tournament Players
		 */
		$table_name = $wpdb->prefix . "tourney_players";
		if (
			$wpdb->get_var("show tables like '{$table_name}'") != $table_name ||
			version_compare($mnm_core_db_version, '1.0') < 0
		) {
			$sql_create_table = "CREATE TABLE " . $table_name . " (
				player_id bigint(20) unsigned NOT NULL auto_increment,
				player_firstname varchar(20) NOT NULL default '',
				player_lastname varchar(20) NOT NULL default '',
				phone_number varchar(20) NOT NULL default '000-000-000',
				p_partner_first varchar(20) NOT NULL default '',
				p_partner_last varchar(20) NOT NULL default '',
				team_id bigint(20) unsigned NOT NULL default '0',
				skill_level bigint(20) unsigned NOT NULL default '1',
				signup_date datetime NOT NULL,
				PRIMARY KEY  (player_id)
		   	) $charset_collate; ";

			/**
			 * It seems IF NOT EXISTS isn't needed if you're using dbDelta - if the table already exists it'll
			 * compare the schema and update it instead of overwriting the whole table.
			 *
			 * @link https://code.tutsplus.com/tutorials/custom-database-tables-maintaining-the-database--wp-28455
			 */
			dbDelta($sql_create_table);

			add_option('mnm_core_db_version', $mnm_core_db_version);
		}

		/**
		 * Bags Teams
		 */
		$table_name = $wpdb->prefix . "bags_teams";
		if (
			$wpdb->get_var("show tables like '{$table_name}'") != $table_name ||
			version_compare($mnm_core_db_version, '1.0') < 0
		) {
			$sql_create_table = "CREATE TABLE " . $table_name . " (
				team_id bigint(20) unsigned NOT NULL auto_increment,
				playerone_id bigint(20) unsigned NOT NULL default '0',
				playertwo_id bigint(20) unsigned NOT NULL default '0',
				seed bigint(20) unsigned NOT NULL default '0',
				team_name varchar(20) NOT NULL default 'NONE',
				PRIMARY KEY  (team_id)
		   	) $charset_collate; ";

			dbDelta($sql_create_table);
			add_option('mnm_core_db_version', $mnm_core_db_version);
		}

		/**
		 * Bags Players
		 */
		$table_name = $wpdb->prefix . "bags_games";
		if (
			$wpdb->get_var("show tables like '{$table_name}'") != $table_name ||
			version_compare($mnm_core_db_version, '1.0') < 0
		) {
			$sql_create_table = "CREATE TABLE " . $table_name . " (
				game_id bigint(20) unsigned NOT NULL auto_increment,
				round_num bigint(20) unsigned NOT NULL default '1',
				date datetime NOT NULL default '0000-00-00 00:00:00',
				visitor_id bigint(20) unsigned NOT NULL default '0',
				home_id bigint(20) unsigned NOT NULL default '0',
				visitor_score bigint(20) unsigned NOT NULL default '0',
				home_score bigint(20) unsigned NOT NULL default '0',
				winner_id bigint(20) unsigned NOT NULL default '0',
				PRIMARY KEY  (game_id)
		   	) $charset_collate; ";

			dbDelta($sql_create_table);
			add_option('mnm_core_db_version', $mnm_core_db_version);
		}

		/**
		 * wptournreg_participants testing
		 */
		$table_name = $wpdb->prefix . "wptournreg_participants";
		if (
			$wpdb->get_var("show tables like '{$table_name}'") != $table_name ||
			version_compare($mnm_core_db_version, '1.0') < 0
		) {
			$sql_create_table = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				tournament_id varchar(32) NOT NULL,
				time int(64) DEFAULT 0 NOT NULL,
				lastname tinytext DEFAULT '' NOT NULL,
				firstname tinytext DEFAULT '' NOT NULL,
				email tinytext NOT NULL,
				phone1 varchar(64) DEFAULT '' NOT NULL,
				phone2 varchar(32) DEFAULT '' NOT NULL,
				rating1 mediumint(9) DEFAULT NULL,
				rating2 mediumint(9) DEFAULT NULL,
				affiliation tinytext DEFAULT '' NOT NULL,
				message text DEFAULT '' NOT NULL,
				approved bool DEFAULT FALSE NOT NULL,
				protected bool DEFAULT FALSE NOT NULL,
				fee_is_paid bool DEFAULT FALSE NOT NULL,
				gender bool DEFAULT FALSE NOT NULL,
				birthyear mediumint(9) DEFAULT NULL,
				postcode varchar(12) NOT NULL,
				city varchar(32) NOT NULL,
				address varchar(128) NOT NULL,
				ip varchar(32) NOT NULL,
				custom1 tinytext DEFAULT '' NOT NULL,
				custom2 tinytext DEFAULT '' NOT NULL,
				custom3 tinytext DEFAULT '' NOT NULL,
				custom4 tinytext DEFAULT '' NOT NULL,
				custom5 tinytext DEFAULT '' NOT NULL,
				hash varchar(32) DEFAULT NULL,
				UNIQUE (hash),
				PRIMARY KEY (id)
			) $charset_collate;";

			dbDelta($sql_create_table);
			add_option('mnm_core_db_version', $mnm_core_db_version);
		}
	}
}
