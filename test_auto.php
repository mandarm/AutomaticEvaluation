
<?php 

session_start();

if ($_SESSION['user_role']=='Faculty') {
	require_once("./includes/header_faculty.php"); 
}
if ($_SESSION['user_role']=='DB-Admin') {
	require_once("./includes/header_admin.php");
}

if ($_SESSION['user_role']=='Student') {
	require_once("./includes/header_student.php");
}

?>

<?php 
	if ($_SESSION['user_role']=='Student') {
		$test_code=$_SESSION['tc'];
	}else{
		$test_code=$_POST['tc'];
	}

	$tc=$test_code;
	$sql1="SELECT * from tests where tc='$tc'";
    
     $stmt1 = $pdo->prepare($sql1);
     $stmt1->execute();
     $t = $stmt1->fetch(PDO::FETCH_ASSOC);

     $qn=$t['noc'];

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
		</script>




<script src="./js/jquery.min.js"></script>

<?php 
	if (isset($_POST['execute-code'])) {
	$tname=$_POST['tname'];
	$_SESSION['tname']=$tname;
	

?>

<center><strong>Execute Your Source Code <br>Only Execution will not submit your code, it will just dispaley your output and expected output. To submit your code click on SUBMIT THIS CODE button. <br>NOTE: Only last submitted source and results from it will be considered for evaluation. Always Keep a local backup of your previous submission</strong></center>
    
    <table border="1" align="center">
      
        <form action="" method="POST" enctype="multipart/form-data">
        <tr>
        	<td>Test/Assignment Code</td>
        	<td><?=$test_code ?></td>
        </tr>
        <tr>
        	<td>Test/Assignment Name</td>
        	<td><?=$tname ?></td>
        </tr>
        <tr>
        	<td>Question No</td>
        	<td>
        		<select name='qn'>
        		<?php
        			
        			for ($i=1; $i<=$qn ; $i++) {    

        			?>
        				<option value="<?=$i ?>"><?=$i ?></option>
        			<?php 				# code...
        			}
        		?>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td width="170px">Programming Language:  </td>
          <td><select name="proglan">
          	<option value="C">C</option>
          	<option value="C++">C++</option>
          	<!--<option value="JAVA">Java</option>-->
          	<option value="PYTHON">Python</option>
          </select> </td> </tr>
        </tr>
        
        <tr>
          <td width="170px">Choose File:  </td>
          <td><input type="file" name="file"></td> </tr>
        <tr>

        <tr>
          <td colspan="2" align="center">
            <input type="submit" name="src_file" style="background: orange" value="Submit">
          </td>
        </tr>

        </form>
       
    </table>

    <br><br>


<?php 

}
?>


<!--*******************************************************C-Start*******************************************************-->

<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='C')
{
	$marks_obtained=0;
	$student_name=$_SESSION['user_name'];
	$stud_roll_no=$_SESSION['roll_no'];
	$qn=$_POST['qn'];
	$stc=0; $tname='';
	$sql="SELECT * from testcase where tc='$test_code' and qn='$qn'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$ntc=$t['notc'];
		$tname=$t['tname'];
		$tm=$t['marks'];
		$evalpt=$t['evalpt'];
		$qm=$t['marks'];


	$sql="SELECT * from T".$test_code." where student_roll='$stud_roll_no'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$p = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($p['prog_lang']=='X' or $_POST['proglan']==$p['prog_lang']) {
		//
	}else{
		?>
			<center><font color="red" size="4">For Previous submission you have chosen <?= $p['prog_lang'] ?> and <br>for current execution you have chosen <?=$_POST['proglan'] ?><br>
			Different Language for different questions are not allowed. Use the programming langrage chosen earlier to submit all answers.</font></center>
		<?php
		require_once("./includes/footer.php");
		die;
	}

	
	?>
<div id='print_reg_card'>
	<script type="text/javascript" src="./js/downloadFile.js"></script>
		<script language="javascript">
		    function printPage(id) {
		    var html="<html>";
		    html+= document.getElementById(id).innerHTML;
		    html+="</html>";
		    var printWin = window.open('','','left=0,top=0,width=60,height=100,toolbar=0,scrollbars=0,status =0');
		    printWin.document.write(html);
		    printWin.document.close();
		    printWin.focus();
		    printWin.print();
		    printWin.close();
		}
		</script>
	<table width="766px" align="center">
			<tr><td>

