<!-- 헤더,네비 불러옴 / 로그인 검사-->
<?php 
    include 'title.php'; 
    require_once("checkLog.php");
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?> 
        <?php include 'calendar.css';?>
        /* 스타일 불러옴 */
    </style>
</head>
<body>


<div class="content">
    <div class="center">
        <!-- 티켓북 업로드 버튼 -->
        <a href="ticketUpload.php"><button>티켓 추가</button></a>
        <?php
        // 데이터베이스 연결
        require_once("dbconfig.php");

        // ticketBook 테이블에서 memberId가 $sessionId인 경우 조회
        $selectSql = "
        SELECT ticketDate, ticketPicture
        FROM ticketBook
        WHERE memberId = '$sessionId'
        ";

        $result = $conn->query($selectSql);

        // 결과를 PHP 배열로 저장
        $tickets = [];


        // 결과가 있을 경우 출력
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>뮤지컬 사진</th><th>관극 날짜</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $tickets[] = $row;
                echo "<tr>";
                echo "<td><img src='" . $row["ticketPicture"] . "' alt='Ticket Picture' style='width: 100px; height: auto;'></td>";
                echo "<td>" . $row["ticketDate"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "티켓이 없습니다.";
        }
        echo "<script>";
        echo "var tickets = " . json_encode($tickets) . ";";
        echo "</script>";
        
        // 데이터베이스 연결 종료
        $conn->close();
        ?>
        
    </div>
</div>
<div id="calendar-container">
    <div class="navigation-buttons">
        <button onclick="showPreviousMonth()">◀</button>
        <div id="calendar"></div>
        <button onclick="showNextMonth()">▶</button>
    </div>
</div>
<script>
    
    var tickets = <?php echo json_encode($tickets); ?>;

    // 초기 달력 표시
    var today = new Date();
    var currentYear = today.getFullYear();
    var currentMonth = today.getMonth();
    generateCalendar(currentYear, currentMonth, tickets);

    function generateCalendar(year, month, tickets) {
        var calendarElement = document.getElementById('calendar');
        var header = document.createElement('h2');
        header.textContent = year + '년 ' + (month + 1) + '월';
        calendarElement.innerHTML = ''; // 기존 내용 지우기
        calendarElement.appendChild(header);

        // 이전에 생성된 달력이 있다면 삭제
        if (calendarElement.firstChild) {
            calendarElement.removeChild(calendarElement.firstChild);
        }

        // 달력 헤더 생성 (연도와 월 표시)
        var header = document.createElement('h2');
        header.textContent = year + '년 ' + (month + 1) + '월';
        calendarElement.appendChild(header);

        // 달력 테이블 생성
        var table = document.createElement('table');

        // 달력 테이블 헤더 생성 (요일 표시)
        var thead = document.createElement('thead');
        var headerRow = document.createElement('tr');
        var daysOfWeek = ['일', '월', '화', '수', '목', '금', '토'];

        for (var i = 0; i < 7; i++) {
            var th = document.createElement('th');
            th.textContent = daysOfWeek[i];
            headerRow.appendChild(th);
        }

        thead.appendChild(headerRow);
        table.appendChild(thead);

        // 달력 내용 생성
        var tbody = document.createElement('tbody');

        // 첫째 날의 날짜를 가져옴
        var firstDay = new Date(year, month, 1);

        // 첫째 날이 속한 주의 첫째 날로 이동
        var startDate = new Date(firstDay);
        startDate.setDate(1 - firstDay.getDay());

        // 6주(최대)만큼 반복
        for (var week = 0; week < 6; week++) {
            var tr = document.createElement('tr');

            // 7일(요일)만큼 반복
            for (var day = 0; day < 7; day++) {
                    var td = document.createElement('td');
                    var currentDate = new Date(startDate);
                    currentDate.setDate(startDate.getDate() + week * 7 + day);

                    // 이번 달에 속하는 날짜만 표시
                    if (currentDate.getMonth() === month) {
                        // 이미지 추가 부분 수정
                            // 버튼 추가 부분
                            var button = document.createElement('button');
                            button.textContent = currentDate.getDate();
                            button.addEventListener('click', function (selectedDate) {
                                return function () {
                                    dateButtonClick(selectedDate);
                                };
                            }(new Date(currentDate))); // 클로저를 사용하여 현재 날짜를 전달

                            td.appendChild(button);
                            // 티켓 데이터 확인
                            for (var i = 0; i < tickets.length; i++) {
                                var ticketDate = new Date(tickets[i].ticketDate);

                                if (currentDate.getDate() === ticketDate.getDate() &&
                                    currentDate.getMonth() === ticketDate.getMonth() &&
                                    currentDate.getFullYear() === ticketDate.getFullYear()) {

                                    var image = new Image();
                                    image.src = tickets[i].ticketPicture;
                                    td.appendChild(image);
                                }
                            }

                    }
                    tr.appendChild(td);
                
            }
            tbody.appendChild(tr);
        }

        table.appendChild(tbody);
        calendarElement.appendChild(table);
    }
    // 날짜 칸 클릭 이벤트 처리 함수 --> 수정 예정!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    function dateButtonClick(selectedDate) {
        // 클래스를 토글하여 클릭한 날짜에 대한 시각적 표시 변경
        selectedDate.target.classList.toggle('clicked');

    }

    function showPreviousMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth, tickets);
    }

    function showNextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth, tickets);
    }


</script> 

</body>
</html>