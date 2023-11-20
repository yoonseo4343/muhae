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
<?php
	$conn = mysqli_connect('18.211.113.100', 'root','rootuser', 'muhae');
	$sql = "
		INSERT INTO muhae
		(rating, review)
		VALUES(
			'{$_POST['rating']}',
			'{$_POST['review']}',
			NOW()
		)
		";
		mysql_query($conn, $sql);
		echo $sql;
?>


    <div id="board_write">
        <h2>REVIEW</h2>
            <div id="write_board">
                <form action="hero.php" method="POST">
                    <div id="board_title">
                       제목 :  <input type="text" name="title" size="30">
                    </div>
	
                    <hr>
                    <div id="in_rating">
                    <fieldset style="width:330px">
                    별점 :
                    <select name="rating" style="width:100px;height:30px">
                        <option value="★★★★★"> ★★★★★ </option>
                        <option value="★★★★☆"> ★★★★☆ </option>
                        <option value="★★★☆☆"> ★★★☆☆ </option>
                        <option value="★★☆☆☆"> ★★☆☆☆ </option>
                        <option value="★☆☆☆☆"> ★☆☆☆☆ </option>
                    </select><br>
                    
                    후기 : <br>
                    <textarea name="review" cols="50" rows="50">
                    </textarea>
                    <hr>

                    <div align="center">
  					<input type="submit" value="전송하기"> &nbsp;&nbsp;
  					<input type="reset" value="다시작성">
                </div><br>
  				</fieldset>

                </form>
            </div>
    </div>

</body>
</html>