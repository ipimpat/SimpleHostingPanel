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
	include("includes/dbconnect.inc.php"); 
	$id = $_GET['id'];
	$query = mysql_query("SELECT * FROM domains WHERE id = '$id'");
	$row = mysql_fetch_assoc($query); 
	$domain = $row['domain'];
?> 
<div id="container">
  <div id="top"></div>
  <div id="middle">
    <h2 class="logo-text">Are you sure?</h2>
    <form name="submit" action="popup.php?page=delete_domain" method="post">
    <? echo "<input name=\"id\" type=\"hidden\" value=\"".$id."\" />" ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td colspan="3"><strong>That you wanna delete: <? echo $domain; ?></strong></td>
        </tr>
        <tr>
          <td colspan="3"><strong>This cannot be undone.</strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><label>
              <input name="yes" type="submit" class="button" id="Login" value="Yes" />
            </label>
            <label>
              <input type="button" class="button" value="No" onClick="window.close()"> 
            </label></td>
        </tr>
      </table>
      <input name="submit" type="hidden" value="submit" />
    </form>
  </div>
  <div id="bottom"></div>
</div>
<?
	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$id = mysql_real_escape_string($id);
		$query = mysql_query("SELECT * FROM domains WHERE id = '$id'");
		$row = mysql_fetch_assoc($query); 
		$domain = $row['domain'];
		$owner = $row['owner'];
		$added = time();
		mysql_query("INSERT INTO jobqueue (`job`, `username`, `domain`, `path`, `added`) VALUES ('delete', '$owner', '$domain', '', '$added')")  or die(mysql_error());
		mysql_query("DELETE FROM domains WHERE id = '$id'") or die(mysql_error());
		echo "<script language=\"javascript\">";
		echo "if(window.opener) window.opener.location.reload(true);";
		echo "window.close();";
		echo "</script>";
	}
}
?>