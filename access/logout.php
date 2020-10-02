<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/

define("FA_LOGOUT_PHP_FILE","");

$page_security = 'SA_OPEN';
$path_to_root="..";
include($path_to_root . "/includes/session.inc");
add_js_file('login.js');

include($path_to_root . "/includes/page/header.inc");

page_header(_("Logout"), true, false, '');

echo '<div class="page-container">';
echo '<div class="content-wrap"';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-sm-10 mx-auto">';
echo '<img class="mx-auto d-block" style="height: 120px" src="'.$path_to_root.'/themes/default/images/erp.png" alt="Logo">';
echo '</div>';
echo '</div>';
echo '<div class="row">';
echo '<div class="col-sm-10 mx-auto" style="margin-top: 150px">';
echo '<h2 class="text-center">You Have Been Logged Out</h2>';
echo "<p class='text-center'> Please click <a href='$path_to_root/index.php'>here</a> to login back to our site";
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';


echo '<footer class="footer-2"  id="footer">';
echo '<div class="vd_bottom ">';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-xs-12 mx-auto">';
echo '<div class="copyright text-center">';
echo '<p>Copyright &copy;2020 Wizag. All Rights Reserved</p>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</footer>';
echo '</div>';


// echo "<table width='100%' border='0'>
//   <tr>
// 	<td align='center'><img src='$path_to_root/themes/default/images/erp.png' alt='FrontAccounting' width='100' height='50' onload='fixPNG(this)' ></td>
//   </tr>
//   <tr>
//     <td>&nbsp;</td>
//   </tr>
//   <tr>
//     <td><div align='center'><font size=2>";
// echo "<table width='100%' border='0'>
//   <tr>
// 	<td align='center'><img src='$path_to_root/themes/default/images/erp.png' alt='FrontAccounting' width='100' height='50'></td>
//   </tr>
//   <tr>
//     <td>&nbsp;</td>
//   </tr>
//   <tr>
//     <td><div align='center'><font size=2>";
// echo _("Thank you for using") . " ";

// echo('<button class = "btn btn-primary">Logout</button>');

// echo "<strong>".$SysPrefs->app_title." $version</strong>";

// echo "</font></div></td>
//   </tr>
//   <tr>
//     <td>&nbsp;</td>
//   </tr>
//   <tr>
//     <td><div align='center'>";
// echo "<a href='$path_to_root/index.php'><b>" . _("Click here to Login Again.") . "</b></a>";
// echo "</div></td>
//   </tr>
// </table>
// <br>\n";
end_page(false, true);
session_unset();
@session_destroy();
