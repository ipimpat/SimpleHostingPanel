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
	$domain = $_POST['domain'];
	$path = $_POST['path'];
	$database = $_POST['database'];
	
	$_SESSION['temp_username'] = $username;
	$_SESSION['temp_email'] = $email;
	$_SESSION['temp_domain'] = $domain;
	$_SESSION['temp_path'] = $path;
	if(!empty($database)){
		$_SESSION['temp_database'] = "checked=\"1\"";
	}
			 
	
	// security
	$username = mysql_real_escape_string($username);
	$email = mysql_real_escape_string($email);
	$domain = mysql_real_escape_string($domain);
	$path = mysql_real_escape_string($path);
	$database = mysql_real_escape_string($database);
		
	// validating
	$query = mysql_query("SELECT * FROM users WHERE username = '$username'");
	$count_user = mysql_num_rows($query);
	$query = mysql_query("SELECT * FROM domains WHERE domain = '$domain'");
	$count_domain = mysql_num_rows($query);
	
	if($password1 == $password2){
		$pass_ok = 1;
	}
	
	// check if any of the fields has been left empty
	if(empty($username) || empty($password1) || empty($password2) || empty($email)){
		header("location:../index.php?page=users&error=1");
		die();
	}
	// check if it's a valid email
	elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
		header("location:../index.php?page=users&error=2");
		die();
	}
	// check if username has been taken
	elseif($count_user > 0) {
		header("location:../index.php?page=users&error=3");
		die();
	}
	// check if domain has been taken
	elseif($count_domain > 0) {
		header("location:../index.php?page=users&error=4");
		die();
	}
	// check if pass is okay
	elseif($pass_ok != 1){
		header("location:../index.php?page=users&error=5");
		die();
	}
	else {
		$added = time();
		$addedby = $_SESSION['username'];
		$owner = $username;
		// insert user information into users
		mysql_query("INSERT INTO users (`username`, `email`, `added`, `addedby`) VALUES ('$username', '$email', '$added', '$addedby')") or die(mysql_error());
		// insert ftpuser information into ftpuser
		$homedir = "/var/users/".$username;
		mysql_query("INSERT INTO ftpuser (`userid`, `passwd`, `uid`, `gid`, `homedir`, `shell`, `count`, `accessed`, `modified`) VALUES ('$username', '$password1', 2001, 2001, '$homedir', '/sbin/nologin', 0, '', '')") or die(mysql_error()); 		
		// insert domain information
		if(!empty($domain)){
			if(empty($path)){
					$path = "/var/users/".$owner."/".$domain;
				}
				else {
					$path = "/var/users/".$owner."".$path;
				}
			mysql_query("INSERT INTO domains (`domain`, `path`, `owner`, `added`) VALUES ('$domain', '$path', '$owner', '$added')")  or die(mysql_error());
			mysql_query("INSERT INTO jobqueue (`job`, `username`, `domain`, `path`, `added`) VALUES ('create', '$owner', '$domain', '$path', '$added')")  or die(mysql_error());
		}
		// Create mysql user
		mysql_query("CREATE USER '$username'@'%' IDENTIFIED BY '$password1';");
		// create mysql database and user
		if(!empty($database)){
			mysql_query("CREATE DATABASE `$username`;") OR DIE(mysql_error()); 
			#mysql_query("GRANT ALL PRIVILEGES ON $username.* TO '$username'@'%' IDENTIFIED BY '$password';") OR DIE(mysql_error()); 
			mysql_query("GRANT ALL PRIVILEGES ON `$username` . * TO '$username'@'%' WITH GRANT OPTION ;");
			mysql_query("FLUSH PRIVILEGES;") OR DIE(mysql_error()); 
			mysql_query("INSERT INTO userdbs (`name`, `owner`, `added`) VALUES ('$username', '$username', '$added')") or die(mysql_error());
		}

		unset($_SESSION['temp_username']);
		unset($_SESSION['temp_email']);
		unset($_SESSION['temp_domain']);
		unset($_SESSION['temp_path']);
		unset($_SESSION['temp_database']);
		header("location:../index.php?page=users");
	}
}
ob_end_flush();
?>