<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?> 
        /* 스타일 불러옴 */
    </style>
</head>
<body>
    <!-- 헤더,네비 불러옴 / 로그인 검사-->
<?php 
include 'title.php'; 
require_once("checkLog.php");
?>

<div class="content">
    <div class="center">
    <!-- 티켓북 업로드 버튼 -->
    <a href="ticketUpload.php"><button>티켓 추가</button></a>
    <?php
    // 데이터베이스 연결
    require_once("dbconfig.php");

     // ticketBook 테이블에서 memberId가 $sessionId인 경우 조회
     $selectSql = "
     SELECT ticketDate, ticketPicture
     FROM ticketBook
     WHERE memberId = '$sessionId'
 ";

 $result = $conn->query($selectSql);

 // 결과가 있을 경우 출력
 if ($result->num_rows > 0) {
     echo "<table>";
     echo "<tr><th>Ticket Picture</th><th>Ticket Date</th></tr>";

     while ($row = $result->fetch_assoc()) {
         echo "<tr>";
         echo "<td><img src='" . $row["ticketPicture"] . "' alt='Ticket Picture' style='width: 100px; height: auto;'></td>";
         echo "<td>" . $row["ticketDate"] . "</td>";
         echo "</tr>";
     }

     echo "</table>";
 } else {
     echo "티켓이 없습니다.";
 }

    // 데이터베이스 연결 종료
    $conn->close();
    ?>

    </div>
</div>

</body>
</html>