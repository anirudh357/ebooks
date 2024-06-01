<?php
    
    session_start();

    // if(!isset($_SESSION["username"])){
    //     header("location:login.php");
    // }

    include 'connect.php';
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
            /* background-image: url('https://img.freepik.com/free-vector/gradient-glassmorphism-background_23-2149447863.jpg?size=626&ext=jpg&ga=GA1.1.553209589.1715212800&semt=ais'); */
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
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
    0% {
        transform: scale(1, 1);
    }
    25% {
        transform: scale(0.9, 1.1);
    }
    50% {
        transform: scale(1.1, 0.9);
    }
    75% {
        transform: scale(0.95, 1.05);
    }
    100% {
        transform: scale(1, 1);
    }
}
.views{
    display: flex;
    justify-content: space-between;
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
        
.container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            margin-bottom: 48px;
        }

        .container form {
            margin-bottom: 48px;
        }

        .message-box{
            color: #3c763d;
            background-color:#dff0d8;
            border-color: #d6e9c6;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
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
        <li><a href="addbook.php" role="button" aria-hashed="true"><i class="fa-solid fa-book" style="margin-right: 10px;"></i>Add book</a></li>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-hashed="true">
        <i class="fa-solid fa-user" style="margin-right: 10px;"></i>Profile
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i> System Administrator</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</li>
    </ul>
</div>
    <div class="container">
    <?php
            if(isset($_SESSION['message'])) {
                echo '<div class="message-box">'.$_SESSION['message'].'</div>';
                unset($_SESSION['message']);
            }
    ?>

    <table class="table table-striped" style="background-color: #C7E8CA;">
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Pdf link</th>
                <th scope="col">Type</th>
                <th scope="col">File Uploaded</th>
                <th scope="col">Date of file Created</th>
                <th scope="col">File Size</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        

    <?php
        $sql="Select * from `books` ORDER BY `uploaded_on` DESC";
        $result=mysqli_query($con, $sql);
        if($result){
            $serialNo = 1;
            // $row=mysqli_fetch_assoc($result);
            // echo $row['name'];
            // $row=mysqli_fetch_assoc($result);
            // echo $row['name'];
            while($row=mysqli_fetch_assoc($result)){
                $Book_ID=$row['Book_ID'];
                $book_title=$row['book_title'];
                $LINK=$row['LINK'];
                $book_type=$row['book_type'];
                $uploaded_on = $row['uploaded_on'];
                if ($row['file_created_date'] !== null) {
                    $file_created_date = $row['file_created_date']; // assuming $row['file_created_date'] is in 'YYYY-MM-DD' format
                    $formatted_date = date('d-m-Y', strtotime($file_created_date));
                } else {
                    // Handle the case where 'file_created_date' is not set
                    $formatted_date = "Date not given";
                }
                
                $file_size = number_format($row['file_size'] / 1024, 2);
                $file_path = substr($LINK, strrpos($LINK, '/') + 1); // Get the filename from the file path

                echo '<tr>
                <th scope="row">' . $serialNo . '</th>
                <td>'.$book_title.'</td>
                <td><a href="' . $LINK . '" target="_blank">' . $file_path . '</a></td>
                <td>'.$book_type.' </td>
                <td>'.$uploaded_on.'</td>
                <td>'.$formatted_date.'</td>
                <td>'.$file_size.' <b>kb</b></td>
                <td>
                <button class="btn btn-primary"><a href="edit.php?editid='.$Book_ID.'" class="text-light">Edit</a></button>
                <button class="btn btn-danger"><a href="delete.php?deleteid='.$Book_ID.'" class="text-light" onclick="return confirm(\'Are you sure you want to delete this item?\')">Delete</a></button>
                </td>
                
              </tr>';
              $serialNo++;
            }
        }
    ?>
            
        </tbody>
    </table>
    

    </div>
    <button id="scrollToTopBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button> 
    <script>
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