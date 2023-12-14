<!DOCTYPE html>
<html lang="en">
    <!-- 헤더,네비 불러옴 -->
    <?php include 'title.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?>
        td{
            color:var(--color3);
        } 
        td:nth-child(1) {
            width: 50px;
        }
        /* 좌측 정렬 스타일 추가 */
        .right-side {
            text-align: left;
        }
        /* 뮤지컬 헤더 스타일 추가 */
        .titleB {
            display: flex;
            align-items: center;
        }

        /* 스타일 불러옴 */
    </style>
</head>
<body>

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
                
                while ($row = $result2->fetch_assoc()) {
                    echo '<div class="titleB">';
                    echo "<br><br><br><br><span style='font-size: 30px;color:var(--color3);'>{$row['musicalName']}</span><&nbsp><&nbsp>";

                    ?>
                    <!-- 좋아요 버튼 폼 -->
                    <form method="post" action="">
                        <input type="hidden" name="sessionId" value="<?php echo $sessionId; ?>">
                        <input type="hidden" name="musicalId" value="<?php echo $id; ?>">
                        <button type="submit" name="likeButton" class="heart">LIKE♥</button>
                    </form>
                    <?php

                    echo '</div><br>';
                    echo '<table style="text-align: left;">';
                    echo "<tr><td>기간 </td><td>{$row['openDate']} ~</td></tr>";
                    echo "<tr><td><br><br></td><td>{$row['closeDate']}<br><br></td></tr>";
                    echo "<tr><td>장소 <br><br></td><td>{$row['theaterName']}<br><br></td></tr>";
                    echo "<tr><td>배우 <br><br></td><td>{$row['actors']}<br><br></td></tr>";
                    echo "<tr><td>러닝 <br><br></td><td>{$row['runningTime']}<br><br></td></tr>";
                    echo "<tr><td>나이 <br><br></td><td>{$row['age']}<br><br></td></tr>";
                    echo "<tr><td>가격 <br><br></td><td>{$row['price']}<br><br></td></tr>";
                    echo "<tr><td>상태 <br><br></td><td>{$row['musicalState']}<br><br></td></tr>";
                    echo '</table><br>';
                    echo "<span style='font-size: larger;color:var(--color3);'>{$row['musicalInfo']}</span>";
                }
                
                
            }
    else {
        echo "뮤지컬 정보가 없습니다.";
    }
            // 데이터베이스 연결 종료
            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>