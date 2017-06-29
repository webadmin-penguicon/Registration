<?php
/************************************************/
/*         CONFIGURATION			*/
/************************************************/

include_once("./config.inc.php");
include_once("./common.inc.php");

/************************************************/
/*         BUILD THE CART			*/
/************************************************/

//Import functions
include_once("./functions.inc.php");

//If we're submitting, we can skip all the rest.
if ($_POST['submit']) { add_to_cart($db,$order,$badge_cost,$badge_name_and_info,$special_badge_name_and_info); } else {


/************************************************/
/*         BUILD THE FORM			*/
/************************************************/

$title="Penguicon ".CON_YEAR." Registration";
display_header_info($title);

echo "<body id='text1'>\n";

echo "<p><a href='http://registration.penguicon.org' target='_blank'>On a mobile device or having trouble scrolling?</a></p>";

echo "<h1 class='posttitle'>Penguicon 2017 Registration";
if (RIBBONS_AVAILABLE) { echo " and Ribbon Ordering"; }
echo "</h1>\n";

echo "<h2>April 28 - April 30, 2017 at the Southfield Westin</h2>";

//echo "<h1 class='error'>This website is for <b>2017</b> pre-registrations.</h1>";
//echo "<p class='error'>If you order a badge here and then try to pick it up at registration during the 2016 con, registration will laugh at you and tell you to buy a badge for the right year.  No exceptions!";

//List current shopping cart
list_current_cart($order);

//Information block

echo "<p class='clear'></p>";

display_info_block($badge_types,$badge_cost);

echo "</body>\n";
echo "</html>\n";
} // end of else: if ($_POST['submit'])
?>