<center><font size="5" color="black">Test/Assignment Code: <font size="5" color="blue"><?=$test_code ?></font>, Test/Assignment Name.: <font size="5" color="blue"><?=$_SESSION['tname'] ?></font></font></center>	
<center><font size="5" color="black">Student Name: <font size="5" color="blue"><?=$student_name ?></font>, Roll No.: <font size="5" color="blue"><?=$stud_roll_no ?></font></font></center>
<center><font size="5" color="black">Question No: <font size="5" color="blue"><?=$qn ?></font></font></center>
<table align="center" border="1">
	<?php

	$file = $_FILES["file"]["tmp_name"];
	$file_basename =basename($_FILES["file"]["name"]);
	$fileType = strtolower(pathinfo($file_basename,PATHINFO_EXTENSION));
	$base_dir='./tests/'.$test_code.'/temp/';
	$base_dir_sub='./tests/'.$test_code.'/';
	$roll=$_SESSION['roll_no'];
	$obj=$test_code.'-'.$roll.'-'.$qn;



	//Upload the file to test code-temp directory


	$base_name   = $tc.'-'.$roll.'-'.$qn.'.c';
	$target_file = $base_dir . $base_name;
	$new_file_name=$base_dir.'-'.$tc.'-'.$roll.'-'.$qn.date("dmYhis").'.c';

	if (file_exists($target_file)) {
      rename($target_file, $new_file_name);
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{
      	echo " Source Code upload failed";
      }


      
    }else{
    	if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{

      	
      	echo "2. Source Code upload failed";
      }

    }



$ce=0;
$rm_executable_file='rm '.$base_dir.$obj;
shell_exec($rm_executable_file);
$prog='gcc -o '.$base_dir.''.$obj.' '.$base_dir.''.$base_name.' 2>&1';
//$pwd=shell_exec('pwd');
//echo "<pre>$pwd</pre>";
//echo $prog;
echo "<tr><td colspan=2>".$file_basename."<br>";
$compilation_error=shell_exec($prog);
if ($compilation_error=="" or !str_contains($compilation_error, 'error')) {
	echo "<font color='green' size='5'><strong>Compilation Message: Compilation Succesful</strong></font><br></td></tr>";
}else{
	echo "<font color='red' size='5'><strong>Compilation Error/Warnings: ";
	echo nl2br($compilation_error)."</strong></font><br></td></tr>";
	$ce=1;
}

if($ce==0){
	
for ($i=1; $i <=$ntc ; $i++) { 
	$tcwm=0.00;
	$tcwp=intval(explode("-",$evalpt)[$i-1]);
	



$ifile=$base_dir_sub.'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
$output = shell_exec('./tests/'.$tc.'/temp/'.$obj.' '.$ifile.' 2>&1');
  


echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";
echo "<td align='center'>Actual output of the testcase should be:</td></tr>";
echo "<tr><td  width='40%'><pre>$output</pre></td>";

$fout=shell_exec('cat '.$base_dir_sub.'output_'.$tc.'-'.$qn.'-'.$i.'.txt');

echo "<td  width='40%'><pre>$fout</pre></td></tr>";


$x=strcmp(trim(str_replace(' ', '', $output)), trim(str_replace(' ', '', $fout)));

echo "<tr><td colspan=2 align='center'>";



if ($x==0) {
	$stc=$stc+1;
	$tcwm=$qm * $tcwp / 100;
	$marks_obtained=$marks_obtained+$tcwm;
	echo "<font color='green' size=5 ><strong>Testcase-".$i." Passed.<br>Marks: ".$tcwm." [".$tcwp."% of ".$qm."]</strong></font></td></tr>";
	
}else{
	echo "<font color='red' size=5 ><strong>Testcase-".$i." Failed.</strong></font></td></tr>";
}


}


?>
<tr>
	<td colspan="2" align="center"><font color='blue' size=5 ><strong>Testcase Summary [Success/Total]: <?=$stc ?>/<?=$ntc ?><br><?php 
		$marks_obtained= ceil($marks_obtained);

		if ($marks_obtained>$tm) {
			$marks_obtained=$tm;
		}

		echo "Total Marks Obtained: ". $marks_obtained . " / ".$tm;


	?></strong></font></td>
</tr>



<?php  

}

