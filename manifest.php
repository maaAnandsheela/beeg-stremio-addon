<?php
//includes
include 'config.php';
include 'beeg.php';

// enable CORS and set JSON Content-Type
setHeaders();

//Manifest Begin
$manifest = new stdClass();
$manifest->id = $config['id'];
$manifest->version = $config['version'];
$manifest->name = $config['name'];
$manifest->description = $config['description'];
$manifest->icon = $config['icon'];
$manifest->resources = array("catalog", "meta", "stream");
$manifest->types = array("movie");
$manifest->idPrefixes = array("beeg");

// define catalog
$catalog[0]['type'] = "movie";
$catalog[0]['name'] = "Beeg:Home";
$catalog[0]['id'] = "beeg_addon_home";
$catalog[0]['extraSupported'] = array("search","genre","skip");
$catalog[0]['genres'] = beeg_get_tags();

$i=1;
foreach ($tags_catalog as $t) {
	$catalog[$i]['type'] = "movie";
	$catalog[$i]['name'] = "Beeg:{$t}";
	$catalog[$i]['id'] = "beeg_addon_{$t}";
	$catalog[$i]['extraSupported'] = array("skip");
	$i++;
}

// set catalogs in manifest
$manifest->catalogs = $catalog;

//Final JSON
echo json_encode((array)$manifest);

?>