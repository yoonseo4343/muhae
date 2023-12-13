<!-- <body> 태그 안에 넣으면 됨. -->
    <!-- 세션시작, 헤더와 네비 기능 -->

<?php
// 세션 시작
session_start();

// 로그인 여부 확인
$loggedIn = isset($_SESSION['id']);
if($loggedIn){
$sessionId=$_SESSION['id']; //현재 로그인된 회원 아이디 값
}
?>
<header >
    <a href="main.php">
        <img src="../src/title2.png" style="padding: 25px;height: 70%; width: auto;">
    </a>
</header>

<nav>
    <a href="main.php">MAIN</a>
    <a href="musicals.php">MUSICALS</a>
    <a href="hero.php">REVIEW</a>
    <a href="likepage.php">LIKE</a>
    <a href="myTicket.php">TICKETBOOK</a>
    <a href="myPage.php">MYPAGE</a>
    <?php
    // 로그인되어 있는 경우에만 로그아웃 링크를 표시
    if ($loggedIn) {
        echo '<a href="logout.php">LOGOUT</a>';
    } else {
        echo '<a href="login.php">LOGIN</a>';
    }
    ?>
</nav>