?>
<tr>
	<td colspan="2" align="center">
		<form action="" method="POST">
		<input type="hidden" name="qn" value="<?=$qn ?>">
		<input type="hidden" name="stc" value="<?=$stc ?>">
		<input type="hidden" name="ntc" value="<?=$ntc ?>">
		<input type="hidden" name="proglan" value="C">
		<input type="hidden" name="mo" value="<?=$marks_obtained ?> ">
		<input type="submit" name="submit-code" value="Submit This Code">
		</form>
	</td>
</tr>


</table>
</div>
		
<br><br><br>
<?php 

}
  
?>



<?php 
	if (isset($_POST['submit-code']) && $_POST['proglan']=='C') {
		$proglan=$_POST['proglan'];
		$qn=$_POST['qn'];
		$mo=$_POST['mo'];

		$student_name=$_SESSION['user_name'];
		$stud_roll_no=$_SESSION['roll_no'];

		$base_dir='./tests/'.$test_code.'/temp/';
		$base_dir_sub='./tests/'.$test_code.'/';
		$base_name   = $tc.'-'.$stud_roll_no.'-'.$qn.'.c';
		$obj   = $tc.'-'.$stud_roll_no.'-'.$qn;
		$from_dir= $base_dir . $base_name;
		$to_dir = $base_dir_sub . $base_name;
		$from_obj= $base_dir . $obj;
		$to_obj = $base_dir_sub . $obj;

		


		copy($from_dir, $to_dir);
		copy($from_obj, $to_obj);

		
		$sql="Update T".$test_code." set Q".$qn."_marks=".$mo.", prog_lang='".$proglan."' where student_roll='".$stud_roll_no."'";
		
		$stmt = $pdo->prepare($sql);
      	$stmt->execute();


      	?>
<center><font color="green" size="5"><strong>Code submitted successfully for Question No: - <?=$qn ?><br><font color="blue" size="5">Go to home to submit code of another question</font></strong></font></center>
      	<?php



	}


?>
<!--*******************************************************C-End*******************************************************-->






<!--*******************************************************C++-Start*******************************************************-->

<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='C++')
{
	$marks_obtained=0;
	$student_name=$_SESSION['user_name'];
	$stud_roll_no=$_SESSION['roll_no'];
	$qn=$_POST['qn'];
	$stc=0; $tname='';
	$sql="SELECT * from testcase where tc='$test_code' and qn='$qn'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$ntc=$t['notc'];
		$tname=$t['tname'];
		$tm=$t['marks'];
		$evalpt=$t['evalpt'];
		$qm=$t['marks'];


	$sql="SELECT * from T".$test_code." where student_roll='$stud_roll_no'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$p = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($p['prog_lang']=='X' or $_POST['proglan']==$p['prog_lang']) {
		//
	}else{
		?>
			<center><font color="red" size="4">For Previous submission you have chosen <?= $p['prog_lang'] ?> and <br>for current execution you have chosen <?=$_POST['proglan'] ?><br>
			Different Language for different questions are not allowed. Use the programming langrage chosen earlier to submit all answers.</font></center>
		<?php
		require_once("./includes/footer.php");
		die;
	}

	
	?>
<div id='print_reg_card'>
	<script type="text/javascript" src="./js/downloadFile.js"></script>
		<script language="javascript">
		    function printPage(id) {
		    var html="<html>";
		    html+= document.getElementById(id).innerHTML;
		    html+="</html>";
		    var printWin = window.open('','','left=0,top=0,width=60,height=100,toolbar=0,scrollbars=0,status =0');
		    printWin.document.write(html);
		    printWin.document.close();
		    printWin.focus();
		    printWin.print();
		    printWin.close();
		}
		</script>
	<table width="766px" align="center">
			<tr><td>

