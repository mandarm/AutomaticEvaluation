<?php 

session_start();

if ($_SESSION['user_role']=='Faculty') {
	require_once("./includes/header_faculty.php"); 
}
if ($_SESSION['user_role']=='DB-Admin') {
	require_once("./includes/header_admin.php");
}

?>



<!--..............................CheckAll Java script  start..............................--
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
        <script src="./js/jquery.min.js"></script>
        <script type="text/javascript">
				$(document).ready(function(){

				  // Check/Uncheck ALl
				  $('#checkAll').change(function(){
				    if($(this).is(':checked')){
				      $('input[name="update[]"]').prop('checked',true);
				    }else{
				      $('input[name="update[]"]').each(function(){
				         $(this).prop('checked',false);
				      });
				    }
				  });

				  // Checkbox click
				  $('input[name="update[]"]').click(function(){
				    var total_checkboxes = $('input[name="update[]"]').length;
				    var total_checkboxes_checked = $('input[name="update[]"]:checked').length;

				    if(total_checkboxes_checked == total_checkboxes){
				       $('#checkAll').prop('checked',true);
				    }else{
				       $('#checkAll').prop('checked',false);
				    }
				  });
				});


	function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
		</script>

<!-- onkeypress="return isNumberKey(event)" -->

<?php 
	if (isset($_POST['ct'])) {

		$tname=$_POST['tname'];
		$tdate=$_POST['tdate'];
		$tedate=$_POST['tedate'];
		$tstime=$_POST['tstime'];
		$tetime=$_POST['tetime'];
		$tdesc=$_POST['tdesc'];
		$noc=$_POST['noc'];
		$tp=$_POST['tp'];
		$total_marks=$_POST['total_marks'];

		?>
		<br><center><font color="blue" size="5"><strong>Create New Test</strong></font></center>
		<form action="" method="POST">
			<table align="center" border="1">
				<tr>
					<td>Test/AssignmentName: </td>
					<td><input type="text" name="tname" required minlength="3" value="<?=$tname ?>"></td>
				</tr>
				<tr>
					<td>Test/AssignmentStart Date (DD-MM-YYYY): </td>
					<td><input type="text" name="tdate" required minlength="10" maxlength="10" pattern="(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-(202)\d" value="<?=$tdate ?>"></td>
				</tr>
				<tr>
					<td>Test/AssignmentStart Time (HH:MM:SS): </td>
					<td><input type="text" name="tstime" required minlength="8" maxlength="8" pattern="([01][0-9]|2[01234]):[0-5][0-9]:[0-5][0-9]" value="<?=$tstime ?>"></td>
				</tr>
				<tr>
					<td>Test/AssignmentEnd Date (DD-MM-YYYY): </td>
					<td><input type="text" name="tedate" required minlength="10" maxlength="10" pattern="(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-(202)\d" value="<?=$tedate ?>"></td>
				</tr>
				<tr>
					<td>Test/AssignmentEnd Time (HH:MM:SS): </td>
					<td><input type="text" name="tetime" required minlength="8" maxlength="8" pattern="([01][0-9]|2[01234]):[0-5][0-9]:[0-5][0-9]" value="<?=$tetime ?>"></td>
				</tr>
				<tr>
					<td>Test/AssignmentDescription (if any): </td>
					<td><input type="text" name="tdesc" value="<?=$tdesc ?>"></td>
				</tr>
				<tr>
					<td>Number of Question (1-99):<br>(without 0 padding) </td>
					<td><input type="text" name="noc" required minlength="1" maxlength="2"  pattern="[1-9][0-9]*" onkeypress="return isNumberKey(event)" value="<?=$noc ?>"></td>
				</tr>
				<tr>
					<td>Total Marks: </td>
					<td><input type="text" name="total_marks" required minlength="1" maxlength="3" onkeypress="return isNumberKey(event)" value="<?=$total_marks ?>"></td>
				</tr>

				<tr>
					<td>Test/AssignmentPassword: </td>
					<td><input type="text" name="tp" required minlength="1" maxlength="50" value="<?=$tp ?>"></td>
				</tr>

				<tr>
					<td colspan="2" align="center"><input type="submit" name="ctb"></td>
				</tr>
			</table>

		</form>
		<?php
	}

?>


