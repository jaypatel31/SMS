<?php
	session_start();
	require_once 'pdo.php';
	if(isset($_GET['update'])){
		header('Location: update.php?id='.$_GET['id']);
	}
	if(isset($_GET['update2'])){
		header('Location: update.php?id2='.$_GET['id2']);
	}
?>
<?php if(isset($_SESSION['username'])){ ?>
<?php
	$name = $surname = $registration_date = $fees_paid = $dob = $gender = $phone=$course = $faculty = $address = $city = $state = $country = $start = $end="";
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
					$sql = "UPDATE  address SET Address = :add, city_id = :city, state_id = :state, country_id = :country WHERE address_id = :ide";
					$stmt = $pdo->prepare($sql);
					$stmt->execute(array(
						':ide' => $_POST['id'],
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
					$sql2 = "UPDATE `user_master` SET `user_name` = :name, `user_Surname` = :surname, `user_registration_date` = :regdate, `user_course_id` = :course, `alloted_faculty_id` = :faculty, `starting_date`= :start, `ending_date` = :end, `fees_paid` = :fees, `dob` = :dob, `gender` = :gender, `phone` = :phone, `user_address_id` = :address WHERE user_id = :id ";
					$stmt2= $pdo->prepare($sql2);
					$stmt2->execute(array(
						':id' => htmlentities($_GET['id']),
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
					$_SESSION['success'] = "Record Updated Succesfully";
					header('Location: update.php?message1=Student');
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
					$sql = "UPDATE  address SET Address = :add, city_id = :city, state_id = :state, country_id = :country WHERE address_id = :ide";
					$stmt = $pdo->prepare($sql);
					$stmt->execute(array(
						':ide' => $_POST['id2'],
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
					$sql2 = "UPDATE `faculty_info` SET `faculty_name` = :name, `faculty_Surname`= :surname, `faculty_registration_date` = :regdate, `faculty_course_id` = :course,`dob` = :dob, `gender` = :gender, `phone` = :phone, `faculty_address_id` = :address WHERE faculty_id = :id";
					$stmt2= $pdo->prepare($sql2);
					$stmt2->execute(array(
						':id' => htmlentities($_GET['id2']),
						':name' => htmlentities($name),
						':surname' => htmlentities($surname),
						':regdate' => $registration_date,
						':course' => $course,
						':dob' => $dob,
						':gender' => $gender,
						':phone' => $phone,
						':address' =>$Naddress
					));
					$_SESSION['success'] = "Record Updated Succesfully";
					header('Location: update.php?message2=Faculty');
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
	<style>
		
		label{
			padding:8px;
			display:inline-block;
			width:25%;
		}
	</style>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once('header.php')?>
</head>

<body>
<?php require('navbar.php')?>
<div class="col-sm-9">
      <h1>Admin Portal</h1>
	  <hr>
	<h1>Update Mode</h1>
	<?php if($error !== false){
		echo '<span style="color:red">'.$error.'</span>';
	}?>
	<?php if(isset($_SESSION['success'])){
		echo '<span style="color:green">'.$_SESSION['success'].'</span>';
		$_SESSION['success'] = "";
	}?>
	<form>
		<input type="submit" name="student" class="btn btn-primary" value="Student Data"><br/> <br/>
		<input type="submit" name="faculty" class="btn btn-primary" value="Faculty Data"><br/>  <br/>
		<a href="index.php">Back</a>
	</form>
   
<?php
require_once('pdo.php');
	if(isset($_GET['student'])){
		$sql = "SELECT user_master.user_id,user_master.User_name,user_master.User_surname,user_master.user_registration_date,user_master.starting_date,user_master.ending_date,course_master.course_name,user_master.DOB,user_master.fees_paid,user_master.Gender,user_master.Phone,address.Address,city.City,state.state,country.Country,faculty_info.faculty_name FROM user_master INNER JOIN city JOIN state JOIN address JOIN country JOIN course_master JOIN faculty_info ON user_master.user_address_id = address.address_id AND address.city_id = city.city_id AND address.state_id = state.state_id AND address.country_id = country.country_id AND user_master.user_course_id = course_master.course_id AND user_master.alloted_faculty_id = faculty_info.faculty_id";
		$stmt = $pdo->query($sql);
		echo "<table class='table table-striped table-hover'>";
		echo "<tr>";
			echo "<th scope='col'>";
					echo 'User_name';
				echo "</th>";
				echo "<th>";
					echo 'User_surname';
				echo "</th scope='col'>";
				echo "<th>";
					echo 'course_name';
				echo "</th scope='col'>";
				echo "<th>";
					echo 'starting_date';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'ending_date';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'faculty_name';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'DOB';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Gender';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Phone';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Address';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'City';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'state';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'fees_paid';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Action';
				echo "</th>";
		echo "</tr>";
		while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo "<tr>";
				echo "<td scope='rows'>";
					echo $rows['User_name'];
				echo "</td>";
				echo "<td>";
					echo $rows['User_surname'];
				echo "</td>";
				echo "<td>";
					echo $rows['course_name'];
				echo "</td>";
				echo "<td>";
					echo $rows['starting_date'];
				echo "</td>";
				echo "<td>";
					echo $rows['ending_date'];
				echo "</td>";
				echo "<td>";
					echo $rows['faculty_name'];
				echo "</td>";
				echo "<td>";
					echo $rows['DOB'];
				echo "</td>";
				echo "<td>";
					echo $rows['Gender'];
				echo "</td>";
				echo "<td>";
					echo $rows['Phone'];
				echo "</td>";
				echo "<td>";
					echo $rows['Address'];
				echo "</td>";
				echo "<td>";
					echo $rows['City'];
				echo "</td>";
				echo "<td>";
					echo $rows['state'];
				echo "</td>";
				echo "<td>";
					echo $rows['fees_paid'];
				echo "</td>";
				echo "<td>";
					echo "<form>";
						echo "<input type='text' name='id' hidden value='".$rows['user_id']."'>";
						echo "<input type='submit' class='btn btn-warning' name='update' value='Update'>";
					echo "</form>";
				echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}
	if(isset($_GET['faculty'])){
		$sql = "SELECT faculty_info.faculty_id,faculty_info.faculty_name,faculty_info.faculty_surname,faculty_info.faculty_registration_date,faculty_info.dob,faculty_info.gender,faculty_info.phone,course_master.course_name,address.Address,state.state,city.City,country.Country FROM faculty_info INNER JOIN course_master JOIN address JOIN city JOIN state JOIN country ON faculty_info.faculty_course_id = course_master.course_id AND faculty_info.faculty_address_id = address.address_id AND address.city_id = city.city_id AND address.state_id = state.state_id AND address.country_id = country.country_id;";
		$stmt = $pdo->query($sql);
		echo "<table class='table table-striped table-hover'>";
		echo "<tr>";
			echo "<th scope='col'>";
					echo 'faculty_name';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'faculty_surname';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'course_name';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'starting_date';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'DOB';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Gender';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Phone';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Address';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'City';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'state';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'Action';
				echo "</th>";
		echo "</tr>";
		while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo "<tr>";
				echo "<td scope='rows'>";
					echo $rows['faculty_name'];
				echo "</td>";
				echo "<td>";
					echo $rows['faculty_surname'];
				echo "</td>";
				echo "<td>";
					echo $rows['course_name'];
				echo "</td>";
				echo "<td>";
					echo $rows['faculty_registration_date'];
				echo "</td>";
				echo "<td>";
					echo $rows['dob'];
				echo "</td>";
				echo "<td>";
					echo $rows['gender'];
				echo "</td>";
				echo "<td>";
					echo $rows['phone'];
				echo "</td>";
				echo "<td>";
					echo $rows['Address'];
				echo "</td>";
				echo "<td>";
					echo $rows['City'];
				echo "</td>";
				echo "<td>";
					echo $rows['state'];
				echo "</td>";
				echo "<td>";
					echo "<form>";
						echo "<input type='text' name='id2' hidden value='".$rows['faculty_id']."'>";
						echo "<input type='submit' class='btn btn-warning' name='update2' value='Update'>";
					echo "</form>";
				echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}
?>
<?php
	$addId = "";
	if(isset($_GET['id'])){
		$sql7 = "SELECT user_master.user_id,user_master.User_name,user_master.User_surname,user_master.user_registration_date,user_master.starting_date,user_master.ending_date,course_master.course_name,user_master.DOB,user_master.fees_paid,user_master.Gender,user_master.Phone,user_master.user_address_id,address.Address,city.City,state.state,country.Country,faculty_info.faculty_name FROM user_master INNER JOIN city JOIN state JOIN address JOIN country JOIN course_master JOIN faculty_info ON user_master.user_address_id = address.address_id AND address.city_id = city.city_id AND address.state_id = state.state_id AND address.country_id = country.country_id AND user_master.user_course_id = course_master.course_id AND user_master.alloted_faculty_id = faculty_info.faculty_id WHERE user_master.user_id = :id";
		$stmt7 =$pdo->prepare($sql7);
		$stmt7->execute(array(
			':id' => htmlentities($_GET['id'])
		));
		$rows4 = $stmt7->fetch(PDO::FETCH_ASSOC);
		if($rows4 !== false){
		$addId = $rows4['user_address_id'];	
		?>
		<form method="post">
			<p>
			<input type="text" name="id" hidden value="<?php echo $addId?>">
			<label>Student_Name : </label><input required type="text" value="<?php echo $rows4['User_name']?>" name="SN">
			</p>
			<p>
			<label>Student_Surname : </label><input required value="<?php echo $rows4['User_surname']?>" type="text" name="SS">
			</p>
			<p>
			<label>Student_Registration_Date : </label><input required value="<?php echo $rows4['user_registration_date']?>" type="date" name="SR">
			</p>
			<p>
			<label>Starting_Date : </label><input required type="date" value="<?php echo $rows4['starting_date']?>" name="ST">
			</p>
			<p>
			<label>Ending_Date : </label><input required type="date" value="<?php echo $rows4['ending_date']?>" name="ED">
			</p>
			<p>
			<label>Fees_paid :</label> <input required type="text" value="<?php echo $rows4['fees_paid']?>" name="FP">
			</p>
			<p>
			<label>Student_Dob :</label> <input required type="date" value="<?php echo $rows4['DOB']?>" name="SD">
			</p>
			<p>
			<label>Gender :</label> <input  type="radio" name="G" <?php if($rows4['Gender'] =="M")echo 'checked'?> value="M">M <input type="radio" <?php if($rows4['Gender'] =="F")echo 'checked'?> name="G" value="F">F
			</p>
			<p>
			<label>Phone :</label> <input  required type="text" value="<?php echo $rows4['Phone']?>" name="P">
			</p>
		
<?php 
	$sql = 'SELECT course_name,course_id FROM course_master';
	$stmt = $pdo->query($sql);
	echo "<p><label>Course :</label> <select name='course'>";
	while($rows1 = $stmt->fetch(PDO::FETCH_ASSOC)){
			if($rows4['course_name'] == $rows1['course_name']){
				echo "<option value='".$rows1['course_id']."' selected>".$rows1['course_name']."</option>";
			}
			else{
				echo "<option value='".$rows1['course_id']."'>".$rows1['course_name']."</option>";
			}
			
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT faculty_name,faculty_id FROM faculty_info';
	$stmt = $pdo->query($sql);
	echo "<p><label>Faculty :</label> <select name='faculty'>";
	while($rows2 = $stmt->fetch(PDO::FETCH_ASSOC)){
			if($rows4['faculty_name'] == $rows2['faculty_name']){
				echo "<option value='".$rows2['faculty_id']."'selected>".$rows2['faculty_name']."</option>";
			}
			else{
				echo "<option value='".$rows2['faculty_id']."'>".$rows2['faculty_name']."</option>";
			}
	}
	echo "</select> </p>";

?>
<p>
<label>Address :</label> <input required type="text" value="<?php echo $rows4['Address']?>" name="SA" >
</p>
<?php 
	$sql = 'SELECT City,city_id FROM city';
	$stmt = $pdo->query($sql);
	echo "<p><label>City :</label> <select name='city'>";
	while($rows3 = $stmt->fetch(PDO::FETCH_ASSOC)){
		if($rows4['City'] == $rows3['City']){
			echo "<option value='".$rows3['city_id']."'selected>".$rows3['City']."</option>";
		}
		else{
			echo "<option value='".$rows3['city_id']."'>".$rows3['City']."</option>";
		}
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT state,state_id FROM state';
	$stmt = $pdo->query($sql);
	echo "<p><label>state :</label> <select name='state'>";
	while($rows5 = $stmt->fetch(PDO::FETCH_ASSOC)){
		if($rows4['state'] == $rows5['state']){
			echo "<option value='".$rows5['state_id']."'selected>".$rows5['state']."</option>";
		}
		else{
			echo "<option value='".$rows5['state_id']."'>".$rows5['state']."</option>";

		}
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT Country,country_id FROM country';
	$stmt = $pdo->query($sql);
	echo "<p><label>Country :</label> <select name='Country'>";
	while($rows6 = $stmt->fetch(PDO::FETCH_ASSOC)){
		if($rows4['Country'] == $rows6['Country']){
			echo "<option value='".$rows6['country_id']."'selected>".$rows6['Country']."</option>";
		}
		else{
			echo "<option value='".$rows6['country_id']."'>".$rows6['Country']."</option>";
		}
	}
	echo "</select> </p>";

?>
<input type="submit" class="btn btn-primary" Value="submit" name="student_data">
<?php }
	}
	echo "</form>";
?>
<?php
		if(isset($_GET['id2'])){
			$sql8 = "SELECT faculty_info.faculty_id,faculty_info.faculty_address_id,faculty_info.faculty_name,faculty_info.faculty_surname,faculty_info.faculty_registration_date,faculty_info.dob,faculty_info.gender,faculty_info.phone,course_master.course_name,address.Address,state.state,city.City,country.Country FROM faculty_info INNER JOIN course_master JOIN address JOIN city JOIN state JOIN country ON faculty_info.faculty_course_id = course_master.course_id AND faculty_info.faculty_address_id = address.address_id AND address.city_id = city.city_id AND address.state_id = state.state_id AND address.country_id = country.country_id WHERE faculty_info.faculty_id= :id";
			 $stmt8 = $pdo->prepare($sql8);
			$stmt8->execute(array(
				':id' => htmlentities($_GET['id2'])
			));
			$rows8 = $stmt8->fetch(PDO::FETCH_ASSOC);
			if($rows8!==false) {
			$id2 = $rows8['faculty_address_id'];	
		?>
			<form method="post">
			<input type="text" name="id2" hidden value="<?php echo $id2?>">
			<p>
			<label>Faculty_Name : </label><input required type="text" value="<?php echo $rows8['faculty_name']?>" name="FN">
			</p>
			<p>
			<label>Faculty_Surname : </label><input required type="text" value="<?php echo $rows8['faculty_surname']?>" name="FS">
			</p>
			<p>
			<label>Faculty_Registration_Date : </label><input required type="date" value="<?php echo $rows8['faculty_registration_date']?>" name="FR">
			</p>
			<p>
			<label>Faculty_Dob :</label> <input required type="date" value="<?php echo $rows8['dob']?>" name="FD">
			</p>
			<p>
			<label>Gender :</label> <input  type="radio" name="G" <?php if($rows8['gender'] =="M")echo 'checked'?> value="M">M <input type="radio" name="G" <?php if($rows8['gender'] =="F")echo 'checked'?> value="F">F
			</p>
			<p>
			<label>Phone :</label> <input required type="text" value="<?php echo $rows8['phone']?>" name="P">
			</p>
		
<?php 
	$sql = 'SELECT course_name,course_id FROM course_master';
	$stmt = $pdo->query($sql);
	echo "<p><label>Course :</label> <select name='course'>";
	while($rows1 = $stmt->fetch(PDO::FETCH_ASSOC)){
			if($rows8['course_name'] == $rows1['course_name']){
				echo "<option value='".$rows1['course_id']."' selected>".$rows1['course_name']."</option>";
			}
			else{
				echo "<option value='".$rows1['course_id']."'>".$rows1['course_name']."</option>";
			}
		
	}
	echo "</select> </p>";

?>
<p>
<label>Address :</label> <input type="txt" value="<?php echo $rows8['Address']?>" name="SA" placeholder="24, shreeram society">
</p>
<?php 
	$sql = 'SELECT City,city_id FROM city';
	$stmt = $pdo->query($sql);
	echo "<p><label>City :</label> <select name='city'>";
	while($rows3 = $stmt->fetch(PDO::FETCH_ASSOC)){
		
		if($rows8['City'] == $rows3['City']){
			echo "<option value='".$rows3['city_id']."'selected>".$rows3['City']."</option>";
		}
		else{
			echo "<option value='".$rows3['city_id']."'>".$rows3['City']."</option>";
		}
		
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT state,state_id FROM state';
	$stmt = $pdo->query($sql);
	echo "<p><label>state :</label> <select name='state'>";
	while($rows5 = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			if($rows8['state'] == $rows5['state']){
			echo "<option value='".$rows5['state_id']."'selected>".$rows5['state']."</option>";
		}
		else{
			echo "<option value='".$rows5['state_id']."'>".$rows5['state']."</option>";

		}
		
	}
	echo "</select> </p>";

?>
<?php 
	$sql = 'SELECT Country,country_id FROM country';
	$stmt = $pdo->query($sql);
	echo "<p><label>Country :</label> <select name='Country'>";
	while($rows6 = $stmt->fetch(PDO::FETCH_ASSOC)){
		
			if($rows8['Country'] == $rows6['Country']){
			echo "<option value='".$rows6['country_id']."'selected>".$rows6['Country']."</option>";
		}
		else{
			echo "<option value='".$rows6['country_id']."'>".$rows6['Country']."</option>";
		}
		
	}
	echo "</select> </p>";

?>
<input type="submit" class="btn btn-primary" Value="submit" name="faculty_data">
<?php }
		}
		echo "</form>"
?>
 </div>
</div>
</div>
</body>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<?php 
if(isset($_GET['message1'])){
echo '
<script>
Toastify({
  text: "Student Data Updated Succesfully",
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
setTimeout(function(){ location.href="update.php" }, 2000);
</script>';

}
if(isset($_GET['message2'])){
echo '
<script>
Toastify({
  text: "Faculty Data Updated Succesfully",
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
setTimeout(function(){ location.href="update.php" }, 2000);
</script>';
}
?>
</html>
 <?php }
	else{
		header('Location: login.php?error=Access Frobidden');
	}
?>
  