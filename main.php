<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
// API 엔드포인트 URL
$api_url = 'http://www.kopis.or.kr/openApi/restful/pblprfr';

// 필수 및 선택적 매개변수 설정
$service_key = 'a875cf23b1ac4fdebe91b2ab2478c821';
$stdate = '20230501';
$eddate = '202301230';
$rows = 10;
$cpage = 1;
$shcate  = 'GGGA';

// cURL 초기화
$ch = curl_init();

// cURL 옵션 설정
$query_string = http_build_query([
    'service' => $service_key,
    'stdate' => $stdate,
    'eddate' => $eddate,
    'rows' => $rows,
    'cpage' => $cpage,
    'shcate' => $shcate
]);

$final_url = $api_url . '?' . $query_string;

curl_setopt($ch, CURLOPT_URL, $final_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// API 호출 및 응답 얻기
$response = curl_exec($ch);

// cURL 리소스 해제
curl_close($ch);

// // API 응답 확인
// if ($response === false) {
//     die('cURL 오류: ' . curl_error($ch));
// }

// API 응답을 JSON 또는 XML 등으로 파싱하여 사용할 수 있습니다.
// 여기에 응답 처리 코드를 추가하세요.

// // API 호출 및 응답 얻기
// $response = curl_exec($ch);

// // cURL 리소스 해제
// curl_close($ch);

// // API 응답 확인
// if ($response === false) {
//     die('cURL 오류: ' . curl_error($ch));
// }

// // API 응답을 SimpleXML로 파싱
// $xml = simplexml_load_string($response);

// // "dbs-db-prfnm" 정보 출력
// foreach ($xml->dbs_db_prfnm as $dbs_db_prfnm) {
//     echo "공연명: " . (string)$dbs_db_prfnm . "<br>";
// }

// // 예제로 응답을 출력
// echo $response ; 

echo "hi";

// $object = simplexml_load_string($response);
// $dbs = $object->dbs->db;
// var_dump($dbs);

// foreach ($dbs as $db) {
// 	echo($db->prfnm)."<br>";
//     echo($db->fcltynm)."<br>"."<br>";
//     }

// API 응답을 SimpleXML로 파싱
$xml = simplexml_load_string($response);

// "db" 요소 내의 정보 파싱
foreach ($xml->db as $db) {
    $mt20id = (string)$db->mt20id;
    $prfnm = (string)$db->prfnm;
    $prfpdfrom = (string)$db->prfpdfrom;
    $prfpdto = (string)$db->prfpdto;
    $fcltynm = (string)$db->fcltynm;
    $poster = (string)$db->poster;
    $genrenm = (string)$db->genrenm;
    $prfstate = (string)$db->prfstate;
    $openrun = (string)$db->openrun;

    echo "mt20id: $mt20id<br>";
    echo "prfnm: $prfnm<br>";
    echo "prfpdfrom: $prfpdfrom<br>";
    echo "prfpdto: $prfpdto<br>";
    echo "fcltynm: $fcltynm<br>";
    echo "poster: $poster<br>";
    echo "genrenm: $genrenm<br>";
    echo "prfstate: $prfstate<br>";
    echo "openrun: $openrun<br>";
    echo "<br>";
}

?>


</body>
</html>