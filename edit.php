<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include 'connect.php';
    
    $Book_ID = $_GET['editid'];

    // for showing already putted data
    $sql = "SELECT * FROM `books` WHERE Book_ID = $Book_ID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $book_title = $row['book_title'];
    $LINK = $row['LINK'];
    $book_type = $row['book_type'];
    $Visibility = $row['Visibility'];
    $file_size = $row['file_size'];

    $file_exists_error = false;
    if (isset($_POST['submit'])) {
//         $book_title = $_POST['book_title'];
//         $book_type = $_POST['book_type'];
//         $visibility = $_POST['visibility'];
//         $uploadDir = realpath('New uploads');
// if (!is_dir($uploadDir)) {
//     mkdir($uploadDir, 0755, true);}

//         // Handle file upload
//         // Handle file upload
// $fileUploaded = false;
// $fileDestination = '';
// if (!empty($_FILES['file']['tmp_name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
//     $file = $_FILES['file'];
//     $fileName = $file['name'];
//     $fileTmpName = $file['tmp_name'];
//     $fileSize = $file['size'];
//     $fileError = $file['error'];
//     $fileType = $file['type'];
//     $fileExt = explode('.', $fileName);
//     $fileActualExt = strtolower(end($fileExt));
//     $allowed = array('jpg', 'jpeg', 'pdf', 'png');

//     if (in_array($fileActualExt, $allowed)) {
//         if ($fileError === 0) {
//             if ($fileSize < 1000000) {
//                 if (!empty($LINK)) {
//                     $existingFilePath = $LINK;
//                     if (file_exists($existingFilePath)) {
//                         unlink($existingFilePath); // Delete the existing file
//                     }
//                 }

//                 $fileDestination = $uploadDir . '/' . $fileName;
//                 if (move_uploaded_file($fileTmpName, $fileDestination)) {
//                     $fileUploaded = true;
//                 } else {
//                     echo "Failed to move uploaded file.";
//                 }
//             } else {
//                 echo "Your file is too big!";
//             }
//         } else {
//             echo "There was an error uploading your file!";
//         }
//     } else {
//         echo "You cannot upload files of this type!";
//     }
// }

//         // Construct the SQL query based on the uploaded file
//         // Construct the SQL query based on the uploaded file
// if ($fileUploaded) {
//     $sql = "UPDATE `books` SET book_title = '$book_title', LINK = '$fileDestination', ";
// } else {
//     $sql = "UPDATE `books` SET book_title = '$book_title', LINK = '$LINK', ";
// }

// if ($book_type == "Others") {
//     $sql .= "book_type = '" . $_POST['book_type1'] . "', ";
// } else {
//     $sql .= "book_type = '$book_type', ";
// }

// $sql .= "visibility = '$visibility' WHERE Book_ID = $Book_ID";

//         // Execute the SQL query and handle the result
//         $result = mysqli_query($con, $sql);
//         if ($result) {
//             $_SESSION['message'] = 'Book updated successfully';
//             header('location:ebookbacktable.php'); // Redirect to ebookbacktable.php only when the query is successful
//             exit; // Add an exit statement to prevent further execution
//         } else {
//             die(mysqli_error($con));
//         }
$Book_ID = $_POST['Book_ID'];
$book_title = $_POST['book_title'];
$book_type = $_POST['book_type'];
$visibility = $_POST['visibility'];
$new_file = $_FILES['file']['name'];
$old_file = $_POST['file_old'];
$fileSize = $_FILES['file']['size'];

$update_filename = $old_file; // Default to old file

if ($new_file != '') {
    $upload_dir = "Uploads/"; // Define the upload directory
    $upload_file = $upload_dir . basename($new_file);

    if (file_exists($upload_file)) {
        $filename = $new_file;
        $_SESSION['message'] = $filename . " File already exists";
        $file_exists_error = true; // Set the flag to indicate the file already exists
    } else {
       if ($_FILES["file"]["size"] < 15000000) { 
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $upload_file)) {
            $update_filename = $upload_file; // Update the filename with the new file path
            unlink($old_file); // Delete the old file

        } else {
            $_SESSION['message'] = "Error uploading file.";
        }
       }
       else{
        $_SESSION['message'] = "Your file is too big!";
       } 
    }
}

