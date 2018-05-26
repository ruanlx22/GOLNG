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

if (!$conn){
    die("Connection to DB failed :" . mysqli_connect_error() . "</br>");
}

$sql = "select * from relationship where adder = $userId";

$result = mysqli_query($conn,$sql);
if ($result){
//    echo "company info get successfully!" . "</br>";
} else {
    echo "Error get relationship info!" . $conn->error . "</br>" ;
}
$num = mysqli_num_rows($result);
$reArray = [];
while($row = $result->fetch_assoc()){
    $reArray[] = [$row['id'],$row['company_start'],$row['company_end']];
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

$info="";
$Sinfo="";



?>

<html>
<head>
    <title>Edit Relationship</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<script>
    var slist1 = '<?php echo json_encode($reArray);?>';
    var reList = eval(decodeURIComponent(slist1));
    var slist2 = '<?php echo json_encode($companyMap);?>';
    var comList = eval(decodeURIComponent(slist2));
    console.log(reList);
    console.log(comList);
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
    <div id="reDiv">
        <span id="info"></span>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>service provider</th>
                    <th>service getter</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody id='tbd'>

            </tbody>
        </table>



    </div>
</center>
</body>
<script>
    <?php if ($num!=0){?>
    var tbd = document.getElementById('tbd');
    var counter = 1;
    for(i in reList){

        var trc = document.createElement('tr');
        // trc.id = 'trc';

        var tdId = document.createElement('td');
        var tdSt = document.createElement('td');
        var tdEn = document.createElement('td');
        var tdOp = document.createElement('td');
        //ID:  reList[i][0]
        tdId.innerHTML = counter;
        tdSt.innerHTML = comList[reList[i][1]-1][0];
        tdEn.innerHTML = comList[reList[i][2]-1][0];

        var btnEdit = document.createElement('button');
        var btnDelete = document.createElement('button');
        btnEdit.innerHTML = 'Edit';
        btnDelete.innerHTML = 'Delete';
        btnEdit.onclick = function () { location.href='edit.php?id='+reList[i][0];};
        btnDelete.onclick = function () {
            if(confirm("Do you confirm the deletion?")){
                $.post('delete.php',{'id':reList[i][0]},function (data) {
                   location.reload();
                });
            }
            else{

            }
        };

        tbd.appendChild(trc);
        trc.appendChild(tdId);
        trc.appendChild(tdSt);
        trc.appendChild(tdEn);
        trc.appendChild(tdOp);
        tdOp.appendChild(btnEdit);
        tdOp.appendChild(btnDelete);
        counter++;
    }
    <?php }
    else{ ?>
    var tbd = document.getElementById('tbd');
    var noRe = document.createElement('td');
    noRe.colSpan = 4;
    noRe.innerHTML="No relationship, Please add it.";
    tbd.appendChild(noRe);
    <?php } ?>
    

</script>
<script src="jquery-3.3.1.min.js"></script>
</html>
