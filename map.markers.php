<?php
include "db.php";
// if db.php doesn't exist, you have to created in datlas folder and add this two following commented lines:

	// $link = mysql_connect("servername", "username", "password") or die("Cannot connect to DB!"); 
	// mysql_select_db("dbname", $link) or die("Cannot connect to DB!");

// don't forget to change servername, username, password and dbname

//print("lat" . "\t" . "lon" . "\t" . "title" . "\t" . "description" . "\t" . "icon" . "\t" . "iconSize" . "\t" . "iconOffset" . "\n");
print("point" . "\t" . "title" . "\t" . "description" . "\t" . "icon" . "\t" . "iconSize" . "\t" . "iconOffset" . "\n");

// marker icon vars
$path = "/wp-content/themes/datlas/images/da-mapmarker.png";
$dim = "13,24";
$off = "-6,-13";

// direct db query
$recordset = mysql_query("SELECT * FROM wp_postmeta WHERE meta_key='_da_location'", $link);
while ( $row = mysql_fetch_array($recordset) ) {
	$marker_id = $row['post_id'];
	$point = $row['meta_value'];
	$recordset2 = mysql_query("SELECT * FROM wp_posts WHERE ID='".$marker_id."' LIMIT 1", $link);
	while ( $row2 = mysql_fetch_array($recordset2) ) {
		$tit = $row2['post_title'];
		$perma = "?case=" .$row2['post_name'];
		$desc = "<a href='" .$perma. "'>See this case study</a>";
		print("$point" . "\t" . "$tit" ."\t". "$desc" ."\t". "$path" ."\t". "$dim" ."\t". "$off" . "\n");
	}
}
?>
