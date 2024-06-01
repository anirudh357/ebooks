<?php
    include 'connect.php';
    session_start();

    if(!isset($_SESSION["username"])){
        header("location:login.php");
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Book Library</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css_files/bootstrap.min.css">
    <link rel="stylesheet" href="css_files/all.min.css" >
    <script src="js_files/pdf.mjs"></script>
    <!-- Bootstrap JS -->
    <script src="js_files/jquery-3.5.1.slim.min.js"></script>
    
    <script src="js_files/bootstrap.bundle.min.js"></script>

    <script src="js_files/jquery.min.js"></script>
    <script src="js_files/f9b2e9e8d9.js" ></script>
    <script src="ebookbacktable.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900;1000&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #DDF7E3;
        }
        .btn-custom {
            background-color: #4a7d47;
            border-color: #4a7d47;
        }
        .btn-custom:hover {
            background-color: #5d9c59;
            border-color: #5d9c59;
        }
        .table-custom {
            background-color: #C7E8CA;
            border-color: #4a7d47;
        }
        .book-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 3rem;
        }
        .book-card {
            max-width: 300px;
            flex: 1 1 auto;
            margin-bottom: 16px;
        }
        @media (max-width: 991px) {
            .book-card {
                flex: 0 0 calc(50% - 1rem);
                max-width: calc(50% - 1rem);
            }
        }
        @media (max-width: 767px) {
            .book-card {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            
        }

        .container form {
            margin-bottom: 48px;
            
        }

        

        .fa-user-circle {
    color: #666;
    margin-right: 5px;
}

.timestamp {
    color: #888;
    font-size: 0.8em;
    margin-right: 5px;
}

.comment-text {
    font-size: 1em;
}

.card-title {
    color: #5d9c59;
}

.navbar {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 40px 20px 80px 20px;
}

.navbar img {
    margin-right: 10px;
    width: 70px;
    height: 70px;
}

.navbar h1 {
    font-size: 50px;
}

.navbar ul {
    display: flex;
    list-style-type: none;
    

    gap: 50px;
    background: #4a7d47; /* Background color for the entire list */
    border-radius: 10px; /* Rounded corners for the entire list */
    padding: 16px;
    width: 100%;
    justify-content: space-around;
}

.navbar ul li a,
.dropdown-item {
    color: #fff;
    text-decoration: none;
    font-size: 1.2em;
    transition: color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    display: inline-block;
    vertical-align: middle;
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    position: relative;
    padding: 10px 20px;
    margin: 0;
}

.navbar ul li a:hover,
.dropdown-item:hover {
    background-color: #5d9c59;
    border-color: #5d9c59;
    box-shadow: rgba(0, 0, 0, 0.5) 20px 20px 30px;
    transform: scale(1.1);
    animation: bouncing 0.5s;
}

@keyframes bouncing {
  from, to { transform: scale(1, 1); }
  25% { transform: scale(0.9, 1.1); }
  50% { transform: scale(1.1, 0.9); }
  75% { transform: scale(0.95, 1.05); }
  
}

.dropdown-menu {
    background-color: #C7E8CA;
    border: 1px solid #4a7d47;
    border-radius: 5px;
    padding: 0.5rem 0;
}

.dropdown-item {
    color: #212529;
    padding: 10px 20px; /* Consistent padding */
    margin: 0; /* Reset margin */
}

.dropdown-item:hover {
    background-color: #5d9c59;
    color: #fff;
}

.dropdown-item i {
    margin-right: 0.5rem;
}  

.views{
    display: flex;
    justify-content: space-between;
}

#scrollToTopBtn {
    display: none;
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 99;
    border: none;
    outline: none;
    background-color: #4a7d47;
    color: white;
    cursor: pointer;
    width: 50px; /* Added */
    height: 50px; /* Added */
    border-radius: 50%; /* Updated */
    font-size: 18px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: flex; /* Added */
    justify-content: center; /* Added */
    align-items: center; /* Added */
}

#scrollToTopBtn:hover {
    background-color: #5d9c59;
    transform: translateY(-5px);
}

#scrollToTopBtn i {
    margin: 0; /* Updated */
}

    </style>
