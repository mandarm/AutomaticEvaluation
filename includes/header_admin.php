
<?php require_once("./includes/db.php"); 
date_default_timezone_set('Asia/Kolkata');
$d=0;
?>


<?php 
  $sql="SELECT * from tests where status='Active'";
    
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

   while($t = $stmt->fetch(PDO::FETCH_ASSOC)){
    $tc=$t['tc'];

    $tet=$t['tedate'].' '.$t['tetime'];

    $current_datetime= date("d-m-Y H:i:s");

    if (strtotime($current_datetime) > strtotime($tet) ) {

      $sql="UPDATE tests set status='Completed'  where status='Active' and tc='$tc'";

      $stmt = $pdo->prepare($sql);
      $stmt->execute();
   }

  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>ACMU</title>
        <link href="./css/styles.css" rel="stylesheet" />
        <link rel="icon" type="./includes/images/x-icon" href="./includes/images/favicon.png" />
    </head>


<style>
body {background-color: white; text-decoration-color: black}
h1   {color: brown;}
p   {color: brown;}


table.center {
    margin-left:auto; 
    margin-right:auto;
    text-decoration-color: black;
  }

  .container{
    width:100%;
}

.flex-rw {
  display: flex;
  flex-flow: row wrap;
}



/* Dropdown Button */
.dropbtn1 {
  background-color: lightcoral;
  color: white;
  /*padding: 16px;*/
  font-size: 16px;
  border: none;
}

.dropbtn2 {
  background-color: blue;
  color: white;
  /*padding: 16px;*/
  font-size: 16px;
  border: none;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #3e8e41;}


.topnav-right {
  float: right;
}

.left_label {

  color: brown;
  font-size: 20px;
}

.right_label {

  color: blue;
  font-size: 20px;
}

.hoverbutton1 {
  background-color: BurlyWood;
  border: "2";
  color: blue;
  /*padding: 15px 32px;*/
  text-align: left;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 200px
}

.hoverbutton2 {
  background-color: orange; /* Green */
  border: "2";
  color: blue;
  /*padding: 15px 32px;*/
  text-align: left;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 200px
}

.menubutton1 {
  background-color: orange; /* Green */
  border: "2";
  color: blue;
  /*padding: 15px 32px;*/
  text-align: left;

  font-size: 16px;


  width: 100px;
 
}

.menubutton2 {
  background-color: lightcoral; /* Green */
  border: "2";
  color: blue;
  /*padding: 15px 32px;*/
  text-align: left;

  font-size: 16px;


  width: 100px;

}

</style>



<!-- ***************************************************************************************************** -->
<script src="./js/jquery.min.js"></script>
<script type="text/javascript">
function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)

}

function display_ct() {
var x = new Date()
var m=x.getMonth() +1
var x1=x.getDate() + "-" + m + "-" + x.getFullYear(); 
x1 = x1 + " - " +  x.getHours( )+ ":" +  x.getMinutes() + ":" +  x.getSeconds();
document.getElementById('ct').innerHTML = x1;
display_c();
 }
</script>


 <body onload=display_ct();>
<?php session_start();

    if(empty($_SESSION['login']) or $_SESSION['user_role']!='DB-Admin'){

      header("Refresh:0;url=./index.php");
    }elseif(time()-$_SESSION['login_time_stamp'] >1200) 
    {
        session_unset();
        session_destroy();
        header("Refresh:0;url=./index.php");
    }else{

        $_SESSION['login_time_stamp']=time();

    }

  $email = $_SESSION['email'];
?>

<div style="background: #cce6ff">
<center><strong><font size="6" color="brown">INDIAN STATISTICAL INSTITUTE KOLKATA </font><!--<br><font size="6" color="blue">Advanced Computing & Microelectrinics Unit</font>--><br><font size="6" color="grey">Automated Test Evaluation System</font></strong></center>
</div>

<div style="display:flex; flex-direction: row; background: #ffd2ad;">
<table width="100%"><tr>
 <td width="40%"> <label class="left_label" >Welcome  <?php echo "<strong>" . $_SESSION['user_name'] . "</strong><font color=\"black\"> (Roll No. <strong>" . $_SESSION['roll_no'] . "</font></strong>)"; ?> </label></td><td width="20%"></td>
  
 <td width="40%" align="right"> <label  class="right_label" > Current Time: <span id='ct' ></span></label></td>
</tr></table>  
</div>
    
<!-- ***************************************************************************************************** -->





   
<div style="background-color:yellow;" class="flex-container">

     <div class="dropdown">
  <form action="./admin_dashboard.php" method="POST">
    
    <button  type="submit" class="menubutton1" name="home" value="home">Home</button>
   </form>
  </div>


    <div class="dropdown">
      <button class="dropbtn1">Tests</button>
      <div class="dropdown-content">
        <form action='./create_test.php' method='POST'>
            <button type='submit' name='ct' value='ct' class="hoverbutton1">Create Test</button>
            
        </form>
        <form action='./view_test.php' method='POST'>
            <button type='submit' name='vt' value='vt' class="hoverbutton2">View Tests</button>    
        </form>

      <!--</form>
        <form action='./test_auto.php' method='POST'>
            <button type='submit' name='vt' value='vt' class="hoverbutton2">Run Test Case & Submit</button>    
        </form>-->
        
      </div>

    </div>

    
    <div class="dropdown">
      <button class="dropbtn2">User Settings</button>
      <div class="dropdown-content">
        <form action='./admin_dashboard.php' method='POST'>
            <button type='submit' name='change-password' value='change-password' class="hoverbutton1">Change Password</button>
        </form>
        <form action='./reset_password_from_admin.php' method='POST'>
            <button type='submit' name='totp-check' value='totp-check' class="hoverbutton2">Reset Password</button>
        </form>
        
      </div>

    </div>


<div class="dropdown">
      <form action="./session_logout.php" method="POST">
       <button type="submit" class="menubutton2" name="logout_session" value="logged-out">Logout</button>
    </form>
  </div>
</div>

</div>




