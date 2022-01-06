<?php
// Detect the current session
session_start();
// Include the Page Layout header
include("header.php"); 

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

// To Do 1 (Practical 2): Validate login credentials with database

//Include the PHP file that establishes database connections handle: $conn
include_once("mysql_conn.php");

//Define the SELECT SQL statement 
$qry = "SELECT Password, Email, Name, ShopperID FROM Shopper WHERE Email = '$email'";
$result = $conn->query($qry); //Execute the SQL and get the returned reuslts
while($row = $result->fetch_array()){
	if (($email == $row['Email']) && ($pwd == $row['Password'])) {
		// Save user's info in session variables
		$_SESSION["ShopperName"] = $row['Name'];
		$_SESSION["ShopperID"] = $row["ShopperID"];
		
		// To Do 2 (Practical 4): Get active shopping cart
		$qry = "SELECT ShopCartID FROM ShopCart WHERE ShopperID=? AND OrderPlaced=0";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $row["ShopperID"]); // i -integer
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if ($result->num_rows > 0){
			$row = $result->fetch_array();
			$_SESSION["Cart"] = $row['ShopCartID'];
				
			//Count number of uncheck items
			$qry = "SELECT COUNT(ShopCartID) FROM shopcartitem WHERE ShopCartID = ?";
			$stmt = $conn->prepare($qry);
			$stmt->bind_param("i", $row['ShopCartID']); // i -integer
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			$row = $result->fetch_array();
			if ($result->num_rows > 0){
				$_SESSION["NumCartItem"] += $row["COUNT(ShopCartID)"];
				
			}	
		}
		// Redirect to home page
		header("Location: index.php");
		exit;
	}
	else {
		echo  "<h3 style='color:red'>Invalid Login Credentials</h3>";
	}
}

//Close Database connection
$conn->close();
	
// Include the Page Layout footer
include("footer.php");
?>