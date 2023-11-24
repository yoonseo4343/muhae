<?php

if (!$loggedIn) {
    echo '<script>';
    echo 'alert("로그인 후 이용가능합니다.");';
    echo 'window.location.href = "login.php";';
    echo '</script>';
}
?>