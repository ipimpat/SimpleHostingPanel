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
	$owner = $_POST['username'];
	$domain = $_POST['domain'];
	$path = $_POST['path'];
	
	// temp
	$_SESSION['temp_domain'] = $domain;
	$_SESSION['temp_path'] = $path;
	
	// security
	$owner = mysql_real_escape_string($owner);
	$domain = mysql_real_escape_string($domain);
	$path = mysql_real_escape_string($path);
	
	// validating
	$query = mysql_query("SELECT * FROM domains WHERE domain = '$domain'");
	$count = mysql_num_rows($query);
	
	// check if any of the required fields has been left empty
	if(empty($owner) || empty($domain)){
		header("location:../index.php?page=domains&error=1");
		die();
	}
	// check if domain already is in use
	elseif($count > 0) {
		header("location:../index.php?page=domains&error=2");
		die();
	}
	else {
		// determin path
		if(empty($path)){
			$path = "/var/users/".$owner."/".$domain;
		}
		else {
			$path = "/var/users/".$owner."".$path;
		}
		
		$added = time();
		mysql_query("INSERT INTO domains (`domain`, `path`, `owner`, `added`) VALUES ('$domain', '$path', '$owner', '$added')")  or die(mysql_error());
		mysql_query("INSERT INTO jobqueue (`job`, `username`, `domain`, `path`, `added`) VALUES ('create', '$owner', '$domain', '$path', '$added')")  or die(mysql_error());
		unset($_SESSION['temp_domain']);
		unset($_SESSION['temp_path']);
		header("location:../index.php?page=domains");
	}
}
ob_end_flush();
?>