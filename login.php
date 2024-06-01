<?php
$host = "localhost";
$user = "root";
$password = "m.m.singh";
$db = "ebooks";

session_start();

$data = mysqli_connect($host, $user, $password, $db);
if ($data == false) {
    die("connection error");
}

if ($_SERVER["REQUEST_METHOD" ] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $encrypted_password = md5($password);

    if ($username == "tirc" && $password == "tirc@345") {
        header("location:ebookbacktable.php");
    } else {
        $sql = "select * from emp_id where username='".$username."' AND password='".$encrypted_password."'";
        $result = mysqli_query($data, $sql);

        $row = mysqli_fetch_array($result);

        if ($row && $row["desig_id"] > 12) {
            $_SESSION["username"]=$username;
            header("location:ebookbacktablenormaluser.php");
        } elseif ($row && $row["desig_id"] <= 12) {
            $_SESSION["username"]=$username;
            header("location:ebookbacktableadmin.php");
        } else {
            echo "username or password incorrect";
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
	        font-family: 'Poppins';
        }


        html, body {
            font-family: Arial, Helvetica, sans-serif;
            background: #DDF7E3;
	        height: 100%;
	        margin: 0 !important;
	        padding: 0 !important;
        }

        input[type=text],
        input[type=password] {
            display: block;
	width: 77%;
	margin-left: 10.5%;
	margin-top: 6%;
	margin-bottom: 2%;
	min-width: 100px;
	height: 30px;
	padding: 4px;
	padding-right: 4px;
	padding-left: 4px;
	border: none;
	border-radius: 2px;
	background-color: #c7e8ca;
	border-bottom: 2px solid #4a7d47;
	font-size: 18px;
	z-index: 3;
        }

        input[type=text]:focus,
        input[type=password]:focus {
            outline: none;
        }

        input[type=text]:autofill, input[type=password]:autofill {
	background-color: #6da66a !important;
}

.loginDiv {
	position: relative;
	top: 10%;
	margin: auto;
	width: 30%;
	height: 50%;
	min-height: 400px;
	min-width: 400px;
	background-color: #C7E8CA;
	border-radius: 35px;
	box-sizing: content-box;
	box-shadow: 0 0 20px -8px #4a7d47;
}

.login {
  position: absolute;
	bottom: 32px;
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
	bottom: 31px;
	font-size: 20px;
	background-color: #5D9C59;
	transition: all 0.1s;
	box-shadow: 0 0 20px -2px #2D5C29;
}

.login:active {
	bottom: 32px;
	font-size: 18px;
	background-color: #385e35;
	transition: all 0.1s;
	box-shadow: 0 0 10px -7px #2D5C29;
}

h1 {
	text-align: center;
	padding-top: 24px;
	font-family: 'Poppins';
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

#password:focus ~ label, #password:valid ~ label {
	font-size: 14px;
	top: -70px;
	transition: all 0.2s;
	color: #4a7d47;
}

#username:focus ~ label,
#username:valid ~ label {
	font-size: 14px;
	top: -70px;
	transition: all 0.2s;
	color: #4a7d47;
}

#username:valid ~ .error {
	display: none;
}

.inputField {
	height: 60px;
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

h1:nth-of-type(2) {
    font-size: 30px;
    margin-top: -80px;
}

h1:nth-of-type(3){

    font-size: 30px;
    margin-top: -60px;
}


        
    </style>
</head>


<body>
<div id="slider">
  <div class="bolaMov1"></div>
  <div class="bolaMov2"></div>
  <div class="bolaMov3"></div>
  <div class="bolaMov4"></div>
  <div class="bolaMov5"></div>
</div>
    <div style="display: flex; align-items: center; justify-content: center;">

    <img src="image/books.png" alt="books" style="margin-right: 10px; width: 70px; height: 70px">
    <!-- <div> -->
        <h1 style="font-size: 50px;">E-Books Site</h1>
        <!-- <h1 style="font-size: 30px;">Books</h1>
        <h1 style="font-size: 30px;">Online</h1>
    </div> -->
    <img src="image/books.png" alt="books" style="margin-left: 10px; width: 70px; height: 70px">
    </div>

    <div class="loginDiv">
    <div>

        <form action="#" method="post">
        <h1>Login Page</h1>
            <div class="inputField"> 
                <input type="text" name="username" id="username" required aria-invalid="false">
                <label>username</label>
            </div>

            <div class="inputField">
                <input type="password" name="password" id="password" required aria-invalid="false">
                <label>password</label>
            </div>

            
                <input type="submit" value="Login" id="login" class="login">

            
        </form>

    </div>
    </div>

</body>

</html>