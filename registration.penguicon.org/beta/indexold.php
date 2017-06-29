<?php


session_start();
require_once('./config.inc.php');

$ha = new Hybrid_Auth($config);

$t = $ha->authenticate('Twitter');
$user_profile = $t->getUserProfile();

echo "Ohai there! U are connected with: <b>{$t->id}</b><br />"; 

echo "<pre>\n";
print_r( $user_profile );
echo "</pre>\n";

$account_settings = $t->api()->get( 'account/settings.json' );
 
echo "Your account settings on Twitter: " . print_r( $account_settings, true );
?>

<p>The part where Amanda types at herself:
<br />
So, that's cool and all, but what I'd rather have is a static page, and then
a bit at the top/bottom/side/whatever that says "Login with: Twitter, Google, Facebook, etc"

It looks like I can make the class be a little more generic, to make that easier.

Also, logging in with Twitter replaces the page icon with the twitter bird.  I'd like that to not happen, or to be over-ridden with our icon or something.


