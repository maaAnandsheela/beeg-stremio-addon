<?php
//includes
include 'beeg.php';

//Get Request Params
$catalog = getRequestParams();
setHeaders();

$get_id = explode(":",$catalog->id);
if ($get_id['0'] == "beeg") {
    $fin = beeg_get_info_id($get_id['1']);
    echo json_encode(generate_stream($fin),JSON_UNESCAPED_SLASHES);
}
else
	echo "null";
?>