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
	echo "<h2>Help</h2>\n";
	echo "<h3>Users</h3>\n";
	echo "<p>When adding a user, proftpd will create the users homedir when the user logs in.<br /> Deleting a user, the users homedir will not automatically deleted.</p>\n";
	echo "<h3>Domains</h3>\n";
	echo "<p>SPH supports multiply domains per user, if you do not specify a path, the path will be /homedir/domain. the user has to manualy create domain/path directory(s)</p>\n";
	echo "<h3>Database</h3>\n";
	echo "<p>When creating a new database, you can select which user, you wan't to create a new DB for</p>\n";
	echo "<h3>Admnistrator</h3>\n";
	echo "<p>SPH, does not have advance user levels, that means that a administrator has full access to all functions</p>\n";
	echo "<h3>Job Queue</h3>\n";
	echo "<p>Because SPH check if there is any jobs, to do like creating new vhost file, delete old vhosts file and so on, you can see all jobs which has not been done yet, in the job queue, SPH checks every 1 minut</p>\n";
}
?>