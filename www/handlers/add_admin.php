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

ob_start();
session_start();
	if(isset($_SESSION['username'])){
	include("../includes/dbconnect.inc.php");
	
	// fetch posts
	$username = $_POST['username'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$email = $_POST['email'];
	
	$_SESSION['temp_username'] = $username;
	$_SESSION['temp_email'] = $email;
	
	// security
	$username = mysql_real_escape_string($username);
	$email = mysql_real_escape_string($email);
	
	// validating
	$query = mysql_query("SELECT * FROM administrators WHERE username = '$username'");
	$count = mysql_num_rows($query);
	
	if($password1 == $password2){
		$pass_ok = 1;
	}
	
	// check if any of the fields has been left empty
	if(empty($username) || empty($password1) || empty($password2) || empty($email)){
		header("location:../index.php?page=administrators&error=1");
		die();
	}
	// check if it's a valid email
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
		header("location:../index.php?page=administrators&error=2");
		die();
	}
	// check if username has been taken
	elseif($count > 0) {
		header("location:../index.php?page=administrators&error=3");
		die();
	}
	// check if pass is okay
	elseif($pass_ok != 1){
		header("location:../index.php?page=administrators&error=4");
		die();
	}
	else {
		$password = md5($password1);
		$added = time();
		$addedby = $_SESSION['username'];
		mysql_query("INSERT INTO administrators (username, password, email, added, addedby) VALUES ('$username', '$password', '$email', '$added', '$addedby')");
		unset($_SESSION['temp_username']);
		unset($_SESSION['temp_email']);
		header("location:../index.php?page=administrators");
	}
}
ob_end_flush();
?>