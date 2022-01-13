<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a cenrally located container -->
<div style="width:80%; margin:auto;">
<form method="post">
	<div class="form-group row">
		<div class="col-sm-9 offset-sm-3">
			<span class="page-title">Forget Password</span>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="eMail">
         Email Address:</label>
		<div class="col-sm-9">
			<input class="form-control" name="eMail" id="eMail"
                   type="email" required />
		</div>
	</div>
	<div class="form-group row">      
		<div class="col-sm-9 offset-sm-3">
			<button type="submit">Submit</button>
		</div>
	</div>
</form>

<?php 
// Process after user click the submit button
if (isset($_POST["eMail"])) {
	// Read email address entered by user
	$eMail = $_POST["eMail"];
	// Retrieve shopper record based on e-mail address
	include_once("mysql_conn.php");
	$qry = "SELECT * FROM Shopper WHERE Email=?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("s", $eMail); 	// "s" - string 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		// To Do 1: Update the default new password to shopper"s account
		$row = $result->fetch_array();
		$shopperID = $row["ShopperID"];
		$new_pwd = "password";
		//Hash the default password
		$hashed_pwd=password_hash($new_pwd, PASSWORD_DEFAULT);
		$qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?";
		$stmt = $conn->prepare($qry);
		//'s' - string, 'i' - int
		$stmt->bind_param("si",$hashed_pwd,$shopperID);
		$stmt->execute();
		$stmt->close();
		// End of To Do 1
		
		// To Do 2: e-Mail the new password to user
		include("myMail.php");

		$to="s10192803@connect.np.edu.sg";
		$from ="s10192803@connect.np.edu.sg";
		$from_name="Mamaya Bookstore";
		$subject = "Mamaya e-Bookstore login password";

		$body="<span style='color:black; front-size=12px;'> 
				your new password is <span style='font-weight:bold'>$new_pwd</span>.<br>
				Do change this default password.
				</span>";
		//Initate the e-mailing sending process
		if(smtpmailer($to, $from, $from_name, $subject,$body)){
			echo "<p>Your new password is sent to: 
				<span style='font-weight:bold'>$to</span>
				</p>";
		}else{
			echo "<p><span style='color:red;'>
				Mailer error: ".$error."<span></p>";
		}
		// End of To Do 2
	}
	else {
		echo "<p><span style='color:red;'>
		      Wrong E-mail address!</span></p>";
	}
	$conn->close();
}
?>

</div> <!-- Closing container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>