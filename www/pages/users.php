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
	// get any messages
	$error_code = $_GET['error'];
	if($error_code == 1){
		$msg = "Not all requiered fields has been filled";
	}
	if($error_code == 2){
		$msg = "No valid email has been entered";
	}
	if($error_code == 3){
		$msg = "Username already taken";
	}
	if($error_code == 4){
		$msg = "Domain in use";
	}
	if($error_code == 5){
		$msg = "Password mismatch";
	}
	// user html table
	echo "<h2>Users</h2>\n";
	echo "<table width=\"90%\">\n";
	echo "  <tr>\n";
	echo "    <th class=\"first\"><strong>Added</strong></th>\n";
	echo "    <th>Username</th>\n";
	echo "    <th>Domains</th>\n";
	echo "    <th>Databases</th>\n";
	echo "    <th>Action</th>\n";
	echo "  </tr>\n";
	$query = mysql_query("SELECT u.id, u.username, u.added, count(db.owner) AS 'database_count', count(d.owner) AS 'domain_count' FROM users u LEFT JOIN userdbs db ON u.username = db.owner LEFT JOIN domains d ON u.username = d.owner GROUP BY u.username ORDER BY username"); // Thanks to Jacob Overgaard for this query
	while($row = mysql_fetch_assoc($query)){
		$added = date('d-m-y', $row['added']);
		echo "  <tr class=\"row-a\">\n";
		echo "    <td class=\"first\">".$added."</td>\n";
		echo "    <td><a href=\"javascript:popUpInfo('popup.php?page=show_user&id=".$row['id']."')\">".$row['username']."</a></td>\n";
		echo "    <td>".$row['domain_count']."</td>\n";
		echo "    <td>".$row['database_count']."</td>\n";
		echo "    <td><a href=\"javascript:popUp('popup.php?page=delete_user&id=".$row['id']."')\">Delete</a></td>\n";
		echo "  </tr>\n";
	}
	echo "</table>\n";
	// Add user html form
	echo "<h2>Add user</h2>\n";
	echo "<form action=\"handlers/add_user.php\" method=\"post\" style=\"width:60%;\">\n";
	echo "  <p>\n";
	echo "    <label><span class=\"require\">*</span> Username</label>\n";
	echo "    <input name=\"username\" type=\"text\" style=\"width:100%\" />\n";
	echo "    <label><span class=\"require\">*</span> Password</label>\n";
	echo "    <input name=\"password1\" type=\"password\" style=\"width:100%\" />\n";
	echo "    <label><span class=\"require\">*</span> Retype password</label>\n";
	echo "    <input name=\"password2\" type=\"password\" style=\"width:100%\" />\n";
	echo "    <label><span class=\"require\">*</span> Email</label>\n";
	echo "    <input name=\"email\" type=\"text\" style=\"width:100%\" />\n";
	echo "    <label>Domain</label>\n";
	echo "    <input name=\"domain\" type=\"text\" style=\"width:100%\" />\n";
	echo "    <label>Path</label>\n";
	echo "    <input name=\"path\" type=\"text\" style=\"width:100%\" />\n";
	echo "    <label>Create database</label>\n";
	echo "    <input type=\"checkbox\" name=\"database\" value=\"1\" ".$_SESSION['temp_database']."/>\n";
	echo "    <div>".$msg."<div style=\"text-align:right; padding:5px;\"><input class=\"button\" type=\"submit\" value=\"Submit\" /></div></div>\n";
	echo "  </p>\n";
	echo "</form>\n";
}
?>