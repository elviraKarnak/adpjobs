<?php
if( !class_exists( 'ADP_Jobs_edit_shortcode') ){
    class ADP_Jobs_edit_shortcode {
        public function __construct(){
            add_shortcode('adp_joblisting', array($this, 'adp_joblisting_callback'));
        }

        function adp_joblisting_callback($atts){


            $atts = shortcode_atts(
                array(
                    'countries' => '', // Default value is an empty string
                ),
                $atts,
                'adp_joblisting'
            );
            ob_start(); 
             $countries = $atts['countries'];
             $countries = explode(',', $countries);
             $countries = "'" . implode("','", $countries) . "'";;

             //var_dump(explode(',', $atts['countries']));

            global $wpdb;

            $items_per_page = 10;
            $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
            $offset = ( $page * $items_per_page ) - $items_per_page;

            $adpJobTableSql = $wpdb->prefix."adp_job_listings";
            $query = "SELECT * FROM $adpJobTableSql WHERE joblocation_code IN (".$countries.")  ";

            $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
            $total = $wpdb->get_var($total_query);

            $jobs = $wpdb->get_results($query.' ORDER BY created_on DESC LIMIT '.$offset.', '.$items_per_page, OBJECT);
          
            //echo $getJobs; 
            //   $jobs = $wpdb->get_results($query);

           // var_dump($jobs);
            foreach($jobs as $job){

                $job_id = $job->job_id; 
                $job_title = $job->job_title; 
                $job_categeroy = $job->job_category; 
                $joblocation_city = $job->joblocation_cityname;
                $joblocation_country = $job->joblocation_name;
                $job_date = $job->job_post_date;
                $jobUrl = $job->job_url;
            ?>
                    <!-- <h2>ADP Job Listing</h2> -->
                    <div class="card card-job">
                    <div class="card-body">
                        <h3 class="card-title link-underline">
                            <!-- <a class="stretched-link js-view-job" href="<?php echo  $jobUrl; ?>"> -->
                                <?php echo $job_title; ?>
                            <!-- </a> -->
                        </h3>
                        <ul class="list-inline job-meta">
                            <li class="list-inline-item"><?php echo $job_categeroy; ?></li>
                            <li class="list-inline-item"><?php echo $joblocation_country; ?></li>
                            <li class="list-inline-item"><?php echo  "Posted On: " . date('d-F-Y', strtotime($job_date)); ?></li>
                            <li class="list-inline-item"><?php echo "Valid Upto: " .date('d-F-Y', strtotime($job->job_expire_date)); ?></li>
                        </ul>
                        <div class="job_description">
                            <div class="accordion">
                                <div class="accordion-item">
                                <div class="accordion-item-header">
                                    <span class="accordion-item-header-title">Description</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down accordion-item-header-icon">
                                    <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </div>
                                <div class="accordion-item-description-wrapper">
                                    <div class="accordion-item-description">
                                        <?php echo $job->job_description; ?>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <a class="stretched-link btn btn-primary js-view-job" href="<?php echo  $jobUrl; ?>" target="_blank">Apply Now</a>
                    </div>
                </div>
            
                <?php } ?>
                <div class="pagination_wraper_adpjobs">
            <?php
       
            echo paginate_links( array(
                            'base' => add_query_arg( 'cpage', '%#%' ),
                            'format' => '',
                            'prev_text' => __('&laquo;'),
                            'next_text' => __('&raquo;'),
                            'total' => ceil($total / $items_per_page),
                            'current' => $page,
                             'type' => 'list'
                                ));
                    ?>
        </div>
        <?php
            
            return "<div class='job_listing_wraper'>".ob_get_clean()."</div>";
        }
        

    }
}