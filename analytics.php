<?php

// Load the Google API PHP Client Library.
require_once ( 'google-api-php-client-2.2.2/vendor/autoload.php');

$analytics = initializeAnalytics();
$result1 = getViews($analytics);
$result2 = getVisitors($analytics);
$result3 = getCountry($analytics);
$result4 = getDuration($analytics);

$views=null;
$visitors=null;
$country=null;

printResult1("views",$result1);
printResult1("visitors",$result2);
printResult1("country",$result3);
printResult1("avg",$result4);


function initializeAnalytics()
{
  // Creates and returns the Analytics Reporting service object.

  // Use the developers console and download your service account
  // credentials in JSON format. Place them in this directory or
  // change the key file location if necessary.
  $KEY_FILE_LOCATION = 'portfolio.json';

  // Create and configure a new client object.
  $client = new Google_Client();
  $client->setApplicationName("Hello Analytics Reporting");
  $client->setAuthConfig($KEY_FILE_LOCATION);
  $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
  $analytics = new Google_Service_Analytics($client);

  return $analytics;
}



function getViews($analytics) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
   return $analytics->data_ga->get(
       'ga:181440461',
       '7daysAgo',
       'today',
       'ga:pageviews,ga:adClicks');
}

function getVisitors($analytics) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
   return $analytics->data_ga->get(
       'ga:181440461',
       '7daysAgo',
       'today',
       'ga:sessions');
}

function getCountry($analytics) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
  $params = array('dimensions' => 'ga:country','max-results'=>'3');

   return $analytics->data_ga->get(
       'ga:181440461',
       '7daysAgo',
       'today',
       'ga:users',$params);
}

function getDuration($analytics) {
  // Calls the Core Reporting API and queries for the number of sessions
  // for the last seven days.
   return $analytics->data_ga->get(
       'ga:181440461',
       '7daysAgo',
       'today',
       'ga:avgTimeOnPage');
}


function printResult1($string,$results) {
  // Parses the response from the Core Reporting API and prints
  // the profile name and total sessions.
  if (count($results->getRows()) > 0) {


    // Get the entry for the first entry in the first row.
    $rows = $results->getRows();
  $GLOBALS[$string]  = $rows[0][0]. ' ';

    // Print the results.
  } else {
    print "No results found.\n";
  }
}
