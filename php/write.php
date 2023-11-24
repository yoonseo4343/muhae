<!DOCTYPE html>
<html>
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
require_once("dbconfig.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 사용자가 제출한 폼 데이터를 확인합니다.
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);
    

    // 현재 날짜 및 시간을 가져옵니다.
    $createdAt = date("Y-m-d H:i:s");

    // 쿼리를 생성하여 데이터베이스에 삽입합니다.
    $sql = "
        INSERT INTO review
        (title, content, boardState, createdAt, memberId, rating)
        VALUES (
            '$title',
            '$review',
            'act',
            '$createdAt',
            '$sessionId',
            '$rating'
        )
    ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    } else {
        echo '<script>alert("Review successfully submitted!");</script>';
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>
<div class="content">
<div class="center">
<div id="board_write">
    <h2>REVIEW</h2>
    <div id="write_board">
        <form action="hero.php" method="POST">
            <div id="board_title">
                제목 : <input type="text" name="title" size="30">
            </div>

            <hr>
            <div id="in_rating">
                <fieldset>
                    별점 :
                    <select name="rating" style="width:100px;height:30px">
                        <option value="★★★★★"> ★★★★★ </option>
                        <option value="★★★★☆"> ★★★★☆ </option>
                        <option value="★★★☆☆"> ★★★☆☆ </option>
                        <option value="★★☆☆☆"> ★★☆☆☆ </option>
                        <option value="★☆☆☆☆"> ★☆☆☆☆ </option>
                    </select><br>

                    후기 : <br>
                    <textarea name="review" cols="100" rows="20"></textarea>
                    <hr>

                    
                        <input type="submit" value="전송하기"> &nbsp;&nbsp;
                        <input type="reset" value="다시작성">
                    <br>
                </fieldset>
            </div>
        </form>
    </div>
</div>
</div>
</div>

</body>
</html>
