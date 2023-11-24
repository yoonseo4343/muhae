<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>뭐해? 뮤해!</title>
	<style>
        <?php include 'webstyle.css';?>

  </style>

</head>
<body>
        <?php include 'title.php'; ?>
	<form action="write.php" method="POST">
        <fieldset style="width:330px">
        <legend>영웅 후기 게시판</legend>
        <?php
 	// 데이터베이스 연결
         require_once("dbconfig.php");

	$sql = "SELECT rating,title FROM review";
	$result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "Rating: " . $row['rating'] . "<br>";
                        echo "Title: " . $row['title'] . "<br><br>";
                    }
                } else {
                    echo "No reviews yet.";
                }

                mysqli_close($conn);
        ?>
        </fieldset>
        <div class="left">
            <input type="submit" value="후기작성">
        </div>
</form>
 	
</body>
</html>