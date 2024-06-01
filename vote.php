<?php
include 'connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = $_POST['book_id']; // Make sure this matches the key you're sending in your AJAX request
    $action = $_POST['action'];
    $currentVotes = $_POST['current_votes'];

    // Retrieve the current vote counts for the book
    $sql = "SELECT upvotes, downvotes FROM books WHERE Book_ID = '$bookId'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $currentUpvotes = $row['upvotes'];
    $currentDownvotes = $row['downvotes'];
    

    // Update the vote counts based on the action
    if ($action === 'upvotes') {
        $newUpvotes = $currentUpvotes + 1;
        $sql = "UPDATE books SET upvotes = '$newUpvotes' WHERE Book_ID = '$bookId'";
        mysqli_query($con, $sql);
    } elseif ($action === 'downvotes') {
        $newDownvotes = $currentDownvotes + 1;
        $sql = "UPDATE books SET downvotes = '$newDownvotes' WHERE Book_ID = '$bookId'";
        mysqli_query($con, $sql);
    }

    // Retrieve the updated vote counts
    $sql = "SELECT upvotes, downvotes FROM books WHERE Book_ID = '$bookId'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $updatedUpvotes = $row['upvotes'];
    $updatedDownvotes = $row['downvotes'];

    // Calculate the new total votes
    $total_votes = $currentVotes;
    if ($action === 'upvotes') {
        $total_votes++;
    } elseif ($action === 'downvotes') {
        $total_votes--;
    }

    // Return the total votes as a JSON response
    $response = array(
        'total_votes' => $total_votes
    );
    echo json_encode($response);
}
?>
