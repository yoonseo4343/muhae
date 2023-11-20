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
 	$conn = mysqli_connect('18.211.113.100', 'root','rootuser', 'muhae');

	$sql = "SELECT * FROM muhae";
	while($row = mysqli_fetch_array)$result)){
		echo $row['rating'];
		echo $row['review'];        
        ?>
        </fieldset>
        <div align="left">
            <input type="submit" value="후기작성">
        </div>
</form>
 	
</body>
</html>