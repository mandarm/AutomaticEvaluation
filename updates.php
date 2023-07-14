

<?php 
  if (isset($_POST['cutcd'])) {
    $tc=$_POST['tc'];

    $tname=$_POST['tname'];
    $noc=$_POST['noc'];
    $total_marks=$_POST['total_marks'];




    
    for ($i=1; $i <=$noc ; $i++) { 
      $qn=$_POST['qn_'.$i];
      $notc=$_POST['notc_'.$i];
      $tcw=$_POST['tcw_'.$i];

     
      $marks=$_POST['marks_'.$i];
      
       $sql="INSERT INTO testcase VALUES (0, '$tc', '$qn', '$notc','$tcw', '$marks')";
 
      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      

    }

     

      $str="CREATE TABLE `T".$tc."` ( `id` int(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, `student_roll` varchar(50) NOT NULL UNIQUE, `student_name` varchar(150) NOT NULL, `prog_lang` varchar(10) DEFAULT 'X', ";

        for ($i=1; $i <=$noc ; $i++) { 

          $str=$str."Q".$i."_marks  int(3) DEFAULT 0 ,  ";
          $str=$str."Q".$i."_fm  int(3) DEFAULT 1,  ";

        }

        $str=$str. " `tot_marks_obtained` int(3) as (";
        for ($i=1; $i <=$noc ; $i++) { 

          if($i==1){

          $str=$str."Q".$i."_marks";
        }else{
            $str=$str." + Q".$i."_marks";

        }

        }

        $str=$str."), `full_marks` int(3) as (";

        for ($i=1; $i <=$noc ; $i++) { 

          if($i==1){

          $str=$str."Q".$i."_fm  ";
        }else{
            $str=$str." + Q".$i."_fm  ";

        }

        }

        $str=$str. "), `percentage` decimal(10,2) as ((tot_marks_obtained / full_marks) * 100)      ) ;";

      $sql=$str;
   
      $stmt = $pdo->prepare($sql);
      $stmt->execute();


    ?>


      <center><font color="Brown">Testcase Update Succesful.</font></center>


    <?php
    

  }


?>








<?php 
  if (isset($_POST['uqpaio'])) {
    
    $tc=$_POST['tc'];

    $target_dir = '/opt/lampp/htdocs/testautomation/tests/'.$tc.'/';

    $sql="SELECT * from tests where tc='$tc'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $t = $stmt->fetch(PDO::FETCH_ASSOC);
    $tname=$t['tname'];
    $noc=$t['noc'];
    $total_marks=$t['total_marks'];


    $sql="SELECT * from testcase where tc='$tc'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

        ?>
        <?php 
        $uploadOk = 1;
        $file_extension =basename($_FILES["qp"]["name"]);
    $fileType = strtolower(pathinfo($file_extension,PATHINFO_EXTENSION));
    if($fileType != "pdf") {
          echo "<center><font color='red' size='5'>Sorry, only .pdf files are allowed in Question Paper.</font></center>";
          $uploadOk = 0;
        }
     
    $qp_base_name   = $tc.'_'.time().'.pdf';
    

            while ($t = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $qn=$t['qn'];
              $notc=$t['notc'];
              
              for ($i=1; $i <=$notc ; $i++) { 
                $ifname='input_'.$tc.'-'.$qn.'-'.$i;
                $ofname='output_'.$tc.'-'.$qn.'-'.$i;
                $var='Question-'.$qn.': Test Case-'.$i;
                $file_extension =basename($_FILES[$ifname]["name"]);
        $fileType = strtolower(pathinfo($file_extension,PATHINFO_EXTENSION));
        if($fileType != "txt") {
          echo "<center><font color='red' size='5'>";
            echo $var.' Input:  ';
              echo "Sorry, only .txt files are allowed in input testcase file.</font></center><br>";
              $uploadOk = 0;
            }

        $file_extension =basename($_FILES[$ofname]["name"]);
        $fileType = strtolower(pathinfo($file_extension,PATHINFO_EXTENSION));
        if($fileType != "txt") {
          echo "<center><font color='red' size='5'>";
            echo $var.' Output: ';
              echo "Sorry, only .txt files are allowed in output testcase file.</font></center><br><br>";
              $uploadOk = 0;
            }

        $ibase_name   = 'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
        $obase_name   = 'output_'.$tc.'-'.$qn.'-'.$i.'.txt';
        $target_file = $target_dir . $base_name;
                
              }

              }


              if ($uploadOk==1) {
                $sql="SELECT * from testcase where tc='$tc'";
    
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
              
              $target_file = $target_dir . $qp_base_name;
              move_uploaded_file($_FILES["qp"]["tmp_name"], $target_file);
              

               while ($t = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $qn=$t['qn'];
                $notc=$t['notc'];
                for ($i=1; $i <=$notc ; $i++) { 
                  $ifname='input_'.$tc.'-'.$qn.'-'.$i;
                  $ofname='output_'.$tc.'-'.$qn.'-'.$i;
                  $var='Question-'.$qn.': Test Case-'.$i;
                  $ibase_name   = 'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
                 $obase_name   = 'output_'.$tc.'-'.$qn.'-'.$i.'.txt';

          

                  $target_file = $target_dir . $ibase_name;
                  move_uploaded_file($_FILES[$ifname]["tmp_name"], $target_file);

                  $target_file = $target_dir . $obase_name;
                  move_uploaded_file($_FILES[$ofname]["tmp_name"], $target_file);
                  
                
                }
              }

              $sql="INSERT INTO qp (id,tc,qpaper) VALUES (0,'$tc','$qp_base_name')";
    
          $stmt = $pdo->prepare($sql);
          $stmt->execute();


          $sql="UPDATE tests set status='Active' where tc='$tc'";
    
          $stmt = $pdo->prepare($sql);
          $stmt->execute();



        }
      
        ?>

          <center><font color="red" size="5">Documents uploaded succesfully. Go to Tests->View Tests for further steps.</font></center>
        <?php
        
        header("url=./view_tests.php");
        require_once("./includes/footer.php");
        die;
      

}