<center><font size="5" color="black">Test/Assignment Code: <font size="5" color="blue"><?=$test_code ?></font>, Test/Assignment Name.: <font size="5" color="blue"><?=$_SESSION['tname'] ?></font></font></center>	
<center><font size="5" color="black">Student Name: <font size="5" color="blue"><?=$student_name ?></font>, Roll No.: <font size="5" color="blue"><?=$stud_roll_no ?></font></font></center>
<center><font size="5" color="black">Question No: <font size="5" color="blue"><?=$qn ?></font></font></center>
<table align="center" border="1">
	<?php

	$file = $_FILES["file"]["tmp_name"];
	$file_basename =basename($_FILES["file"]["name"]);
	$fileType = strtolower(pathinfo($file_basename,PATHINFO_EXTENSION));
	$base_dir='./tests/'.$test_code.'/temp/';
	$base_dir_sub='./tests/'.$test_code.'/';
	$roll=$_SESSION['roll_no'];
	$obj=$test_code.'-'.$roll.'-'.$qn;



	//Upload the file to test code-temp directory


	$base_name   = $tc.'-'.$roll.'-'.$qn.'.c++';
	$target_file = $base_dir . $base_name;
	$new_file_name=$base_dir.'-'.$tc.'-'.$roll.'-'.$qn.date("dmYhis").'.c++';

	if (file_exists($target_file)) {
      rename($target_file, $new_file_name);
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{
      	echo " Source Code upload failed";
      }


      
    }else{
    	if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{

      	
      	echo "2. Source Code upload failed";
      }

    }

	


	
$ce=0;
$rm_executable_file='rm '.$base_dir.$obj;
shell_exec($rm_executable_file);
$prog='g++ -o '.$base_dir.''.$obj.' '.$base_dir.''.$base_name.' 2>&1';

echo "<tr><td colspan=2>".$file_basename."<br>";
$compilation_error=shell_exec($prog);
if ($compilation_error=="" or !str_contains($compilation_error, 'error')) {
	echo "<font color='green' size='5'><strong>Compilation Message: Compilation Succesful</strong></font><br></td></tr>";
}else{
	echo "<font color='red' size='5'><strong>Compilation Error/Warnings: ";
	echo nl2br($compilation_error)."</strong></font><br></td></tr>";
	$ce=1;
}


if($ce==0){
for ($i=1; $i <=$ntc ; $i++) { 
	$tcwm=0.00;
	$tcwp=intval(explode("-",$evalpt)[$i-1]);

$ifile=$base_dir_sub.'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
$output = shell_exec('./tests/'.$tc.'/temp/'.$obj.' '.$ifile.' 2>&1');
  




echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";
echo "<td align='center'>Actual output of the testcase should be:</td></tr>";
echo "<tr><td  width='40%'><pre>$output</pre></td>";

$fout=shell_exec('cat '.$base_dir_sub.'output_'.$tc.'-'.$qn.'-'.$i.'.txt');

echo "<td  width='40%'><pre>$fout</pre></td></tr>";

$x=strcmp(trim(str_replace(' ', '', $output)), trim(str_replace(' ', '', $fout)));

echo "<tr><td colspan=2 align='center'>";



if ($x==0) {
	$stc=$stc+1;
	$tcwm=$qm * $tcwp / 100;
	$marks_obtained=$marks_obtained+$tcwm;
	echo "<font color='green' size=5 ><strong>Testcase-".$i." Passed.<br>Marks: ".$tcwm." [".$tcwp."% of ".$qm."]</strong></font></td></tr>";
}else{
	echo "<font color='red' size=5 ><strong>Testcase-".$i." Failed.</strong></font></td></tr>";
}


}


?>
<tr>
	<td colspan="2" align="center"><font color='blue' size=5 ><strong>Testcase Summary [Success/Total]: <?=$stc ?>/<?=$ntc ?><br><?php 
		$marks_obtained= ceil($marks_obtained);
		if ($marks_obtained>$tm) {
			$marks_obtained=$tm;
		}
		echo "Total Marks Obtained: ". $marks_obtained . " / ".$tm;


	?></strong></font></td>
</tr>

<?php  

}

?>
<tr>
	<td colspan="2" align="center">
		<form action="" method="POST">
		<input type="hidden" name="qn" value="<?=$qn ?>">
		<input type="hidden" name="stc" value="<?=$stc ?>">
		<input type="hidden" name="ntc" value="<?=$ntc ?>">
		<input type="hidden" name="proglan" value="C++">
		<input type="hidden" name="mo" value="<?=$marks_obtained ?> ">
		<input type="submit" name="submit-code" value="Submit This Code">
		</form>
	</td>
