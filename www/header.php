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
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
	echo "<head>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
	echo "<title>Simple Hosting Panel</title>\n";
	echo "<link href=\"styles.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	echo "<script language=\"JavaScript\">\n";
	echo "<!-- Begin\n";
	echo "function popUp(URL) {\n";
	echo "day = new Date();\n";
	echo "id = day.getTime();\n";
	echo "eval(\"page\" + id + \" = window.open(URL, '\" + id + \"', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=405,height=240,left = 440,top = 250');\");\n";
	echo "}\n";
	echo "function popUpInfo(URL) {\n";
	echo "day = new Date();\n";
	echo "id = day.getTime();\n";
	echo "eval(\"page\" + id + \" = window.open(URL, '\" + id + \"', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=405,height=280,left = 440,top = 250');\");\n";
	echo "}\n";
	echo "// End -->\n";
	echo "</script>\n";
	echo "</head>\n";
}
?>