if (!$file_exists_error) { // Only update the database if no file exists error
    $update_file_query = "UPDATE `books` SET book_title = '$book_title', LINK = '$update_filename', ";
    if ($book_type == "Others") {
        $update_file_query .= "book_type = '" . $_POST['book_type1'] . "', ";
    
    } else {
        $update_file_query .= "book_type = '$book_type', ";
    }
    $update_file_query .= "visibility = '$visibility', file_size = '$fileSize' WHERE Book_ID = $Book_ID";
    $update_file_query_run = mysqli_query($con, $update_file_query);

    if ($update_file_query_run) {
        $_SESSION['message'] = "File updated successfully";
        header('location: ebookbacktable.php');
        exit; // Exit the script after redirection
    } else {
        $_SESSION['message'] = "File updation failed!";
    }
}
}
?>


<!-- HTML code remains the same -->

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>E-Books Library</title>

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

 .form-group:nth-of-type(2) div{
    margin: -30px 67px;
 }       

    </style>


<script type="text/javascript">
        console.log("Dropdown value changed to: " + val);
        function othersOption(val){
            


            var element=document.getElementById('book_type1');
            if(val==='Others' || val==='Select'){
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
    <?php if (isset($_SESSION['message']) && $_SESSION != '') { ?>
            <div class="alert alert-danger"><?php echo $_SESSION['message']; ?></div>
        <?php
            unset($_SESSION['message']);
        } ?>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <input type="hidden" name="Book_ID" value="<?php echo $row['Book_ID']; ?>">
        </div>

        <div class="form-group mb-3">
            <input type="text" class="form-control" placeholder="Enter book title" name="book_title" autocomplete="off" value=<?php echo $book_title;?>>
            <label>Book Title</label>
        </div>
        <div class="form-group mb-3">
        
                <input type="file" class="form-control" name="file" autocomplete="off">
                
                <label>Upload File</label>
                <input type="hidden" name="file_old" value="<?php echo $row['LINK']; ?>">
        </div>

        <div class="form-group position-relative mb-3"  >
                <select name="book_type" class="form-control" onchange="othersOption(this.value)">
                    <option value="Other book type" >--Select Book Type--</option>
                    <option value="Jornal" <?php if ($book_type == 'Jornal') echo 'selected'; ?> >Journal</option>
                    <option value="Paper" <?php if ($book_type == 'Paper') echo 'selected'; ?> >Paper</option>
                    <option value="Report" <?php if ($book_type == 'Report') echo 'selected'; ?> >Report</option>
                    <option value="Book" <?php if ($book_type == 'Book') echo 'selected'; ?> >Book</option>
                    <option value="Others" <?php if ($book_type == 'Others') echo 'selected'; ?> >Others</option>
                </select>
                <input type="text" name="book_type1" id="book_type1" style="display: none; position: absolute; top: 20%;" placeholder="input type">
                <label>Book Type</label>
            
        </div>
        <div class="form-group mb-3" style="margin-top: 50px;">
                
                <select name="visibility" class="form-control">
                    <option value="Select Type" <?php if ($Visibility == 'Select Type') echo 'selected'; ?> >--Select Visibilty--</option>
                    <option value="Confidential" <?php if ($Visibility == 'Confidential') echo 'selected'; ?> >Confidential</option>
                    <option value="Non-Confidential" <?php if ($Visibility == 'Non-Confidential') echo 'selected'; ?> >Non-Confidential</option>
                </select>
                <label>Visibility</label>
                
        </div>
        <div class="form-group mb-3">
            <input type="submit" value="Submit" id="login" name="submit" class="login">
        </div>    
    </form>
    </div>
    <div class="d-flex justify-content-center mt-5">
            <button class="btn btn-custom"><a href="ebookbacktable.php" class="text-light">Previous page</a></button>
    </div>

  </body></html>