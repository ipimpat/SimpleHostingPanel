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

session_start();
if(isset($_SESSION['username'])){
	$logged_in = "1";
	if (file_exists("setup.php")) {
    echo "<h1 class=\"warning\">Warning: setup.php has NOT been deleted!!</h1>";
	}
	include("includes/dbconnect.inc.php");
	include("header.php");
	include("content.php");
	include("footer.php");
}
else {
	header("location: login.php");
}

?>