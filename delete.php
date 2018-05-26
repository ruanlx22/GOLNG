<?php
if(isset($_POST['id'])){
    return delete($_POST['id']);
}



function delete($id){
    $USER = 'root';
    $PASSWORD = '';
    $SERVER = 'localhost';
    $DB = 'GOLNG';

    $conn = mysqli_connect($SERVER, $USER, $PASSWORD, $DB);

    $sql = "DELETE FROM relationship WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    if ($result){
        $data = array(
            'status'=>0,
            'info'=>"Delete successfully!"
        );

    } else {
        $data = array(
            'status'=>1,
            'info'=>"Some things goes wrong, Please try later!"
        );
    }
//    echo $data;
//    echo json_encode($data);
    return json_encode($data);
}