</head>
<body>
<!--php echo $_SESSION["username"] ?> -->
<div class="navbar">
    <div style="display: flex; align-items: center; justify-content: center; margin: 40px 20px 80px 20px;">
        <img src="image/books.png" alt="books" style="margin-right: 10px; width: 70px; height: 70px;">
        <h1 style="font-size: 50px;">E-Books Site</h1>
        <img src="image/books.png" alt="books" style="margin-left: 10px; width: 70px; height: 70px;">
    </div>

    <ul>
        <li><a href="#"><i class="fa-solid fa-house" style="margin-right: 10px;"></i>Home</a></li>
        <li><a href="statisticsnormaluser.php" role="button" aria-hashed="true"><i class="fa-solid fa-chart-simple" style="margin-right: 10px;"></i>Statistics</a></li>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-hashed="true">
        <i class="fa-solid fa-user" style="margin-right: 10px;"></i>Profile
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i> <?php echo $_SESSION["username"]; ?></a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</li>
    </ul>
</div>
</div>
    <div class="container">
    <form action="" method="POST">
    <input type="text" name="search" placeholder="Search for books...">
    <input type="radio" name="book_type" value="all" checked> All
    <input type="radio" name="book_type" value="journal"> Journal
    <input type="radio" name="book_type" value="paper"> Paper
    <input type="radio" name="book_type" value="report"> Report
    <input type="radio" name="book_type" value="book"> Book
    <input type="radio" name="book_type" value="others"> Others
    <!-- Add more radio buttons for more book types -->
    <input type="submit" name="submit" value="Search">
</form>     
<div class="book-grid">
        

    <?php

if(isset($_POST['submit'])){
    $search = $_POST['search'];
    if (isset($_POST['book_type']) && $_POST['book_type'] === 'all') {
        $sql = "SELECT * FROM `books` WHERE `book_title` LIKE '%$search%' AND visibility='Non-Confidential' ORDER BY `uploaded_on` DESC";
    }
    else if (isset($_POST['book_type']) && !empty($_POST['book_type'])) {
        $book_type = $_POST['book_type'];
        $sql = "SELECT * FROM `books` WHERE `book_title` LIKE '%$search%' AND `book_type` = '$book_type' AND visibility='Non-Confidential' ORDER BY `uploaded_on` DESC";
    } else {
        $sql = "SELECT * FROM `books` WHERE `book_title` LIKE '%$search%' AND visibility='Non-Confidential' ORDER BY `uploaded_on` DESC";
    }
}

else{
        $sql="Select * from `books` WHERE visibility='Non-Confidential' ORDER BY `uploaded_on` DESC";
}
        $result=mysqli_query($con, $sql);
        if($result){
            // $row=mysqli_fetch_assoc($result);
            // echo $row['name'];
            // $row=mysqli_fetch_assoc($result);
            // echo $row['name'];
            while($row=mysqli_fetch_assoc($result)){
                $Book_ID=$row['Book_ID'];
                $book_title=$row['book_title'];
                $LINK=$row['LINK'];
                $book_type=$row['book_type'];
                $upvotes = $row['upvotes'];
            $downvotes = $row['downvotes'];
            $total_votes = $upvotes - $downvotes; 
                ?>
                <div class="book-card" data-book-id="<?php echo $Book_ID; ?>" data-votes="<?php echo $total_votes; ?>">
                        <div class="card">
                            <img src="book_cover/images (5).jpg" class="card-img-top" alt="Book Cover">
                            <div class="card-body" style="display: flex; flex-direction: column;">
                                <h5 class="card-title"><?php echo $book_title; ?></h5>
                                <p class="card-text">Book ID: <?php echo $Book_ID; ?></p>
                                <p class="card-text">Type: <?php echo $book_type; ?></p>
                                <br>
                                <div class="buttons" style="display: flex; flex-direction: column;">
                                <div class="views">
                                <a href="<?php echo $LINK; ?>" target="_blank" class="btn btn-primary" onclick="incrementViewCount(<?php echo $Book_ID; ?>, '<?php echo $LINK; ?>')">View PDF</a>
                                <p class="card-text">Views: <?php echo $row['views']; ?></p>
                                </div>
                                <div class="mt-3" style="display: flex; justify-content: space-between;">
                                <div class="upvotes_downvotes">
                            <button class="btn btn-success btn-sm" data-book-id="<?php echo $Book_ID; ?>" data-action="upvotes">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <span class="vote-count"><?php echo $total_votes; ?></span>
                            <button class="btn btn-danger btn-sm" data-book-id="<?php echo $Book_ID; ?>" data-action="downvotes">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                            </div>
                            
                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#commentModal" data-book-id="<?php echo $Book_ID; ?>">
                                <i class="fas fa-comment"></i> Comment
                            </button>
                            </div>
                        </div>

                        
                            </div>
                        </div>
                    </div>
                <?php
            }
        }
    ?>
            
