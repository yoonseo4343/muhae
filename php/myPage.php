<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?>
        /* 새로운 스타일 추가 */
        .ticket-list {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .ticket-item {
            float: left;  /* 티켓 사진 옆으로 나란히 */
            width: 33%;
            text-align: center;
            max-width: 150px;
            margin-bottom: 20px;
        }

        .ticket-item img {
            max-width: 100%;
            margin-bottom: 10px;
        }
        .album-item img {
            max-width: 100%;
            max-height: 200px; /* 원하는 높이로 조절 */
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'title.php'; ?>
    <?php

    // 데이터베이스 연결
    require_once("dbconfig.php");

    // 회원 아이디 가져오기
    $loggedInUserId = $_SESSION['id'];

    // POST로 전송된 폼 데이터 확인
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 폼에서 전송된 값을 가져옴
        $newEmail = $_POST["email"];
        $newNickname = $_POST["nickname"];

        // SQL 쿼리를 사용하여 회원 정보 업데이트
        $updateSql = "UPDATE member SET email = '$newEmail', nickName = '$newNickname' WHERE memberId = '$loggedInUserId'";
        $updateResult = $conn->query($updateSql);

        if ($updateResult) {
            echo '<script>alert("회원정보가 수정되었습니다.");</script>';
            // 추가로 필요한 작업 수행 가능
        } else {
            echo "회원 정보 수정에 실패했습니다: " . $conn->error;
        }
    }

    // 현재 회원 정보 조회 쿼리
    $sql = "SELECT * FROM member WHERE memberId = '$loggedInUserId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 결과가 있을 경우, 회원 정보를 가져옴
        $row = $result->fetch_assoc();
        $userId = $row["memberId"];
        $userEmail = $row["email"];
        $userNick = $row["nickName"];
    } else {
        // 회원 정보가 없을 경우에 대한 처리
        echo '<script>alert("로그인 후 이용 가능합니다.");</script>';
        echo '<script>window.location.href = "login.php";</script>';
        exit();
    }


    // 티켓북 정보 조회 쿼리
    $ticketQuery = "SELECT ticketId, ticketPicture, ticketDate FROM ticketBook WHERE memberId = '$loggedInUserId'";
    $ticketResult = $conn->query($ticketQuery);

    ?>

    <div class="content">
        <div class="center">
            <!-- 회원 정보 수정 폼 -->
            <form method="post" action="myPage.php">
                <fieldset>
                    <h2>내 정보 수정</h2>
                    <p><label for="id">아이디:</label>
                    <input type="text" id="id" name="id" value="<?php echo $userId; ?>" readonly="readonly"></p>
                    <p><label for="email">Email:</label>
                    <input type="text" id="email" name="email" value="<?php echo $userEmail; ?>"></p>
                    <p><label for="nickname">Nickname:</label>
                    <input type="text" id="nickname" name="nickname" value="<?php echo $userNick; ?>"></p>
                    <input type="submit" value="회원 수정">
                </fieldset>
                
            </form>
        </div>
        
    </div>
    <div class="content">
        <div class="center">
            <!-- 티켓북 정보 출력 -->
            <fieldset>
                <h2>티켓북</h2>
                <?php
                if ($ticketResult->num_rows > 0) {
                    while ($ticketRow = $ticketResult->fetch_assoc()) {
                        $ticketId = $ticketRow['ticketId']; // 티켓의 고유한 ID
                        $ticketPicture = $ticketRow['ticketPicture'];
                        $ticketDate = $ticketRow['ticketDate'];

                        // 티켓 정보를 화면에 출력
                        echo "<div class='ticket-item'>";
                        echo "<div class='ticket-group'>";
                        echo "<img src='$ticketPicture' alt='Ticket Picture'>";
                        echo "<p>Date: $ticketDate</p>";

                        // 삭제 버튼 추가
                        echo "<form method='post' action='delete_ticket.php'>";
                        echo "<input type='hidden' name='ticketId' value='$ticketId'>";
                        echo "<input type='submit' value='삭제'>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "티켓이 없습니다.";
                }
                ?>
            </fieldset>
                
        </div>
    </div>

    <div class="content">
        <div class="center">
            <!-- 찜 목록 출력 -->
            <fieldset>
                <h2>찜 목록</h2>
                <?php
                // 사용자가 찜한 뮤지컬 목록 가져오기
                $likedMusicalsQuery = "SELECT musicals.poster, musicals.musicalId
                    FROM musicals
                    JOIN likeMusical ON musicals.musicalId = likeMusical.musicalId
                    WHERE likeMusical.memberId = '$loggedInUserId'";

                $likedMusicalsResult = mysqli_query($conn, $likedMusicalsQuery);

                // 결과가 있을 경우 출력
                if (mysqli_num_rows($likedMusicalsResult) > 0) {
                    echo "<div class='album'>";
                    while ($row = mysqli_fetch_assoc($likedMusicalsResult)) {
                        $poster = $row['poster'];
                        $musicalId = $row['musicalId'];

                        // 앨범 형식으로 출력
                        echo "<div class='album-item'>";
                        echo "<a href='musical_detail.php?id=$musicalId'>";
                        echo "<img src='$poster' alt='$musicalId Poster'>";
                        echo "</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "찜한 뮤지컬이 없습니다.";
                }
                ?>
            </fieldset>
        </div>    
    </div>
        

    <?php
    $conn->close();
    ?>
</body>
</html>