</tr>


</table>
</div>
		
<br><br><br>
<?php 

}
  
?>



<?php 
	if (isset($_POST['submit-code']) && $_POST['proglan']=='C++') {
		$proglan=$_POST['proglan'];
		$qn=$_POST['qn'];
		$mo=$_POST['mo'];

		$student_name=$_SESSION['user_name'];
		$stud_roll_no=$_SESSION['roll_no'];

		$base_dir='./tests/'.$test_code.'/temp/';
		$base_dir_sub='./tests/'.$test_code.'/';
		$base_name   = $tc.'-'.$stud_roll_no.'-'.$qn.'.c++';
		$obj   = $tc.'-'.$stud_roll_no.'-'.$qn;
		$from_dir= $base_dir . $base_name;
		$to_dir = $base_dir_sub . $base_name;
		$from_obj= $base_dir . $obj;
		$to_obj = $base_dir_sub . $obj;

		


		copy($from_dir, $to_dir);
		copy($from_obj, $to_obj);

		
		$sql="Update T".$test_code." set Q".$qn."_marks=".$mo.", prog_lang='".$proglan."' where student_roll='".$stud_roll_no."'";
		
		$stmt = $pdo->prepare($sql);
      	$stmt->execute();


      	?>
<center><font color="green" size="5"><strong>Code submitted successfully for Question No: - <?=$qn ?><br><font color="blue" size="5">Go to home to submit code of another question</font></strong></font></center>
      	<?php



	}


?>
<!--*******************************************************C++-End*******************************************************-->



<!--*******************************************************JAVA-Start*******************************************************-->

<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='JAVA')
{
	$marks_obtained=0;
	$student_name=$_SESSION['user_name'];
	$stud_roll_no=$_SESSION['roll_no'];
	$qn=$_POST['qn'];
	$stc=0; $tname='';
	$sql="SELECT * from testcase where tc='$test_code' and qn='$qn'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$ntc=$t['notc'];
		$tname=$t['tname'];
		$tm=$t['marks'];
		$evalpt=$t['evalpt'];
		$qm=$t['marks'];


	$sql="SELECT * from T".$test_code." where student_roll='$stud_roll_no'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$p = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($p['prog_lang']=='X' or $_POST['proglan']==$p['prog_lang']) {
		//
	}else{
		?>
			<center><font color="red" size="4">For Previous submission you have chosen <?= $p['prog_lang'] ?> and <br>for current execution you have chosen <?=$_POST['proglan'] ?><br>
			Different Language for different questions are not allowed. Use the programming langrage chosen earlier to submit all answers.</font></center>
		<?php
		require_once("./includes/footer.php");
		die;
	}

	
	?>
<div id='print_reg_card'>
	<script type="text/javascript" src="./js/downloadFile.js"></script>
		<script language="javascript">
		    function printPage(id) {
		    var html="<html>";
		    html+= document.getElementById(id).innerHTML;
		    html+="</html>";
		    var printWin = window.open('','','left=0,top=0,width=60,height=100,toolbar=0,scrollbars=0,status =0');
		    printWin.document.write(html);
		    printWin.document.close();
		    printWin.focus();
		    printWin.print();
		    printWin.close();
		}
		</script>
	<table width="766px" align="center">
			<tr><td>

<center><font size="5" color="black">Test/Assignment Code: <font size="5" color="blue"><?=$test_code ?></font>, Test/Assignment Name.: <font size="5" color="blue"><?=$_SESSION['tname'] ?></font></font></center>	
<center><font size="5" color="black">Student Name: <font size="5" color="blue"><?=$student_name ?></font>, Roll No.: <font size="5" color="blue"><?=$stud_roll_no ?></font></font></center>
<center><font size="5" color="black">Question No: <font size="5" color="blue"><?=$qn ?></font></font></center>
<table align="center" border="1">
	<?php

	$file = $_FILES["file"]["tmp_name"];
	$file_basename =basename($_FILES["file"]["name"]);
	$fileType = strtolower(pathinfo($file_basename,PATHINFO_EXTENSION));
	$base_dir='/opt/lampp/htdocs/testautomation/tests/'.$test_code.'/temp/';
	$base_dir_sub='./tests/'.$test_code.'/';
	$roll=$_SESSION['roll_no'];
	$obj=str_replace('-', '', $roll).'_'.$tc.'_'.$qn;


	$base_name   = str_replace('-', '', $roll).'_'.$tc.'_'.$qn.'.java';
	$target_file = $base_dir . $base_name;
	$new_file_name=$base_dir.'_'.str_replace('-', '', $roll).'_'.$tc.'_'.$qn.date("dmYhis").'.java';

	if (file_exists($target_file)) {
      rename($target_file, $new_file_name);
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{
      	echo " Source Code upload failed";
      }


      
    }else{
    	if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{

      	
      	echo "2. Source Code upload failed";
      }

    }


