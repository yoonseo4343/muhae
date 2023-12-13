<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <!-- 헤더,네비,세션 불러옴 -->
    <?php include 'title.php'; ?>
    <style>
        <?php include 'webstyle.css';?> 
        /* 스타일 불러옴 */
        table {
            width: 65%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px; /* 추가된 부분: 테이블 내의 텍스트 크기를 작게 설정 */
            margin: auto;
        }

        table, th, td {
            border: 1px solid #ddd;
            border: none; /* 세로줄 투명하게 처리 */
            border-bottom: 1px dashed #ddd; /* 가로줄을 점선으로 설정 */
            cursor: pointer;
        }

        th, td {
            padding: 10px;
            line-height: 1.2;
            text-align: left;
        }

        th {
            border-bottom: 1px solid #ddd; /* 아랫줄은 실선으로 설정 */
        }
        /* 각 셀에 대한 가로 간격 설정 */
        td:nth-child(1) {
            width: 30px;
        }

        td:nth-child(2) {
            width: 200px;
        }

        td:nth-child(3) {
            width: 80px;
        }
        td:nth-child(4) {
            width: 90px;
            
        }

        td:nth-child(5) {
            width: 150px;
        }

        /* 모달 창 스타일 추가 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* 어두운 배경색 지정 */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%; 
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="center">
            <?php
                // 데이터베이스 연결
                require_once("dbconfig.php");

                // 리뷰 목록을 가져오는 쿼리
                $selectReviews = "
                    SELECT boardId, title, rating, memberId, createdAt, content
                    FROM review
                    ORDER BY createdAt DESC
                ";

                $result = $conn->query($selectReviews); 

                // 가져온 리뷰 목록을 테이블로 출력
                if ($result->num_rows > 0) {
                    echo "<h2>REVIEW</h2>";
                    echo "<table>";
                    echo "<tr>
                            <th>번호</th>
                            <th>뮤지컬</th>
                            <th>별점</th>
                            <th>작성자</th>
                            <th>작성시간</th>
                        </tr>";

                    $count = 1; // 리뷰 번호 초기값 설정
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr onclick='showPopup(\"{$row['boardId']}\", \"{$row['title']}\", \"{$row['rating']}\",
                             \"{$row['content']}\")'>";
                        echo "<td>{$count}</td>";
                        echo "<td>{$row['title']}</td>";
                        echo "<td>{$row['rating']}</td>";
                        echo "<td>{$row['memberId']}</td>";
                        echo "<td>{$row['createdAt']}</td>";
                        echo "</tr>";
                        $count++;
                    }
                    echo "</table>";
                } else {
                    echo "<p>아직 리뷰가 없습니다.</p>";
                }
                
            ?>

            <div class="text">
                <font style="cursor: hand" onClick="location.href='./write.php'">리뷰남기기</font>
            </div>

            <!-- 모달 창의 HTML 부분 -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle"></h2>
                    <p id="modalRating"></p>
                    <div id="modalContent"></div>
                </div>
            </div>
            <?php
            // 데이터베이스 연결 종료
            $conn->close();
            ?>

            <!-- JavaScript 코드 추가 -->
            <script>
                function showPopup(boardId, title, rating, content) {
                    document.getElementById("modalTitle").innerHTML = title;
                    document.getElementById("modalRating").innerHTML = rating;
                    document.getElementById("modalContent").innerHTML = content.replace(/\n/g, '<br>');

                    var modal = document.getElementById("myModal");
                    modal.style.display = "block";
                }

                function closeModal() {
                    var modal = document.getElementById("myModal");
                    modal.style.display = "none";
                }
                // 모달 창 외부를 클릭하면 모달이 닫히도록 함
                window.onclick = function (event) {
                    var modal = document.getElementById("myModal");
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                };
            </script>
        </div>
    </div>
</body>
</html>
