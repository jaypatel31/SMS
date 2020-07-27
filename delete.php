<?php
	session_start();
	require_once 'pdo.php';
	if(isset($_POST['delete'])){
		header('Location: view.php');
		$sql2 = "DELETE FROM user_master WHERE user_id = :id";
		$stmt2 = $pdo->prepare($sql2);
		$stmt2->execute(array(
			':id' => htmlentities($_GET['id'])
		));
		
		$_SESSION['success'] = "Record Deleted Successfully";
		header('Location: view.php?message1=Student Data Deleted Succesfully');
	}
	if(isset($_POST['delete2'])){
		$sql2 = "DELETE FROM faculty_info WHERE faculty_id = :id";
		$stmt2 = $pdo->prepare($sql2);
		$stmt2->execute(array(
			':id' => htmlentities($_GET['id2'])
		));
		$_SESSION['success'] = "Record Deleted Successfully";
		header('Location: view.php?message2=Faculty Data Deleted Succesfully');
	}
?>
<?php
	$name = false;
	if(isset($_GET['id'])){
		$sql = "SELECT user_name FROM user_master WHERE user_id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':id' => htmlentities($_GET['id'])
		));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = $rows['user_name'];
		$name2 = "delete";
	}
	if(isset($_GET['id2'])){
		$sql = "SELECT faculty_name FROM faculty_info WHERE faculty_id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':id' => htmlentities($_GET['id2'])
		));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = $rows['faculty_name'];
		$name2 = "delete2";
	}
?>
<html>
<head>
	<title>DELETE</title>
	<?php require('header.php')?>
</head>
<body>
<?php require('navbar.php')?>
	
		<div class="col-sm-9">
      <h1>Admin Portal</h1>
	  <hr>
		<form method="post">
		<?php
		if($name!==false){
			echo "<p style='color:red'> Are you Sure To Delete ".$name." Data?</p>";
		}
		?>
		<p>
			<input type="submit"  class="btn btn-danger" value="Yes" name="<?php echo $name2?>">
			<a href="view.php">NO</a>
		</p>
		</form>
		 </div>
</div>
</div>
</body>
</html>

  