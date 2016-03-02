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
	// Job queue html table
	echo "<h2>Job Queue</h2>\n";
	echo "<table width=\"98%\">\n";
	echo "  <tr>\n";
	echo "    <th class=\"first\"><strong>Added</strong></th>\n";
	echo "    <th>Job</th>\n";
	echo "    <th>User</th>\n";
	echo "    <th>Domain</th>\n";
	echo "    <th>Action</th>\n";
	echo "  </tr>\n";
	$query = mysql_query("SELECT * FROM jobqueue"); 
	while($row = mysql_fetch_assoc($query)){ 
		$added = date('H:i:s', $row['added']);
		echo "  <tr class=\"row-a\">\n";
		echo "    <td class=\"first\">".$added."</td>\n";
		echo "    <td>".$row['job']."</td>\n";
		echo "    <td>".$row['username']."</td>\n";
		echo "    <td>".$row['domain']."</td>\n";
		echo "    <td><a href=\"javascript:popUp('popup.php?page=delete_job&id=".$row['id']."')\">Delete</a></td>\n";
		echo "  </tr>\n";
	}
	echo "</table>\n";
}
?>