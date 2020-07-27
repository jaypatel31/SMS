<?php
	session_start();
	require_once 'pdo.php';
?>
<?php if(isset($_SESSION['username'])){ ?>
<?php
	$name = $surname = $registration_date=$fees_paid = $dob = $gender=$phone=$course = $faculty = $address = $city = $state = $country = $start = $end="";
	$error = $success = false;
	if(isset($_POST['student_data'])){
		$name= $_POST['SN'];
		$surname= $_POST['SS'];
		$registration_date= $_POST['SR'];
		$fees_paid= $_POST['FP'];
		$dob= $_POST['SD'];
		isset($_POST['G'])?$_POST['G']:$_POST['G'] = "";
		$gender= $_POST['G'];
		$phone= $_POST['P'];
		$course = $_POST['course'];
		$faculty= $_POST['faculty'];
		$address= $_POST['SA'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['Country'];
		$start= $_POST['SD'];
		$end=$_POST['ED'];
		if(is_numeric($phone) || is_numeric($fees_paid)){
			if(isset($_POST['SN'])){
				if($gender!==""){
					$sql = "INSERT INTO address (Address,city_id,state_id,country_id) VALUES (:add, :city, :state, :country)";
					$stmt = $pdo->prepare($sql);
					$stmt->execute(array(
						':add' => htmlentities($address),
						':city' => $city,
						':state' => $state,
						':country' => $country
					));
					$call = 'SELECT address_id FROM address WHERE Address= :adde';
					$stmt3= $pdo->prepare($call);
					$stmt3->execute(array(
						':adde' => htmlentities($address)
					));
					$rows4 = $stmt3->fetch(PDO::FETCH_ASSOC);
					$Naddress = $rows4['address_id'];
					$sql2 = "INSERT INTO `user_master` (`user_name`, `user_Surname`, `user_registration_date`, `user_course_id`, `alloted_faculty_id`, `starting_date`, `ending_date`, `fees_paid`, `dob`, `gender`, `phone`, `user_address_id`) VALUES ( :name, :surname, :regdate, :course, :faculty, :start, :end, :fees, :dob, :gender, :phone, :address)";
					$stmt2= $pdo->prepare($sql2);
					$stmt2->execute(array(
						':name' => htmlentities($name),
						':surname' => htmlentities($surname),
						':regdate' => $registration_date,
						':course' => $course,
						':faculty' => $faculty,
						':start' => $start,
						':end' =>$end,
						':fees' => $fees_paid,
						':dob' => $dob,
						':gender' => $gender,
						':phone' => $phone,
						':address' =>$Naddress
					));
					$_SESSION['success'] = "Record Added Succesfully";
					header('Location: add.php?message1=Student');
					return;
				}
				else{
					$error = "Please Select Gender";
				}
			}
		}else{
			$error= "Phone or Fees_paid should be numeric";
		}
	}
	if(isset($_POST['faculty_data'])){
		$name= $_POST['FN'];
		$surname= $_POST['FS'];
		$registration_date= $_POST['FR'];
		$dob= $_POST['FD'];
		isset($_POST['G'])?$_POST['G']:$_POST['G'] = "";
		$gender= $_POST['G'];
		$phone= $_POST['P'];
		$course = $_POST['course'];
		$address= $_POST['SA'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['Country'];
		if(is_numeric($phone)){
			if(isset($_POST['FN'])){
				if($gender!==""){
					$sql = "INSERT INTO address (Address,city_id,state_id,country_id) VALUES (:add, :city, :state, :country)";
					$stmt = $pdo->prepare($sql);
					$stmt->execute(array(
						':add' => htmlentities($address),
						':city' => $city,
						':state' => $state,
						':country' => $country
					));
					$call = 'SELECT address_id FROM address WHERE Address= :adde';
					$stmt3= $pdo->prepare($call);
					$stmt3->execute(array(
						':adde' => htmlentities($address)
					));
					$rows4 = $stmt3->fetch(PDO::FETCH_ASSOC);
					
					$Naddress = $rows4['address_id'];
					$sql2 = "INSERT INTO `faculty_info` (`faculty_name`, `faculty_Surname`, `faculty_registration_date`, `faculty_course_id`, `dob`, `gender`, `phone`, `faculty_address_id`) VALUES ( :name, :surname, :regdate, :course,  :dob, :gender, :phone, :address)";
					$stmt2= $pdo->prepare($sql2);
					$stmt2->execute(array(
						':name' => htmlentities($name),
						':surname' => htmlentities($surname),
						':regdate' => $registration_date,
						':course' => $course,
						':dob' => $dob,
						':gender' => $gender,
						':phone' => $phone,
						':address' =>$Naddress
					));
					$_SESSION['success'] = "Record Added Succesfully";
					header('Location: add.php?message2=Faculty');
					return;
				}
				else{
					$error = "Please Select Gender";
				}
			}
		}else{
			$error= "Phone should be numeric";
		}
	}
?>
<html>
<head>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require 'header.php' ?>
	<style>
		
		label{
			padding:8px;
			display:inline-block;
			width:25%;
		}
	</style>
</head>
<body>
	<?php require 'navbar.php' ?>
	<div class="col-sm-9">
      <h1>Admin Portal</h1>
	  <hr>
		
    
	<h1>Add Mode</h1>
	<?php if($error !== false){
		echo '<span style="color:red">'.$error.'</span>';
	}?>
	<?php if(isset($_SESSION['success'])){
		echo '<span style="color:green">'.$_SESSION['success'].'</span>';
		$_SESSION['success'] = "";
	}?>
	<form method="post">
		<input type="submit" class="btn btn-primary" name="student" value="New Student "><br/> <br/>
		<input type="submit" class="btn btn-primary" name="faculty" value="New Faculty" ><br/> <br/>
		<a href="index.php">Back</a>
	</form>
	</div>
<form method="post"  class="form-inline">
<div class="col-sm-9">
<?php
	if(isset($_POST['student'])){
		?>
			 
			<p>
			<label >Student_Name : </label><input   required type="text" name="SN">
			</p>
			<p >
			<label >Student_Surname : </label><input required type="text" name="SS">
			</p>
			<p>
			<label >Student_Registration_Date : </label><input required type="date" name="SR">
			</p>
			<p>
			<label>Starting_Date : </label><input required type="date" name="ST">
			</p>
			<p>
			<label>Ending_Date : </label><input required type="date" name="ED">
			</p>
			<p>
			<label>Fees_paid :</label> <input required type="text" name="FP">
			</p>
			<p>
			<label>Student_Dob :</label> <input required type="date" name="SD">
			</p>
			<p>
			<label>Gender :</label> <input  type="radio" name="G" value="M">M <input type="radio" name="G" value="F">F
			</p>
			<p>
			<label>Phone :</label> <input required type="text" name="P">
			</p>
		
<?php 
	$sql = 'SELECT course_name,course_id FROM course_master';
	$stmt = $pdo->query($sql);
	echo "<p><label>Course :</label> <select name='course'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['course_id']."'>".$rows['course_name']."</option>";
		
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT faculty_name,faculty_id FROM faculty_info';
	$stmt = $pdo->query($sql);
	echo "<p><label>Faculty :</label> <select name='faculty'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['faculty_id']."'>".$rows['faculty_name']."</option>";
		
	}
	echo "</select> </p>";

?>
<p>
<label>Address :</label> <input type="txt" name="SA" placeholder="24, shreeram society">
</p>
<?php 
	$sql = 'SELECT City,city_id FROM city';
	$stmt = $pdo->query($sql);
	echo "<p><label>City :</label> <select name='city'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['city_id']."'>".$rows['City']."</option>";
		
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT state,state_id FROM state';
	$stmt = $pdo->query($sql);
	echo "<p><label>state :</label> <select name='state'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['state_id']."'>".$rows['state']."</option>";
		
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT Country,country_id FROM country';
	$stmt = $pdo->query($sql);
	echo "<p><label>Country :</label> <select name='Country'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['country_id']."'>".$rows['Country']."</option>";
		
	}
	echo "</select> </p>";

?>
<input type="submit" class="btn btn-primary" Value="submit" name="student_data">
<?php }
	
?>
<?php
	if(isset($_POST['faculty'])){
		?>

			<p>
			<label>Faculty_Name : </label><input required type="text" name="FN">
			</p>
			<p>
			<label>Faculty_Surname : </label><input required type="text" name="FS">
			</p>
			<p>
			<label>Faculty_Registration_Date : </label><input required type="date" name="FR">
			</p>
			<p>
			<label>Faculty_Dob :</label> <input required type="date" name="FD">
			</p>
			<p>
			<label>Gender :</label> <input  type="radio" name="G" value="M">M <input type="radio" name="G" value="F">F
			</p>
			<p>
			<label>Phone :</label> <input required type="text" name="P">
			</p>
		
<?php 
	$sql = 'SELECT course_name,course_id FROM course_master';
	$stmt = $pdo->query($sql);
	echo "<p><label>Course :</label> <select name='course'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['course_id']."'>".$rows['course_name']."</option>";
		
	}
	echo "</select> </p>";

?>
<p>
<label>Address :</label> <input type="txt" name="SA" placeholder="24, shreeram society">
</p>
<?php 
	$sql = 'SELECT City,city_id FROM city';
	$stmt = $pdo->query($sql);
	echo "<p><label>City :</label> <select name='city'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['city_id']."'>".$rows['City']."</option>";
		
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT state,state_id FROM state';
	$stmt = $pdo->query($sql);
	echo "<p><label>state :</label> <select name='state'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['state_id']."'>".$rows['state']."</option>";
		
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT Country,country_id FROM country';
	$stmt = $pdo->query($sql);
	echo "<p><label>Country :</label> <select name='Country'>";
	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			echo "<option value='".$rows['country_id']."'>".$rows['Country']."</option>";
		
	}
	echo "</select> </p>";

?>
<input type="submit" class="btn btn-primary" Value="submit" name="faculty_data">
<?php }
	
?>
</div>
</form>
 
  </div>
</div>
</body>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<?php 
if(isset($_GET['message1'])){
echo '
<script>
Toastify({
  text: "Student Data Added Succesfully",
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
setTimeout(function(){ location.href="add.php" }, 2000);
</script>';

}
if(isset($_GET['message2'])){
echo '
<script>
Toastify({
  text: "Faculty Data Added Succesfully",
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
setTimeout(function(){ location.href="add.php" }, 2000);
</script>';
}
?>
</html>
<?php }
	else{
		header('Location: login.php?error=Access Frobidden');
	}
?>