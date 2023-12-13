<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 데이터베이스 연결
    require_once("dbconfig.php");

    $ticketId = $_POST['ticketId'];

    // 데이터베이스에서 티켓 삭제
    $deleteSql = "DELETE FROM ticketBook WHERE ticketId = '$ticketId'";

    if ($conn->query($deleteSql) === TRUE) {
        echo '<script>alert("티켓이 성공적으로 삭제되었습니다.");</script>';
        echo '<script>window.location.href = "myPage.php";</script>'; // myPage.php로 이동
    } else {
        echo "티켓 삭제에 실패했습니다. 에러: " . $conn->error;
    }

    // 데이터베이스 연결 종료
    $conn->close();
}
?>
