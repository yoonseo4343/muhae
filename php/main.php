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
    
    <?php include 'title.php'; 
    // 데이터베이스 연결
    require_once("dbconfig.php");?>

    <div class="content">
        <div class="left-side">
            <!-- 베스트 뮤덕 내용을 추가할 부분 -->
            <!-- 티켓북 추가할 부분 -->
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

            <!-- 리뷰 내용을 추가할 부분 -->
        </div>
    </div>

    <?php // 데이터베이스 연결 종료
        $conn->close();
    ?>
</body>
</html>
