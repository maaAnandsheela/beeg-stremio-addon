<?php
//includes 
include 'helpers.php';

define("beeg_base_url", "https://beeg.com/");
define("beeg_version", "1546225636701"); //Needs dynamic only for stream not for api calls.

function beeg_get_feed_home() {
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/index/main/0/pc");
	$data = json_decode($data,true);	
	

	for ($i =0; $i < 65;$i++) {
		//id
		$final[$i]['id'] = "beeg:{$data['videos'][$i]['svid']}";
		
		//images
	    $final[$i]['poster'] = img_to_base64($data['videos'][$i]['svid'],$data['videos'][$i]['thumbs']['0']['image']);

		//name
		$final[$i]['name'] = $data['videos'][$i]['title'];
		
	    $metas['metas'][] = generate_meta($final[$i]);
	}
	return $metas;
}

function beeg_get_feed($tag) {
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/index/tag/0/pc?tag={$tag}");
	$data = json_decode($data,true);	
	
	$i = 0;
	$size = sizeof($data['videos']) ;
	if ($size > 65) 
		$f =65;
	else
		$f = $size -1;
	for ($i =0; $i < $f;$i++) {
		//id
		$final[$i]['id'] = "beeg:{$data['videos'][$i]['svid']}";
		
		//images
	    $final[$i]['poster'] = img_to_base64($data['videos'][$i]['svid'],$data['videos'][$i]['thumbs']['0']['image']);

		//name
		$final[$i]['name'] = $data['videos'][$i]['title'];
		
	    $metas['metas'][] = generate_meta($final[$i]);
	}
	return $metas;
}

function beeg_get_info_id($id) {
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/video/{$id}?v=2");
	$data = json_decode($data,true);
	
	//vid_links
	$final['vid_240']  = str_replace("{DATA_MARKERS}","data=pc_XX__".beeg_version."_0",$data['240p']); 
	$final['vid_240'] = "https:{$final['vid_240']}";
	$final['vid_480']  = str_replace("{DATA_MARKERS}","data=pc_XX__".beeg_version."_0",$data['480p']);
	$final['vid_480'] = "https:{$final['vid_480']}";
	$final['vid_720']  = str_replace("{DATA_MARKERS}","data=pc_XX__".beeg_version."_0",$data['720p']);
	$final['vid_720'] = "https:{$final['vid_720']}";
	
	//images only one size to reduce bandwidth on server because they will be served in base64. Due to referrer problem in beeg.com
	$final['img'] = img_to_base64($id,NULL);
	$final['poster'] = img_to_base64($id,NULL);
	
	//title and description
	$final['name'] = $data['title'];
	$final['description'] = $data['desc'];
	
	//id
	$final['id'] = "beeg:{$id}";
	
	//cast
	$final['cast'] = explode(",",$data['cast']);
	
	//duration
	$data['duration'] = $data['duration']/60;
    $final['runtime'] = "{$data['duration']} min";
	
	return $final;
}

function beeg_search_results_parse($type,$query) {
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/index/{$type}/0/pc?{$type}={$query}");
	$data = json_decode($data,true);	
	
	$i = 0;
	
	foreach ($data['videos'] as $d) {
		//id
		$final[$i]['id'] = "beeg:{$d['svid']}";
		
		//images
	    $final[$i]['poster'] = img_to_base64($data['videos'][$i]['svid'],$data['videos'][$i]['thumbs']['0']['image']);
		
		//name
		$final[$i]['name'] = $d['title'];
		
	    $metas[] = generate_meta($final[$i]);
		$i++;
	}
	return $metas;	
	
}

function beeg_search($query) {
	$query = urlencode($query);
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/suggest?q={$query}");
	$data = json_decode($data,true);
		$k = 0;	
	foreach ($data['items'] as $d) {
		$meta = beeg_search_results_parse($d['type'],$d['code']);
		for ($j=0; $j<3 ; $j++) {
			$c = $j + $k ;
			$metas['metas'][$c] = $meta[$j];			
		}
		$k = $k +3 ;
	}
	return $metas;
}

function beeg_skip_feed($quant,$tag) {
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/index/tag/0/pc?tag={$tag}");
	$data = json_decode($data,true);	
	
	$size = sizeof($data['videos']) ;
	if ($size > $quant) {
	$f = $quant + 50;
	
	for ($i =$quant; $i < $f;$i++) {
		//id
		$final[$i]['id'] = "beeg:{$data['videos'][$i]['svid']}";
		
		//images
	    $final[$i]['poster'] = img_to_base64($data['videos'][$i]['svid'],$data['videos'][$i]['thumbs']['0']['image']);

		//name
		$final[$i]['name'] = $data['videos'][$i]['title'];
		
	    $metas['metas'][] = generate_meta($final[$i]);
	}
	}
	else {
		$metas['metas'] =array();
	}
	return $metas;	
}

function beeg_skip_feed_home($quant) {
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/index/main/0/pc");
	$data = json_decode($data,true);	
	
	$size = sizeof($data['videos']) ;
	if ($size > $quant) {
	$f = $quant + 50;
	
	for ($i =$quant; $i < $f;$i++) {
		//id
		$final[$i]['id'] = "beeg:{$data['videos'][$i]['svid']}";
		
		//images
	    $final[$i]['poster'] = img_to_base64($data['videos'][$i]['svid'],$data['videos'][$i]['thumbs']['0']['image']);

		//name
		$final[$i]['name'] = $data['videos'][$i]['title'];
		
	    $metas['metas'][] = generate_meta($final[$i]);
	}
	}
	else {
		$metas['metas'] =array();
	}
	return $metas;	
}

function img_to_base64($id,$image) {
   $key = "img-{$id}";
   $cache = cache_check($key);
   if ($cache['status']) {
	$f = $cache['data'];
   }
   else {
    $data = file_get_contents("https://img.beeg.com/264x198/{$image}");
    $data = base64_encode($data);
    $f = "data:image/jpeg;base64,{$data}";
	cache_create($key,$f,cache_catalog_ttl);
   }
   return $f;
}

function beeg_get_tags() {
	$data = file_get_contents(beeg_base_url."api/v6/".beeg_version."/index/main/0/pc");
	$data = json_decode($data,true);	
	
    foreach ($data['tags'] as $t) {
          $ta[] = $t['tag'];
    }	
	return $ta;
}