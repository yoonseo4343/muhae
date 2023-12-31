<!DOCTYPE html>
<html lang="en">
        <!-- 헤더,네비 불러옴 -->
        <?php include 'title.php'; ?>
<div class="upload_content">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>티켓 등록 페이지</title>
    <style>
        <?php include 'webstyle.css';?> 
        /* 스타일 불러옴 */
    </style>
</head>
<body>

    <div class="center">
<?php
// 폼이 제출되었을 때의 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 데이터베이스 연결
    require_once("dbconfig.php");

    $ticketDate = $_POST['ticketDate'];
    $ticketMemo = $_POST['ticketMemo'];

    // 파일 업로드 처리
    $uploadDirectory = 'tickets/'; // 업로드된 파일이 저장될 디렉터리

    if ($_FILES['ticketPicture']['error'] !== UPLOAD_ERR_OK) {
        die('파일 업로드 실패: ' . $_FILES['ticketPicture']['error']);
    }

    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif');
    $uploadedFileType = strtolower(pathinfo($_FILES['ticketPicture']['name'], PATHINFO_EXTENSION));

    if (!in_array($uploadedFileType, $allowedFileTypes)) {
        die('허용되지 않는 파일 형식입니다.');
    }

    $uniqueFileName = uniqid() . '_' . $_FILES['ticketPicture']['name'];
    $destination = $uploadDirectory . $uniqueFileName;

    if (!move_uploaded_file($_FILES['ticketPicture']['tmp_name'], $destination)) {
        die('파일 이동 실패');
    }

    // 데이터베이스에 데이터 삽입
    $sql = "INSERT INTO ticketBook (memberId, ticketDate, ticketPicture, ticketMemo) VALUES ('$sessionId', '$ticketDate', '$destination', '$ticketMemo')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("티켓이 성공적으로 등록되었습니다.");</script>';
        echo '<script>window.location.href = "myTicket.php";</script>';

    } else {
        echo "티켓 등록에 실패했습니다. 에러: " . $conn->error;
    }

    // 데이터베이스 연결 종료
    $conn->close();
}
?>

<!-- 티켓 등록 폼 -->
<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <label for="ticketDate">관극 날짜 : </label>
    <input type="date" name="ticketDate" required><br><br>

    <label for="ticketPicture">사진 첨부 : </label>
    <input type="file" name="ticketPicture" accept="image/*" required><br><br>

    <label for="ticketMemo">메모 : </label>
    <textarea name="ticketMemo"></textarea><br><br>

    <input class="button" type="submit" value="등록하기">
</form><br>
<a href="myTicket.php"><button class="button">돌아가기</button></a>
    </div>
</div>
</body>
</html>
