<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "cebisa_apparel";
    $conn = mysqli_connect($host, $username, $password, $db_name);

    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    else{
        echo "Connection Successful";
    }

    $Product_Name = filter_input(INPUT_POST, $_POST[""], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $Product_Price = filter_input(INPUT_POST, $_POST[""], FILTER_VALIDATE_INT);
    $Product_Image = filter_input(INPUT_POST, $_POST[""], FILTER_DEFAULT);
    $Product_Quantity = filter_input(INPUT_POST, $_POST[""], FILTER_DEFAULT);
    $Product_Size = filter_input(INPUT_POST, $_POST[""], FILTER_VALIDATE_BOOL);
    $Product_Color = filter_input(INPUT_POST, $_POST[""], FILTER_VALIDATE_BOOL);
    $Product_Description = filter_input(INPUT_POST, $_POST[""], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $sql = "insert into Admin(Product_Name, Product_Price, Product_Image, Product_Quantity, Product_Sizes, Product_Description)
                        values()";

    if(isset($_POST["Upload"])){

        mysqli_query($conn, $sql);

    }
    else{

        die("Could not upload the Product Successfully");

    }