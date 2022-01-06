<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>

<!-- HTML Form to collect search keyword and submit it to the same page in server -->
<div style="width:80%; margin:auto;"> <!-- Container -->
<form name="frmSearch" method="get" action="">
    <div class="form-group row"> <!-- 1st row -->
        <div class="col-sm-9 offset-sm-3">
            <span class="page-title">Product Search</span>
        </div>
    </div> <!-- End of 1st row -->
    <div class="form-group row"> <!-- 2nd row -->
        <label for="keywords" 
               class="col-sm-3 col-form-label">Product Title:</label>
        <div class="col-sm-6">
            <input class="form-control" name="keywords" id="keywords" 
                   type="search" />
        </div>
        <div class="col-sm-3">
            <button type="submit">Search</button>
        </div>
    </div>  <!-- End of 2nd row -->
</form>

<?php
// The non-empty search keyword is sent to server
if (isset($_GET["keywords"]) && trim($_GET['keywords']) != "") {
    // To Do (DIY): Retrieve list of product records with "ProductTitle" 
	// contains the keyword entered by shopper, and display them in a table.
	
    //Include the PHP file that establishes database connections handle: $conn
    include_once("mysql_conn.php");

    //Define the SELECT SQL statement 
    if(isset($_GET['keywords']) && trim($_GET['keywords']) != ""){
        $keyword = $_GET['keywords'];
        $qry = "SELECT * FROM product WHERE ProductTitle LIKE '%$keyword%' 
                AND ProductDesc LIKE '%$keyword%'";    
        $result = $conn->query($qry);
        if($result->num_rows> 0){
            while($row = $result->fetch_array()){
                $product = "ProductDetails.php?pid=$row[ProductID]";
                echo "<p><a href='$product'>$row[ProductTitle]</a></p>";
            }
        }
        else echo "No record found!";
    }
    
    //Close Database connection
    $conn->close();

	// To Do (DIY): End of Code
}

echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>