header("Refresh:0");
?>














<br><center><font color="blue" size="5">Tests/Assignments Pending for Update</font></center>

<?php 
$faculty_roll=$_SESSION['roll_no'];
$sql="SELECT * from tests where status='Pending' and faculty_roll='$faculty_roll'";
    
$stmt = $pdo->prepare($sql);
$stmt->execute();

if ($stmt->rowCount()==0) {
  ?>
    <center><font color="green" size="5">You do not have any test/assignment pending for update</font></center>
  <?php 
}else{
?>

  <table align="center" border="1" width='80%'>
    <tr align="center" style="background: #ffeecc">
      <td width="10%">Test/Assignemnt Code</td>
      <td width="35%">Test/Assignemnt Name</td>
      <td width="8%">Test Date</td>
      <td width="10%">Testcase Details</td>
      <td width="10%">Question Paper and Testcase Upload</td>
      <td width="8%">Test Status</td>
    </tr>

<?php
    while($t = $stmt->fetch(PDO::FETCH_ASSOC)){
      $tc=$t['tc'];
      $tname=$t['tname'];
      $tdate=$t['tdate'];
      $status=$t['status'];
      $modified_on=$t['modified_on'];

      $sql1="SELECT * from testcase where tc='$tc'";
    
      $stmt1 = $pdo->prepare($sql1);
      $stmt1->execute();

      $sql2="SELECT * from qp where tc='$tc'";
    
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->execute();

      ?>
      <tr align="center">
        <td><?=$tc ?></td>
        <td><?=$tname ?></td>
        <td><?=$tdate ?></td>
        
      
      <?php

      if ($stmt1->rowCount()>0) {
       echo "<td><font color='green'>Updated</font></td>";
      }else{
        
        $current_datetime= date("d-m-Y H:i:s");
        
        $cooling_period= strtotime($modified_on) + 00;
        

        if (strtotime($current_datetime) < $cooling_period ) {
      ?>
       <td>Wait upto <?= date('d-m-Y H:i:s', $cooling_period); ?> for further updates. </td>

      <?php 
      $e=$e+1;
      goto skip;
      
      
    }

        ?>
        <form action="" method="POST">
          <input type="hidden" name="tc" value="<?=$tc ?>">
          <input type="hidden" name="tname" value="<?=$tname ?>">
          <input type="hidden" name="tdate" value="<?=$tdate ?>">
          <td><input type="submit" name="utc" value="Click to Update"></td>

        </form>

        <?php 
      }
      skip:

      if ($stmt1->rowCount()==0) {
       echo "<td><font color='red'>This option will be available after updating Testcase details</font></td>";
      }else{
            if ($stmt2->rowCount()>0) {
           echo "<td><font color='green'>Updated</font></td>";
          }else{

            ?>
            <form action="" method="POST">
              <input type="hidden" name="tc" value="<?=$tc ?>">
            <input type="hidden" name="tname" value="<?=$tname ?>">
            <input type="hidden" name="tdate" value="<?=$tdate ?>">
              <td><input type="submit" name="uqp" value="Upload Question paper and Testcases"></td>
            </form>
            <?php 
            
          }
      }

      ?>
      <td><?=$t['status'] ?></td>
    </tr>
      <?php

    }

    ?>
      </table>
    <?php 

}

