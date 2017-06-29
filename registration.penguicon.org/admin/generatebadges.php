<?php
include_once("common.inc.php");

function print_boilerplate($location,$i,$name,$extended) {
        echo "  <div id='".$location."'>\n";
        echo "     <img class='badge' src='2017badge.jpg' />\n";
        echo "     <div id='badgenumber'>\n";
        echo "       ".$i."\n";
        echo "     </div>\n";
        echo "    <div id='badgetext'>\n";

        if (strlen($name) > 20) {
            echo "      <div class='smaller'>\n";
            echo "        ".$name."\n";
            echo "      </div>\n";

        } else {
            echo "      ".$name."\n";
        }

        if ($extended) {
            echo "      <div id='extendedtext'>\n";
            echo "         ".$extended;
            echo "      </div>\n";
        }
        echo "    </div>\n";
        echo "  </div>\n";
}

if (!is_logged_in())
{
    header('Location: login.php');
    die();
} else {

    $start = $_GET['start'];
    $end = $_GET['end'];
    if (!$start) { $start = 1; }
    if (!$end) { $end = 2100; }

    include_once("lib/database_functions.php");

    $wherestring = " WHERE badge_number >= ".$start." AND badge_number <= ".$end. " AND con_year = '".CON_YEAR."'";
    $badge_data = array();
    $extended_data = array();


    $sql = mysql_query("SELECT badge_number,badge_name,extended_badgename FROM badges".$wherestring);
    echo mysql_error();
    while ($row = mysql_fetch_array($sql)) {
        $badge_data[$row['badge_number']] = $row['badge_name'];
        $extended_data[$row['badge_number']] = $row['extended_badgename'];
    }

    echo "<html>\n\n<head>\n";
    echo "<LINK rel='stylesheet' type='text/css' href='style.css'>\n";
    echo "</head>\n";

    echo "<body>\n";

    $i = $start;
    while ($i <= $end) {

        echo "<div id='page'><p class='break'>\n";

        print_boilerplate("left-top",$i,$badge_data[$i],$extended_data[$i]);
        $i++;
        print_boilerplate("left-center",$i,$badge_data[$i],$extended_data[$i]);
        $i++;
        print_boilerplate("left-bottom",$i,$badge_data[$i],$extended_data[$i]);
        $i++;
        print_boilerplate("right-top",$i,$badge_data[$i],$extended_data[$i]);
        $i++;
        print_boilerplate("right-center",$i,$badge_data[$i],$extended_data[$i]);
        $i++;
        print_boilerplate("right-bottom",$i,$badge_data[$i],$extended_data[$i]);
        $i++;

        echo "</p></div>";

    }

    echo "</body>\n";    

}

?>
