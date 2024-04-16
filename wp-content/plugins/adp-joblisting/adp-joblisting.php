<?php
/**
 * Plugin Name: ADP Job Listing
 * Description: ADP Job Listing is a job listing plugin based on ADP Workfroce.
 * Author: Raihan Reza
 * Author URI: http://elvirainfotech.com/
 * Version: 1.0.0
 * Requires at least: 5.6
 * Tested up to: 6.4.2
 * Text Domain: adp-joblisting
 * Copyright (c) 2024 ADP Job Listing
 * License: GPL v2 or later
 * License URI:https://www.gnu.org/licenses/gpl-2.0.html
 * @author    Raihan Reza
 * @category  Genarel
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * 
 */

/*
ADP Job Listing is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

ADP Job Listing is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with ADP Job Listing. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'ADP_Job_Listing' )){
    class ADP_Job_Listing {
        function __construct() {
			$this->define_constants(); 
            require_once( ADP_Job_Listing_PATH . 'inc/abp_job_listing_workfroce_shortcode.php' );
            $ADP_Jobs_edit_shortcode = new ADP_Jobs_edit_shortcode();

            require_once( ADP_Job_Listing_PATH . 'inc/jobdata_fetch.php' );
            $ADP_Jobs_fetch_jobs = new ADP_Jobs_fetch_jobs();

            require_once( ADP_Job_Listing_PATH . 'inc/adpjobs_options.php' );
            $ADP_Jobs_plugin_options = new ADP_Jobs_plugin_options();

            add_action( 'wp_enqueue_scripts', array( $this,'register_scripts_adpjobs' ));
		}

		public function define_constants(){
			define( 'ADP_Job_Listing_PATH', plugin_dir_path( __FILE__ ) );
			define( 'ADP_Job_Listing_URL', plugin_dir_url( __FILE__ ) );
			define( 'ADP_Job_Listing_VERSION', '1.0.0' );
		}


        public function register_scripts_adpjobs(){
            wp_enqueue_style( 'adpjobs-customcss', ADP_Job_Listing_URL . 'assets/css/style.css',array(),time());
            wp_enqueue_script('jquery');
            //wp_enqueue_script( 'adpjobs-customdata', ADP_Job_Listing_URL . 'assets/data.js',array(),time());
            wp_enqueue_script( 'adpjobs-customjs', ADP_Job_Listing_URL . 'assets/js/custom.js',array(),time(),true);
        }

		public static function activate(){

            // initial load 
            global $wpdb;

            $adpJobTableSql = $wpdb->prefix."adp_job_listings";

              /* Subscription Plans Table */
              $adpJobTableSql = "CREATE TABLE $adpJobTableSql (
                id int NOT NULL AUTO_INCREMENT,
                created_on datetime NOT NULL,
                job_id varchar(255) NOT NULL,
                job_title varchar(255) NOT NULL,
                job_description LONGTEXT NOT NULL,
                job_category varchar(255) NOT NULL,
                joblocation_code varchar(255) NOT NULL,
                joblocation_name varchar(255) NOT NULL,
                joblocation_cityname varchar(255) NOT NULL,
                job_post_date datetime NOT NULL,
                job_expire_date datetime NOT NULL,
                job_url varchar(255) NOT NULL,
                UNIQUE KEY id (id)
            ) $charset_collate;";
        
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($adpJobTableSql);

             /* Subscription Plans Table End*/

            if( $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'job_listing'" ) === null ){
                $current_user = wp_get_current_user();
                $job_listing_page = array(
                    'post_title'    => __('Job Listing', 'adp-joblisting' ),
                    'post_name' => 'job_listing',
                    'post_status'   => 'publish',
                    'post_author'   => $current_user->ID,
                    'post_type' => 'page',
                    'post_content'  => '<!-- wp:shortcode -->[adp_joblisting]<!-- /wp:shortcode -->'
                );
                wp_insert_post($job_listing_page);
            }
			
		}
        public static function deactivate(){
            flush_rewrite_rules();
        }

        public static function uninstall(){
           // flush_rewrite_rules();
        }
		
        
	}
}

if( class_exists( 'ADP_Job_Listing' ) ){
    register_activation_hook( __FILE__, array( 'ADP_Job_Listing', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'ADP_Job_Listing', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'ADP_Job_Listing', 'uninstall' ) );

    $ADP_Job_Listing = new ADP_Job_Listing();
}