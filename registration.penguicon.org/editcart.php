<?php
/************************************************/
/*         CONFIGURATION			*/
/************************************************/

include_once("./config.inc.php");
include_once("./common.inc.php");

//Import functions
include_once("./functions.inc.php");

//If we're submitting, we can skip all the rest.
if ($_POST['submit']) { $errors = edit_cart($db,$order); } else {


/************************************************/
/*         BUILD THE FORM			*/
/************************************************/

$title = "Edit cart - Penguicon ".CON_YEAR." Registration";
display_header_info($title);

echo "<body id='text1'>\n";

echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>\n";
//Information block

echo "<h1 class='posttitle'>Edit your cart";
echo "</h1>\n";

//List current shopping cart
$edit = 1;
list_current_cart($order,$edit);

echo "</form>\n";

display_footer_info();

} // end of else: if ($_POST['submit'])
?>
