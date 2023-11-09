<!-- musicals table에 api 정보 불러와서 저장 -->
<?php

// 데이터베이스 연결 정보
$host = 'your_database_host';
$user = 'your_database_username';
$pass = 'your_database_password';
$db   = 'your_database_name';

// 데이터베이스 연결
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Open API URL 및 서비스 키
$api_url = 'http://www.kopis.or.kr/openApi/restful/pblprfr/PF132236?service=your_service_key';

// cURL을 사용하여 API에서 데이터 가져오기
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// XML 데이터를 SimpleXML로 파싱
$xml = simplexml_load_string($response);

// 필요한 데이터 추출 및 데이터베이스에 저장
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

// 데이터베이스 연결 종료
$conn->close();

?>