</div>
<div id="pdf-viewer"></div>
<!-- Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <ul id="commentList" style="list-style-type: none;"></ul>
                <form id="commentForm">
                    <input type="hidden" id="bookIdInput" name="book_id">
                    <div class="form-group">
                        <label for="commentInput">Comment:</label>
                        <textarea class="form-control" id="commentInput" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
    </div>

    <button id="scrollToTopBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>
    <script>
    $(document).ready(function() {
    // ... (Existing code)

    // Comment modal functionality
    $(".btn-secondary").click(function() {
        var bookId = $(this).data("book-id");
        $("#bookIdInput").val(bookId);

        // Fetch existing comments for the book
        $.ajax({
            url: "fetch_comments.php",
            type: "GET",
            data: {
                book_id: bookId
            },
            success: function(response) {
                var comments = JSON.parse(response);
                var commentList = $("#commentList");
                commentList.empty(); // Clear previous comments

                if (comments.length === 0) {
                    var noCommentMessage = $("<li>No comments found for this book.</li>");
                    commentList.append(noCommentMessage);
                } else {
                    // Append existing comments to the list
                    $.each(comments, function(index, commentData) {
                        var commentItem = $("<li></li>");
                        var userIcon = $("<i class='fas fa-user-circle'></i>");
                        var userText = (commentData.user !== null) ? $("<span class='user-text'>" + commentData.user + "</span>") : "";
                        var timestamp = $("<span class='timestamp'>" + commentData.timestamp + "</span>");
                        var commentText = $("<span class='comment-text'>" + commentData.comment + "</span>");

                        commentItem.append(userIcon, userText, timestamp, commentText);
                        commentList.append(commentItem);
                    });
                }
            }
        });
    });

    // Event handler for form submission
    $("#commentForm").submit(function(e) {
        e.preventDefault();
        var bookId = $("#bookIdInput").val();
        var comment = $("#commentInput").val();

        // Send an AJAX request to save the comment
        $.ajax({
            url: "save_comment.php",
            type: "POST",
            data: {
                book_id: bookId,
                comment: comment
            },
            success: function(response) {
                // Handle the response from the server
                console.log(response);
                // Append the new comment to the list
                var currentDate = new Date();
                var timestamp = currentDate.toLocaleString();
                var commentItem = $("<li></li>");
                var userIcon = $("<i class='fas fa-user-circle'></i>");
                var userText = ""; // Set userText to an empty string if not available
                var timestampSpan = $("<span class='timestamp'>" + timestamp + "</span>");
                var commentText = $("<span class='comment-text'>" + comment + "</span>");

                commentItem.append(userIcon, userText, timestampSpan, commentText);
                $("#commentList").prepend(commentItem);
                $("#commentInput").val("");
            }
        });
    });
});

function incrementViewCount(bookId, pdfUrl) {
    // Find the book card element
    var bookCard = $(".book-card[data-book-id='" + bookId + "']");
    var viewCountElement = bookCard.find(".views .card-text");
    var currentViewCount = parseInt(viewCountElement.text().split(": ")[1]);

    // Send an AJAX request to update the view count
    $.ajax({
        url: 'update_view_count.php',
        type: 'POST',
        data: {
            book_id: bookId
        },
        success: function(response) {
            // Increment the view count on the page
            viewCountElement.text("Views: " + (currentViewCount + 1));

            // Display the PDF using PDF.js
            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                var viewer = document.getElementById('pdf-viewer');
                viewer.innerHTML = ''; // Clear existing content

                // Create a new PDF viewer
                var pdfViewer = new pdfjsViewer.PDFViewer({
                    container: viewer
                });

                // Load the PDF document
                pdfViewer.setDocument(pdf);

                // Adjust the viewer's container size
                viewer.style.height = '600px'; // Adjust as needed
                pdfViewer.currentScaleValue = 'page-width';
            }).catch(function(error) {
                console.error('Error loading PDF:', error);
            });
        },
        error: function() {
            console.error('Error updating view count.');
        }
    });
}

// Get the button
var scrollToTopBtn = document.getElementById("scrollToTopBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scrollToTopBtn.style.display = "block";
    } else {
        scrollToTopBtn.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

// Attach the click event to the button
scrollToTopBtn.addEventListener("click", topFunction);
</script>
</body>
</html>