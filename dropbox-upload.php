
<?php

ini_set("display_errors",1);

$api_url = 'https://content.dropboxapi.com/2/files/upload'; //dropbox api url

$token = 'fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; 

$headers = array('Authorization: Bearer ' . $token,
    'Content-Type: application/octet-stream',
    'Dropbox-API-Arg: ' .
    json_encode(
            array(
                "path" => '/' . basename('image/1st.jpg'),
                "mode" => "add",
                "autorename" => true,
                "mute" => false
            )
    ),
    'Content-Type: application/octet-stream'
);

$ch = curl_init($api_url);

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);

$path = 'images/1st.jpg';

$fp = fopen($path, 'rb');
$filesize = filesize($path);

curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $filesize));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, 1); // debug

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo "<pre>response === "; print_r($response); echo "</pre>";
echo "<pre>http_code === "; print_r($http_code); echo "</pre>";


?>