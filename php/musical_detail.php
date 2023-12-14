<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?>
        td{
            color:var(--color3);
        } 
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

            //사진 출력
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
            <!-- 좋아요 버튼 폼 -->
            <form method="post" action="">
                <input type="hidden" name="sessionId" value="<?php echo $sessionId; ?>">
                <input type="hidden" name="musicalId" value="<?php echo $id; ?>">
                <button type="submit" name="likeButton" class="heart">LIKE♥</button>
            </form>

            <?php
            // 좋아요 버튼이 눌렸을 때 처리
            if (isset($_POST['likeButton'])) {
                //로그인 검사
                require_once("checkLog.php");
                // 클라이언트에서 전송한 데이터 가져오기
                $memberId = $_POST["sessionId"];
                $musicalId = $_POST["musicalId"];

                // 중복 삽입 방지를 위한 쿼리
                $checkDuplicateQuery = "SELECT * FROM likeMusical WHERE memberId = '$memberId' AND musicalId = '$musicalId'";
                $duplicateResult = $conn->query($checkDuplicateQuery);

                if ($duplicateResult->num_rows == 0) {
                    // 중복이 없을 때만 삽입
                    $likeSql = "INSERT INTO likeMusical (memberId, musicalId) VALUES ('$memberId', '$musicalId')";
                    $likeRe = $conn->query($likeSql);
                    echo '<script>alert("관심 뮤지컬로 등록되었습니다.");</script>';
                } else {
                    // 이미 등록된 경우, 좋아요 취소를 위한 데이터 삭제
                    $deleteLikeSql = "DELETE FROM likeMusical WHERE memberId = '$memberId' AND musicalId = '$musicalId'";
                    $deleteResult = $conn->query($deleteLikeSql);
                    echo '<script>alert("관심 뮤지컬로 등록이 취소되었습니다.");</script>';
                }
            }
            ?>
        <?php
        //데이터 조회 쿼리
            $sql2 = "SELECT musicalName, openDate, closeDate,theaterName, 
                    actors, runningTime, age,price, musicalInfo,musicalState
                FROM musicals
                WHERE musicalId = '$id'";
            $result2 = $conn->query($sql2);
            
            //내용 출력
    if ($result2->num_rows > 0) {
        echo '<table>';
        while ($row = $result2->fetch_assoc()) {
            echo "<tr><td><strong>Musical Name:</strong></td><td>{$row['musicalName']}</td></tr>";
            echo "<tr><td><strong>Open Date:</strong></td><td>{$row['openDate']}</td></tr>";
            echo "<tr><td><strong>Close Date:</strong></td><td>{$row['closeDate']}</td></tr>";
            echo "<tr><td><strong>Theater Name:</strong></td><td>{$row['theaterName']}</td></tr>";
            echo "<tr><td><strong>Actors:</strong></td><td>{$row['actors']}</td></tr>";
            echo "<tr><td><strong>Running Time:</strong></td><td>{$row['runningTime']}</td></tr>";
            echo "<tr><td><strong>Age:</strong></td><td>{$row['age']}</td></tr>";
            echo "<tr><td><strong>Price:</strong></td><td>{$row['price']}</td></tr>";
            echo "<tr><td><strong>Musical Info:</strong></td><td>{$row['musicalInfo']}</td></tr>";
            echo "<tr><td><strong>Musical State:</strong></td><td>{$row['musicalState']}</td></tr>";
        }
        echo '</table>';
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