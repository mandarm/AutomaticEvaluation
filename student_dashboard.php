
<?php require_once("./includes/header_student.php"); 

?>



<!--........................................Change Password...................................-->
<?php
//Change password code<script>
 

if (isset($_POST['change-password-btn'])) {
      $email = $_SESSION['email'];
      $current_password=trim($_POST['current-password']);
      $new_password=trim($_POST['new-password']);
      $password_hash = password_hash($new_password, PASSWORD_BCRYPT,);

      $confirm_password=trim($_POST['confirm-password']);

      $sql_email_chk = "SELECT * FROM USERS where email='$email'";
                                            
      $stmt_email_chk = $pdo->prepare($sql_email_chk);
      $stmt_email_chk->execute();
      $user = $stmt_email_chk->fetch(PDO::FETCH_ASSOC);
      $user_password_hash = $user['password'];

      if ($new_password != $confirm_password) {
                echo "<center><font color=\"red\">New Password and confirm password does not match</br></font></center>";
                $_POST['change-password']='change-password';


      }elseif (password_verify($current_password, $user_password_hash)){

          $sql_password_update = "UPDATE USERS SET password='$password_hash' where email='$email'";
          $stmt_password_update = $pdo->prepare($sql_password_update);
          $stmt_password_update->execute();
          session_destroy();
          ?>
            <center><font color="red" size="5"> Password updated successfully</font></center>
          <?php 
          

      }else{
          echo "<center><font color=\"red\">Wrong Current password</font></center>";
           $_POST['change-password']='change-password';

      }
}


//Change password form generation

if (isset($_POST['change-password'])) {
  
?>
  <center><font color="green"><strong>Change Password</strong></font></center>
  <center><font color="blue">After password changed, you will be logged out. You need to login again using new password.</font></center>

<form action="student_dashboard.php" method="POST">
<table align="center" border="1">
    
<tr style="color:purple"><td>Current Password</td>
  <td>
        <input name="current-password" id="inputCurrentPassword" type="password" placeholder="Enter current password" required="true" style="width: 300px;" minlength="3" maxlength="12" />
    </td>
</tr>

<tr style="color:purple"><td>New Password</br> (max 12, min 6 characters)</td>
  <td>
        <input name="new-password" id="inputNewPassword" type="password" placeholder="Enter new password" required="true" style="width: 300px;" minlength="6" maxlength="12" />
    </td>
</tr>
                                              

 <tr style="color:purple"><td>Confirm New Password</td>
  <td>
      <input name="confirm-password" id="inputConfirmPassword" type="password" placeholder="Confirm new password" required="true" style="width: 300px;" minlength="6" maxlength="12"/>
    </td>
</tr>

<tr align="center">
  <td colspan=2 ><button type="submit" name="change-password-btn" style="background-color:yellow;margin:auto;display:block;text-align:center;" >Change Password</button></td>
</tr>

</table>

</form>


<?php
}




?>
<!--....................Change Password End......................................................-->


<?php 

$current_datetime= date("d-m-Y H:i:s");
$student_roll=$_SESSION['roll_no'];

$sql="SELECT * from tests where tc='$tc'";
    
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $t = $stmt->fetch(PDO::FETCH_ASSOC);
  $tst=$t['tdate'].' '.$t['tstime'];
  $tname=$t['tname'];
  $noq=$t['noc'];
  $td=$t['tdesc'];

  $sql1="SELECT * from T".$tc." where student_roll='$student_roll'";
   // echo $sql1;
  $stmt1 = $pdo->prepare($sql1);
  $stmt1->execute();
  $sr = $stmt1->fetch(PDO::FETCH_ASSOC);



?>



<center><font color="brown" size="5"><strong>Test/Assignment: <font color="brown" size="5"><?=$tc ?></font> (<font color="brown" size="5"><?=$tname ?></font>)  </strong></font></center><br>
<center>[<?=$td ?>]</center><br>

<table align="center" border="1">
  <tr align="center" style="background-color: #ffffb3">
    <td>Programming Language</td>

    <?php 
      for ($i=1; $i<=$noq ; $i++) { 
        ?>
          <td>Q<?=$i ?> Marks</td>
           <td>Q<?=$i ?> Full Marks</td>
        <?php
      }

    ?>
    <td>Total Marks Obtained</td>
    <td>Total Test Marks</td>
    <td>Percentage</td>
    
  </tr>
  <tr align="center">
    <td><?=$sr['prog_lang'] ?></td>
    <?php 
      for ($i=1; $i<=$noq ; $i++) { 
        ?>
          <td> 
              <?php 
                  $var1="Q".$i."_marks";
                  $var2="Q".$i."_fm";

                  echo $sr[$var1];

              ?>
          </td>
           <td><?=$sr[$var2] ?></td>
        <?php
      }

    ?>
    <td><?=$sr['tot_marks_obtained'] ?></td>
    <td><?=$sr['full_marks'] ?></td>
    <td><?=$sr['percentage'] ?></td>

  </tr>
</table><br><center> 'X' indicates programing language not chosen yet.</center><br>

<?php 
  if (strtotime($current_datetime) < strtotime($tst) ) {

  ?>
      <center><font color="black" size="4"><strong>Question paper will be available from <?=$tst ?>. Refresh this page on or after <?=$tst ?> to get the question paper.</strong></font></center>

  <?php

  }
?>


<?php 
  if (strtotime($current_datetime) >= strtotime($tst) ) {

    $sql="SELECT * from qp where tc='$tc'";
    
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $q = $stmt->fetch(PDO::FETCH_ASSOC);

  $qpaper=$q['qpaper'];

  ?>
      <center><a href="./tests/<?=$tc ?>/<?=$qpaper ?>" target="_blank" >View Question Paper</a>

        <form action="./test_auto.php" method="POST">
          <input type="hidden" name="tname" value="<?=$tname ?>">
          <input type="submit" name="execute-code" value="Execute and Submit Code">
        </form>
      </center>
  <?php

  }
?>


<?php require_once("./includes/footer.php"); ?>
