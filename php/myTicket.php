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
    <!-- 헤더,네비 불러옴 -->
<?php include 'title.php'; ?>

<div class="content">
    <div class="center">
    <!-- 티켓북 업로드 버튼 -->
    <a href="ticketUpload.php"><button>티켓 추가</button></a>
    <?php
    // 데이터베이스 연결
    require_once("dbconfig.php");


    // 나의 티켓북 뷰 생성 SQL 문
    $createViewSql = "
        CREATE VIEW myTickets AS
        SELECT ticketId, ticketDate, ticketPicture, ticketMemo
        FROM ticketBook
        WHERE memberId = '$sessionId'
    ";

    // 뷰 생성 실행
    if ($conn->query($createViewSql) === TRUE) {
        echo "뷰가 성공적으로 생성되었습니다.";
    } else {
        echo "뷰 생성에 실패했습니다. 에러: " . $conn->error;
    }

    // 뷰의 내용 조회 SQL 문
    $selectViewSql = "
        SELECT ticketId, ticketDate, ticketPicture, ticketMemo
        FROM myTickets
    ";

    // 뷰의 내용 조회
    $result = $conn->query($selectViewSql);

    // 결과가 있을 경우 출력
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Ticket Picture</th><th>Ticket Date</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ticketPicture"] . "</td>";
            echo "<td>" . $row["ticketDate"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "뷰의 내용이 없습니다.";
    }

    // 데이터베이스 연결 종료
    $conn->close();
    ?>

    </div>
</div>

</body>
</html>