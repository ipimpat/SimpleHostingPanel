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
	// Get apache version
	$apache_version = apache_get_version();
	// Get php version
	$php_version = phpversion();
	// Get server uptime
	$data = shell_exec('uptime');
	$uptime = explode(' up ', $data);
	$uptime = explode(',', $uptime[1]);
	$uptime = $uptime[0].', '.$uptime[1];
	$server_uptime = $uptime;
	$sph_version = "1.0.2 BETA";
	// MySQL version
	function MySQL_Version() {
	   $output = shell_exec('mysql -V');
	   preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version);
	   return $version[0];
	}
	$mysql_version = MySQL_Version();
	
	// SPH html
	echo "<h2>Panel info</h2>\n";
	// Count users
	$query = mysql_query("SELECT * FROM users");
	$user_count = mysql_num_rows($query);
	echo "Users: ".$user_count."<br />";
	// Count domains
	$query = mysql_query("SELECT * FROM domains");
	$domain_count = mysql_num_rows($query);
	echo "Domains: ".$domain_count."<br />";
	// Count databases
	$query = mysql_query("SELECT * FROM userdbs");
	$userdb_count = mysql_num_rows($query);
	echo "Databases: ".$userdb_count."<br />";

	// sysinfo html
	echo "<h2>System info</h2>\n";
	echo "Apache: ".$apache_version."<br />";
	echo "PHP: ".$php_version."<br />";
	echo "Uptime: ".$server_uptime."<br />";
	echo "MySQL: ".$mysql_version."<br />"; 
	echo "Simple Hosting Panel: ".$sph_version."<br />";
}
?>