<?php 

session_start();

if ($_SESSION['user_role']=='Faculty') {
	require_once("./includes/header_faculty.php"); 
}
if ($_SESSION['user_role']=='DB-Admin') {
	require_once("./includes/header_admin.php");
}


if (isset($_POST['cancel_upload'])) {
  header("Refresh:0;url=./view_test.php");
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



<?php 
  if (isset($_POST['assign-student'])) {
     $tc=$_POST['tc'];
     $tname=$_POST['tname'];

     ?>
     <center><font size="5" color="brown"><strong> Upload Student List in Proper Format</strong></font></center><br>
     <center>Test/Assignment Code: <?=$tc ?></center><br>
     <center>Test/Assignment Name: <?=$tname ?></center><br>

     <center><font color="blue">If a [Roll No, Name] pair is re-uploaded, then previous name will be updated if there is a mismatch, otherwise upload of the pair will be ignored.</font></center><br>

     <center><a href="./sample_files/student_list.csv" download>Click here</a> for sample format</br></center>

     <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="val[]" value="<?=$tc ?>">
      <input type="hidden" name="val[]" value="<?=$tname ?>">

      <table border="1" align="center">
        <tr align="center">
              <td>Choose your CSV file</td>
              <td align="center"><input type="file" name="file" value="Choose CSV file" accept=".xls,.xlsx" required="true" /></td>
              
          </tr>

          <tr>
              
              <td colspan="2" align="center" ><input style="background-color:blue;color: white;" type="submit" name="upload_student_list" value="Upload"/></td>
          </tr>
      </table>
       <?php 
        $val = array($tc,$tname);
      ?>

     </form>

     <?php

  }



?>




<?php 
if (isset($_POST['upload_student_list'])) {
  $tc=$_POST['val'][0];
  $tname=$_POST['val'][1];

  $file = $_FILES["file"]["tmp_name"];

 $file_extension =basename($_FILES["file"]["name"]);
 $fileType = strtolower(pathinfo($file_extension,PATHINFO_EXTENSION));

if(strtolower($fileType) != "csv") {
      echo "<center><font color='red' size='5'> Sorry, only CSV files are allowed.</center></font> ";
      require_once("./includes/footer.php");
      die;
    }


 $file_open = fopen($file,"r");
 $csv = fgetcsv($file_open, 1000, ",");

 ?>
  <center>Test/Assignment Code: <?=$tc ?></center><br>
  <center>Test/Assignment Name: <?=$tname ?></center><br>
  <form method="post" action="" >
      <input type="hidden" name="val[]" value="<?=$tc ?>">
      <input type="hidden" name="val[]" value="<?=$tname ?>">

      <table border="1" align="center" width="50%">
        <tr align="center">
              <td align="center">Roll No</td>
              <td align="center">Student Name</td>
              
        </tr>
        <?php 
          $i=0; $m=2;
           while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
           {


            $student_roll=strtoupper(trim($csv[0])) ;
            $student_name=strtoupper(trim($csv[1]));

            if($i % $m == 0){

              echo "<tr bgcolor='lime'>";
            }else{

              echo "<tr bgcolor='white'>";
            }
            ?>
            <td width="50px"><?= $student_roll ?><input type="hidden" name="student_roll_<?= $i ?>" value="<?=$student_roll ?>" /></td>
            <td width="50px"><?= $student_name ?><input type="hidden" name="student_name_<?= $i ?>" value="<?=$student_name ?>" /></td>
            </tr>
            <?php 
            $i=$i + 1;
          }
        ?>
          <tr>
      <td colspan="6" align="center">
        Number of records: <?= $i ?>
        <input type="hidden" name="nrecord" value="<?=$i ?>" /><br>
        <input type="submit" name="upload_student_list_btn" value="Verify & Upload"/>
        <!--<input type="submit" name="cancel_upload" value="Cancel Upload"/>-->

      </td>

    </tr>
      </table>
       <?php 
        $val = array($tc,$tname);
      ?>

     </form>



<?php

}


?>



<?php 
if (isset($_POST['upload_student_list_btn'])) {
  $tc=$_POST['val'][0];
  $tname=$_POST['val'][1];
  $cnt=$_POST['nrecord'];

  $x=0;
  while ($x < $cnt) {
   // echo "Updating Record - ".$x;
    $student_roll=$_POST['student_roll_'.$x];
    $student_name=$_POST['student_name_'.$x];

    $sql="SELECT * from student_allocation where stud_roll_no='$student_roll' and tc='$tc'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $sql1='';
    $insert=0;
    if ($stmt->rowCount()>0) {
      $sql1="UPDATE student_allocation set student_name='$student_name' where stud_roll_no='$student_roll'";
      
    }else{
       $sql1="INSERT INTO student_allocation (id,tc,stud_roll_no,student_name) VALUES (0,'$tc','$student_roll','$student_name')";
       $insert=1;
    }

   
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    //echo $sql1."<br>";
    //Insert data into marks table
     $sql="SELECT * from testcase where tc='$tc'";
     $stmt = $pdo->prepare($sql);
     $stmt->execute();
     if ($insert==1) {
      $sqlu="INSERT INTO T".$tc." (id,student_roll,student_name) VALUES (0,'$student_roll','$student_name')";
      $stmtu = $pdo->prepare($sqlu);
      $stmtu->execute();
      //echo "--".$sqlu."<br>";
      }
     while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
      $qn=$r['qn'];
      $marks=$r['marks'];

     

     $sqlu="UPDATE T".$tc." SET Q".$qn."_fm=".$marks." where student_roll='".$student_roll."'";
     
     $stmtu = $pdo->prepare($sqlu);
     $stmtu->execute();

     }

    $x=$x+1;
  }

echo "<center>Student List Upload Successful</center>";

}





?>






<?php 
  if (isset($_POST['view-student'])) {
     $tc=$_POST['tc'];
     $tname=$_POST['tname'];

     $sql="SELECT * from student_allocation where tc='$tc' order by stud_roll_no";
     $stmt = $pdo->prepare($sql);
     $stmt->execute();

     ?>
<br><center><font color="brown" size="4">Assigned Student for Test/Assignment: <font color="blue" size="4"><?=$tname ?> (Test Code: <?=$tc ?>)</font></font></center><br>
     <table border="1" align="center">
       <tr>
         <td>Roll No</td>
         <td>Student Name</td>
       </tr>

       <?php 
          while ( $r = $stmt->fetch(PDO::FETCH_ASSOC)) {
           $student_roll=$r['stud_roll_no'];
           $student_name=$r['student_name'];

           ?>
            <tr>
              <td><?=$student_roll ?></td>
              <td><?=$student_name ?></td>
            </tr>
           <?php
          }

       ?>

     </table>


     <?php


   }

?>













<?php

require_once("./includes/footer.php");
?>