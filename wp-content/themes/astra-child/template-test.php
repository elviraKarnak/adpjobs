<?php
/**
* Template Name: api test Page
**/
get_header();




// Path to your JSON file
    $jsonFile = get_stylesheet_directory_uri().'/data.json';

    //echo $jsonFile;

    // Read the JSON file
    $jsonData = file_get_contents($jsonFile);

    // Decode the JSON data into a PHP array
    $arrayData = json_decode($jsonData, true);

    echo "<pre>";
    // Print or use the data
    print_r($arrayData);
    echo "</pre>";



get_footer(); ?> 