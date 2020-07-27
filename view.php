<?php session_start()?>
<?php require 'header.php'?>
<body>
<?php require 'navbar.php' ?>

<?php if(isset($_SESSION['username'])){ ?>
<div class="col-sm-9">
      <h1>Admin Portal</h1>
	  <hr>
	<h3>View or Delete Mode</h3>
	<form>
	<?php if(isset($_SESSION['success'])){
		echo '<span style="color:green">'.$_SESSION['success'].'</span>';
		$_SESSION['success'] = "";
		echo "<br/> <br/>";
	}?>
		
		<input type="submit" class="btn btn-primary" name="student" value="Student Data"><br/> <br/>
		<input type="submit" class="btn btn-primary" name="faculty" value="Faculty Data"><br/>  <br/>
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
				echo "<th scope='col'>";
					echo 'User_surname';
				echo "</th>";
				echo "<th scope='col'>";
					echo 'course_name';
				echo "</th>";
				echo "<th scope='col'>";
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
				echo "<td scope='row'>";
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
					echo "<form action='delete.php'>";
						echo "<input type='text' name='id' hidden value='".$rows['user_id']."'>";
						echo "<input type='submit' class='btn btn-danger' name='del' value='Delete'>";
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
				echo "</th >";
				echo "<th scope='col'>";
					echo 'Action';
				echo "</th >";
		echo "</tr>";
		while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo "<tr>";
				echo "<td scope='row'>";
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
					echo "<form action='delete.php'>";
						echo "<input type='text' name='id2' hidden value='".$rows['faculty_id']."'>";
						echo "<input type='submit' class='btn btn-danger' name='del2' value='Delete'>";
					echo "</form>";
				echo "</td>";
			echo "<tr>";
		}
		echo "</table>";
	}
	
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
  text: "Student Data Deleted Succesfully",
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
setTimeout(function(){ location.href="view.php" }, 2000);
</script>';

}
if(isset($_GET['message2'])){
echo '
<script>
Toastify({
  text: "Faculty Data Deleted Succesfully",
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
setTimeout(function(){ location.href="view.php" }, 2000);
</script>';
}
?>
</html>
<?php }
	else{
		header('Location: login.php?error=Access Frsobidden');
	}
?>