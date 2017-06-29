<?php 

function hybrid_login($provider) {

	 $hybrid_user = new Hybrid_Auth(HYBRID_CONFIG);
	 $hybrid_connection = $hybrid_user->authenticate($provider);

	 if ($hybrid_connection->isUserConnected()) {
	     $user_profile = $hybrid_connection->getUserProfile();
             $_SESSION['pcon_registration'] = 1;
             $_SESSION['auth_provider'] = $provider;
             $_SESSION['userid'] = $user_profile->displayName;
             $_SESSION['emailVerified'] = $user_profile->emailVerified;
             $_SESSION['email'] = $user_profile->email;
             $_SESSION['firstName'] = $user_profile->firstName;
             $_SESSION['lastName'] = $user_profile->lastName;
             $_SESSION['just_logged_in'] = 1;
	 }
}

function is_logged_in()
{
    if(isset($_SESSION['pcon_registration']) && $_SESSION['pcon_registration']) {
        return true;
    } else {
        return false;
    }
}


function logout()
{
    $_SESSION = array(); //destroy all of the session variables
    session_destroy();
}

?>
