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
$recordset0 =  mysql_query("SELECT * FROM wp_terms WHERE slug='city' LIMIT 1", $link);
while ( $row0 = mysql_fetch_array($recordset0) ) {
	$term_id = $row0['term_id'];
}
$recordset1 = mysql_query("SELECT * FROM wp_term_relationships WHERE term_taxonomy_id='".$term_id."'", $link);
while ( $row1 = mysql_fetch_array($recordset1) ) {
//	$marker_id = $row1['post_id'];
	$marker_id = $row1['object_id'];

	$recordset2 = mysql_query("SELECT * FROM wp_postmeta WHERE meta_key='_da_location' AND post_id='" .$marker_id. "'", $link);
	while ( $row2 = mysql_fetch_array($recordset2) ) {
		$point = $row2['meta_value'];
		
		$recordset3 = mysql_query("SELECT * FROM wp_posts WHERE ID='".$marker_id."' LIMIT 1", $link);
		while ( $row3 = mysql_fetch_array($recordset3) ) {
			$tit = $row3['post_title'];
			$perma = "?case=" .$row3['post_name'];
			$desc = "<a href='" .$perma. "'>See the case studies in this City</a>";
			print("$point" . "\t" . "$tit" ."\t". "$desc" ."\t". "$path" ."\t". "$dim" ."\t". "$off" . "\n");
		}

	}

}
?>
