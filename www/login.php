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
	margin-top: 100px;
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
body,td,th {
	color: #FFF;
}
</style>
</head>
<body>
<div id="container">
  <div id="top"></div>
  <div id="middle">
  <h2 class="logo-text">Simple Hosting Panel</h2>
  <form name="submit" action="handlers/check_login.php" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="85"><strong>Username:</strong></td>
        <td width="4"></td>
        <td width="200"><input name="username" type="text" class="input" id="username" /></td>
        </tr>
      <tr>
        <td><strong>Password:</strong></td>
        <td width="4"></td>
        <td><input name="password" type="password" class="input" id="password" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><label>
          <input name="Login" type="submit" class="button" id="Login" value="Submit" />
        </label></td>
        </tr>
    </table>
    <input name="submit" type="hidden" value="submit" />
    </form>
  </div>
  <div id="bottom"></div>
</div>
</body>
</html>
