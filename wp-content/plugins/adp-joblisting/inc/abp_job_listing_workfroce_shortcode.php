<?php
if( !class_exists( 'FMI_Product_Subscription_edit_shortcode') ){
    class FMI_Product_Subscription_edit_shortcode {
        public function __construct(){
            add_shortcode('adp_joblisting', array($this, 'adp_joblisting_callback'));
        }

        function adp_joblisting_callback($atts){


            $atts = shortcode_atts(
                array(
                    'countries' => 'US', // Default value is an empty string
                ),
                $atts,
                'adp_joblisting'
            );
            ob_start(); 
             $countries = $atts['countries'];
             $countries = explode(',', $countries);
             $countries = "'" . implode("','", $countries) . "'";;

           // var_dump(explode(',', $atts['countries']));

            global $wpdb;
            $adpJobTableSql = $wpdb->prefix."adp_job_listings";
            $getJobs = "SELECT * FROM $adpJobTableSql WHERE joblocation_country IN (".$countries.") ORDER BY created_on DESC";

            //echo $getJobs; 
            $jobs = $wpdb->get_results($getJobs);
            foreach($jobs as $job){

                $job_id = $job->job_id; 
                $job_title = $job->job_title; 
                $job_categeroy = $job->job_categeroy; 
                $joblocation_city = $job->joblocation_city;
                $joblocation_country = $job->joblocation_country;
                $job_date = $job->job_date;
                $jobUrl = $job->job_url;
            ?>
                    <!-- <h2>ADP Job Listing</h2> -->
                    <div class="card card-job">
                    <div class="card-body">
                        <h3 class="card-title link-underline">
                            <a class="stretched-link js-view-job" href="<?php echo  $jobUrl; ?>">
                                <?php echo $job_title; ?>
                            </a>
                        </h3>
                        <ul class="list-inline job-meta">
                            <li class="list-inline-item"><?php echo $job_id; ?></li>
                            <li class="list-inline-item"><?php echo $job_categeroy; ?></li>
                            <li class="list-inline-item"><?php echo $joblocation_city.", ".$joblocation_country; ?></li>
                        </ul>
                    </div>
                </div>
            <?php
            }
            return "<div class='job_listing_wraper'>".ob_get_clean()."</div>";
        }

    }
}