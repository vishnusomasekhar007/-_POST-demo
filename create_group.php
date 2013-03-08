<?php

include 'evil_check.php'; //session authentication
include 'sulai_connect.php';//database connection

if(!$USER) //not user
{
    die();
}
else 
{
   /*if user create group..if the group is the 1st group in the group list then start its id as 'grp756' else increment the id of latest inserted group by '37' */
 
    $select_group="SELECT * FROM `group` WHERE status='ACTIVE'";
    $select_group_execute=  mysqli_query($link, $select_group);
    $select_group_fetch= mysqli_fetch_assoc($select_group_execute);
    if(!$select_group_fetch)//1st group
    {
    $var='grp'.'756';
    }
    else //if not 1st group
    {
     $select_group1="SELECT id FROM `group` ORDER BY created_on DESC";
     $select_group_execute1=  mysqli_query($link, $select_group1);
     $select_group_fetch1=  mysqli_fetch_array($select_group_execute1,MYSQL_BOTH);
     $str=$select_group_fetch1[0];
     preg_match_all('|\d+|', $str, $matches,PREG_PATTERN_ORDER);
     $num=$matches[0][0]+37;
     $var='grp'.$num;
    }
    $date = date('Y/m/d H:i:s');
    if($_POST['gp_scope']=="")
        $_POST['gp_scope']='PUBLIC'; 
    $title=mysqli_real_escape_string($link, $_POST[gp_title]);
    $scope=mysqli_real_escape_string($link, $_POST[gp_scope]);
 //create group
    $insert_group="INSERT INTO `group` (id,title,status,created_on,scope,user_email) VALUES ('$var','$title','ACTIVE','$date','$scope','$USER')";
    $insert_group_execute= mysqli_query($link, $insert_group);
    if(!$insert_group_execute)//group creation failed
    {
        die("group is not created");
    }
  else 
    {
    echo 'success';    
    }
 }
  
  
?>
