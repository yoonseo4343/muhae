<?php
// 데이터베이스 연결 
require_once("../dbconfig.php");

// 폼이 제출되었을 때의 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 사용자로부터 받은 데이터를 변수에 할당
    $memberId = $_POST["ID"];
    $email = $_POST["email"];
    $pw = $_POST["pw"];
    $nickName = $_POST["uname"];

    // 데이터베이스에 데이터 추가
    $e_pw = password_hash($pw, PASSWORD_DEFAULT);
    $query_add_user = "INSERT INTO member(memberId, pw, nickName, email) VALUES ('$memberId', '$e_pw', '$nickName', '$email')";
    
    if (mysqli_query($conn, $query_add_user)) {
        echo "회원가입이 완료되었습니다.";
    } else {
        echo "Error: " . $query_add_user . "<br>" . mysqli_error($conn);
    }
}

// 데이터베이스 연결 종료
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>회원가입</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="register.php" method="POST">
        <h2>회원가입</h2>

        <label>아이디</label>
        <input type="text" memberId="memberId" placeholder="memberId" required><br>

        <label>이메일</label>
        <input type="text" name="email" placeholder="email" required><br>

        <label>비밀번호</label>
        <input type="password" name="pw" placeholder="pw" required><br>

        <label>닉네임</label>
        <input type="text" name="uname" placeholder="User Name" required><br>


        <button type="submit">회원가입</button><br>
        <a href="login.php" class="ca">이미 가입 되어 있으신가요?</a>
    </form>
</body>
</html>
