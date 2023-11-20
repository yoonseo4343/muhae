<?php
// 세션 시작
session_start();

// 현재 세션 모두 삭제
session_unset();

// 세션 파기
session_destroy();

// 로그아웃 후 리다이렉트할 페이지
$redirect_page = 'main.php'; // 로그아웃 후 이동할 페이지

// 로그아웃 후 리다이렉트
header('Location: ' . $redirect_page);
exit();
?>
