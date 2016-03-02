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
// Apache NameVirtualHost
$NameVirtualHost = "*";
// Apache Port
$apache_port = "80";

// Logging function
function WriteLog($message){
		$log_file = "/var/log/shp/create_vhost.log";
		$date = date("d-m-y H:i:s");
		$fh_log = fopen($log_file, 'a');
		$write_log = $date.", ".$message."\n";
		fwrite($fh_log, $write_log);
		fclose($fh_log);
}


$query = mysql_query("SELECT * FROM jobqueue");
while($row = mysql_fetch_assoc($query)){
	
	// Create new Virtual Host file
    if($row['job'] == "create"){
		// Specify values
		$domain = $row['domain'];
		$path = $row['path'];
		$ServerAdmin = $row['username'];
		$id = $row['id'];
		
		// vhost config		
		$vhost_config = "<VirtualHost ".$NameVirtualHost.":".$apache_port.">\n";
        $vhost_config .= "       ServerAdmin ".$ServerAdmin."\n";
        $vhost_config .= "       ServerName  ".$domain."\n";
        $vhost_config .= "       ServerAlias www.".$domain."\n";
	    $vhost_config .= "    	 \n";
        $vhost_config .= "       # Indexes + Directory Root.\n";
        $vhost_config .= "       DirectoryIndex index.html index.htm index.php\n";
        $vhost_config .= "       DocumentRoot ".$path."/\n";
	    $vhost_config .= "    	 \n";
		$vhost_config .= "       # Open Basedir\n";
		$vhost_config .= "       <Directory ".$path.">\n";
		$vhost_config .= "           php_admin_flag engine on\n";
		$vhost_config .= "           php_admin_value open_basedir ".$path.":/tmp\n";
		$vhost_config .= "       </Directory>\n";
		$vhost_config .= "    	 \n";
        $vhost_config .= "       # Logfiles\n";
        $vhost_config .= "       ErrorLog  /var/users/logs/".$domain."_error.log\n";
        $vhost_config .= "       CustomLog /var/users/logs/".$domain."_access.log combined\n";
        $vhost_config .= "</VirtualHost>\n";
		
		// write vhost file
		$vhost_file = $vhost_folder."/".$domain;
		$fh_vhost = fopen($vhost_file, 'w') or die(WriteLog("Error writing ".$domain." vhost file"));
		$write_vhost_config = $vhost_config;
		fwrite($fh_vhost, $write_vhost_config);
		fclose($fh_vhost);
		
		// Delete job
		mysql_query("DELETE FROM jobqueue WHERE id = '$id'") or die(WriteLog(mysql_error()));
		WriteLog($domain."succesfully added");
		
		// Restart apache
		exec('/etc/init.d/apache2 force-reload');
	}
}
?>
