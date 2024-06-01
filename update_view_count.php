<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = $_POST['book_id'];

    // Update the view count for the specified book
    $sql = "UPDATE books SET views = views + 1 WHERE Book_ID = $bookId";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo 'View count updated successfully.';
    } else {
        echo 'Error updating view count: ' . mysqli_error($con);
    }
}
?>