<?php 
     if(isset($_POST['ctb'])){

     	$tname=$_POST['tname'];
		$tdate=$_POST['tdate'];
		$tedate=$_POST['tedate'];
		$tstime=$_POST['tstime'];
		$tetime=$_POST['tetime'];
		$tdesc=$_POST['tdesc'];
		$noc=$_POST['noc'];
		$tp=$_POST['tp'];
		$total_marks=$_POST['total_marks'];
		$e=0;

		//$s= $tdate.' '.$tstime;
		//$e= $tdate.' '.$tetime;

		$datetime1 = new DateTime($tdate.' '.$tstime);
		$datetime2 = new DateTime($tedate.' '.$tetime);


		if ($datetime1 > $datetime2 ) {
			?>
			<center><font color="red" size="5"> Test/AssignmentEnd Date-Time is earlier than Test/AssignmentStart Date-Time. Please Enter Correct Details</font></center>

			<?php 
			$e=$e+1;
			
			
		}

		$todays_date= new dateTime (date("d-m-Y H:i:s"));

		if ($todays_date > $datetime1 ) {
			?>
			<center><font color="red" size="5"> Current Date-Time is earlier than Test/AssignmentStart Date-Time. Please Enter Correct Details</font></center>

			<?php 
			$e=$e+1;
			
			
		}

		?>

<center><font color="blue" size="5"><strong>Create New Test/Assignment- Confirm Details</strong></font></center>
		<form action="" method="POST">
			<table align="center" border="1">
				<tr>
					<td>Test/Assignment Name: </td>
					<td><?=$tname ?></td> <input type="hidden" name="tname" value="<?=$tname ?>">
					<input type="hidden" name="val[]" value="<?=$tname ?>">
				</tr>
				<tr>
					<td>Test/Assignment Start Date (DD-MM-YYYY): </td>
					<td><?=$tdate ?></td> <input type="hidden" name="tdate" value="<?=$tdate ?>">
					<input type="hidden" name="val[]" value="<?=$tdate ?>">
				</tr>
				<tr>
					<td>Test/Assignment Start Time (HH:MM:SS): </td>
					<td><?=$tstime ?></td> <input type="hidden" name="tstime" value="<?=$tstime ?>">
					<input type="hidden" name="val[]" value="<?=$tstime ?>">
				</tr>
				<tr>
					<td>Test/Assignment End Date (DD-MM-YYYY): </td>
					<td><?=$tedate ?></td> <input type="hidden" name="tedate" value="<?=$tedate ?>">
					<input type="hidden" name="val[]" value="<?=$tedate ?>">
				</tr>
				<tr>
					<td>Test/Assignment End Time (HH:MM:SS): </td>
					<td><?=$tetime ?></td> <input type="hidden" name="tetime" value="<?=$tetime ?>">
					<input type="hidden" name="val[]" value="<?=$tetime ?>">
				</tr>
				<tr>
					<td>Test/Assignment Description (if any): </td>
					<td><?=$tdesc ?></td> <input type="hidden" name="tdesc" value="<?=$tdesc ?>">
					<input type="hidden" name="val[]" value="<?=$tdesc ?>">
				</tr>
				<tr>
					<td>Number of Question (1-99):</td>
					<td><?=$noc ?></td><input type="hidden" name="noc" value="<?=$noc ?>">
					<input type="hidden" name="val[]" value="<?=$noc ?>">
				</tr>
				<tr>
					<td>Total Marks: </td>
					<td><?=$total_marks ?></td><input type="hidden" name="total_marks" value="<?=$total_marks ?>">
					<input type="hidden" name="val[]" value="<?=$total_marks ?>">
				</tr>

				<tr>
					<td>Test/Assignment Password: </td>
					<td><?=$tp ?></td><input type="hidden" name="tp" value="<?=$tp ?>">
					<input type="hidden" name="val[]" value="<?=$tp ?>">
				</tr>

				<tr>
					<?php 
						if ($e==0) {
							?>
								<td colspan="2" align="center"><input type="submit" name="ctb-cnf" value="Confirm"></td>
							<?php
						}else{
							?>
								<td colspan="2" align="center"><input type="submit" name="ct" value="Go Back & Edit"></td>
							<?php

						}
					?>

					
				</tr>
			</table>
			<?php 
				$val = array($tname,$tdate,$tstime,$tedate,$tetime,$tdesc,$noc,$total_marks,$tp);
			?>



		</form>

		<?php

     }
  
?>

<?php 
     if(isset($_POST['ctb-cnf'])){

     	

     	$tname=$_POST['val'][0];
		$tdate=$_POST['val'][1];
		$tstime=$_POST['val'][2];
		$tedate=$_POST['val'][3];
		$tetime=$_POST['val'][4];
		$tdesc=$_POST['val'][5];
		$noc=$_POST['val'][6];
		$total_marks=$_POST['val'][7];
		$tp=$_POST['val'][8];
		$faculty_roll=$_SESSION['roll_no'];
		$t=time();

		$sql="SELECT max(tc) as mtc from tests";
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$tc=$t['mtc'] + 1;

		$sql="INSERT INTO tests values (0,'$tc','$tname','$faculty_roll','$tdate','$tstime','$tedate','$tetime','$tdesc','$noc','$total_marks','$tp','Pending',current_timestamp())";
		
		$stmt = $pdo->prepare($sql);
		$stmt->execute();

		//Create a folder with test code

		$loc="/opt/lampp/htdocs/testautomation/tests/".$tc;
		mkdir($loc);
		mkdir($loc.'/temp');
		shell_exec("sudo chmod -R 777 ./tests/".$tc);

		echo "<br><br><center><font color='brown' size='5'>Test/Assignment Created Successfully. Update other details from home page to activate the Test/Assignment.</font></center>";
		require_once("./includes/footer.php");
		die;
		

	}

		?>




		<?php require_once("./includes/footer.php"); ?>