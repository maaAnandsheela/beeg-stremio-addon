<?php
//includes
include 'beeg.php';

//Get Request Params
$catalog = getRequestParams();
setHeaders();
$get_id = explode(":",$catalog->id);
if ($get_id['0'] == "beeg") {
  $cache_key = "meta_{$get_id['1']}";
  $cache = cache_check($cache_key);
  if ($cache['status']) {
	echo $cache['data'];
  }
  else {
	$fin = beeg_get_info_id($get_id['1']);
    $metas = generate_meta($fin);
    $meta_final['meta'] = $metas;
	$data = json_encode($meta_final,JSON_UNESCAPED_SLASHES);
	cache_create($cache_key,$data,cache_meta_ttl);
	echo $data;
  }
}
else
	echo "null";

?>