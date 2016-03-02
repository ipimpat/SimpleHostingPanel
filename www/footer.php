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
	echo "<!--footer starts here-->\n";
	echo "  <div id=\"footer\">\n";
	echo "    <p> &copy; 2009 <strong>Simple Hosting Panel</strong> |\n"; 
	echo "      Design by: <a href=\"http://www.styleshout.com/\">styleshout</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/\">Home</a>&nbsp;|&nbsp; <a href=\"index.php?page=help\">Help</a>&nbsp;|&nbsp; <a href=\"logout.php\">Logout</a></p>\n";
	echo "  </div>\n";
	echo "  <!-- wrap ends here -->\n";
	echo "</div>\n";
	echo "</body>\n";
	echo "</html>\n";
}
?>