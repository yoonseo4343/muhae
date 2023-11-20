<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// 데이터베이스 연결
require_once("dbconfig.php");

// 세션 시작
session_start();

// 현재 로그인된 사용자의 세션 아이디 가져오기
$sessionId = session_id();

// 뷰 생성 SQL 문
$createViewSql = "
    CREATE VIEW myTickets AS
    SELECT memberId, ticketPicture, ticketDate
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
    SELECT memberId, ticketPicture, ticketDate
    FROM myTickets
";

// 뷰의 내용 조회
$result = $conn->query($selectViewSql);

// 결과가 있을 경우 출력
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Member ID</th><th>Ticket Picture</th><th>Ticket Date</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["memberId"] . "</td>";
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

</body>
</html>