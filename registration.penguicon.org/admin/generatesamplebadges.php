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

    $badges = array(
       233 => "left-top",
       235 => "left-center",
       469 => "left-bottom",
       402 => "right-top",
       987 => "right-center",
       986 => "right-bottom"
    );


    $badgewhere = "";
    foreach ($badges as $x => $trash) {
        if ($badgewhere) { $badgewhere .= " OR "; }
        $badgewhere .= "badge_number = '".$x."'";
    }

    include_once("lib/database_functions.php");

    $wherestring = " WHERE con_year='2015' AND (".$badgewhere.")";
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

    foreach ($badges as $i => $location) {

        print_boilerplate($location,$i,$badge_data[$i],$extended_data[$i]);

    }

    echo "</body>\n";    

}

?>
