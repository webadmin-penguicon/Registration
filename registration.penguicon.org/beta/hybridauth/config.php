<?php
	#AUTOGENERATED BY HYBRIDAUTH 2.2.2 INSTALLER - Wednesday 4th of February 2015 09:58:58 PM

/**
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2014, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return 
	array(
		"base_url" => "http://registration.penguicon.org/beta/hybridauth/", 

		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"AOL"  => array ( 
				"enabled" => false 
			),

			"Yahoo" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "233736105042-rjetflqvremnorrd76bg8f77ig5vehs4.apps.googleusercontent.com", "secret" => "ST8tqxhAqpiaRJNNrT3nayRZ" ),
				"scope"           => "profile",
//				"hd" 		  => "sundae.lodden.com",
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "1556608054608317", "secret" => "8e3aecfd67c186cb4c735585b7d139b3" ),
				"scope"   => "public_profile, email"
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "tN1mHAfcww49KeIkj5ya0i1Ve", "secret" => "KMAo73IH0FR3GxfXDoTlQKNehHQPH1hVmXwTznQWF7YEw1z6Xj" ) 
			),

			// windows live
			"Live" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"MySpace" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "#MYSPACE_APPLICATION_KEY#", "secret" => "#MYSPACE_APPLICATION_SECRET#" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => ""
	);