
<?php require_once("./includes/header_admin.php"); ?>

<script type="text/javascript">
	
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
       
</script> 


</script>


<!-- ...............................................................................................-->

<?php
						if(isset($_POST['reset-password'])) {

							$roll_no = trim($_POST['roll_no']);
							
							$new_password=trim($_POST['new-password']);
							$confirm_password=trim($_POST['confirm-password']);
                        	                        	
                        	//user existance check start
                        	$sql_roll_chk = "SELECT * FROM USERS where roll_no='$roll_no' and account_status='Active'";

                            $stmt_roll_chk = $pdo->prepare($sql_roll_chk);
                           
							$stmt_roll_chk->execute();

                        	$roll_count = $stmt_roll_chk->rowCount();
                        

							if ($roll_count == 0) {
								echo "<center><font color=\"red\">User with Roll No" . $roll_no ." not registered/account not active. </font></center>";
							}elseif ($new_password != $confirm_password) {
								echo "<center><font color=\"red\">New Password and confirm password does not match</br></font></center>";


							}elseif ($new_password == $confirm_password) {

								//Generate password hash
								$password_hash = password_hash($new_password, PASSWORD_BCRYPT);

								$sql_password_update = "UPDATE USERS SET password='$password_hash' where roll_no='$roll_no'";
                                $stmt_password_update = $pdo->prepare($sql_password_update);
								if($stmt_password_update->execute())
								{
									
								
								echo "<center><font color=\"red\">Password reset successful.</font></center>";
								
								}
							}


							
						}

?>

<center><font color="green"><strong>Reset Password</strong></font></center>

<form action="reset_password_from_admin.php" method="POST">
<table align="center" border="1">
    
<tr>
	<td>Enter your Roll No:</td>
	<td><input name="roll_no" placeholder="Enter Roll No" required="true" style="width: 300px;"/></td>
</tr>

<tr style="color:purple"><td>New Password</td>
	<td>
        <input name="new-password" id="inputNewPassword" type="password" placeholder="Enter new password" required="true" style="width: 300px;" minlength="6" maxlength="12" value="123456" />
    </td>
</tr>
                                              

 <tr style="color:purple"><td>Confirm Password</td>
 	<td>
    	<input name="confirm-password" id="inputConfirmPassword" type="text" placeholder="Confirm password" required="true" style="width: 300px;" minlength="6" maxlength="12" value="123456" />
    </td>
</tr>

<tr align="center">
	<td colspan=2 ><button type="submit" name="reset-password" style="background-color:yellow;margin:auto;display:block;text-align:center;" >Reset Password</button></td>
</tr>

</table>

</form>

<?php require_once("./includes/footer.php"); ?>
