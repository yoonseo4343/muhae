<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteButton'])) {
    // 폼에서 전송된 게시글 ID 확인
    $boardId = $_POST['boardId'];

    // 여기에 데이터베이스에서 게시글을 삭제하는 코드를 추가하세요

    // 데이터베이스 연결
    require_once("dbconfig.php");

    // 게시글 삭제 쿼리
    $deleteReviewQuery = "DELETE FROM review WHERE boardId = '$boardId'";
    $deleteReviewResult = $conn->query($deleteReviewQuery);

    if ($deleteReviewResult) {
        echo '<script>alert("게시글이 성공적으로 삭제되었습니다.");</script>';
        // 삭제 후 리뷰 목록 페이지로 리다이렉트
        echo '<script>window.location.href = "myPage.php";</script>';
    } else {
        echo "게시글 삭제에 실패했습니다: " . $conn->error;
    }

    // 데이터베이스 연결 종료
    $conn->close();

    exit();
} else {
    // 올바르지 않은 접근 방식에 대한 처리 (직접 URL을 통한 접근 등)
    echo "잘못된 접근입니다.";
}
?>