$ce=0;	
echo '<br>javac  '.$base_dir.''.$base_name,"<br>";
$rm_executable_file='rm '.$base_dir.$obj;
shell_exec($rm_executable_file);
$prog='javac  '.$base_dir.''.$base_name;

echo "<tr><td colspan=2>".$file_basename."<br>";
$compilation_error=shell_exec($prog);
if ($compilation_error=="" or !str_contains($compilation_error, 'error')) {
	echo "<font color='green' size='5'><strong>Compilation Message: Compilation Succesful</strong></font><br></td></tr>";
}else{
	echo "<font color='red' size='5'><strong>Compilation Error/Warnings: ";
	echo nl2br($compilation_error)."</strong></font><br></td></tr>";
	$ce=1;
}


if($ce==0){
for ($i=1; $i <=$ntc ; $i++) { 
	$tcwm=0.00;
	$tcwp=intval(explode("-",$evalpt)[$i-1]);

$ifile=$base_dir_sub.'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
$output = shell_exec('java /opt/lampp/htdocs/testautomation/tests/'.$tc.'/temp/'.$obj.' '.$ifile.' 2>&1');
  


echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";
echo "<td align='center'>Actual output of the testcase should be:</td></tr>";
echo "<tr><td  width='40%'><pre>$output</pre></td>";

$fout=shell_exec('cat '.$base_dir_sub.'output_'.$tc.'-'.$qn.'-'.$i.'.txt');

echo "<td  width='40%'><pre>$fout</pre></td></tr>";

$x=strcmp(trim(str_replace(' ', '', $output)), trim(str_replace(' ', '', $fout)));

echo "<tr><td colspan=2 align='center'>";



if ($x==0) {
	$stc=$stc+1;
	$tcwm=$qm * $tcwp / 100;
	$marks_obtained=$marks_obtained+$tcwm;
	echo "<font color='green' size=5 ><strong>Testcase-".$i." Passed.<br>Marks: ".$tcwm." [".$tcwp."% of ".$qm."]</strong></font></td></tr>";
}else{
	echo "<font color='red' size=5 ><strong>Testcase-".$i." Failed.</strong></font></td></tr>";
}


}


?>
<tr>
	<td colspan="2" align="center"><font color='blue' size=5 ><strong>Testcase Summary [Success/Total]: <?=$stc ?>/<?=$ntc ?><br><?php 
		$marks_obtained= ceil($marks_obtained);
		if ($marks_obtained>$tm) {
			$marks_obtained=$tm;
		}
		echo "Total Marks Obtained: ". $marks_obtained . " / ".$tm;


	?></strong></font></td>
</tr>

<?php  

}


?>
<tr>
	<td colspan="2" align="center">
		<form action="" method="POST">
		<input type="hidden" name="qn" value="<?=$qn ?>">
		<input type="hidden" name="stc" value="<?=$stc ?>">
		<input type="hidden" name="ntc" value="<?=$ntc ?>">
		<input type="hidden" name="proglan" value="JAVA">
		<input type="hidden" name="mo" value="<?=$marks_obtained ?> ">
		<input type="submit" name="submit-code" value="Submit This Code">
		</form>
	</td>
</tr>


</table>
</div>
		
<br><br><br>
<?php 

}
  
?>



