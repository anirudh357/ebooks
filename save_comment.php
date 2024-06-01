<?php
include 'connect.php';
session_start(); // Start the session

if (isset($_POST['book_id']) && isset($_POST['comment'])) {
    $bookId = $_POST['book_id'];
    $comment = $_POST['comment'];

    // Check if the user is logged in
    if (isset($_SESSION["username"])) {
        $user = $_SESSION["username"]; // Get the username from the session
    } else {
        $user = "Guest"; // If not logged in, set the user as "Guest"
    }

    // Insert the new comment into the database
    $sql = "INSERT INTO book_comments (book_id, comment, user) VALUES ($bookId, '$comment', '$user')";
    if (mysqli_query($con, $sql)) {
        echo "Comment saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}
?>