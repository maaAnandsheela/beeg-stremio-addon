<?php
//includes
include 'beeg.php';

//Get Request Params
$catalog = getRequestParams();
setHeaders();
if (empty($catalog->extra)) {	
   $get_id = explode("_",$catalog->id);
   $get_id['2'] = strtolower($get_id['2']);
  if ($get_id['2'] == "home") {
	  echo json_encode(beeg_get_feed_home());
  }
  else {
   $cache = cache_check($get_id['2']);
   if ($cache['status']) {
	echo $cache['data'];
   }
   else {
    $data = json_encode(beeg_get_feed($get_id['2']));
	cache_create($get_id['2'],$data,cache_catalog_ttl);
	echo $data;
   }
 }
}
else {
	if ($catalog->extra->search) {		
		$key = "search_{$catalog->extra->search}";
        $cache = cache_check($key);
        if ($cache['status']) {
	      echo $cache['data'];
        }
        else {
          $data = json_encode(beeg_search($catalog->extra->search));
	      cache_create($key,$data,cache_catalog_ttl);
	      echo $data;
        }		
	}
	elseif ($catalog->extra->genre) {
		$tag = str_replace(" ","-",$catalog->extra->genre);	
		$tag = strtolower($tag);
        $cache = cache_check($tag);
        if ($cache['status']) {
	      echo $cache['data'];
        }
        else {
          $data = json_encode(beeg_get_feed($tag));
	      cache_create($tag,$data,cache_catalog_ttl);
	      echo $data;
        }
	}
	elseif ($catalog->extra->skip) {
		$get_id = explode("_",$catalog->id);
        $get_id['2'] = strtolower($get_id['2']);
        if ($get_id['2'] == "home") {
	       echo json_encode(beeg_skip_feed_home($catalog->extra->skip));
        }		
		else {
           $cache = cache_check("{$catalog->extra->skip}-{$get_id['2']}");
           if ($cache['status']) {
	        echo $cache['data'];
           }
           else {
             $data = json_encode(beeg_skip_feed($catalog->extra->skip,$get_id['2']));
	         cache_create($get_id['2'],$data,cache_catalog_ttl);
	         echo $data;
		   }
        }		
	}
	else {
		echo "null";
	}
}
?>