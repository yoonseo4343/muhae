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
    <div class="left-side">
            <?php
            // 데이터베이스 연결
            require_once("dbconfig.php");
            $id = $_GET['id']; //뮤지컬 아이디 받아옴

            //데이터 조회 쿼리
            $sql = "SELECT poster
                FROM musicals
                WHERE musicalId = '$id'";
            $result = $conn->query($sql);

            //출력
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p> <img src='{$row['poster']}' alt='Poster' class='responsive-img'></p>";
                }
            } else {
                echo "뮤지컬 정보가 없습니다.";
            }

            
            ?>
        </div>
        <div class="right-side">
            <?php
        //데이터 조회 쿼리
            $sql2 = "SELECT musicalName, openDate, closeDate,theaterName, 
                    actors, runningTime, age,price, musicalInfo,musicalState
                FROM musicals
                WHERE musicalId = '$id'";
            $result2 = $conn->query($sql2);

            //출력
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    echo "<p><strong>Musical Name:</strong> {$row['musicalName']}</p>";
                    echo "<p><strong>Open Date:</strong> {$row['openDate']}</p>";
                    echo "<p><strong>Close Date:</strong> {$row['closeDate']}</p>";
                    echo "<p><strong>Theater Name:</strong> {$row['theaterName']}</p>";
                    echo "<p><strong>Actors:</strong> {$row['actors']}</p>";
                    echo "<p><strong>Running Time:</strong> {$row['runningTime']}</p>";
                    echo "<p><strong>Age:</strong> {$row['age']}</p>";
                    echo "<p><strong>Price:</strong> {$row['price']}</p>";
                    echo "<p><strong>Musical Info:</strong> {$row['musicalInfo']}</p>";
                    echo "<p><strong>Musical State:</strong> {$row['musicalState']}</p>";
                }
            } else {
                echo "뮤지컬 정보가 없습니다.";
            }
            // 데이터베이스 연결 종료
            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>