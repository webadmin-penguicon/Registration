<?php

date_default_timezone_set('America/Detroit');

include_once("config-db.inc.php");

//Current year info
$con_year = 2017;

//When the form sends email, who should it say the email is from?
$email_from = "registration@penguicon.org";

//When the form emails badge submissions, who should it send the email to?
$badge_email_to = "alrobins@gmail.com";

//Important dates.  All dates should be in YYYY-MM-DD format
$con_start = "2017-04-28";
$con_end = "2017-04-30";
$badge_prereg_closes = "2017-04-03";

//Set costs.
$at_door_badge_cost = 50.00;
$badge_cutoff_dates = array(
  "2016-05-02" => 35.00,
  "2017-04-02" => 40.00,
);

//"Weekend" doesn't matter and is set very high for debugging.  "
//Never set it lower than the highest pre-reg price, as it
//will be automatically adjusted based on $badge_cutoff_dates.

//Don't remove the staff, concom, and panelist entries.
//You can disable them being shown in forms below.
$badge_cost = array(
  'weekend' => 60.00,
  'teen' => 40.00,
  'kid' => 0.00,
  'friday' => 30.00,
  'saturday' => 40.00,
  'sunday' => 20.00,
  'staff' => 25.00,
  'concom' => 35.00,
  'panelist' => 30.00,
);

//Can you buy Staff, Concom, and Panelist badges at reduced rates through this form?  
// 1 for yes, 0 for no
$special_badges_available = 1;

//We need a warning for people buying the special badges.
//Even if you set $special_badges_available to 0 above, please
//leave $warning set to something sane.
$warning = "";
$warning .= "<p><font color='red'>\n";
$warning .= "<b>Warning:</b> Staff, Concom, and Panelists <i>must</i> be ";
$warning .= "confirmed in order to receive the special rates.  ";
$warning .= "If you purchase one of these badges but do not qualify for it, ";
$warning .= "you will be charged full price ";
$warning .= "(minus what you have already paid) at the door-- NO EXCEPTIONS.  ";
$warning .= "It is your responsibility to make sure that ";
$warning .= "your name is on the appropriate Staff/Concom/Panelist lists to receive the discount.";
$warning .= "</font></p>\n";

//Can you purchase ribbons via this form? 
// 1 for yes, 0 for no
$ribbons_available = 1;

//Keep these variables set to something, even if you've disabled ribbon ordering
$ribbon_prereg_closes = "2017-03-02";
$ribbon_setup_fee = 4;
$ribbon_per_item_fee = 0.16;
$premium_ribbon_per_item_fee = 0.18;
$ribbon_email_to = "ribbons@penguicon.org";
$ribbon_vendor_link = "http://www.rvawardsaz.com/color.htm";
$ribbon_character_limit = 25;

$ribbon_qty_discount_setup = array (
  50 => 3.00,
);

$ribbon_font_choices = array (
  "arial" => "Arial",
  "comic-sans" => "Comic Sans",
  "courier" => "Courier",
  "destine" => "Destine",
  "jokerman" => "Jokerman",
  "park-ave" => "Park Avenue",
  "times-nr" => "Times New Roman",
  "trebuchet" => "Trebuchet",
);

//Chances are, these won't change much from year to year.
$special_badge_name_and_info = array (
  'staff' => "Staff rate (See warning)",
  'concom' => "Con-com rate (See warning)",
  'panelist' => "Panelist rate (See warning)",
);

$badge_name_and_info = array(
  'weekend' => "Weekend (Adult)",
//  'teen' => "Weekend (Teen 13+)",
  'kid' => "Weekend (Child 0 - 12)",
//  'saturday' => "Saturday-Only (Adult or Teen)",
//  'sunday' => "Sunday-Only (Adult or Teen)",
);

$ribbon_color = array (

   "Additional #6" => "black",
   "Horse Show #8, Fair #13" => "brown",
   "Horse Show #6, Fair #8, Athletic #5" => "emerald",
   "Additional #9" => "forest green",
   "Horse/Dog Show #3" => "gold",
   "Horse Show #9, Fair #11" => "gray",
   "Fair #2" => "lavendar",
   "Horse Show #10, Fair #12" => "light blue",
   "Fair #9, Additional #4" => "light green",
   "Additional #3" => "light yellow",
   "Additional #8" => "maroon",
   "Additional #2" => "medium blue",
   "Additional #10" => "old gold",
   "Additional #13" => "orange",
   "Horse Show #5, Fair #6, Ahtletic #6" => "pink",
   "Horse Show #7, Fair #1" => "purple",
   "Horse/Dog Show/Athletic #2, Fair #4" => "red",
   "AKC #1" => "rose",
   "Horse/Dog Show/Athletic #1, Fair #3" => "royal blue",
   "Fair #10, Additional #5" => "tan",
   "Additional #7" => "teal",
   "Additional #1" => "turquoise",
   "Horse/Dog Show #4, Fair #5, Athletic #3" => "white",
   "Fair #7, Athletic #4" => "yellow",

);

$premium_ribbon_color = array (

    "Hot brite #1" => "hot green",
    "Hot brite #4" => "hot light green",
    "Hot brite #2" => "hot orange",
    "Hot brite #2" => "hot pink",
    "Hot brite #3" => "hot yellow",
    "Additional #12" => "pastel rainbow",
    "Additional #11" => "rainbow",

);

$ribbon_text = array (
    "black",
    "blue",
    "copper",
    "gold",
    "green",
    "rainbow",
    "red",
    "silver",
);

?>
