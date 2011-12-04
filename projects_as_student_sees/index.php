<?php

// read in text from template file as a string
require 'info.php';

$html_from_template = file_get_contents('portfolio.html');
$user_preferences = json_decode(file_get_contents('preferences.txt'));

$username = $user_preferences->{'name'};
$netid = $user_preferences->{'netid'};
$facebook = $user_preferences->{'facebook'};
$blog = $user_preferences->{'blog'};
$twitter = $user_preferences->{'twitter'};
$googleplus = $user_preferences->{'googleplus'};
$flickr = $user_preferences->{'flickr'};
$soundcloud = $user_preferences->{'soundcloud'};
$vimeo = $user_preferences->{'vimeo'};
$youtube = $user_preferences->{'youtube'};
$linkedin  = $user_preferences->{'linkedin'};
$gdgt  = $user_preferences->{'gdgt'};
$github  = $user_preferences->{'github'};


$projectpattern = '/\\{\\:\s*startproject\s*\\:\\}.*?\\{\\:\s*endproject\s*\\:\\}/si';

$num_matches = preg_match($projectpattern,$html_from_template,$matches);

$projects_replacement_code = "";

$info_url = $serving_scripts_location."get_basic_portfolio.php?netid=$netid";

$projects = json_decode(file_get_contents($info_url));

if (count($projects>0)) {
	$num_projects = count($projects);
	for ($i=0;$i<$num_projects;$i++) { // this should be length of an array, corresponding to projects in database
		$linktodetail = "detail.php?projectid=".$projects[$i][0];
		$title = $projects[$i][1];
		$visual = "https://itp.nyu.edu/projects_documents/".$projects[$i][5];
		$abstract = $projects[$i][2];
		$description = $projects[$i][3];
		$url = $projects[$i][4];
		//$venue = "Infinity... and beyond!";
		//$class = "Class... what? Is this a school project?";
		
		$pattern = array();
		$pattern[0] = '/\\{\\:\s*title\s*\\:\\}/i';
		$pattern[1] = '/\\{\\:\s*name\s*\\:\\}/i';
		$pattern[2] = '/\\{\\:\s*abstract\s*\\:\\}/i';
		$pattern[3] = '/\\{\\:\s*description\s*\\:\\}/i';
		$pattern[4] = '/\\{\\:\s*url\s*\\:\\}/i';
		$pattern[5] = '/\\{\\:\s*visual\s*\\:\\}/i';
		$pattern[6] = '/\\{\\:\s*linktodetail\s*\\:\\}/i';
		//$pattern[6] = '/\\{\\:\s*venue\s*\\:\\}/i';
		//$pattern[7] = '/\\{\\:\s*class\s*\\:\\}/i';
		$replacement = array();
		$replacement[0] = $title;
		$replacement[1] = $username;
		$replacement[2] = $abstract;
		$replacement[3] = $description;
		$replacement[4] = $url;
		$replacement[5] = $visual;
		$replacement[6] = $linktodetail;
		//$replacement[6] = $venue;
		//$replacement[7] = $class;
		
		ksort($pattern);
		ksort($replacement);
		
		$projects_replacement_code .= preg_replace($pattern, $replacement, $matches[0]);
	}

}
$projects_replacement_code = preg_replace('/\\{\\:\s*startproject\s*\\:\\}/i','',$projects_replacement_code);
$projects_replacement_code = preg_replace('/\\{\\:\s*endproject\s*\\:\\}/i','',$projects_replacement_code);

// temporary variables to hold information
// eventually draw from database

$pattern = array();
$pattern[0] = '/\\{\\:\s*startproject\s*\\:\\}.*?\\{\\:\s*endproject\s*\\:\\}/si';
$pattern[1] = '/\\{\\:\s*name\s*\\:\\}/i';
$pattern[2] = '/\\{\\:\s*facebook\s*\\:\\}/i';
$pattern[3] = '/\\{\\:\s*blog\s*\\:\\}/i';
$pattern[4] = '/\\{\\:\s*twitter\s*\\:\\}/i';
$pattern[5] = '/\\{\\:\s*googleplus\s*\\:\\}/i';
$pattern[6] = '/\\{\\:\s*flickr\s*\\:\\}/i';
$pattern[7] = '/\\{\\:\s*soundcloud\s*\\:\\}/i';
$pattern[8] = '/\\{\\:\s*vimeo\s*\\:\\}/i';
$pattern[9] = '/\\{\\:\s*youtube\s*\\:\\}/i';
$pattern[10] = '/\\{\\:\s*linkedin\s*\\:\\}/i';
$pattern[11] = '/\\{\\:\s*gdgt\s*\\:\\}/i';
$pattern[12] = '/\\{\\:\s*github\s*\\:\\}/i';

$replacement = array();
$replacement[0] = $projects_replacement_code;
$replacement[1] = $username;
$replacement[2] = $facebook;
$replacement[3] = $blog;
$replacement[4] = $twitter;
$replacement[5] = $googleplus;
$replacement[6] = $flickr;
$replacement[7] = $soundcloud;
$replacement[8] = $vimeo;
$replacement[9] = $youtube;
$replacement[10] = $linkedin;
$replacement[11] = $gdgt;
$replacement[12] = $github;

ksort($pattern);
ksort($replacement);

$html_for_display = preg_replace($pattern, $replacement, $html_from_template);

// print out contents of text file
echo $html_for_display;




?>