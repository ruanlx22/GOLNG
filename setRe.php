<?php
session_start();
if (!isset($_SESSION['user'])){
    header("Refresh:0;url=map.php");
}
require('company.php');
$user=unserialize($_SESSION['user']);
$userId = $user[1]->getId();
ini_set('display_errors',1);
ini_set('display_startup_errors' ,1);
error_reporting(E_ALL);
$USER = 'root';
$PASSWORD = '';
$SERVER = 'localhost';
$DB = 'GOLNG';

$conn = mysqli_connect($SERVER, $USER, $PASSWORD, $DB);

$sql = "select id, name from company";
$results = mysqli_query($conn,$sql);
if ($results){
//    echo "company info get successfully!" . "</br>";
} else {
    echo "Error get company info!" . $connection->error . "</br>" ;
}
$companyArray = [];
while($row = $results->fetch_assoc()){
    $companyArray[] = [$row['id'],$row['name']];
}
$info="";
$Sinfo="";


if(isset($_POST['submit'])){
    $start = $_POST['start'];
    $end = $_POST['end'];
    $des = $_POST['description'];

    $sql = "SELECT * from  relationship where company_start = $start and company_end = $end AND adder = ".$userId;
    $result = mysqli_query($conn,$sql);
    if (!$result){
        $info = "Error get company info!" . $connection->error . "</br>" ;
        goto ex;
    }
    if(mysqli_num_rows($result)){
        $info = "This relationship already exists";
        goto ex;
    }
    $sql = "Insert into relationship(id,company_start,company_end,description,adder) VALUE (null,$start,$end,'$des',$userId)";
    $result = mysqli_query($conn,$sql);
    if (!$result){
        $info = "Error get company info!" . $connection->error . "</br>" ;
        goto ex;
    }
    $Sinfo = "Add relationship successfully!";

    ex:
}
?>

<html>
<head>
    <title>Set Relationship</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<script>
    var slist = '<?php echo json_encode($companyArray);?>';
    var list = eval(decodeURIComponent(slist));
</script>
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
    <h3>Set Relationship</h3>
    <form action="" method="post" onsubmit="return check()">
        <span class="info" id="info"><?php echo $info;?></span><br>
        <span class="info" style="color: green"><?php echo $Sinfo;?></span><br>
        <div align="center">
            <label>From: </label><br>
            <select name="start" id="start">
                <option>Please choose a company</option>
                <script>
                    // console.log(list);
                    for (i in list){
                        var op = document.createElement('option');
                        op.value = list[i][0];
                        op.innerHTML = list[i][1];
                        document.getElementById('start').appendChild(op);
                    }
                </script>
            </select><br>
            <label>To: </label><br>
            <select name="end" id="end">
                <option>Please choose a company</option>
                <script>
                    // console.log(list);
                    for (j in list){
                        var op = document.createElement('option');
                        op.value = list[j][0];
                        op.innerHTML = list[j][1];
                        document.getElementById('end').appendChild(op);
                    }
                </script>
            </select><br>
            <label>Description:</label><br>
            <textarea name="description" id="description" placeholder="Please add description" rows="6" style="width: 400px;"></textarea>
            <span></span><br>
            <input name="submit" type="submit" value="Set">
        </div>
    </form>
</center>
<script>
    function check() {
        var des = document.getElementById('description').innerHTML;

        var objS = document.getElementById('start');
        var indexS = objS.selectedIndex; // 选中索引
        var valueS = objS.options[indexS].value; // 选中值

        var objE = document.getElementById('end');
        var indexE = objE.selectedIndex; // 选中索引
        var valueE = objE.options[indexE].value; // 选中值

        if(des||indexS==0||indexE==0){
            document.getElementById('info').innerHTML="Please select two companies and write description";
            return false;
        }

        if(indexS!=<?php echo $user[1]->getId();?>&&indexE!=<?php echo $user[1]->getId();?>){
            document.getElementById('info').innerHTML="You should add the relationship about your company!<br>(One of the selected company must belong to you)!";
            return false;
        }

        if(indexS==indexE){
            document.getElementById('info').innerHTML="Please select two different companies";
            return false;
        }

        return true;
    }
</script>
</body>
</html>
