<?php
include 'connect.php';

if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    // Query to fetch comments, users, and timestamps for the specified book
    $sql = "SELECT comment, user, timestamp FROM book_comments WHERE book_id = $bookId ORDER BY timestamp DESC";
    $result = mysqli_query($con, $sql);

    $comments = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = array(
                'comment' => $row['comment'],
                'user' => $row['user'],
                'timestamp' => date('Y-m-d H:i:s', strtotime($row['timestamp']))
            );
        }
    }

    echo json_encode($comments);
}
?>