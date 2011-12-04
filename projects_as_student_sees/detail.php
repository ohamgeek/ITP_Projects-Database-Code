<?php
if (isset($_REQUEST['projectid'])) {
	$projectid = $_REQUEST['projectid'];
// read in text from template file as a string
require 'info.php';

$html_from_template = file_get_contents('project_detail.html');
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

$info_url = $serving_scripts_location."get_project_detail.php?projectid=$projectid";

$project_details = json_decode(file_get_contents($info_url));

		$title = $project_details[0][1];
		$visual = "https://itp.nyu.edu/projects_documents/".$projects[0][5];
		$abstract = $project_details[0][2];
		$description = $project_details[0][3];
		$url = $project_details[0][4];
		//$venue = "Infinity... and beyond!";
		//$class = "Class... what? Is this a school project?";
		
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
$pattern[13] = '/\\{\\:\s*title\s*\\:\\}/i';
$pattern[14] = '/\\{\\:\s*abstract\s*\\:\\}/i';
$pattern[15] = '/\\{\\:\s*description\s*\\:\\}/i';
$pattern[16] = '/\\{\\:\s*url\s*\\:\\}/i';
$pattern[17] = '/\\{\\:\s*visual\s*\\:\\}/i';
$pattern[18] = '/\\{\\:\s*linktodetail\s*\\:\\}/i';
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
$replacement[13] = $title;
$replacement[14] = $abstract;
$replacement[15] = $description;
$replacement[16] = $url;
$replacement[17] = $visual;
$replacement[18] = $linktodetail;

ksort($pattern);
ksort($replacement);

$html_for_display = preg_replace($pattern, $replacement, $html_from_template);

// print out contents of text file
echo $html_for_display;
} else {
	echo "Sorry. We could not find that project.";
}



?>