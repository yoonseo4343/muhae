<!DOCTYPE html>
<html>
<head>
	<title>로그인</title>
	<link rel="stylesheet" type="text/css" href="webstyle.css">
</head>
<body>
    <?php
    session_start();
    include "dbconfig.php";
    // $memberId = $_POST["ID"];
    //     $email = $_POST["email"];
    //     $pw = $_POST["pw"];
    //     $nickName = $_POST["uname"];

    // 폼에서 받은 데이터
    $memberId = $_POST["ID"];
    $pw = $_POST["pw"];

    //id, pw null값이 아니라면 연결
    if (isset($_POST['ID'],$_POST['pw'])) {
        $conn = new mysqli($DBhost, $DBuser, $DBpassword, $DBname);

        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $memberId = validate($_POST['ID']);
        $pw = validate($_POST['pw']);

        if(empty($memberId)){ //id 비어있을 때 
            header("Location: index.php?error = memberId를 입력하세요");
            exit();
        }else if(empty($pw)){ //pw 비어있을 때
            header("Location: index.php?error = pw를 입력하세요");
            exit();
        }else{
            $hashed_pw = password_hash($pw, PASSWORD_BCRYPT);
        }

        //member 테이블에서 데이터 조회하는 sql 쿼리 생성 및 실행
        $sql = "SELECT * FROM member WHERE user_name='$memberId'";
        $result = mysqli_query($conn, $sql);

        if($result){
            $row = mysqli_fetch_assoc($result);
            $q_pw = $row['pw'];
            $u_name = $row['memberId'];
            $u_nickName = $row['nickName'];
            //사용자 id와 pw 일치 시 세션 변수 설정 후 메인 화면으로 고고
            if(password_verify($pw, $q_pw)){ //pw 일치 확인
                $_SESSION['id'] = $memberId;
                $_SESSION['name'] = $nickName;
                header("Location: main.php");
                exit();
            }else {
                header("계정명 또는 암호가 틀렸습니다.");
                exit();
            }
        }else {
            header("계정명 또는 암호가 틀렸습니다.");
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
    <input type="text" name="uname" placeholder="User Name"><br>

    <label>Password</label>
    <input type="password" name="password" placeholder="Password"><br>

    <button type="submit">로그인</button>
        <a href="register.php" class="ca">회원 가입</a>
    </form>
</body>
</html>
