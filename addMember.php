<?php
    session_start();// Detect the current session

    //read the data input from previous page
    $name = $_POST["name"];
    $address = $_POST["address"];
    $country = $_POST["country"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //Create password hash 
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);

    //Include the PHP file that establishes database connections handle: $conn
    include_once("mysql_conn.php");

    //Define the INSERT SQL statement 
    $qry = "INSERT INTO Shopper (Name, Address, Country, Phone, Email, Password)
            VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($qry);

    //"ssss" - 6 string parameters
    $stmt->bind_param("ssssss", $name, $address, $country, $phone, $email, $password);

    if($stmt->execute()){ //SQL Statement executed successfully
    //Retrieve the shopper ID assigned to the new shopper
    $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
    $result = $conn->query($qry); //Execute the SQL and get the returned reuslts
    while($row = $result->fetch_array()){
        $_SESSION["ShopperID"] = $row["ShopperID"];
    }

    //Succesful message and ShopperID
    $Message = "Registration successful! <br>
                Your ShopperID is $_SESSION[ShopperID]<br>";
    //Save the Shopper Name in a session variable
    $_SESSION["ShopperName"] = $name;
    }
    else{ //Error message
        $Message = "<h3 style='color:red'>Error in inserting record</h3>";
    }

    //Release the resource allocated for prepared statement
    $stmt->close();
    //Close Database connection
    $conn->close();

    //Display Page layout header with updated session state and links
    include("header.php");
    echo $Message;
    include("footer.php");
?>