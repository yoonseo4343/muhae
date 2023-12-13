<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <?php include 'title.php'; ?>
    <style>
        <?php include 'webstyle.css';?>
        <?php include 'slide.css';?>
        /* 모달 스타일 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 50%;
            height: 150%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0);
        }

        /* 모달 내용 스타일 */
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            max-width: 800px;
        }

        /* 닫기 버튼 스타일 */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            margin-top: -10px;
            margin-right: -10px;
        }
        
        /* 모달 내용 스타일 */
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            max-width: 600px;
        }

        /* 이미지 크기 조정 */
        .modal-content img {
            width: 100%;
            max-width: 100%; /* 이미지의 최대 넓이를 100%로 설정 */
            height: auto;
        }



    </style>
    
</head>
<body>
    
    <?php 
    // 데이터베이스 연결
    require_once("dbconfig.php");?>

    <div class="content">
        <div class="left-side"  >
            <!-- 베스트 뮤덕 내용을 추가할 부분 -->
            <!-- 티켓북 추가할 부분 -->
            <tr><th>MY TICKET</th></tr>
            <?php
            
            if ($loggedIn) {
                $selectSql = "
                SELECT ticketDate, ticketPicture
                FROM ticketBook
                WHERE memberId = '$sessionId'
                ORDER BY ticketDate DESC
                LIMIT 3
                ";
    
                $result = $conn->query($selectSql);
                while ($row = mysqli_fetch_assoc($result)){
                    $picture = $row['ticketPicture'];
                    echo "<div class='ticket'><a href='myTicket.php'>";
                    echo "<img src='$picture'>";
                    echo "</a></div>";
                }
            }
            else{
                echo "<div class='ticket'><a href='myTicket.php'>";
                echo "<img src='../src/ticket.png'></a></div>";
            }
            ?>

            <!-- 인기 뮤지컬 리스트 -->
            <hr>
            <tr><th>BEST MUSICAL</th></tr>
            <?php
            $bestQ="SELECT m.poster, m.musicalId
            FROM (
                SELECT l.musicalId, COUNT(*) AS count_likes
                FROM likeMusical l
                GROUP BY l.musicalId
                ORDER BY count_likes DESC
                LIMIT 3
            ) AS top_likes
            JOIN musicals m ON top_likes.musicalId = m.musicalId;";
            $bestR = mysqli_query($conn, $bestQ);
            while ($row = mysqli_fetch_assoc($bestR)){
                $poster = $row['poster'];
                $musicalId=$row['musicalId'];
                echo "<a href='musical_detail.php?id=$musicalId'>";
                echo "<img src='$poster'>";
                echo "</a>";
            }
            ?>
        </div>

    <div class="center">
        <div id="slider-container">
        <div id="image-slider" class="slide">
        <?php
        $query = "SELECT poster,musicalId FROM musicals ORDER BY openDate DESC LIMIT 5";
        $result = mysqli_query($conn, $query);
        $imagePaths = array();
        // $idArray=array();

        while ($row = mysqli_fetch_assoc($result)) {
            $poster = $row['poster'];
            $musicalId = $row['musicalId'];
        
            // 결과를 배열에 추가
            $imagePaths[] = $poster;
            // $idArray[] = array('musicalId' => $musicalId);
        }

        // 이미지 경로를 기반으로 이미지 태그 생성
        foreach ($imagePaths as $path) {
            // 이미지의 실제 너비와 높이를 읽어와서 출력
            list($width, $height) = getimagesize($path);
            echo '<div class="slide"><img src="' . $path . '" alt="Slide"></div>';
        }
        ?>
    </div>
</div>

<script>
        // JavaScript를 사용하여 이미지 슬라이드 제어
        const sliderContainer = document.querySelector('.content');
const slider = document.getElementById('image-slider');
const slides = document.querySelectorAll('.slide');

let currentIndex = 0;

function updateSlider() {
    const contentWidth = (sliderContainer.clientWidth)*3/5; // slider-container의 너비

    // 슬라이드의 너비를 slider-container의 너비와 동일하게 설정
    slides.forEach(slide => {
        slide.style.width = `${contentWidth}px`;
    });

    const newTransformValue = -currentIndex * contentWidth + 'px';
    slider.style.transform = 'translateX(' + newTransformValue + ')';
}

// 창 크기가 변경될 때 슬라이드 너비를 업데이트
window.addEventListener('resize', updateSlider);

// 초기화 시에도 한 번 호출하여 초기 슬라이드 너비를 설정
updateSlider();

// 자동으로 슬라이드 변경
function nextSlide() {
    if (currentIndex < slides.length - 2) {
        currentIndex++;
    } else {
        currentIndex = 0;
    }
    updateSlider();
}

// 일정 시간마다 슬라이드 변경
setInterval(nextSlide, 3000);

</script>
    </div>

    <div class="right-side">
        <table>
            <thead>
                <tr><th>REVIEW</th></tr>
            </thead>
            <tbody>
                <tr><td><a href="hero.php" target="_blank"><img src="../src/영웅.jpg" width="200" height="80" alt=""></a></td></tr>
                <tr><td><a href="hero.php" target="_blank"><img src="../src/영웅.jpg" width="200" height="80" alt="영웅"></a></td></tr>
                <tr><td><a href="hero.php" target="_blank"><img src="../src/영웅.jpg" width="200" height="80" alt="영웅"></a></td></tr>
            </tbody>
        </table>

        <br>

        <!-- 뮤지컬 컴퍼니 주소 추가 -->
        <table>
            <thead>
                <tr>
                    <th>MUSICAL COMPANY</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <a href="https://emkmusical.com/" target="_blank">
                            <img src="../src/emk.jpg" alt="COMPANY">
                        </a>
                        <br>
                        <a href="https://www.odmusical.com/production/list?ca_id=01" target="_blank">
                            <img src="../src/OD컴퍼니.jpg" alt="COMPANY">
                        </a>
                        <br>
                        <a href="https://www.iseensee.com/Home/Perf/SalePerfList.aspx" target="_blank">
                            <img src="../src/신시.jpg" alt="COMPANY">
                        </a>
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img src="../src/레베카.jpg" alt="이미지 설명" >
        <p>뮤지컬 대관 할인 서비스!!!!</p>
        <P>선착순 50명 한정</p>
    </div>
</div>

<script>
    // 모달 JavaScript
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('myModal');
        openModal(); // 페이지 로딩 시에 모달 열기

        // 모달 열기
        function openModal() {
            modal.style.display = 'block';
        }

        // 모달 닫기
        function closeModal() {
            modal.style.display = 'none';
        }

        // 모달 외부 클릭 시 모달 닫기
        window.onclick = function (event) {
            if (event.target === modal) {
                closeModal();
            }
        };
    });

</script>


<?php // 데이터베이스 연결 종료
    $conn->close();
?>
</body>
</html>
