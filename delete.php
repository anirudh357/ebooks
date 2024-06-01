<?php
    include 'connect.php';
    session_start();

    if(isset($_GET['deleteid'])){
        $id=$_GET['deleteid'];
    
        // First, delete the related records from the `book_comments` table
        $sql="DELETE FROM `book_comments` WHERE `book_id`=$id";
        $result=mysqli_query($con,$sql);
        if(!$result){
            die(mysqli_error($con));
        }
    
        // Then, delete the record from the `books` table
        $sql="DELETE FROM `books` WHERE `Book_ID`=$id";
        $result=mysqli_query($con,$sql);
        if($result){
            $_SESSION['message'] = 'Book deleted successfully';
            header('location:ebookbacktable.php');
        }
        else{
            die(mysqli_error($con));
        }
    }
    

?>