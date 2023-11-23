<!-- musicals table에 api 정보 불러와서 저장 -->
<?php

// 데이터베이스 연결
require_once("dbconfig.php");

// 에러 로깅 활성화
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Open API URL 및 서비스 키
$api_url = 'http://www.kopis.or.kr/openApi/restful/pblprfr/PF132236?service=a875cf23b1ac4fdebe91b2ab2478c821';

// cURL을 사용하여 API에서 데이터 가져오기
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// //테스트 코드 가져옴
// // API 엔드포인트 URL
// $api_url = 'http://www.kopis.or.kr/openApi/restful/pblprfr';

// // 필수 및 선택적 매개변수 설정
// $service_key = 'a875cf23b1ac4fdebe91b2ab2478c821';
// $stdate = '20231101';
// $eddate = '202301230';
// $rows = 30;
// $cpage = 1;
// $shcate  = 'GGGA';

// // cURL 초기화
// $ch = curl_init();

// // cURL 옵션 설정
// $query_string = http_build_query([
//     'service' => $service_key,
//     'stdate' => $stdate,
//     'eddate' => $eddate,
//     'rows' => $rows,
//     'cpage' => $cpage,
//     'shcate' => $shcate
// ]);

// $final_url = $api_url . '?' . $query_string;

// curl_setopt($ch, CURLOPT_URL, $final_url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // API 호출 및 응답 얻기
// $response = curl_exec($ch);

// // cURL 리소스 해제
// curl_close($ch);
// //여기까지

// XML 데이터를 SimpleXML로 파싱
$xml = simplexml_load_string($response);
echo $response;
// 필요한 데이터 추출 및 데이터베이스에 저장
if ($xml && isset($xml->dbs) && isset($xml->dbs->db)) {
    echo "good";
foreach ($xml->dbs->db as $db) {
    $mt20id = $db->mt20id;
    $prfnm = $db->prfnm;
    $prfpdfrom = $db->prfpdfrom;
    $prfpdto = $db->prfpdto;
    $fcltynm = $db->fcltynm;
    $prfcast = $db->prfcast;
    $prfruntime = $db->prfruntime;
    $prfage = $db->prfage;
    $pcseguidance = $db->pcseguidance;
    $poster = $db->poster;
    $sty = $db->sty;
    $prfstate = $db->prfstate;

    // 데이터베이스에 데이터 삽입
    $sql = "INSERT INTO musicals 
            (musicalId, musicalName, openDate, closeDate, theaterId, actors, runningTime, age, price, poster, musicalInfo, musicalState) 
            VALUES 
            ('$mt20id', '$prfnm', '$prfpdfrom', '$prfpdto', '$fcltynm', '$prfcast', '$prfruntime', '$prfage', '$pcseguidance', '$poster', '$sty', '$prfstate')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully for $prfnm.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
}else{
    echo "No data found.";
}

// 데이터베이스 연결 종료
$conn->close();

?>
