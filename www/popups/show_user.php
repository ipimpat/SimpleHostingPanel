<?

#############################################################################
#    This program is free software: you can redistribute it and/or modify	#
#    it under the terms of the GNU General Public License as published by	#
#    the Free Software Foundation, either version 3 of the License, or		#
#    (at your option) any later version.									#
#																			#
#    This program is distributed in the hope that it will be useful,		#
#    but WITHOUT ANY WARRANTY; without even the implied warranty of			#
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			#
#    GNU General Public License for more details.							#
#																			#
#    You should have received a copy of the GNU General Public License		#
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.	#
#############################################################################

if($logged_in == "1"){
	include("includes/dbconnect.inc.php"); 
	$id = $_GET['id'];
	$id = mysql_real_escape_string($id);
	$query = mysql_query("SELECT * FROM users WHERE id = '$id'");
	$row = mysql_fetch_assoc($query);
	
	$username = $row['username'];
	$email = $row['email'];
	$added = date('d-m-y', $row['added']);
	$addedby = $row['addedby'];
	
	$query = mysql_query("SELECT * FROM ftpuser WHERE userid = '$username'");
	$row = mysql_fetch_assoc($query);
	
	$ftpuser = $row['userid'];
	$ftppass = $row['passwd'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple Hosting Panel</title>
<style type="text/css">
body {
	font: 80% verdana, arial, helvetica, sans-serif;
	text-align: center; /* for IE */
	background-color: #CCC;
}
#container {
	margin: 0 auto;   /* align for good browsers */
	text-align: left; /* counter the body center */
	width: 377px;
	background-image:url(images/login-middle.jpg);
}
#top {
	background-image:url(images/login-top.jpg);
	height:35px;
}
#middle {
	padding-left:30px;
	padding-right:30px;
}
#bottom {
	background-image:url(images/login-bottom.jpg);
	height:35px;
}
.logo-text {
	color:#FFF;
}
.input {
	width:100%
}
input.button {
	font: bold 12px Arial, Sans-serif;
	height: 24px;
	margin: 0;
	padding: 2px 3px;
	color: #FFF;
	background: #8EB50C url(images/button-bg.jpg) repeat-x 0 0;
	border: none;
}
body, td, th {
	color: #FFF;
}
</style>
</head>
<body>
<div id="container">
  <div id="top"></div>
  <div id="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="85"><strong>Username:</strong></td>
        <td width="4"></td>
        <td width="200"><? echo $username; ?></td>
      </tr>
      <tr>
        <td width="85"><strong>Added:</strong></td>
        <td width="4"></td>
        <td width="200"><? echo $added; ?></td>
      </tr>
      <tr>
        <td width="85"><strong>Added by:</strong></td>
        <td width="4"></td>
        <td width="200"><? echo $addedby; ?></td>
      </tr>
      <tr>
        <td><strong>Email: </strong></td>
        <td width="4"></td>
        <td><? echo $email; ?></td>
      </tr>
      <tr>
        <td><strong>FTP Pass: </strong></td>
        <td width="4"></td>
        <td><? echo $ftppass; ?></td>
      </tr>
      <tr>
        <td><strong>Databases: </strong></td>
        <td width="4"></td>
        <td>
        <select name="databases" id="databases">
		<? 
        $query = mysql_query("SELECT * FROM userdbs WHERE owner = '$username'");
        while($row = mysql_fetch_assoc($query)){
        echo "<option>".$row['name']."</option>";
        } 
        ?>
        </select>
        </td>
      </tr>
      <tr>
        <td><strong>Domains: </strong></td>
        <td width="4"></td>
        <td>
        <select name="domains" id="domains">
		<? 
        $query = mysql_query("SELECT * FROM domains WHERE owner = '$username'");
        while($row = mysql_fetch_assoc($query)){
        echo "<option>".$row['domain']."</option>";
        } 
        ?>
        </select>
        </td>
    </table>
  </div>
  <div id="bottom"></div>
</div>
</body>
</html>
<?
}
?>