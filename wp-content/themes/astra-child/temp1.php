<?php
/**
* Template Name: api test_2 Page
**/
get_header();

// Path to your JSON file
    $jsonFile = get_stylesheet_directory_uri().'/data.json';

    //echo $jsonFile;

    // Read the JSON file
    $jsonData = file_get_contents($jsonFile);

    // Decode the JSON data into a PHP array
    $jobsData = json_decode($jsonData, true);

    $i = 0;
    foreach($jobsData['jobRequisitions'] as $jobdata){

        echo "<pre>";
        var_dump($jobdata['postingInstructions']['0']['nameCode']['longName']);
        echo "</pre>";
        break;

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
   
        }
            echo "<br>";
            echo $job_id; 
            echo "<br>";
            echo $job_title;
            echo "<br>";
            echo $jobLocationCode;
            echo "<br>";
            echo $jobLocationName;
            echo "<br>";
            echo $jobLocationcity;
            echo "<br>";
            echo $jobpostdate;
            echo "<br>";
            echo $jobexpiredate;
            echo "<br>";
            echo $job_link;
            echo "<br>";
            echo "-----------------------------";

       
        //print_r($jobdata['requisitionLocations']);

        $i++;
        
    }



get_footer(); ?> 