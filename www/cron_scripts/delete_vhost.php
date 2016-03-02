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

// Connect to DB
include('/var/www/includes/dbconnect.inc.php');
// Apache vhost folder
$vhost_folder = "/etc/apache2/sites-enabled";

// Logging function
function WriteLog($message){
		$log_file = "/var/log/shp/delete_vhost.log";
		$date = date("d-m-y H:i:s");
		$fh_log = fopen($log_file, 'a');
		$write_log = $date.", ".$message."\n";
		fwrite($fh_log, $write_log);
		fclose($fh_log);
}


$query = mysql_query("SELECT * FROM jobqueue");
while($row = mysql_fetch_assoc($query)){
	
	// Create new Virtual Host file
    if($row['job'] == "delete"){
		// Specify values
		$domain = $row['domain'];
		$id = $row['id'];		
		
		// delete vhost
		$delete_vhost = $vhost_folder."/".$domain;
		unlink($delete_vhost) or die(WriteLog("Error deleting ".$domain." vhost file"));
		
		// Delete job
		mysql_query("DELETE FROM jobqueue WHERE id = '$id'") or die(WriteLog(mysql_error()));
		WriteLog($domain."succesfully deleted");
		
		// Restart apache
		exec('/etc/init.d/apache2 force-reload');
	}
}
?>
