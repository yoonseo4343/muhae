<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?>
    </style>
</head>
<body>
    <?php include 'title.php'; ?>
    <?php

    // 데이터베이스 연결
    require_once("dbconfig.php");

    // 회원 아이디 가져오기
    $loggedInUserId = $_SESSION['id'];

    // POST로 전송된 폼 데이터 확인
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 폼에서 전송된 값을 가져옴
        $newEmail = $_POST["email"];
        $newNickname = $_POST["nickname"];

        // SQL 쿼리를 사용하여 회원 정보 업데이트
        $updateSql = "UPDATE member SET email = '$newEmail', nickName = '$newNickname' WHERE memberId = '$loggedInUserId'";
        $updateResult = $conn->query($updateSql);

        if ($updateResult) {
            echo '<script>alert("회원정보가 수정되었습니다.");</script>';
            // 추가로 필요한 작업 수행 가능
        } else {
            echo "회원 정보 수정에 실패했습니다: " . $conn->error;
        }
    }

    // 현재 회원 정보 조회 쿼리
    $sql = "SELECT * FROM member WHERE memberId = '$loggedInUserId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 결과가 있을 경우, 회원 정보를 가져옴
        $row = $result->fetch_assoc();
        $userId = $row["memberId"];
        $userEmail = $row["email"];
        $userNick = $row["nickName"];
    } else {
        // 회원 정보가 없을 경우에 대한 처리
        echo '<script>alert("로그인 후 이용 가능합니다.");</script>';
        echo '<script>window.location.href = "login.php";</script>';
        exit();
    }

    $conn->close();
    ?>
    <div class="content">
        <div class="center">
            <!-- 회원 정보 수정 폼 -->
            <form method="post" action="myPage.php">
                <fieldset>
                    <h2>내 정보 수정</h2>
                    <p><label for="id">아이디:</label>
                    <input type="text" id="id" name="id" value="<?php echo $userId; ?>" readonly="readonly"></p>
                    <p><label for="email">Email:</label>
                    <input type="text" id="email" name="email" value="<?php echo $userEmail; ?>"></p>
                    <p><label for="nickname">Nickname:</label>
                    <input type="text" id="nickname" name="nickname" value="<?php echo $userNick; ?>"></p>
                    <input type="submit" value="회원 수정">
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>