?>




<?php 
  if (isset($_POST['utc'])) {
    $tc=$_POST['tc'];

    $sql="SELECT * from tests where tc='$tc'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $t = $stmt->fetch(PDO::FETCH_ASSOC);
    $tname=$t['tname'];
    $noc=$t['noc'];
    $total_marks=$t['total_marks'];

    ?>
     <br><br> <center><font color="Brown">Update Testcase Details</font><br>
      <font color="Blue">Test/Assignment Code: </font><?=$tc ?>, <font color="Blue">Test/Assignment Name: </font><?=$tname ?>, <font color="Blue">Total Marks: </font><?=$total_marks ?>, <font color="Blue"># of Question: </font><?=$noc ?></center>
      <form action="" method="POST" >
      <table align="center" border="1">
        <tr>
          <td>Question No</td>
          <td>Number of Testcases</td>
          <td>Test case weightage<br> in % in order <br>TC1%-TC2%-...-TCN%<br></td>
          <td>Total Marks for the Question</td>
        </tr>
        
    <?php

    for ($i=1; $i <=$noc ; $i++) { 
      $qn=$i;
      ?>
      <tr>
      <td><?=$i ?></td><input type="hidden" name="qn_<?=$i ?>" value="<?=$i ?>" >
      <td><input type="text" name="notc_<?=$i ?>" required='true' minlength="1" maxlength="3" onkeypress="return isNumberKey(event)" ></td>
      <td><input type="text" name="tcw_<?=$i ?>" required='true' minlength="1" maxlength="100" placeholder="xx-xx-xx" pattern="[0-9]+(-[0-9]+)*"></td>
      <td><input type="text" name="marks_<?=$i ?>" required='true' minlength="1" maxlength="3"  onkeypress="return isNumberKey(event)" ></td>
    </tr>
      <?php
    }

    ?>
     <td align="center" colspan="4"><input type="submit" name="utcd" value="Update Testcase Details"></td>
     <input type="hidden" name="noc" value="<?=$noc ?>">
     <input type="hidden" name="tc" value="<?=$tc ?>">
     <input type="hidden" name="tname" value="<?=$tname ?>">
     <input type="hidden" name="total_marks" value="<?=$total_marks ?>">

   </table></form>
      <?php
  }


?>