<?php 
	if (isset($_POST['submit-code']) && $_POST['proglan']=='JAVA') {
		$proglan=$_POST['proglan'];
		$qn=$_POST['qn'];
		$mo=$_POST['mo'];

		$student_name=$_SESSION['user_name'];
		$stud_roll_no=$_SESSION['roll_no'];

		$base_dir='./tests/'.$test_code.'/temp/';
		$base_dir_sub='./tests/'.$test_code.'/';
		$base_name   = $tc.'-'.$stud_roll_no.'-'.$qn.'.java';
		$obj   = $tc.'-'.$stud_roll_no.'-'.$qn;
		$from_dir= $base_dir . $base_name;
		$to_dir = $base_dir_sub . $base_name;
		$from_obj= $base_dir . $obj;
		$to_obj = $base_dir_sub . $obj;

		


		copy($from_dir, $to_dir);
		copy($from_obj, $to_obj);

		
		$sql="Update T".$test_code." set Q".$qn."_marks=".$mo.", prog_lang='".$proglan."' where student_roll='".$stud_roll_no."'";
		
		$stmt = $pdo->prepare($sql);
      	$stmt->execute();


      	?>
<center><font color="green" size="5"><strong>Code submitted successfully for Question No: - <?=$qn ?><br><font color="blue" size="5">Go to home to submit code of another question</font></strong></font></center>
      	<?php



	}


?>
<!--*******************************************************JAVA-End*******************************************************-->



<!--*******************************************************Python-Start*******************************************************-->

<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='PYTHON')
{
	$marks_obtained=0;
	$student_name=$_SESSION['user_name'];
	$stud_roll_no=$_SESSION['roll_no'];
	$qn=$_POST['qn'];
	$stc=0; $tname='';
	$sql="SELECT * from testcase where tc='$test_code' and qn='$qn'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$ntc=$t['notc'];
		$tname=$t['tname'];
		$tm=$t['marks'];
		$evalpt=$t['evalpt'];
		$qm=$t['marks'];


	$sql="SELECT * from T".$test_code." where student_roll='$stud_roll_no'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$p = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($p['prog_lang']=='X' or $_POST['proglan']==$p['prog_lang']) {
		//
	}else{
		?>
			<center><font color="red" size="4">For Previous submission you have chosen <?= $p['prog_lang'] ?> and <br>for current execution you have chosen <?=$_POST['proglan'] ?><br>
			Different Language for different questions are not allowed. Use the programming langrage chosen earlier to submit all answers.</font></center>
		<?php
		require_once("./includes/footer.php");
		die;
	}

	
	?>
<div id='print_reg_card'>
	<script type="text/javascript" src="./js/downloadFile.js"></script>
		<script language="javascript">
		    function printPage(id) {
		    var html="<html>";
		    html+= document.getElementById(id).innerHTML;
		    html+="</html>";
		    var printWin = window.open('','','left=0,top=0,width=60,height=100,toolbar=0,scrollbars=0,status =0');
		    printWin.document.write(html);
		    printWin.document.close();
		    printWin.focus();
		    printWin.print();
		    printWin.close();
		}
		</script>
	<table width="766px" align="center">
			<tr><td>

<center><font size="5" color="black">Test/Assignment Code: <font size="5" color="blue"><?=$test_code ?></font>, Test/Assignment Name.: <font size="5" color="blue"><?=$_SESSION['tname'] ?></font></font></center>	
<center><font size="5" color="black">Student Name: <font size="5" color="blue"><?=$student_name ?></font>, Roll No.: <font size="5" color="blue"><?=$stud_roll_no ?></font></font></center>
<center><font size="5" color="black">Question No: <font size="5" color="blue"><?=$qn ?></font></font></center>
<table align="center" border="1">
	<?php

	$file = $_FILES["file"]["tmp_name"];
	$file_basename =basename($_FILES["file"]["name"]);
	$fileType = strtolower(pathinfo($file_basename,PATHINFO_EXTENSION));
	$base_dir='./tests/'.$test_code.'/temp/';
	$base_dir_sub='./tests/'.$test_code.'/';
	$roll=$_SESSION['roll_no'];
	$obj=$test_code.'-'.$roll.'-'.$qn;



	//Upload the file to test code-temp directory


	$base_name   = $tc.'-'.$roll.'-'.$qn.'.py';
	$target_file = $base_dir . $base_name;
	$new_file_name=$base_dir.'-'.$tc.'-'.$roll.'-'.$qn.date("dmYhis").'.py';

	if (file_exists($target_file)) {
      rename($target_file, $new_file_name);
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{
      	echo " Source Code upload failed";
      }


      
    }else{
    	if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
      	
      }else{

      	
      	echo "2. Source Code upload failed";
      }

    }

	


