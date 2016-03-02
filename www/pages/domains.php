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
		$msg = "Domain in use";
	}
	
	// domain html table
	echo "<h2>Domains</h2>\n";
	echo "<table width=\"90%\">\n";
	echo "  <tr>\n";
	echo "    <th class=\"first\"><strong>Added</strong></th>\n";
	echo "    <th>Domains</th>\n";
	echo "    <th>Owner</th>\n";
	echo "    <th>Action</th>\n";
	echo "  </tr>\n";
	$query = mysql_query("SELECT * FROM domains ORDER BY domain"); 
	while($row = mysql_fetch_assoc($query)){
		$added = date('d-m-y', $row['added']);
		echo "  <tr class=\"row-a\">\n";
		echo "    <td class=\"first\">".$added."</td>\n";
		echo "    <td>".$row['domain']."</td>\n";
		echo "    <td>".$row['owner']."</td>\n";
		echo "    <td><a href=\"javascript:popUp('popup.php?page=delete_domain&id=".$row['id']."')\">Delete</a></td>\n";
		echo "  </tr>\n";
	}
	echo "</table>\n";
	// Add domain html form
	echo "<h2>Add domain</h2>\n";
	echo "<form name=\"submit\" action=\"handlers/add_domain.php\" method=\"post\" style=\"width:60%;\">\n";
	echo "  <p>\n";
	echo "    <label><span class=\"require\">*</span> Username</label>\n";
	echo "    <select name=\"username\" style=\"width:100%;\">\n";
	echo "      <option value=\"select\" selected=\"selected\">Select</option>\n";
	$query = mysql_query("SELECT * FROM users ORDER BY username");
	while($row = mysql_fetch_assoc($query)){
		echo "      <option value=\"".$row['username']."\">".$row['username']."</option>\n";
	}
	echo "    </select>\n";
	echo "    <label><span class=\"require\">*</span> Domain</label>\n";
	echo "    <input name=\"domain\" type=\"text\" style=\"width:100%\" />\n";
	echo "    <label>Path</label>\n";
	echo "    <input name=\"path\" type=\"text\" style=\"width:100%\" />\n";
	echo "    <div>".$msg."<div style=\"text-align:right; padding:5px;\"><input class=\"button\" type=\"submit\" value=\"Submit\" /></div></div>\n";
	echo "  </p>\n";
	echo "</form>\n";
}
?>