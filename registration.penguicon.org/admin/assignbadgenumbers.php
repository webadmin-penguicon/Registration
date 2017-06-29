<?php
include_once("common.inc.php");

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {
    display_short_header();

    function find_next_badge_number ($x,$in_use=array()) {
      if ($in_use[$x] == 1) {
          $x = find_next_badge_number($x+1,$in_use);
      }
      return $x;
    }

/* What's my logic here? */

/* I like them ordered by price.  */
/* With a buffer of 50 "oh shit" badges */

/*
So, find all the badges that:
$0.00 price
dealer
staff
concom
featured
panelist
goh
%volunteer%
comped


... wait.  first find all the numbers that are taken.
*/

    $in_use = array();
    $sql = "SELECT badge_number FROM badges WHERE con_year='".CON_YEAR."'";
    $sql .= " AND (badge_number !=0 OR badge_number IS NOT NULL)";
    $temp = mysql_query($sql);
    while ($row = mysql_fetch_array($temp)) {
        $in_use[$row['badge_number']] = 1;
    }

/* NOW figure out where to start */

    $no_refund = array(
       "concom",
       "staff",
    );

    $wherestring = "";
    foreach ($no_refund as $type) {
        if ($wherestring) {
            $wherestring .= " OR ";
        }
        $wherestring .= " type='".$type."'";
    }

    $badgenum = 0;
    $sql = "SELECT id,type FROM badges WHERE con_year='".CON_YEAR."' AND badge_number IS NULL";
    $sql .= " AND (cost='0.00' OR ".$wherestring.")";
    $temp = mysql_query($sql);
    while ($row = mysql_fetch_array($temp)) {

        $badgenum = find_next_badge_number($badgenum+1,$in_use);
        $sql = "UPDATE badges SET badge_number='";
        $sql .= $badgenum;
        $sql .= "' WHERE id = ".$row['id'];

        mysql_query($sql);
    }

    //Add an "oh shit" buffer
    $buffer = 50;
    for ($y = 0; $y < $buffer; $y++) {
        $badgenum = find_next_badge_number($badgenum+1,$in_use);
        $sql = "UPDATE badges SET badge_number='";
        $sql .= $badgenum;
        $sql .= "' WHERE id = ".$row['id'];

        mysql_query($sql);
    }

    //Panelists are wonky and can change prices at the last second.
    $sql = "SELECT id,type FROM badges WHERE con_year='".CON_YEAR."' AND badge_number IS NULL";
    $sql .= " AND has_panels=1";
    $temp = mysql_query($sql);
    while ($row = mysql_fetch_array($temp)) {

        $badgenum = find_next_badge_number($badgenum+1,$in_use);
        $sql = "UPDATE badges SET badge_number='";
        $sql .= $badgenum;
        $sql .= "' WHERE id = ".$row['id'];

        mysql_query($sql);
    }

    //Add an "oh shit" buffer
    $buffer = 25;
    for ($y = 0; $y < $buffer; $y++) {
        $badgenum = find_next_badge_number($badgenum+1,$in_use);
        $sql = "UPDATE badges SET badge_number='";
        $sql .= $badgenum;
        $sql .= "' WHERE id = ".$row['id'];

        mysql_query($sql);
    }


    //Order the rest by price
    $sql = "SELECT id,type FROM badges WHERE con_year='".CON_YEAR."' AND badge_number IS NULL";
    $sql .= " ORDER BY cost ASC";
    $temp = mysql_query($sql);
    while ($row = mysql_fetch_array($temp)) {

        $badgenum = find_next_badge_number($badgenum+1,$in_use);
        $sql = "UPDATE badges SET badge_number='";
        $sql .= $badgenum;
        $sql .= "' WHERE id = ".$row['id'];

        mysql_query($sql);
    }

    echo "<p>Finished assigning badge numbers.";

}

?>
