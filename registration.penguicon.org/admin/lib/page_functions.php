<?php 

function display_header() {
    display_short_header();
    display_navigation();
}

function display_navigation() {

    echo "<br>\n<br>Administrative:\n";
    echo "<br><a href='changepassword.php'>Change your password</a>\n";
    echo "<br><a href='adduser.php'>Add a user</a>\n";

    echo "<br>\n<br>Orders:\n";
    echo "<br><a href='addpayment.php'>Enter a payment</a>\n";
    echo "<br>View and edit payments\n";
    echo "<br><a href='addrefund.php'>Enter a refund given</a>\n";
    echo "<br><a href='vieworder.php'>View an order</a>\n";
    echo "<br><a href='addorder.php'>Add a new master order</a>\n";

    echo "<br>\n<br>Badges:\n";
    echo "<br><a href='addbadge.php'>Add a badge to an order</a>\n";
    echo "<br>View and edit badges\n";
    echo "<br>Search for a badge\n";

    echo "<br>\n<br>Ribbons:\n";
    echo "<br><a href='addribbon.php'>Add a ribbon to an order</a>\n";
    echo "<br>View and edit ribbons\n";
    echo "<br><a href='report_ribboncsv.php'>Create CSV to turn into spreadsheet</a>\n";

    echo "<br>\n<br>Con Prep:\n";
    echo "<br><a href='report_labelcsv.php'>Create CSV for labels</a>\n";

    echo "<br>\n<br>Reports:\n";
    echo "<br><a href='report_incomebydate.php'>Income by date</a>\n";
    echo "<br><a href='report_staffandpanelist.php'>Staff & panelists</a>\n";
    echo "<br><a href='report_totalsales.php'>Total badge sales, by type</a>\n";
    echo "<br><a href='report_unprocessedorders.php'>Unprocessed orders</a>\n";
    echo "<br><a href='report_budgetitems.php'>Ribbons paid via budget</a>\n";
    echo "<br>All ribbon orders\n";
    echo "<br><a href='report_allbadges.php'>All badges, by badge number</a>\n";
    echo "<br><a href='report_allbadges.php?by=name'>All badges, by last name</a>\n";
    echo "<br><a href='report_nonzerobalance.php'>Non-zero balances</a>\n";
    echo "<br><A href='report_refundsgiven.php'>Refunds given</a>\n";

    echo "<br>\n<br>Printing:\n";
    echo "<br>Badge layout\n";
    echo "<br>Ribbon labels\n";
    echo "<br>Badge-envelope labels\n";

}

function display_short_header() {
    echo "Logged in as ".$_SESSION['userid']."  &nbsp; &nbsp; <a href='./logout.php'>Logout</a>\n";
    echo "<p><a href='index.php'>Home</a>\n";
}

?>