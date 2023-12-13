<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
      <title>뭐해? 뮤해!</title>
    <style>
        table.table2 {
            border-collapse: separate;
            border-spacing: 1px;
            text-align: left;
            line-height: 1.5;
            border-top: 1px solid #ccc;
            margin: 20px 10px;
        }

        table.table2 tr {
            width: 50px;
            padding: 10px;
            font-weight: bold;
            vertical-align: top;
            border-bottom: 1px solid #ccc;
        }

        table.table2 td {
            width: 100px;
            padding: 10px;
            vertical-align: top;
            border-bottom: 1px solid #ccc;
        }
<?php include 'webstyle.css';?>
    </style>
</head>

<body>
<?php include 'title.php'; ?>

<div class="content">
    <div class="center">
<?php
// 폼이 제출되었을 때의 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 데이터베이스 연결
    require_once("dbconfig.php");

    $title = $_POST['title'];
    $content = $_POST['content'];
    $createdAt = date('Y-m-d H:i:s');
    $rating = $_POST['rating'];
 

    // 데이터베이스에 데이터 삽입
    $sql = "INSERT INTO review (memberId, title, content, createdAt, rating) 
    VALUES ('$sessionId', '$title', '$content', '$createdAt', '$rating')";

    if ($conn->query($sql) === TRUE) {
        $lastInsertedId = $conn->insert_id; // 새로 생성된 boardId를 가져옴
        echo '<script>alert("리뷰가 성공적으로 등록되었습니다.");</script>';
        echo '<script>window.location.href = "hero.php";</script>';
    } else {
        echo "리뷰 등록에 실패했습니다. 에러: " . $conn->error;
    }

    // 데이터베이스 연결 종료
    $conn->close();
}
?>
<!-- 리뷰등록폼 -->
    <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <!-- method : POST!!! (GET X) -->
        <table style="padding-top:50px" align=center width=auto border=0 cellpadding=2>
            <tr>
                <td style="height:40; float:center; background-color:#3C3C3C">
                    <p style="font-size:25px; text-align:center; color:white; margin-top:15px; margin-bottom:15px"><b>리뷰 작성하기</b></p>
                </td>
            </tr>
            <tr>
                <td bgcolor=white>
                    <table class="table2">
                        <tr>
                            <td><label for="title">뮤지컬</label></td>
                            <td><input type="text" name="title" size=70 required></td>
                        </tr>
                        <tr>
                                    <td><label for="rating">별점</label></td>
                                    <td>
                                        <select name="rating" required>
                                            <option value="★☆☆☆☆">★☆☆☆☆</option>
                                            <option value="★★☆☆☆">★★☆☆☆</option>
                                            <option value="★★★☆☆">★★★☆☆</option>
                                            <option value="★★★★☆">★★★★☆</option>
                                            <option value="★★★★★">★★★★★</option>
                                        </select>
                                    </td>
                                </tr>
                        <tr>
                            <td><label for="content">리뷰</label></td>
                            <td><textarea name="content" cols=75 rows=15 required></textarea></td>
                        </tr>
                    </table>

                    <center>
                        <input style="height:26px; font-size:16px;" type="submit" value="등록하기">
                    </center>
                </td>
            </tr>
        </table>
    </form>
    <a href="hero.php"><button>돌아가기</button></a>
    </div></div>
</body>

</html>