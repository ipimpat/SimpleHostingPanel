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
	$name = $_POST['name'];
	
	$_SESSION['temp_name'] = $name;
	
	// security
	$username = mysql_real_escape_string($username);
	$name = mysql_real_escape_string($name);
	
	// validating
	$query = mysql_query("SELECT * FROM userdbs WHERE name = '$name'");
	$count = mysql_num_rows($query);
	
	if($password1 == $password2){
		$pass_ok = 1;
	}
	
	// check if any of the fields has been left empty
	if(empty($username) || empty($name)){
		header("location:../index.php?page=databases&error=1");
		die();
	}
	// check if database name has been taken
	elseif($count > 0) {
		header("location:../index.php?page=databases&error=2");
		die();
	}
	// check if pass is okay
	elseif($pass_ok != 1){
		header("location:../index.php?page=databases&error=3");
		die();
	}
	else {
		$added = time();
		$addedby = $_SESSION['username'];
		mysql_query("CREATE DATABASE `$name`;") OR DIE(mysql_error());
		mysql_query("GRANT ALL PRIVILEGES ON `$name` . * TO '$username'@'%' WITH GRANT OPTION ;");
		mysql_query("FLUSH PRIVILEGES;") OR DIE(mysql_error()); 
		mysql_query("INSERT INTO userdbs (`name`, `owner`, `added`) VALUES ('$name', '$username', '$added')") or die(mysql_error());
		unset($_SESSION['temp_name']);
		header("location:../index.php?page=databases");
	}
}
ob_end_flush();
?>