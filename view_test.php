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





<br><center><font color="blue" size="5">Succesfully Created Tests/Assignments</font></center>

<?php 
$faculty_roll=$_SESSION['roll_no'];
$sql="SELECT * from tests where (status='Active' or status='Completed') and faculty_roll='$faculty_roll' order by status";
    
$stmt = $pdo->prepare($sql);
$stmt->execute();

?>

  <table align="center" border="1" width='80%'>
    <tr align="center" style="background: #ffeecc">
      <td width="10%">Test/Assignment Code <br>(Test/Assignment Password)</td>
      <td width="15%">Test/Assignment Name</td>
      <td width="8%">Date - Time</td>
      <td width="18%">Details</td>
      <td width="10%">Test/Assignment Case Details</td>
      <td width="10%">Question Paper and Test Case Upload</td>
      <td width="8%">Test/Assignment Status</td>
      <td width="8%">Action</td>
    </tr>

<?php
    while($t = $stmt->fetch(PDO::FETCH_ASSOC)){
      $tc=$t['tc'];
      $tname=$t['tname'];
      $tp=$t['test_password'];
      $tdate=$t['tdate'];
      $status=$t['status'];
      $modified_on=$t['modified_on'];
      $noq=$t['noc'];

      $sql1="SELECT * from testcase where tc='$tc'";
    
      $stmt1 = $pdo->prepare($sql1);
      $stmt1->execute();
      

      $sql2="SELECT * from qp where tc='$tc'";
    
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute();

      ?>
      <tr align="center">
        <td><?=$tc ?><br>(<?=$tp ?>)</td>
        <td><?=$tname ?></td>
        <td><font color="blue"><?=$tdate ?> - <?=$t['tstime'] ?></font><br>to<br><font color="blue"><?=$t['tedate'] ?> - <?=$t['tetime'] ?></font></td>
        <td>
        	No of Question: <?=$t['noc'] ?><br>
        	Total Marks: <?=$t['total_marks'] ?><br>

        	<?php 
        	while($tcr = $stmt1->fetch(PDO::FETCH_ASSOC)){

        		?>
        		<font color="blue">
        		Question No <?=$tcr['qn'] ?><br></font>
        		&emsp;Marks: <?=$tcr['marks'] ?><br>
        		&emsp;No of Test Cases: <?=$tcr['notc'] ?><br>
        		<?php

        	}

        	?>


        </td>
        <td><font color='green'>Updated</font></td>
        <td><font color='green'>Updated</font></td>
        <td><?=$t['status'] ?></td>

        
        	<td>

        		<?php 
        			if ($t['status']=='Active') {
        				?>
                <form action="assign_student.php" method="POST">
                <input type="hidden" name="tc" value="<?=$tc ?>">
                <input type="hidden" name="tname" value="<?=$tname ?>">
                <input type="hidden" name="tdate" value="<?=$tdate ?>">
                <input type="hidden" name="noq" value="<?=$noq ?>">
        					<input type="submit" name="assign-student" value="Assign Student"><br><br>
                  <input type="submit" name="view-student" value="View Student">
                </form>
        				<?php
        			}else{
        				?>
          <form action="result.php" method="POST">
          <input type="hidden" name="tc" value="<?=$tc ?>">
          <input type="hidden" name="tname" value="<?=$tname ?>">
          <input type="hidden" name="tdate" value="<?=$tdate ?>">
          <input type="hidden" name="noq" value="<?=$noq ?>">
        				<input type="submit" name="view-result" value="View Result">
          </form>
        				<?php
        			}
        		?>


        	</td>

        

        </tr>

        <?php 
      }
     
      ?>
      </table>
    
<?php 

require_once("./includes/footer.php");
?>