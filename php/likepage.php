<!-- 이걸 복사해서 사용하면 좋을 듯 필요한거 다 들어감 아마 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIKE MUSICAL</title>
    <style>
        <?php include 'webstyle.css';?> 
        /* 스타일 불러옴 */
    </style>
</head>
<body>
    <!-- 헤더,네비,세션 불러옴 -->
    <?php include 'title.php'; ?>

    <div class="content">
        <div class="center">
            <?php
            // 데이터베이스 연결
            require_once("dbconfig.php");

            // 페이지당 보여줄 항목 수
            $itemsPerPage = 9;

            // 현재 페이지 파악
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            // musicals 테이블에서 poster 선택하여 출력
            $offset = ($currentPage - 1) * $itemsPerPage;
            $query = "SELECT musicals.poster, musicals.musicalId
            FROM musicals
            JOIN likeMusical ON musicals.musicalId = likeMusical.musicalId
            WHERE likeMusical.memberId = '$sessionId'
            LIMIT $itemsPerPage OFFSET $offset";
            $result = mysqli_query($conn, $query);

            // 결과가 있을 경우 출력
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='album'>";
                while ($row = mysqli_fetch_assoc($result)) {
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

                // 페이지 링크 출력
                $totalItems = mysqli_num_rows(mysqli_query($conn, "SELECT musicalId FROM musicals"));
                $totalPages = ceil($totalItems / $itemsPerPage);
                echo "<div class='pagination'>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=$i' " . ($i == $currentPage ? 'class="active"' : '') . ">$i</a>";
                }
                echo "</div>";
            } else {
                echo "관심 뮤지컬이 없습니다.";
            }

            // 데이터베이스 연결 종료
            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>