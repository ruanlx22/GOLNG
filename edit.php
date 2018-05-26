<?php
session_start();
if (!isset($_SESSION['user'])){
    header("Refresh:0;url=map.php");
}
require('company.php');
$user=unserialize($_SESSION['user']);
//$userId = $user[1]->getId();
if(!isset($_GET['id'])){
    header("Refresh:0;url=editRe.php");
}
$reId = $_GET['id'];

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


$sql = "select * from relationship where id = $reId";
$result = mysqli_query($conn,$sql);
if ($result){
//    echo "company info get successfully!" . "</br>";
} else {
    echo "Error get relationship info!" . $conn->error . "</br>" ;
}
$re = [];
while ($row = $result->fetch_assoc()){
    $re[] = $row['id'];
    $re[] = $row['company_start'];
    $re[] = $row['company_end'];
    $re[] = $row['description'];
}


$sql = "select name,id from company";
$result = mysqli_query($conn,$sql);
if ($result){
//    echo "company info get successfully!" . "</br>";
} else {
    echo "Error get company info!" . $conn->error . "</br>" ;
}
$companyMap = [];
while($row = $result->fetch_assoc()){
    $companyMap[] = [$row['name'],$row['id']];
}


if(isset($_POST['update'])){
    $des = $_POST['description'];
    $upId = $_POST['upId'];
    $sql = "UPDATE relationship SET description = '$des' where id = $upId";

}
$result = mysqli_query($conn,$sql);
if ($result){
//    echo "company info get successfully!" . "</br>";
} else {
    echo "Error get company info!" . $conn->error . "</br>" ;
}
?>

<html>
<head>
    <title>Edit Relationship</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav style="background-color: cadetblue;padding: 0;">
    <a href='map.php' class="navBar">Go LNG</a>
    <span> | </span>
    <?php
    if(isset($_SESSION['user'])){
        echo "<a class='navBar'>".$user[1]->getName()."</a>";
        echo "<span> | </span><a class='navBar' href='setRe.php'>Set Relationship</a>";
        echo "<span> | </span><a class='navBar' href='editRe.php'>Edit Relationship</a>";
        echo "<span> | </span><a class='navBar' href='logout.php'>Log out</a>";
    }
    else{
        echo "<a class='navBar' href='login.php'>Login</a>";
    }
    ?>
</nav>
<center>
<form action="" method="post">
    <input type="hidden" value="<?php echo $re[0];?>" name="upId">
    <label>From:</label><br>
    <label><?php echo $companyMap[$re[1]-1][0]?></label><br>
    <label>To:</label><br>
    <label><?php echo $companyMap[$re[2]-1][0]?></label><br><br>
    <textarea name="description" id="description" placeholder="Please add description" rows="6" style="width: 400px;"><?php echo $re[3];?></textarea><br>
    <button name="update">UPDATE</button>
</form>
</center>
</body>
</html>
