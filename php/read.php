<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>뭐해? 뮤해!</title>
    <style>
        <?php include 'webstyle.css';?>
    </style>
</head>

<body>
    <?php
    $connect = mysqli_connect('127.0.0.1', 'root', 'password', 'db_board');
    $number = $_GET['number'];  // GET 방식 사용
    session_start();
    $query = "select title, content, date, hit, id from board where number = $number";
    $result = $connect->query($query);
    $rows = mysqli_fetch_assoc($result);
    ?>

    <table class="read_table" align=center>
        <tr>
            <td colspan="4" class="read_title"><?php echo $rows['title'] ?></td>
        </tr>
        <tr>
            <td class="read_id">작성자</td>
            <td class="read_id2"><?php echo $rows['id'] ?></td>
            <td class="read_hit">조회수</td>
            <td class="read_hit2"><?php echo $rows['hit'] ?></td>
        </tr>


        <tr>
            <td colspan="4" class="read_content" valign="top">
                <?php echo $rows['content'] ?></td>
        </tr>
    </table>

    <!-- MODIFY & DELETE 추후 세션처리로 보완 예정 -->
    <div class="read_btn">
        <button class="read_btn1" onclick="location.href='./index.php'">목록</button>&nbsp;&nbsp;
        <button class="read_btn1" onclick="location.href='./modify.php?number=<?= $number ?>&id=<?= $_SESSION['userid'] ?>'">수정</button>&nbsp;&nbsp;
        <button class="read_btn1" onclick="location.href='./delete.php?number=<?= $number ?>&id=<?= $_SESSION['userid'] ?>'">삭제</button>
    </div>
</body>

</html>