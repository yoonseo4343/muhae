<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?> 
        /* 스타일 불러옴 */
    </style>
</head>
<body>
    <!-- 헤더,네비 불러옴 -->
    <?php include 'title.php'; ?>

    <div class="content">
        <div class="center">
            <?php
            // 데이터베이스 연결
            require_once("dbconfig.php");

            // 데이터베이스 연결 종료
            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>