<?php
	$mysqli = new mysqli('localhost', 'root', 'r', 'secure');
//$mysqli = new mysqli('localhost', 'mreuser1_mits', 'mits@123','mreuser1_healthvault');
if ($mysqli->connect_errno) {
    echo "Sorry, this website is experiencing problems.";
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}
if(!empty($_GET['code']) && isset($_GET['code']))
{
$code=$_GET['code'];
$sql=$mysqli->prepare("SELECT * FROM unverified_users WHERE activationcode=?");
$sql->bind_param("s",$code);
$sql->execute();
$sql->store_result();

$num=$sql->num_rows;
echo $num;
//var_dump($code);
if($num>0)
{
$st=0;
$result=$mysqli->prepare("SELECT * FROM unverified_users WHERE activationcode=? and status=?");
$result->bind_param("ss",$code,$st);
//var_dump($result);
$result->execute();
$result->store_result();
var_dump($result);
$result4=$result->num_rows;   
if($result4>0) 
 {
$st=1;
$result=$mysqli->prepare("SELECT email FROM unverified_users WHERE activationcode=?");
$result->bind_param("s",$code);
$result->execute();
$result->store_result();

foreach($result as $row)
{

    // $dir="/home/mreuser1/public_html/myhealthvault.tk/documents/".$row['email'];
   //  	mkdir($dir,0777,true);
	$msg="Your account is activated."; 
    $result1=$mysqli->prepare("UPDATE unverified_users SET status=? WHERE activationcode=?");
    $result1->bind_param("ss",$st,$code);
       $result1->execute();
    echo("Error description: " . mysqli_error($mysqli));

    $sql2=$mysqli->prepare("select email,password from unverified_users where activationcode=?");
    $sql2->bind_param("s",$code);
    $sql2->execute();
     echo("Error description: " . mysqli_error($mysqli));
    $sql2->store_result();
    $sql2->bind_result($email5, $password5);
    $sql2->fetch(); 
    echo $email5;
    echo $password5;
    $sql6=$mysqli->prepare("insert into users (email,password) values (?,?)");
    $sql6->bind_param("ss",$email5,$password5);
    $sql6->execute();
    echo("Error description: " . mysqli_error($mysqli));

}
}

else
{
$msg="Your account is already active";
}
}
else
{
$msg ="Wrong activation code or activation code expired.";
}
}
printf("%s",$msg);
if(strcmp($msg,"Your account is activated.")==0)
{
    echo " You are now being redirected to login page";
    sleep(4);
    print "<META http-equiv='refresh' content='3;URL=http://localhost:8080/secure/Data-Security/'>";
    //   header( "Location: https://myhealthvault.tk" );

}
?>
