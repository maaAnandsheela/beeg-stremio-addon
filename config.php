<?php

//Manifest Config
$config['id'] = "test.beeg.com";
$config['description'] = "Watch Latest Videos From beeg.com. Now on stremio.";
$config['name'] = "beegAddon";
$config['icon'] = "https://beeg.com/img/logo/apple-touch-icon-144x144-precomposed.png";
$config['version'] = "0.0.1";

//Customs tags from beeg. To display on Home.
$tags_catalog = array(
                      "anal",
                      "beautiful",
					  "hardcore",
					  "lesbian");

//Cache Settings
define("cache_status", 1); //defaults to 1 that is enabled. 
define('cache_path', dirname(__FILE__).'/temp/'); //replace it with your path.	Dont change the directory if deploying on heroku and probably wont work on heroku.
define('cache_meta_ttl',86400); //meta of stream cache time	in s; defaults to 1 day
define('cache_catalog_ttl',3600); //catalog of tag cache time in s; defaults to 1 hour