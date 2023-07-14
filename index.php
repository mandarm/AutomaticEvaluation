<?php ob_start(); session_start();?>
<?php require_once("./includes/header.php"); ?>



<?php 
	$sql="SELECT * from tests where status='Active'";
    
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	 while($t = $stmt->fetch(PDO::FETCH_ASSOC)){
	 	$tc=$t['tc'];

	 	$tet=$t['tedate'].' '.$t['tetime'];

	 	$current_datetime= date("d-m-Y H:i:s");

	 	//echo " Current Time = ".$current_datetime;
	 	//echo "  Curr DT =".strtotime($current_datetime);
	 	//echo " Test Date Time= ".strtotime($tet);

	 	if (strtotime($current_datetime) > strtotime($tet) ) {

	 		$sql="UPDATE tests set status='Completed' where status='Active' and tc='$tc'";
    
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
	 }

	}


?>






<!-- ....................................... Signin Handeller Start........................................................-->
<?php
						if(isset($_POST['submit'])) {


							$roll_no = strtolower(trim($_POST['roll_no']));
							$password = trim($_POST['password']);
                        	$password_hash = password_hash($password, PASSWORD_BCRYPT,);
                        	
                            $sql_roll_chk = "SELECT * FROM USERS where roll_no='$roll_no'";
                        	
				            
                                            
  							$stmt_roll_chk = $pdo->prepare($sql_roll_chk);
							$stmt_roll_chk->execute();
                        	$roll_count = $stmt_roll_chk->rowCount();
									
                        	

                            if ($roll_count == 0){
                                echo "<center><font color=\"red\">User does not exists.</font></center>";
                                //die;
                                } //user existance check end

							elseif ($roll_count == 1){
                     			//user credential check - verify password - start
  								$user = $stmt_roll_chk->fetch(PDO::FETCH_ASSOC);
                                $user_password_hash = $user['password'];
                                $user_role = $user['user_role'];
                                $user_name = $user['full_name'];
                                $email=$user['email'];
                                
                                if (password_verify($password, $user_password_hash)){

                        			
										$_SESSION['email']=$email;
										$_SESSION['user_role']=$user_role;
										$_SESSION['login']='success';
										$_SESSION['user_name']=$user_name;
										$_SESSION['login_time_stamp'] = time();
                                        $_SESSION['roll_no']=$roll_no;
                                       									
										                                                                         
                                        

										if ($user_role=="DB-Admin") {
                                            //echo $sql;
											header("Refresh:0;url=./admin_dashboard.php");
										}elseif ($user_role=="Faculty") {
											header("Refresh:0;url=./faculty_dashboard.php");
										}elseif ($user_role=="Staff") {
											header("Refresh:0;url=./admin_dashboard.php");
										}else{

											header("Refresh:0;url=./index.php");
										}

									
								} // user credential check - end

								else{ echo "<center><font color=\"red\">Wrong Credentials</font></center>";
								//die;
								} 
							}
							else {echo "<center><font color=\"red\">Multiple users registered with same email id</font></center>";//die;
								}

                                skip_student_login:
                                skip_faculty_login:
                                null_login:

					}  
					 ?>


	

					 <?php
						if(isset($_POST['submit-student'])) {


							$roll_no = strtoupper(trim($_POST['roll_no']));
							$tc = trim($_POST['tc']);
							$tp = trim($_POST['tp']);

							                      	

                        	$sql_tc_chk = "SELECT * from tests where tc='$tc' and status='Active'";              
  							$stmt_tc_chk = $pdo->prepare($sql_tc_chk);
							$stmt_tc_chk->execute();
                        	$tc_count = $stmt_tc_chk->rowCount();

                        	
                            $sql_roll_chk = "SELECT * FROM student_allocation where stud_roll_no='$roll_no' and tc='$tc'";              
  							$stmt_roll_chk = $pdo->prepare($sql_roll_chk);
							$stmt_roll_chk->execute();
                        	$roll_count = $stmt_roll_chk->rowCount();
									
                        	//echo $sql_roll_chk;

                            if ($tc_count == 0){
                                echo "<center><font color=\"red\">Test (".$tc.") does not exists / submission time expired.</font></center>";
                                
                                } //user existance check end
                                elseif ($tc_count>0 && $roll_count == 0){
                                echo "<center><font color=\"red\">Student with Roll No.: </font><font color=\"blue\">".$roll_no."</font><font color=\"red\"> is not listed as a candidate for the test (code): </font><font color=\"blue\">".$tc.".</font></center>";
                                //die;
                                } //user existance check end

							elseif ($roll_count >0 && $tc_count>0){
								$tst = $stmt_tc_chk->fetch(PDO::FETCH_ASSOC);
								$td = $tst['tdate'];
								$tname = $tst['tname'];
								$today=date('d-m-Y');
								
								if (strtotime($today)  < strtotime($td)) {
									echo "<center><font color=\"red\">Login by students for test : </font><font color=\"blue\">".$tc."(".$tst['tname'].")</font><font color=\"red\"> is allowed only on or after: </font><font color=\"blue\">".$td.".</font></center>";
									require_once("./includes/footer.php");
									die;
								}


								if ($tst['test_password']==$tp){
                     			//user credential check - verify password - start
  								$stud = $stmt_roll_chk->fetch(PDO::FETCH_ASSOC);
                                
                                $user_role = 'Student';
                                $_SESSION['user_role']=$user_role;
                                $user_name = $stud['student_name'];
                                $_SESSION['user_name']=$user_name;
                                $_SESSION['roll_no']=$roll_no;
                                $_SESSION['login']='success';
                                $_SESSION['login_time_stamp'] = time();
                                $_SESSION['tc']=$tc;
                                $_SESSION['tname']=$tname;
                                

								if ($user_role=="DB-Admin") {
                                           
									header("Refresh:0;url=./admin_dashboard.php");
								}elseif ($user_role=="Faculty") {
									header("Refresh:0;url=./faculty_dashboard.php");
								}elseif ($user_role=="Staff") {
									header("Refresh:0;url=./admin_dashboard.php");
								}elseif ($user_role=="Student") {
									
									header("Refresh:0;url=./student_dashboard.php");
								}
								else{

									header("Refresh:0;url=./index.php");
								}

									
							

								}else{
									


								 echo "<center><font color=\"red\">Wrong Test Password</font></center>";
								
								} 
							}
							
					}  
					 ?>





