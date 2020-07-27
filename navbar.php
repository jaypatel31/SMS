<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Admin Portal</h4>
	 <?php
		$home_class = $view_class = $add_class = $update_class ="";
		$basename = basename($_SERVER['SCRIPT_NAME']);
		if($basename == "index.php"){
			$home_class = 'class="active"';
		}else if($basename == "view.php" || $basename == "delete.php" ){
			$view_class = 'class="active"';
		}else if($basename == "add.php"){
			$add_class = 'class="active"';
		}else if($basename == "update.php"){
			$update_class = 'class="active"';
		}
	  ?>
      <ul class="nav nav-pills nav-stacked">
        <li <?php echo $home_class ?>><a href="index.php">Home</a></li>
        <li <?php echo $view_class ?>><a href="view.php">View Or Delete</a></li>
        <li <?php echo $add_class ?>><a href="add.php">Add</a></li>
        <li <?php echo $update_class ?>><a href="update.php">Update</a></li>
		<li ><a href="logout.php">Logout</a></li>
      </ul><br>
    </div>