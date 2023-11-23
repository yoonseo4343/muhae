<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style> 
    <?php include 'calendar.css';?>
  </style>
  <title>달력 예제</title>
</head>
<body>
<div id="calendar-container">
    <div class="navigation-buttons">
        <button onclick="showPreviousMonth()">◀</button>
        <div id="calendar"></div>
        <button onclick="showNextMonth()">▶</button>
    </div>
</div>

<script>
    // 초기 달력 표시
    var today = new Date();
    var currentYear = today.getFullYear();
    var currentMonth = today.getMonth();
    generateCalendar(currentYear, currentMonth);

    function generateCalendar(year, month) {
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
                    // 이미지 추가 부분
                    var image = new Image();
                    var imagePath = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate() + '.jpg';
                    image.src = imagePath;
                    td.textContent = currentDate.getDate();

                    // 이미지가 있는 경우에는 이미지와 년, 월, 일 정보를 함께 표시
                    if (image.complete) { // 이미지가 로드되었는지 확인
                        
                        var dateDiv = document.createElement('div');
                        dateDiv.textContent = currentDate.getDate();

                        td.appendChild(image);
                    }
                }

                tr.appendChild(td);
            }

            tbody.appendChild(tr);
        }

        table.appendChild(tbody);
        calendarElement.appendChild(table);
    }

    function showPreviousMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth);
    }

    function showNextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth);
    }

    // 예제로 현재 날짜의 달력을 표시
    var today = new Date();
    generateCalendar(today.getFullYear(), today.getMonth());
</script>

</body>
</html>
