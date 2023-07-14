<?php 

session_start();

if ($_SESSION['user_role']=='Faculty') {
	require_once("./includes/header_faculty.php"); 
}
if ($_SESSION['user_role']=='DB-Admin') {
	require_once("./includes/header_admin.php");
}


//$str= 'echo "  " | sudo -k -S chmod +X -R /opt/lampp/htdocs/testautomation/tests/';
//shell_exec($str);
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
    if (isset($_POST['view-result'])) {
      $tc=$_POST['tc'];
      $tname=$_POST['tname'];
      $noq=$_POST['noq'];

      $sql="SELECT * from T".$tc;
    
      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      shell_exec("zip -r ".$tc.".zip ./tests/".$tc."/");
      shell_exec("mv ".$tc.".zip ./tests/");
?>

<br>
<center><font color="brown" size="5"><strong>RESULT<br>Test/Assignment: <font color="brown" size="5"><?=$tc ?></font> (<font color="brown" size="5"><?=$tname ?></font>)  </strong></font></center><br>

<table align="center" border="1">
  <tr align="center" style="background-color: #ffffb3">
    <td>Student Name</td>
    <td>Roll No</td>
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
    <td>Viwe Output & Code</td>
  <?php 
    while ($sr = $stmt->fetch(PDO::FETCH_ASSOC)) {
      # code...
   
  ?>  
  </tr>
  <tr align="center">
    <td><?=$sr['student_name'] ?></td>
    <td><?=$sr['student_roll'] ?></td>
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
    <td>
      <?php 
        for ($i=1; $i<=$noq ; $i++) { 
          $v="Question-".$i;
          ?>
          <form action="test_auto_fac.php" method="POST" target="_blank">
                <input type="hidden" name="tc" value="<?=$tc ?>">
                <input type="hidden" name="tname" value="<?=$tname ?>">
                <input type="hidden" name="proglan" value="<?=$sr['prog_lang']  ?>">
                <input type="hidden" name="qn" value="<?=$i ?>">
                <input type="hidden" name="student_roll" value="<?=$sr['student_roll'] ?>">
                <input type="hidden" name="student_name" value="<?=$sr['student_name']  ?>">
                <input type="submit" name="src_file" value="<?=$v ?>">
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



<center><font color="blue" size="5">'X' in Programming Language indicates the student have not answered any question</font></center><br><br>

<center><font color="brown" size="4"><a href="./tests/<?=$tc ?>.zip" target="_blank">Click Here</a> to download ZIP file of source codes</font></center>

<?php
    }

?>


    
<?php 

require_once("./includes/footer.php");
?>