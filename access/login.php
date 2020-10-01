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
	if (!isset($path_to_root) || isset($_GET['path_to_root']) || isset($_POST['path_to_root']))
		die(_("Restricted access"));
	include_once($path_to_root . "/includes/ui.inc");
	include_once($path_to_root . "/includes/page/header.inc");

	$js = "<script language='JavaScript' type='text/javascript'>
function defaultCompany()
{
	document.forms[0].company_login_name.options[".user_company()."].selected = true;
}
</script>";
	add_js_file('login.js');
	// Display demo user name and password within login form if allow_demo_mode option is true
	if ($SysPrefs->allow_demo_mode == true)
	{
	    $demo_text = _("Login as user: demouser and password: password");
	}
	else
	{
		$demo_text = _("Please login here");
    	if (@$SysPrefs->allow_password_reset) {
      		$demo_text .= " "._("or")." <a href='$path_to_root/index.php?reset=1'>"._("request new password")."</a>";
    	}
	}

	if (check_faillog())
	{
		$blocked_msg = '<span class="redfg">'._('Too many failed login attempts.<br>Please wait a while or try later.').'</span>';

	    $js .= "<script>setTimeout(function() {
	    	document.getElementsByName('SubmitUser')[0].disabled=0;
	    	document.getElementById('log_msg').innerHTML='$demo_text'}, 1000*".$SysPrefs->login_delay.");</script>";
	    $demo_text = $blocked_msg;
	}
	flush_dir(user_js_cache());
	if (!isset($def_coy))
		$def_coy = 0;
	$def_theme = "default";

	$login_timeout = $_SESSION["wa_current_user"]->last_act;

	$title = $login_timeout ? _('Authorization timeout') : $SysPrefs->app_title." ".$version." - "._("Login");
	$encoding = isset($_SESSION['language']->encoding) ? $_SESSION['language']->encoding : "iso-8859-1";
	$rtl = isset($_SESSION['language']->dir) ? $_SESSION['language']->dir : "ltr";
	$onload = !$login_timeout ? "onload='defaultCompany()'" : "";

	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
	echo "<html dir='$rtl' >\n";
	echo "<head profile=\"http://www.w3.org/2005/10/profile\"><title>$title</title>\n";
   	echo "<meta http-equiv='Content-type' content='text/html; charset=$encoding' >\n";
	echo "<link href='$path_to_root/themes/$def_theme/default.css' rel='stylesheet' type='text/css'> \n";
	echo "<link href='$path_to_root/themes/$def_theme/bootstrap.min.css' rel='stylesheet' type='text/css'> \n";
 	echo "<link href='$path_to_root/themes/default/images/favicon.ico' rel='icon' type='image/x-icon'> \n";
	send_scripts();
	if (!$login_timeout)
	{
		echo $js;
	}
	echo "</head>\n";

	echo "<body id='loginscreen' $onload>\n";

	// echo "<table class='titletext'><tr><td>$title</td></tr></table>\n";
	
	div_start('_page_body');
	br();br();

	echo '<div class="card mx-auto" style="width: 30rem;">';
	echo '<img class="card-img-top" src="'.$path_to_root.'/themes/'.$def_theme.'/images/erp.png" alt="Card image cap">';
	// echo '<ul class="list-group list-group-flush">';
	// echo '<li class="list-group-item">Cras justo odio</li>';
	// echo '<li class="list-group-item">Dapibus ac facilisis in</li>';
	// echo '<li class="list-group-item">Vestibulum at eros</li>';
	// echo '</ul>';
	echo '<div class="card-body">';


	start_form(false, false, $_SESSION['timeout']['uri'], "loginform");
	start_table(false, "class='login'");
	start_row();
	echo "<td align='center' colspan=2>";
	if (!$login_timeout) { // FA logo
    	// echo "<a target='_blank' href='".$SysPrefs->power_url."'><img src='$path_to_root/themes/$def_theme/images/erp.png' alt='FrontAccounting' height='50' onload='fixPNG(this)' border='0' ></a>";
    	echo "<a target='_blank' href='".$SysPrefs->power_url."'><img src='$path_to_root/themes/$def_theme/images/erp.png' alt='FrontAccounting' height='50' border='0' ></a>";
	} else { 
		echo "<font size=5>"._('Authorization timeout')."</font>";
	} 
	echo "</td>\n";
	end_row();

	if (!$login_timeout)
		// table_section_title(_("Version")." $version   Build ".$SysPrefs->build_version." - "._("Login"));
	$value = $login_timeout ? $_SESSION['wa_current_user']->loginname : ($SysPrefs->allow_demo_mode ? "demouser":"");

	text_row(_("User name"), "user_name_entry_field", $value, 20, 30);

	$password = $SysPrefs->allow_demo_mode ? "password":"";

	password_row(_("Password:"), 'password', $password);


	if ($login_timeout) {
		hidden('company_login_name', user_company());
	} else {
		$coy =  user_company();
		if (!isset($coy))
			$coy = $def_coy;
		if (!@$SysPrefs->text_company_selection) {
			echo "<tr><td>"._("Company")."</td><td><select name='company_login_name'>\n";
			for ($i = 0; $i < count($db_connections); $i++)
				echo "<option value=$i ".($i==$coy ? 'selected':'') .">" . $db_connections[$i]["name"] . "</option>";
			echo "</select>\n";
			echo "</td></tr>";
		} else {
			text_row(_("Company"), "company_login_nickname", "", 20, 50);
		}
		start_row();
		label_cell($demo_text, "colspan=2 align='center' id='log_msg'");
		end_row();
	}; 
	end_table(1);
	echo "<input type='hidden' id=ui_mode name='ui_mode' value='".!fallback_mode()."' >\n";
	echo "<center><input type='submit' value='&nbsp;&nbsp;"._("Login -->")."&nbsp;&nbsp;' name='SubmitUser'"
		." onclick='set_fullmode();'".(isset($blocked_msg) ? " disabled" : '')." ></center>\n";

	foreach($_SESSION['timeout']['post'] as $p => $val) {
		// add all request variables to be resend together with login data
		if (!in_array($p, array('ui_mode', 'user_name_entry_field', 
			'password', 'SubmitUser', 'company_login_name'))) 
			if (!is_array($val))
				echo "<input type='hidden' name='$p' value='$val'>";
			else
				foreach($val as $i => $v)
					echo "<input type='hidden' name='{$p}[$i]' value='$v'>";
	}
	end_form(1);



	echo '</div>';
	echo '</div>';



	$Ajax->addScript(true, "document.forms[0].password.focus();");

    echo "<script language='JavaScript' type='text/javascript'>
    //<![CDATA[
            <!--
            document.forms[0].user_name_entry_field.select();
            document.forms[0].user_name_entry_field.focus();
            //-->
    //]]>
	</script>";
	echo "<script src='$path_to_root/themes/$def_theme/bootstrap.min.js'></script>\n";
	echo "<script src='$path_to_root/themes/$def_theme/jquery-3.5.1.slim.min.js'></script>\n";
	echo "<script src='$path_to_root/themes/$def_theme/popper.min.js'></script>\n";
    div_end();
	// echo "<table class='bottomBar'>\n";
	// echo "<tr>";
	// if (isset($_SESSION['wa_current_user'])) 
	// 	$date = Today() . " | " . Now();
	// else	
	// 	$date = date("m/d/Y") . " | " . date("h.i am");
	// echo "<td class='bottomBarCell'>$date</td>\n";
	// echo "</tr></table>\n";
	// echo "<table class='footer'>\n";
	// echo "<tr>\n";
	// echo "<td><a target='_blank' href='".$SysPrefs->power_url."' tabindex='-1'>".$SysPrefs->app_title." $version - " . _("Theme:") . " " . $def_theme . "</a></td>\n";
	// echo "</tr>\n";
	// echo "<tr>\n";
	// echo "<td><a target='_blank' href='".$SysPrefs->power_url."' tabindex='-1'>".$SysPrefs->power_by."</a></td>\n";
	// echo "</tr>\n";
	// echo "</table><br><br>\n";
	echo "</body></html>\n";

