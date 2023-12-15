<!-- musicals table에 api 정보 불러와서 저장 -->
<!-- 주기적으로 호출 후 DB테이블 업뎃 -->
<?php

// 데이터베이스 연결
require_once("dbconfig.php");

// API 엔드포인트 URL
$api_url = 'http://www.kopis.or.kr/openApi/restful/pblprfr';

// 필수 및 선택적 매개변수 설정
$service_key = 'a875cf23b1ac4fdebe91b2ab2478c821';
$stdate = date('Ymd');
$eddate = date('Ymd', strtotime('+1 year'));
$rows = 30;
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
//여기까지

// XML 데이터를 SimpleXML로 파싱
$xml = simplexml_load_string($response);

foreach ($xml->db as $db) {
    $mt20id = (string)$db->mt20id;
    echo "영화 아이디: $mt20id<br>";
    echo "<br>";


//$response파싱후
// Open API URL 및 서비스 키
$api_url2 = 'http://www.kopis.or.kr/openApi/restful/pblprfr/' . $mt20id . '?service=a875cf23b1ac4fdebe91b2ab2478c821';

// cURL을 사용하여 API에서 데이터 가져오기
$ch2 = curl_init($api_url2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
$response2 = curl_exec($ch2);
curl_close($ch2);

echo $response2;
if ($response2 !== false) {
    $data2 = simplexml_load_string($response2);

    $prfnm = $data2->xpath('//prfnm'); // 공연명
$prfnm = (string)$prfnm[0];

$prfpdfrom = $data2->xpath('//prfpdfrom'); // 시작
$prfpdfrom = (string)$prfpdfrom[0];

$prfpdto = $data2->xpath('//prfpdto'); // 종료
$prfpdto = (string)$prfpdto[0];

$fcltynm = $data2->xpath('//fcltynm'); // 공연장
$fcltynm = (string)$fcltynm[0];

$prfcast = $data2->xpath('//prfcast'); // 출연
$prfcast = (string)$prfcast[0];

$prfruntime = $data2->xpath('//prfruntime'); // 런타임
$prfruntime = (string)$prfruntime[0];

$prfage = $data2->xpath('//prfage'); // 연령
$prfage = (string)$prfage[0];

$pcseguidance = $data2->xpath('//pcseguidance'); // 가격
$pcseguidance = (string)$pcseguidance[0];

$poster = $data2->xpath('//poster'); // 포스터
$poster = (string)$poster[0];

$sty = $data2->xpath('//sty'); // 줄거리
$sty = (string)$sty[0];

$prfstate = $data2->xpath('//prfstate'); // 상태
$prfstate = (string)$prfstate[0];

    // 데이터베이스에 데이터 삽입
    $sql = "INSERT INTO musicals 
            (musicalId, musicalName, openDate, closeDate, theaterName, actors, runningTime, age, price, poster, musicalInfo, musicalState) 
            VALUES 
            ('$mt20id', '$prfnm', '$prfpdfrom', '$prfpdto', '$fcltynm', '$prfcast', '$prfruntime', '$prfage', '$pcseguidance', '$poster', '$sty', '$prfstate')";
    $result=$conn->query($sql);
    if ($result === TRUE) {
        echo "Data inserted successfully for $prfnm.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No data found for mt20id: $mt20id.";
}
}
// 데이터베이스 연결 종료
$conn->close();

?>