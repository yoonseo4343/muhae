<!DOCTYPE html>
<html lang="en">
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

    <div class="content">
        <div class="left-side">
            <!-- 베스트 뮤덕 내용을 추가할 부분 -->
            <!-- 티켓북 추가할 부분 -->
        </div>

        <div class="center">
            <!-- 디비에서 가장 최근 뮤지컬 사진 불러와야 함 -->
            <img src="../src/영웅.jpg" alt="뮤지컬 이미지(테스트용)">
        </div>

        <div class="right-side">
            <table>
                <thead>
                    <tr><th>REVIEW</th></tr>
                </thead>
                <tbody>
                    <tr><td><a href="hero.php" target="_blank"><img src="영웅.jpg" width="200" height="80" alt=""></a></td></tr>
                    <tr><td><a href="hero.php" target="_blank"><img src="영웅.jpg" width="200" height="80" alt="영웅"></a></td></tr>
                    <tr><td><a href="hero.php" target="_blank"><img src="영웅.jpg" width="200" height="80" alt="영웅"></a></td></tr>
                </tbody>
            </table>

            <!-- 리뷰 내용을 추가할 부분 -->
        </div>
    </div>

</body>
</html>
