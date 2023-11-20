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
  <header>
		<h1>영웅</h1>
	</header>
	<form action="hero.php" method="POST">
		별점 :
		<select name="rating" style="width:100px;height:20.5px">
			<option value="★★★★★"> ★★★★★ </option>
			<option value="★★★★☆"> ★★★★☆ </option>
			<option value="★★★☆☆"> ★★★☆☆ </option>
			<option value="★★☆☆☆"> ★★☆☆☆ </option>
			<option value="★☆☆☆☆"> ★☆☆☆☆ </option>
		</select><br>
		후기 : <br>
		<textarea name="review" cols="30" rows="2">			
		</textarea> &nbsp;&nbsp;
		<input type="submit" value="후기작성">
		</form>
		<iframe src="review.php" width="300" height="300">
		
		</iframe>
 	
</body>
</html>