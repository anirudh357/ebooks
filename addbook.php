<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//for inserting
include 'connect.php';
session_start();
if (isset($_POST['submit'])) {
    $book_title = $_POST['book_title'];
    $book_type = $_POST['book_type'];
    $visibility = $_POST['visibility'];
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'pdf', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
                // $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'Uploads/' . $fileName;
                move_uploaded_file($fileTmpName, $fileDestination);

                $sql = "insert into `books` (book_title, LINK, book_type, visibility, file_size) values('$book_title', '$fileDestination', ";
                if ($book_type == 'Others') {
                    $sql .= "'$_POST[book_type1]', ";
                } else {
                    $sql .= "'$book_type', ";
                }
                
                $sql .= "'$visibility', '$fileSize') ";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    $_SESSION['message'] = 'This item is added successfully';
                    header('location:ebookbacktable.php');
                } else {
                    die(mysqli_error($con));
                }
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Add Books</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    font-family: 'Poppins', sans-serif;
}

body, html {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #DDF7E3;
    margin: 0 !important;
    padding: 0 !important;
}

.container {
    position: relative;
    top: 10%;
    margin: auto;
    width: 30%;
    min-width: 400px;
    background-color: #C7E8CA;
    border-radius: 35px;
    box-sizing: content-box;
    box-shadow: 0 0 20px -8px #4a7d47;
    padding: 24px 0; /* Add padding to the container */
}

input[type=text],
input[type=file],
select {
    display: block;
    width: 77%;
    margin-left: 10.5%;
    margin-top: 6%;
    margin-bottom: 2%;
    min-width: 100px;
    height: 30px;
    padding: 4px;
    border: none;
    border-radius: 2px;
    background-color: #c7e8ca;
    border-bottom: 2px solid #4a7d47;
    font-size: 18px;
    z-index: 3;
}

input[type=text]:focus,
input[type=file]:focus,
select:focus {
    outline: none;
}

input[type=text]:-webkit-autofill,
input[type=file]:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 1000px #6da66a inset;
    box-shadow: 0 0 0 1000px #6da66a inset;
}

.login {
    position: relative;
    bottom: 0; /* Remove absolute positioning */
    left: 5%;
    width: 90%;
    padding: 10px;
    background-color: #4a7d47;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 15px;
    font-size: 18px;
    box-shadow: 0 0 10px -5px #2D5C29;
    transition: all 0.1s;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.login:hover {
    font-size: 20px;
    background-color: #5D9C59;
    transition: all 0.1s;
    box-shadow: 0 0 20px -2px #2D5C29;
}

.login:active {
    font-size: 18px;
    background-color: #385e35;
    transition: all 0.1s;
    box-shadow: 0 0 10px -7px #2D5C29;
}

h1 {
    text-align: center;
    padding-top: 24px;
    font-family: 'Poppins', sans-serif;
    padding-bottom: 15px;
    color: #253e24;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

label {
    position: relative;
    top: -40px;
    margin-left: 10.5%;
    font-size: 18px;
    z-index: 0;
    transition: all 0.4s;
    pointer-events: none;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

input:focus ~ label,
input:valid ~ label,
select:focus ~ label,
select:valid ~ label {
    font-size: 14px;
    top: -70px;
    transition: all 0.2s;
    color: #4a7d47;
}

input:valid ~ .error {
    display: none;
}

.form-group {
    height: 60px;
    position: relative;
    margin-bottom: 20px; 
    
}

.error {
    display: none;
    width: 80%;
    margin: auto;
    color: #DF2E38;
    margin-top: -20px;
}

input[aria-invalid="true"] {
    border-bottom: 2px solid #DF2E38;
}

@keyframes shake {
    0% {transform: translateX(-10px);}
    20% {transform: translateX(10px);}
    40% {transform: translateX(-10px);}
    60% {transform: translateX(10px);}
    80% {transform: translateX(0px);}
}

.form-control{
    width: 77%;
}

.btn-custom {
            background-color: #4a7d47;
            border-color: #4a7d47;
            margin-bottom: 10px;
            margin-top: 100px;
        }
        .btn-custom:hover {
            background-color: #5d9c59;
            border-color: #5d9c59;
        }

    </style>


    <script type="text/javascript">
        console.log("Dropdown value changed to: " + val);
        function othersOption(val){
            var element=document.getElementById('book_type1');
            if(val==='Others'){
                element.style.display='block';
            }
            else{
                element.style.display='none';
            }
        }
    </script>
    
</head>

<body>
    <div class="container my-5">
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group" autocomplete="off">
                <input type="text" class="form-control" placeholder="Enter book title" name="book_title" autocomplete="off">
                <label>Book Title</label>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="file" autocomplete="off">
                <label>Upload File</label>
            </div>
            <div class="form-group position-relative "  >
                <select name="book_type" class="form-control" onchange="othersOption(this.value)">
                    <option value="Select Type">--Select Book Type--</option>
                    <option value="Jornal">Journal</option>
                    <option value="Paper">Paper</option>
                    <option value="Report">Report</option>
                    <option value="Book">Book</option>
                    <option value="Others">Others</option>
                </select>
                <input type="text" name="book_type1" id="book_type1" style="display: none; position: absolute; top: 20%;" placeholder="input type">
                <label>Book Type</label>
            
            </div>
            <div class="form-group" style="margin-top: 50px;">
                
                <select name="visibility" class="form-control">
                    <option value="Select Type">--Select Visibilty--</option>
                    <option value="Confidential">Confidential</option>
                    <option value="Non-Confidential">Non-Confidential</option>
                </select>
                <label>Visibility</label>
                
            </div>

            <input type="submit" value="Submit" id="login" name="submit" class="login">
        </form>
    </div>
    <div class="d-flex justify-content-center mt-5">
            <button class="btn btn-custom"><a href="ebookbacktable.php" class="text-light">Previous page</a></button>
    </div>

</body>

</html>