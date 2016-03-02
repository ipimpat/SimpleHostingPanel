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

if($logged_in = "1"){
	echo "<body>\n";
	echo "<!-- wrap starts here -->\n";
	echo "<div id=\"wrap\">\n";
	echo "  <!--header -->\n";
	echo "  <div id=\"header\">\n";
	echo "    <h1 id=\"logo-text\"><a href=\"index.php\">Simple Hosting Panel</a></h1>\n";
	echo "  </div>\n";
	echo "  <!-- menu -->\n";
	echo "  <div  id=\"menu\">\n";
	echo "    <ul>\n";
	// top menu
	if($_GET['page'] == "users"){
		echo "      <li id=\"current\"><a href=\"index.php\">Home</a></li>\n";
		echo "      <li><a href=\"index.php?page=help\">Help</a></li>\n";
	}
	elseif($_GET['page'] == "help"){
		echo "      <li><a href=\"index.php\">Home</a></li>\n";
		echo "      <li id=\"current\"><a href=\"index.php?page=help\">Help</a></li>\n";
	}
	else{
		echo "      <li><a href=\"index.php\">Home</a></li>\n";
		echo "      <li><a href=\"index.php?page=help\">Help</a></li>\n";
	}
	echo "      <li class=\"last\"><a href=\"logout.php\">Logout</a></li>\n";
	echo "    </ul>\n";
	echo "  </div>\n";
	echo "  <!-- content-wrap starts here -->\n";
	echo "  <div id=\"content-wrap\">\n";
	echo "    <div id=\"sidebar\">\n";
	echo "      <h3>Administration</h3>\n";
	echo "      <ul class=\"sidemenu\">\n";
	echo "        <li><a href=\"index.php?page=users\">Users</a></li>\n";
	echo "        <li><a href=\"index.php?page=domains\">Domains</a></li>\n";
	echo "        <li><a href=\"index.php?page=databases\">Databases</a></li>\n";
	echo "        <li><a href=\"index.php?page=administrators\">Administrators</a></li>\n";
	echo "        <li><a href=\"index.php?page=jobqueue\">Job Queue</a></li>\n";
	echo "        <li><a href=\"index.php?page=sysinfo\">System info</a></li>\n";
	echo "      </ul>\n";
	echo "      <h3>3rd party</h3>\n";
	echo "      <ul class=\"sidemenu\">\n";
	echo "        <li><a href=\"/phpmyadmin\">phpMyAdmin</a></li>\n";
	echo "      </ul>\n";
	echo "    </div>\n";
	echo "    <!-- content start -->\n";
	echo "    <div id=\"main\">\n";
	if(isset($_GET['page'])){
		switch ($_GET['page']){
			case "sysinfo": include("pages/sysinfo.php");
			break;
			case "users": include("pages/users.php");
			break;
			case "domains": include("pages/domains.php");
			break;
			case "databases": include("pages/databases.php");
			break;
			case "administrators": include("pages/administrators.php");
			break;
			case "jobqueue": include("pages/jobqueue.php");
			break;
			case "help": include("pages/help.php");
			break;
			default: include("pages/sysinfo.php");
			break;
		}
	}
	else{
		include("pages/sysinfo.php");
	}
	
	echo " </div>\n";
	echo "    <!-- content end -->\n";
	echo "    <!-- content-wrap ends here -->\n";
	echo "  </div>\n";
}
?>