for ($i=1; $i <=$ntc ; $i++) { 
	$tcwm=0.00;
	$tcwp=intval(explode("-",$evalpt)[$i-1]);

$ifile=$base_dir_sub.'input_'.$tc.'-'.$qn.'-'.$i.'.txt';


$output = shell_exec('python3 /opt/lampp/htdocs/testautomation/tests/'.$tc.'/temp/'.$base_name.' '.$ifile.' 2>&1');




echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";
echo "<td align='center'>Actual output of the testcase should be:</td></tr>";
echo "<tr><td  width='40%'><pre>$output</pre></td>";

$fout=shell_exec('cat '.$base_dir_sub.'output_'.$tc.'-'.$qn.'-'.$i.'.txt');

echo "<td  width='40%'><pre>$fout</pre></td></tr>";

$x=strcmp(trim(str_replace(' ', '', $output)), trim(str_replace(' ', '', $fout)));

echo "<tr><td colspan=2 align='center'>";



if ($x==0) {
	$stc=$stc+1;
	$tcwm=$qm * $tcwp / 100;
	$marks_obtained=$marks_obtained+$tcwm;
	echo "<font color='green' size=5 ><strong>Testcase-".$i." Passed.<br>Marks: ".$tcwm." [".$tcwp."% of ".$qm."]</strong></font></td></tr>";
}else{
	echo "<font color='red' size=5 ><strong>Testcase-".$i." Failed.</strong></font></td></tr>";
}


}


?>
<tr>
	<td colspan="2" align="center"><font color='blue' size=5 ><strong>Testcase Summary [Success/Total]: <?=$stc ?>/<?=$ntc ?><br><?php 
		$marks_obtained= ceil($marks_obtained);
		if ($marks_obtained>$tm) {
			$marks_obtained=$tm;
		}
		echo "Total Marks Obtained: ". $marks_obtained . " / ".$tm;


	?></strong></font></td>
</tr>

<?php  


?>
<tr>
	<td colspan="2" align="center">
		<form action="" method="POST">
		<input type="hidden" name="qn" value="<?=$qn ?>">
		<input type="hidden" name="stc" value="<?=$stc ?>">
		<input type="hidden" name="ntc" value="<?=$ntc ?>">
		<input type="hidden" name="proglan" value="PYTHON">
		<input type="hidden" name="mo" value="<?=$marks_obtained ?> ">
		<input type="submit" name="submit-code" value="Submit This Code">
		</form>
	</td>
</tr>


</table>
</div>
		
<br><br><br>
<?php 

}
  
?>



<?php 
	if (isset($_POST['submit-code']) && $_POST['proglan']=='PYTHON') {
		$proglan=$_POST['proglan'];
		$qn=$_POST['qn'];
		$mo=$_POST['mo'];

		$student_name=$_SESSION['user_name'];
		$stud_roll_no=$_SESSION['roll_no'];

		$base_dir='./tests/'.$test_code.'/temp/';
		$base_dir_sub='./tests/'.$test_code.'/';
		$base_name   = $tc.'-'.$stud_roll_no.'-'.$qn.'.py';
		$obj   = $tc.'-'.$stud_roll_no.'-'.$qn;
		$from_dir= $base_dir . $base_name;
		$to_dir = $base_dir_sub . $base_name;
		$from_obj= $base_dir . $obj;
		$to_obj = $base_dir_sub . $obj;

		


		copy($from_dir, $to_dir);
		

		
		$sql="Update T".$test_code." set Q".$qn."_marks=".$mo.", prog_lang='".$proglan."' where student_roll='".$stud_roll_no."'";
		//echo $sql;
		$stmt = $pdo->prepare($sql);
      	$stmt->execute();


      	?>
<center><font color="green" size="5"><strong>Code submitted successfully for Question No: - <?=$qn ?><br><font color="blue" size="5">Go to home to submit code of another question</font></strong></font></center>
      	<?php



	}


?>
<!--*******************************************************PYTHON-End*******************************************************-->
