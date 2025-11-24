<?
include('incl/connect.php');
if(isset($_SESSION['uid'])){
    $get_id=$_SESSION['uid'];
    $sql="SELECT * FROM users WHERE id= $get_id";
    $USER =$connection->query($sql)->fetch(2);
}
?>