<?php 
  if (isset($_POST['utcd'])) {
    $tc=$_POST['tc'];

    $tname=$_POST['tname'];
    $noc=$_POST['noc'];
    $total_marks=$_POST['total_marks'];

    
     //check number of % provided
    $err=0;
    for ($i=1; $i <=$noc ; $i++) { 
      
        $notc=$_POST['notc_'.$i];
        $tcw=explode("-",$_POST['tcw_'.$i]);

        if(count($tcw)!=$notc){
          $err=1;
          ?>
            <center><font color="red" size="5"> No of Tesecase for Question - <?=$i ?> is <?=$notc ?><br>
                    Percentage provided (including blank) for <?=count($tcw) ?> Testcase(s)<br><br>
                    
          <?php
        }
    }

    if($err==1){
      ?>
      Please go back and retry with proper value</font></center>
      <?php
      require_once("./includes/footer.php"); 
      die;
    }


    $err=0;
    for ($i=1; $i <=$noc ; $i++) { 
        
        $tcw=explode("-",$_POST['tcw_'.$i]);
        
        $tcwp=0;
        for ($j=0; $j < count($tcw); $j++) { 
          
          $tcwp=$tcwp + intval($tcw[$j]);
          $tcw[$j];
        }

        if($tcwp!=100){
          $err=1;
          ?>
            <br><center><font color="red" size="5"> Sum of Weightage Percentages for  Question - <?=$i ?> is <?=$tcwp ?><br>
                    Sum of Percentage Weightage Percentages must be 100<br><br>
                    
          <?php
        }
    }


    if($err==1){
      ?>
      Please go back and retry with proper value</font></center>
      <?php
      require_once("./includes/footer.php"); 
      die;
    }






    ?>
     <br><br> <center><font color="Brown">Confirm Testcase Details</font><br>
      <font color="Blue">Test/Assignment Code: </font><?=$tc ?>, <font color="Blue">Test/Assignment Name: </font><?=$tname ?>, <font color="Blue">Total Marks: </font><?=$total_marks ?>, <font color="Blue"># of Question: </font><?=$noc ?></center>
      <form action="" method="POST" >
      <table align="center" border="1">
        <tr>
          <td>Question No</td>
          <td>Number of Testcases</td>
          <td>Test case weightage<br> in % in order <br>TC1%-TC2%-...-TCN%<br></td>
          <td>Total Marks for the Question</td>
        </tr>
        
    <?php

   










    $tm=0;
    for ($i=1; $i <=$noc ; $i++) { 
      $qn=$_POST['qn_'.$i];
      $notc=$_POST['notc_'.$i];
      $tcw=$_POST['tcw_'.$i];
      $marks=$_POST['marks_'.$i];

      $tm=$tm + $marks;
      ?>
      <tr align="center">
      <td><?=$i ?></td><input type="hidden" name="qn_<?=$i ?>" value="<?=$i ?>" >
      <td><?=$notc ?><input type="hidden" name="notc_<?=$i ?>" required value="<?=$notc ?>" ></td>
      <td><?=$tcw ?><input type="hidden" name="tcw_<?=$i ?>" required value="<?=$tcw ?>" ></td>
      <td><?=$marks ?><input type="hidden" name="marks_<?=$i ?>" required value="<?=$marks ?>" ></td>
    </tr>
      <?php
    }

    if ($tm != $total_marks) {
      ?>
      
         <center><font color="Brown">Total Matks & Marks Breakup Does Not Match. Please Retry with Correct Breakup.</font><br>
         <tr> <td align="center" colspan="3"><input type="submit" name="utc" value="Rectify"></td></tr>
    
     <input type="hidden" name="tc" value="<?=$tc ?>"></table></form>
     </center>
      <?php
      require_once("./includes/footer.php"); 
      die;
    }

    ?>
     <tr><td align="center" colspan="4"><input type="submit" name="cutcd" value="Confirm Testcase Details"></td></tr>
     <input type="hidden" name="noc" value="<?=$noc ?>">
     <input type="hidden" name="tc" value="<?=$tc ?>">
     <input type="hidden" name="tname" value="<?=$tname ?>">

   </table></form>
      <?php
  }


?>



<?php 
  if (isset($_POST['uqp'])) {
    $tc=$_POST['tc'];

    $sql="SELECT * from tests where tc='$tc'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $t = $stmt->fetch(PDO::FETCH_ASSOC);
    $tname=$t['tname'];
    $noc=$t['noc'];
    $total_marks=$t['total_marks'];


    $sql="SELECT * from testcase where tc='$tc'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    //$t = $stmt->fetch(PDO::FETCH_ASSOC);

    ?>
     <br><br> <center><font color="Brown">Upload Question paper and input-output file</font><br>
      <font color="Blue">Test/Assignemnt Code: </font><?=$tc ?>, <font color="Blue">Test/Assignemnt Name: </font><?=$tname ?>, <font color="Blue">Total Marks: </font><?=$total_marks ?>, <font color="Blue"># of Question: </font><?=$noc ?></center>
      <form action="" method="POST" enctype="multipart/form-data">
      <table align="center" border="1">
        <tr>
          <td>Question Paper (.pdf only)</td>
          <td colspan="1"><input type="file" name="qp" accept=".pdf"></td>
        </tr>

        <?php 
            while ($t = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $qn=$t['qn'];
              $notc=$t['notc'];
              for ($i=1; $i <=$notc ; $i++) { 
                $fname=$tc.'-'.$qn.'-'.$i;
                $var='Question-'.$qn.': Test Case-'.$i;
                ?>
                <?php 
                  if ($qn%2==0) {
                    echo '<tr style="background:  #cceeff">';
                  }else{
                    echo '<tr style="background: #fff2e6">';
                  }
                ?>
                  <td><?=$var ?> Input File (.txt only)</td>
                  <td><input type="file" name="input_<?=$fname ?>" accept=".txt" required></td>
                </tr>
                <?php 
                  if ($qn%2==0) {
                    echo '<tr style="background:  #cceeff">';
                  }else{
                    echo '<tr style="background: #fff2e6">';
                  }
                ?>
                  <td><?=$var ?> Desired Output File (.txt only)</td>
                  <td><input type="file" name="output_<?=$fname ?>" accept=".txt" required></td>
                </tr>

                <?php
              }
            }
        ?>
        <input type="hidden" name="tc" value="<?=$tc ?>">
        <tr align="center"><td colspan="2"><input type="submit" name="uqpaio" value="Upload Files"></td></tr>

      </table></form>
        
    <?php
    

}
?>






