<?php
require_once('company.php');
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors' ,1);
error_reporting(E_ALL);
$USER = 'root';
$PASSWORD = '';
$SERVER = 'localhost';
$DB = 'GOLNG';

$conn = mysqli_connect($SERVER, $USER, $PASSWORD, $DB);

if (!$conn){
    die("Connection to DB failed :" . mysqli_connect_error() . "</br>");
}
$info = "";
//echo "company info get successfully!" . "</br>";
if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM userinfo WHERE name = '".$username."' AND password = '".$password."'";
    $result = mysqli_query($conn,$sql);
    if (!$result){
    echo "Error get company info!" . $connection->error . "</br>" ;
    }
//    mysqli_num_rows($result);
//    echo mysqli_fetch_assoc($result)['name'];
    elseif(mysqli_num_rows($result)){
        $info = "Login successfully";
        $company = $result->fetch_assoc();
        $sqlCom = "select * from company where id=".$company['company'];
//        echo $sqlCom;
        $resultCom = mysqli_query($conn,$sqlCom);
        if (!$resultCom){
            echo "Error get company info!" . $connection->error . "</br>" ;
        }
        elseif (!mysqli_num_rows($resultCom)){
            $company = new company(0,0,0,0,0,0,0,0);
            $user = [$username,$company];
            $_SESSION['user'] = $user;
//            header("Refresh:3;url=map.php");
        }
        else{
            $row = $resultCom->fetch_assoc();
            $company = new company($row['id'],$row['name'],$row['lat'],$row['lon'],$row['description'],$row['url'],$row['image'],$row['category']);
            $user = [$username,$company];
//            echo $company->getName();
            $_SESSION['user'] = $user;
            //echo $_SESSION['user'][0];
//            echo $_SESSION['user'][1]->getName();
            header("Refresh:1;url=map.php");
        }

    }
    else{
        $info = "wrong username or password!";
    }
}

?>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav style="background-color: cadetblue;padding: 0;">
    <a href='map.php' class="navBar">Go LNG</a>
    <span> | </span>
    <?php
    if(isset($_SESSION['user'])){
        echo "<a class='navBar'>".$_SESSION['user'][1]->getName()."</a>";
    }
    else{
        echo "<a class='navBar' href='login.php'>Login</a>";
    }
    ?>
</nav>
<center>
    <h3>Login</h3>
    <form action="" method="post">
        <span class="info"><?php echo $info;?></span><br>
        Username: <input name="username" type="text"><br>
        Password: <input name="password" type="password"><br>
        <span></span><br>
        <input name="submit" type="submit" value="login">
    </form>
</center>
</body>
</html>
