<!DOCTYPE html>
<html lang="en">
<!-- 헤더,네비 불러옴 / 로그인 검사-->
<?php 
    include 'title.php'; 
    require_once("checkLog.php");
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?> 
        <?php include 'calendar.css';?>
        /* 스타일 불러옴 */
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
            width: 40%;
            max-width: 600px;

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
        table {
            background-color: #FFFFFF; /* 새로운 배경색을 여기에 지정하세요 */
        }
        h2 {
            color: white; /* 헤더 텍스트의 색상을 지정하세요 */
            padding: 10px; /* 헤더의 내부 여백을 조절하세요 */
            text-align: center; /* 헤더 텍스트의 정렬을 조절하세요 */
            margin-top: 0; /* 헤더의 상단 마진을 조절하세요 */
        }

    </style>
</head>

<body>
    

    <div class="content">
        <div class="left-side">
            <!-- 티켓북 업로드 버튼 -->
            <a href="ticketUpload.php"><button>티켓 추가</button></a>
            <?php
            // 데이터베이스 연결
            require_once("dbconfig.php");

            // ticketBook 테이블에서 memberId가 $sessionId인 경우 조회
            $selectSql = "
            SELECT ticketDate, ticketPicture, ticketMemo
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
            <div id="calendar-container">
                <div class="navigation-buttons">
                    <button onclick="showPreviousMonth()">◀</button>
                    <div id="calendar"></div>
                    <button onclick="showNextMonth()">▶</button>
                </div>
            </div>
    </div>

    <!-- 모달 창 -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="modalText"></p>
        </div>
    </div>

    <script>

        var tickets = <?php echo json_encode($tickets); ?>;
        var currentYear, currentMonth;

        // 초기 달력 표시
        var today = new Date();
        currentYear = today.getFullYear();
        currentMonth = today.getMonth();
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
            header = document.createElement('h2');
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
                        // 버튼 또는 이미지 추가 부분
                        var buttonOrImage;
                        var hasImage = false;
                        var ticket; // 이미지 클릭시 관련 티켓 정보를 저장할 변수

                        for (var i = 0; i < tickets.length; i++) {
                            var ticketDate = new Date(tickets[i].ticketDate);

                            if (
                                currentDate.getDate() === ticketDate.getDate() &&
                                currentDate.getMonth() === ticketDate.getMonth() &&
                                currentDate.getFullYear() === ticketDate.getFullYear()
                            ) {
                                // 이미지 추가 부분
                                var image = new Image();
                                image.src = tickets[i].ticketPicture;
                                image.addEventListener('click', function (selectedTicket) {
                                    return function () {
                                        ticket = selectedTicket;
                                        openModal(ticket);
                                    };
                                }(tickets[i])); // 클로저를 사용하여 현재 티켓을 전달

                                buttonOrImage = image;
                                hasImage = true;
                                break; // 이미지를 찾았으면 반복문 종료
                            }
                        }

                        // 모달 열기
                        function openModal(selectedTicket) {
                            var modalTextElement = document.getElementById('modalText');
                            if (modalTextElement) {
                                var memo = selectedTicket.ticketMemo || '메모가 없습니다.';
                                modalTextElement.innerText = 'Ticket Memo: ' + memo;
                                document.getElementById('myModal').style.display = 'block';
                            } else {
                                console.error('Modal text element not found.');
                            }
                        }

                        // 이미지가 없는 경우 버튼 추가
                        if (!hasImage) {
                            var button = document.createElement('button');
                            button.textContent = currentDate.getDate();
                            button.addEventListener('click', function (selectedDate) {
                                return function () {
                                    ticket = null; // 이미지가 없는 경우 ticket을 null로 설정
                                    dateButtonClick(selectedDate);
                                };
                            }(new Date(currentDate))); // 클로저를 사용하여 현재 날짜를 전달

                            buttonOrImage = button;
                        }

                        td.innerHTML = ''; // 기존 내용 지우기
                        td.appendChild(buttonOrImage);

                    }
                    tr.appendChild(td);

                }
                tbody.appendChild(tr);
            }

            table.appendChild(tbody);
            calendarElement.appendChild(table);
        }

        // 날짜 칸 클릭 이벤트 처리 함수
        function dateButtonClick(selectedTicket) {
            // 클릭 시 콘솔에 로그 출력
            if (selectedTicket) {
                var memo = selectedTicket.ticketMemo || '메모가 없습니다.';
                window.alert('Ticket Memo: ' + memo);
            } else {
                window.alert('No Ticket Memo available.');
            }
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

        // 모달 닫기
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

    </script>

</body>

</html>