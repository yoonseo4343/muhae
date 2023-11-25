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
    require_once("dbconfig.php");
    $query = "select * from review order by boardId desc";    //역순 출력
    $result = mysqli_query($connect, $query);
    //$result = $connect->query($query);
    $total = mysqli_num_rows($result);  //result set의 총 레코드(행) 수 반환
    ?>
    <p style="font-size:25px; text-align:center"><b>게시판</b></p>
    <table align=center>
        <thead align="center">
            <tr>
                <td width="50" align="center">번호</td>
                <td width="500" align="center">제목</td>
                <td width="100" align="center">작성자</td>
                <td width="200" align="center">날짜</td>
                <td width="50" align="center">조회수</td>
            </tr>
        </thead>

        <tbody>
            <?php
            while ($rows = mysqli_fetch_assoc($result)) { //result set에서 레코드(행)를 1개씩 리턴
                if ($total % 2 == 0) {
            ?>
                    <tr class="even">
                        <!--배경색 진하게-->
                    <?php } else {
                    ?>
                    <tr>
                        <!--배경색 그냥-->
                    <?php } ?>
                    <td width="50" align="center"><?php echo $total ?></td>
                    <td width="500" align="center">
                        <a href="read.php?number=<?php echo $rows['number'] ?>">
                            <?php echo $rows['title'] ?>
                    </td>
                    <td width="100" align="center"><?php echo $rows['id'] ?></td>
                    <td width="200" align="center"><?php echo $rows['date'] ?></td>
                    <td width="50" align="center"><?php echo $rows['hit'] ?></td>
                    </tr>
                <?php
                $total--;
            }
                ?>
        </tbody>
    </table>

    <div class=text>
        <font style="cursor: hand" onClick="location.href='./write.php'">글쓰기</font>
    </div>
</body>

</html>
 	