<!-- ....................................... Signin Handeller End........................................................-->

<table align="center">
	<tr>
		<td>
			<center><font color="blue">Faculty/Admin Login</font> </center>
			<form action="index.php" method="POST">
	
				<table align="center" border="0">
				    
				<tr>
				    <td align="right">Roll No.: </td>
				    <td><input name="roll_no" id="roll_no" placeholder="Enter your Roll No." required="true" /></td>
				</tr>
				<tr>
					<td align="right">Password:</td><td><input name="password" id="password" type="password" placeholder="Enter password" required="true" maxlength="12" /></td>
				</tr>

				<tr align="center">
					<td></td>
					<td  ><button type="submit" name="submit" style="background-color:yellow;margin:auto;display:block;text-align:center;">Login</button></td><td></td></tr>

				</table>

			</form>
			
		</td>

		<td>&emsp;&emsp;</td>

		<td>
			<center><font color="blue">Student Login</font> </center>
			<form action="index.php" method="POST">
	
				<table align="center" border="0">
				    
				<tr>
				    <td align="right">Roll No.: </td>
				    <td><input name="roll_no" id="roll_no" placeholder="Enter your Roll No." required="true" /></td>
				</tr>
				<tr>
				    <td align="right">Test/Assignment Code.: </td>
				    <td><input name="tc"  placeholder="Enter test code." required="true" /></td>
				</tr>
				<tr>
					<td align="right">Test/Assignment Password:</td><td><input name="tp" type="text" placeholder="Enter test password" required="true" maxlength="50" /></td>
				</tr>

				<tr align="center">
					<td></td>
					<td  ><button type="submit" name="submit-student" style="background-color:yellow;margin:auto;display:block;text-align:center;">Login</button></td><td></td></tr>

				</table>

			</form>
			
		</td>
	</tr>

</table>







<?php require_once("./includes/footer.php"); ?>
