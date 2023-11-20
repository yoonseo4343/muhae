<!DOCTYPE html>
<html>
<head>
    <title>로그인</title>
    <style>
        <?php include 'webstyle.css';?>
    </style>
</head>
<body>
<?php include 'title.php'; ?>
<div class="content">
    <div class="center">
    <?php

   // 데이터베이스 연결
   require_once("dbconfig.php");
    // 폼에서 받은 데이터
    $memberId = isset($_POST["memberId"]) ? $_POST["memberId"] : null;
    $pw = isset($_POST["pw"]) ? $_POST["pw"] : null;

    // 아이디와 비밀번호가 입력되었는지 확인
    if (isset($memberId, $pw)) {
        //$conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBname);

        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $memberId = validate($memberId);
        $pw = validate($pw);

        // member 테이블에서 데이터 조회하는 SQL 쿼리 생성 및 실행
        $sql = "SELECT * FROM member WHERE memberId='" . mysqli_real_escape_string($conn, $memberId) . "'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $q_pw = $row['pw'];
            $u_name = $row['memberId'];
            $u_nickName = $row['nickName'];

            // 사용자 아이디와 비밀번호 일치 시 세션 변수 설정 후 메인 화면으로 이동
            if (password_verify($pw, $q_pw)) {
                $_SESSION['id'] = $memberId;
                $_SESSION['name'] = $u_nickName;
                header("Location: main.php");
                exit();
            } else {
                header("Location: index.php?error=계정명 또는 암호가 틀렸습니다.");
                exit();
            }
        } else {
            header("Location: index.php?error=계정명 또는 암호가 틀렸습니다.");
            exit();
        }
    }

    ?>
    <form action="login.php" method="post">
    <h2>LOGIN</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <label>User Name</label>
    <input type="text" name="memberId" placeholder="ID"><br>

    <label>Password</label>
    <input type="password" name="pw" placeholder="Password"><br>

    <button type="submit">로그인</button>
    <a href="register.php" class="ca">회원 가입</a>
    </form>
</body>
</html>
