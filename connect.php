<?php
    $con=new mysqli('localhost', 'root', 'm.m.singh', 'ebooks');

    if(!$con){
        echo "Connection successful";
    }
    // else{
    //     die(mysqli_error($con));
    // }

?>