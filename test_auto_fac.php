
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

	$test_code=$_POST['tc'];
	$tname=$_POST['tname'];
	$qn=$_POST['qn'];
	$tc=$test_code;



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


<!--*******************************************************C-Start*******************************************************-->
<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='C')
{
	$marks_obtained=0;
	$student_name=$_POST['student_name'];
	$stud_roll_no=$_POST['student_roll'];
	$qn=$_POST['qn'];
	$stc=0; 
	$sql="SELECT * from testcase where tc='$test_code' and qn='$qn'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$ntc=$t['notc'];
		
		$tm=$t['marks'];
		$evalpt=$t['evalpt'];
		$qm=$t['marks'];
	
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

<center><font size="5" color="black">Test/Assignment Code: <font size="5" color="blue"><?=$test_code ?></font>, Test/Assignment Name.: <font size="5" color="blue"><?=$tname ?></font></font></center>	
<center><font size="5" color="black">Student Name: <font size="5" color="blue"><?=$student_name ?></font>, Roll No.: <font size="5" color="blue"><?=$stud_roll_no ?></font></font></center>
<center><font size="5" color="black">Question No: <font size="5" color="blue"><?=$qn ?></font></font></center>
<table align="center" border="1">
	<?php

	
	$base_dir_sub='./tests/'.$test_code.'/';
	$roll=$_POST['student_roll'];
	$obj=$test_code.'-'.$roll.'-'.$qn;
	$sf=$test_code.'-'.$roll.'-'.$qn.'.c';



for ($i=1; $i <=$ntc ; $i++) { 
	$tcwm=0.00;
	$tcwp=intval(explode("-",$evalpt)[$i-1]);

if (file_exists($base_dir_sub.''.$sf)) {
	
		if (file_exists($base_dir_sub.''.$obj)) {
			# code...
		}else{
			echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";

			echo "<td align='center'>Actual output of the testcase should be:</td></tr>";
			echo "<tr><td align='left'><font color='red'>Compilation Error</font><br>";
			$prog='gcc -o '.$base_dir_sub.''.$obj.' '.$base_dir_sub.''.$sf.' 2>&1';
			$compilation_error=shell_exec($prog);
			echo nl2br($compilation_error);
			echo "<br></td>";
			goto skipc;
		}


}else{


	echo "<tr><td align='center'><font color='red' size='6'>Source File Not Submitted</font><br></td>";
	$marks_obtained= ceil($marks_obtained);
	goto skipc2;
}


$ifile=$base_dir_sub.'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
$output = shell_exec('./tests/'.$tc.'/temp/'.$obj.' '.$ifile.' 2>&1');

echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";

echo "<td align='center'>Actual output of the testcase should be:</td></tr>";

echo "<tr><td  width='40%'><pre>$output</pre></td>";
skipc:
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
		echo "Marks Obtained: ". $marks_obtained . " / ".$tm;

	?></strong></font></td>
</tr>

<?php  
skipc2:

?>

</tr>


</table>
</div>

<br><center><strong><font color="red" size="5">Source Code</font></strong></center><br>
<table align="center" border="1">
	<tr>
		<td>
			<?php 

		$orig=file_get_contents( './tests/'.$tc.'/temp/'.$obj.'.c');
		$a = htmlentities($orig);
		echo '<code>';
		echo '<pre>';

		echo $a;

		echo '</pre>';
		echo '</code>';
?>
		</td>
	</tr>
	
</table>

<?php 

}
  
?>


<!--*******************************************************C-End*******************************************************-->





<!--*******************************************************C++ Start*******************************************************-->

<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='C++')
{
	$marks_obtained=0;
	$student_name=$_POST['student_name'];
	$stud_roll_no=$_POST['student_roll'];
	$qn=$_POST['qn'];
	$stc=0; 
	$sql="SELECT * from testcase where tc='$test_code' and qn='$qn'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$ntc=$t['notc'];
		
		$tm=$t['marks'];
		$evalpt=$t['evalpt'];
		$qm=$t['marks'];
	
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

<center><font size="5" color="black">Test/Assignment Code: <font size="5" color="blue"><?=$test_code ?></font>, Test/Assignment Name.: <font size="5" color="blue"><?=$tname ?></font></font></center>	
<center><font size="5" color="black">Student Name: <font size="5" color="blue"><?=$student_name ?></font>, Roll No.: <font size="5" color="blue"><?=$stud_roll_no ?></font></font></center>
<center><font size="5" color="black">Question No: <font size="5" color="blue"><?=$qn ?></font></font></center>
<table align="center" border="1">
	<?php

	
	$base_dir_sub='./tests/'.$test_code.'/';
	$roll=$_POST['student_roll'];
	$obj=$test_code.'-'.$roll.'-'.$qn;
	$sf=$test_code.'-'.$roll.'-'.$qn.'.c++';



for ($i=1; $i <=$ntc ; $i++) { 
	$tcwm=0.00;
	$tcwp=intval(explode("-",$evalpt)[$i-1]);

if (file_exists($base_dir_sub.''.$sf)) {
	
		if (file_exists($base_dir_sub.''.$obj)) {
			# code...
		}else{
			echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";

			echo "<td align='center'>Actual output of the testcase should be:</td></tr>";
			echo "<tr><td align='left'><font color='red'>Compilation Error</font><br>";
			$prog='gcc -o '.$base_dir_sub.''.$obj.' '.$base_dir_sub.''.$sf.' 2>&1';
			$compilation_error=shell_exec($prog);
			echo nl2br($compilation_error);
			echo "<br></td>";
			goto skipcpp;
		}


}else{



	
	echo "<tr><td align='center'><font color='red' size='6'>Source File Not Submitted</font><br></td>";
	$marks_obtained= ceil($marks_obtained);
	goto skipcpp2;
}


$ifile=$base_dir_sub.'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
$output = shell_exec('./tests/'.$tc.'/temp/'.$obj.' '.$ifile.' 2>&1');

echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";
echo "<td align='center'>Actual output of the testcase should be:</td></tr>";
echo "<tr><td  width='40%'><pre>$output</pre></td>";
skipcpp:
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
		echo "Marks Obtained: ". $marks_obtained . " / ".$tm;

	?></strong></font></td>
</tr>

<?php  
skipcpp2:

?>

</table>
</div>
	<br><center><strong><font color="red" size="5">Source Code</font></strong></center><br>
<table align="center" border="1">
	<tr>
		<td>
			<?php 

		$orig=file_get_contents( './tests/'.$tc.'/temp/'.$obj.'.c++');
		$a = htmlentities($orig);
		echo '<code>';
		echo '<pre>';

		echo $a;

		echo '</pre>';
		echo '</code>';
?>
		</td>
	</tr>
	
</table>	

<?php 

}
  
?>


<!--*******************************************************C++ End*******************************************************-->





<!--*******************************************************PYTHON-Start*******************************************************-->

<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='PYTHON')
{
	$marks_obtained=0;
	$student_name=$_POST['student_name'];
	$stud_roll_no=$_POST['student_roll'];
	$qn=$_POST['qn'];
	$stc=0; 
	$sql="SELECT * from testcase where tc='$test_code' and qn='$qn'";
		
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

		$t = $stmt->fetch(PDO::FETCH_ASSOC);
		$ntc=$t['notc'];
		
		$tm=$t['marks'];
		$evalpt=$t['evalpt'];
		$qm=$t['marks'];
	
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

<center><font size="5" color="black">Test/Assignment Code: <font size="5" color="blue"><?=$test_code ?></font>, Test/Assignment Name.: <font size="5" color="blue"><?=$tname ?></font></font></center>	
<center><font size="5" color="black">Student Name: <font size="5" color="blue"><?=$student_name ?></font>, Roll No.: <font size="5" color="blue"><?=$stud_roll_no ?></font></font></center>
<center><font size="5" color="black">Question No: <font size="5" color="blue"><?=$qn ?></font></font></center>
<table align="center" border="1">
	<?php

	
	$base_dir_sub='./tests/'.$test_code.'/';
	$roll=$_POST['student_roll'];
	$obj=$test_code.'-'.$roll.'-'.$qn.".py";



for ($i=1; $i <=$ntc ; $i++) { 
	$tcwm=0.00;
	$tcwp=intval(explode("-",$evalpt)[$i-1]);

if (file_exists($base_dir_sub.''.$obj)) {
	
		//do nothing
}else{

	echo "<tr><td align='center'><font color='red' size='6'>Source File Not Submitted</font><br></td>";
	$marks_obtained= ceil($marks_obtained);
	goto skippy2;
}

$ifile=$base_dir_sub.'input_'.$tc.'-'.$qn.'-'.$i.'.txt';
$output = shell_exec('python3 ./tests/'.$tc.'/temp/'.$obj.' '.$ifile.' 2>&1');

echo "<tr><td align='center'>Output: Testcase - ".$i."<br></td>";
echo "<td align='center'>Actual output of the testcase should be:</td></tr>";

echo "<tr><td  width='40%'><pre>$output</pre></td>";
skippy:
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
		echo "Marks Obtained: ". $marks_obtained . " / ".$tm;

	?></strong></font></td>
</tr>

<?php  

skippy2:
?>

</tr>


</table>
</div>

<br><center><strong><font color="red" size="5">Source Code</font></strong></center><br>
<table align="center" border="1">
	<tr>
		<td>
			<?php 

		$orig=file_get_contents( './tests/'.$tc.'/temp/'.$obj);
		$a = htmlentities($orig);
		echo '<code>';
		echo '<pre>';

		echo $a;

		echo '</pre>';
		echo '</code>';
?>
		</td>
	</tr>
	
</table>

<?php 

}
  
?>


<!--*******************************************************PYTHON-End*******************************************************-->




<?php
    if(isset($_POST["src_file"]) && $_POST['proglan']=='X')
{

	$student_name=$_POST['student_name'];
	$stud_roll_no=$_POST['student_roll'];
	?>
	<BR><BR><center><font color="red" size="4"><strong><?=$student_name ?>(ROLL NO.: <?=$stud_roll_no ?>) HAS NOT SUBMITTED ANY SOURCE CODE</strong></font></center>

	<?php
}

?>


<?php 
	include('./includes/footer.php');
?>