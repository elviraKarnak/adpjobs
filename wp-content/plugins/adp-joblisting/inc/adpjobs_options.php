<?php
if( !class_exists( 'ADP_Jobs_plugin_options') ){
    class ADP_Jobs_plugin_options {

        public function __construct(){
            add_action("admin_menu", array($this,"setup_adpjobs_admin_menus"));
        }

        function setup_adpjobs_admin_menus() {
            $job_overview = add_menu_page(
              __( 'ADP Job Listing', 'adp-joblisting' ),
              __( 'ADP Job Listing', 'adp-joblisting' ),
              'manage_options', 
              'adp-joblisting-menu', 'adp_joblisting_cb','dashicons-id-alt',10
            );

            $fetch_jobs = add_submenu_page('adp-joblisting-menu', 
            __( 'Fetch Jobs', 'adp-joblisting' ),
            __( 'Fetch Jobs', 'adp-joblisting' ),
              'manage_options', 
            'fetch_jobs', 'fetch_job_cb'
            ); 

            function adp_joblisting_cb() {
               // require( Shelleyashmans_Bookings_PATH . 'views/sa_form_list.php' );
               echo "<h2>Jobs</h2>";
               }
            function fetch_job_cb() {
                require( ADP_Job_Listing_PATH . 'view/fetch_job.php' );
            }


        }
    }
}