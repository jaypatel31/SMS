<?php
	session_start();
	require('pdo.php');
	
?>
<?php if(isset($_SESSION['username'])){ ?>
<?php
	$sql = "SELECT count(*) From user_master";
	$stmt= $pdo->query($sql);
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	$student = $rows['count(*)'];
	
	$sql2 = "SELECT count(*) From faculty_info";
	$stmt2= $pdo->query($sql2);
	$rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	$faculty = $rows2['count(*)'];
?>
<html>
<?php require('header.php')?>
<body>

<?php require('navbar.php')?>

    <div class="col-sm-9">
      <h1>Admin Portal</h1>
	  <hr>
		<p>Welcome to the admin portal</p>
		<p>Number of student in this system : <?php echo $student?></p>
		<p>Number of Faculty in this system : <?php echo $faculty?></p>
		<p>Click On the Navigation bar to do Tasks.</p>
    </div>
  </div>
</div>

</body>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<?php echo '
<script>
Toastify({
  text: "Welcome to the Admin Portal ",
  duration: 2000, 
  destination: "https://github.com/apvarun/toastify-js",
  newWindow: true,
  close: true,
  gravity: "top", // `top` or `bottom`
  position: "center", // `left`, `center` or `right`
  backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
  stopOnFocus: true, // Prevents dismissing of toast on hover
  onClick: function(){} // Callback after click
}).showToast();
</script>'
?>
</html>
<?php }
	else{
		header('Location: login.php?error=Permission Frobidden');
	}
?>
