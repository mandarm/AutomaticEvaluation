<?php ob_start(); ?>
<?php require_once("./includes/db.php"); 
date_default_timezone_set('Asia/Kolkata');?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>ISI: Automated Test Evaluation System</title>
        <link href="./css/styles.css" rel="stylesheet" />
        <link rel="icon" type="./includes/images/x-icon" href="./includes/images/favicon.png" />

         <script type="text/javascript">
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>
    </head>


<style>
body {background-color: white; text-decoration-color: black}
h1   {color: brown;}
p   {color: brown;}


table.center {
    margin-left:auto; 
    margin-right:auto;
    text-decoration-color: black;
  }

  .container{
    width:100%;
}

.flex-rw {
  display: flex;
  flex-flow: row wrap;
}



/* Dropdown Button */
.dropbtn1 {
  background-color: green;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropbtn2 {
  background-color: blue;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #3e8e41;}




</style>

 <body>
<div style="background: #cce6ff">
<center><strong><font size="6" color="brown">INDIAN STATISTICAL INSTITUTE KOLKATA </font><!--<br><font size="6" color="blue">Advanced Computing & Microelectrinics Unit</font>--><br><font size="6" color="grey">Automated Test Evaluation System</font></strong></center>
</div>

<div style="background-color:#f7f5e1;" class="flex-container">
<form action="./index.php">
  
<!--<button type="submit">Home</button>-->
</form>

</div>
<br>
