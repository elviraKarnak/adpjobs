<?php
if( !class_exists( 'ADP_Jobs_fetch_jobs') ){
    class ADP_Jobs_fetch_jobs {
        public function __construct(){
            add_action( 'wp_ajax_nopriv_fetch_jobs', array( $this, 'fetch_jobs_cb' ));
            add_action( 'wp_ajax_fetch_jobs', array( $this,'fetch_jobs_cb' ));
        }

      public function fetch_jobs_cb(){

        global $wpdb;
        $table_name = $wpdb->prefix . 'adp_job_listings'; // Replace 'your_table_name' with the actual table name
        
        $wpdb->query("TRUNCATE TABLE $table_name");


        $jsonFile = ADP_Job_Listing_URL.'assets/data.json';

        //echo $jsonFile;
    
        // Read the JSON file
        $jsonData = file_get_contents($jsonFile);
    
        // Decode the JSON data into a PHP array
        $jobsData = json_decode($jsonData, true);
    
        $i = 0;
        foreach($jobsData['jobRequisitions'] as $jobdata){
    
            $job_id = $jobdata['job']['jobCode']['codeValue'];
            $job_title = $jobdata['job']['jobTitle'];
           
            $job_link =  $jobdata['links']['1']['href'];
            $locationCode = [];
            $locationName = [];
            $locationCity = [];
            $jobCatsArray = [];
            $jobpostdate = '';
            $jobexpiredate = '';
    
            foreach($jobdata['requisitionLocations'] as $loc){
               //print_r($loc);
                array_push($locationCode, $loc['address']['countryCode']);
                array_push($locationName, $loc['nameCode']['shortName']);
                array_push($locationCity, $loc['address']['cityName']);
                break;
            }
    
            $jobLocationCode =  implode(', ', $locationCode);
            $jobLocationName =  implode(', ', $locationName);
            $jobLocationcity =  implode(', ', $locationCity);
            
    
            foreach($jobdata['job']['occupationalClassifications'] as $jobcat){
               array_push($jobCatsArray,  $jobcat['classificationCode']['shortName']);
            }
       
            $jobCats = implode(', ', $jobCatsArray);
            foreach($jobdata['postingInstructions'] as $jobinfo){
               
                $jobpostdate = $jobinfo['postDate'];
                $jobexpiredate = $jobinfo['expireDate'];
                $job_description = $jobinfo['nameCode']['longName'];
       
            }
                
          global $wpdb;
          $table_name = $wpdb->prefix . 'adp_job_listings';
          
          $data = array(
              'created_on'        => current_time( 'mysql' ),
              'job_id'            => $job_id,
              'job_title'         => $job_title,
              'job_description'   => $job_description,
              'job_category'      => $jobCats,
              'joblocation_code'  => $jobLocationCode,
              'joblocation_name'  => $jobLocationName,
              'joblocation_cityname' => $jobLocationcity,
              'job_post_date'     => $jobpostdate,
              'job_expire_date'   => $jobexpiredate,
              'job_url'           => $job_link
          );
          
          $wpdb->insert( $table_name, $data );
         
        }
      }

    }
}