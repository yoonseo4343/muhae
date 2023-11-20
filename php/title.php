<!-- <body> 태그 안에 넣으면 됨. -->
    <!-- 헤더와 네비 기능 -->
<header>
    <h1><a href="main.php" style="text-decoration: none; color: inherit;">뭐해? 뮤해!</h1>
</header>

<nav>
    <a href="#">MUSICALS</a>
    <a href="#">REVIEW</a>
    <a href="#">LIKE</a>
    <a href="myTicket.php">TICKETBOOK</a>
    <a href="#">MYPAGE</a>
    <?php
    // 로그인되어 있는 경우에만 로그아웃 링크를 표시
    if ($loggedIn) {
        echo '<a href="logout.php">LOGOUT</a>';
    } else {
        echo '<a href="login.php">LOGIN</a>';
    }
    ?>
</nav>
