<?php
/**
 * @package Browser-Sniff
 * @author Priyadi Iman Nurcahyo | Bruno Andrade Pedrassani
 * @version 2.1
 */
/*
Plugin Name: Browser Sniff
Plugin URI: http://brunopedrassani.com/wordpress/plugins/browser-sniff
Description: Detects web browser type and operating system to show in the comment loop
Version: 2.0
Author: Priyadi Iman Nurcahyo | Bruno Andrade Pedrassani(maintaner)
Author URI: http://brunopedrassani.com
*/

// begin global settings
$pri_image_url = get_settings('siteurl') . "/wp-content/plugins/browser-sniff/icons";
$pri_image_path = ABSPATH . "/wp-content/plugins/browser-sniff/icons";
// end settings



// ######################################## Adding Options Page Functions #######################################################

function bs_options() {
	
	// if submitted, process results
	if ( $_POST["bs_submit"] ) {
		
		$tmp = array();
		
		$tmp['width'] = stripslashes($_POST["bs_width"]);
		$tmp['height'] = stripslashes($_POST["bs_height"]);
		$tmp['before'] = stripslashes($_POST["bs_before"]);
		$tmp['between'] = stripslashes($_POST["bs_between"]);
		$tmp['after'] = stripslashes($_POST["bs_after"]);
		$tmp['show_icons'] = stripslashes($_POST["bs_show_icons"]);
		$tmp['position'] = stripslashes($_POST["bs_position"]);
		
		update_option('bs_options', serialize($tmp));
	}
	
	//get options from database
	$dbBsOptions = array();
	$dbBsOptions = unserialize(get_option('bs_options'));
	
	//load Options or set default
	if (!$dbBsOptions['width']) {
		$dbBsOptions['width'] = "14";
	}
	
	if (!$dbBsOptions['height']) {
		$dbBsOptions['height'] = "14";
	}

	if (!$dbBsOptions['before']) {
		$dbBsOptions['before'] = "Using";
	}

	if (!$dbBsOptions['between']) {
		$dbBsOptions['between'] = "on";
	}

	if (!$dbBsOptions['after']) {
		$dbBsOptions['after'] = "";
	}

	if (!$dbBsOptions['show_icons']) {
		$dbBsOptions['show_icons'] = "true";
	}
	
	if (!$dbBsOptions['position']) {
		$dbBsOptions['position'] = 'automagically';
	}
	// options form
	echo '<div><form method="post">';
	echo "<div class=\"wrap\"><h2>Browser Sniff - Show the World your browser and OS</h2>";
	echo '
				<h3 class="title">How does this "sniff" works?</h3>
				<p><a href="http://brunopedrassani.com/wordpress/plugins/browser-sniff" target="_blank">Browser-Sniff</a> is a simple plugin that takes the user-agent string stored in Wordpress and convert it into "images", in order to show in the comment loop what the commenter used to... make the comment. Something like "Using Firefox 3.6.3 in Windows Vista".
				<br /><br />
				You need to hook the code pri_print_browser() in your theme - inside the comment_loop - , in order for it to work.</p>
				<br />
				<h3 class="title">Customization</h3>				
				<table class="form-table">';
					// Width x Height
					echo '<tr valign="top"><th scope="row">Width x Height:</th>';
					echo '<td><input type=text width="76px" value="'.$dbBsOptions['width'].'" name="bs_width"> x <input type=text width="76" value="'.$dbBsOptions['height'].'" name="bs_height">
					<p class=\'help\'>The default is 14x14 px and keep in mind that all images are squared.
					</p></td></tr>';

					// Before String
					echo '<tr valign="top"><th scope="row">The Before String:</th>';
					echo '<td><input type=text value="'.$dbBsOptions['before'].'" name="bs_before">
					<p class=\'help\'>This is the string that is printed before browser name. Default is "Using".
					</p></td></tr>';

					// Between String
					echo '<tr valign="top"><th scope="row">The Between String:</th>';
					echo '<td><input type=text value="'.$dbBsOptions['between'].'" name="bs_between">
					<p class=\'help\'>This string is printed between browser name and OS name. Default is "on".
					</p></td></tr>';

					// After String
					echo '<tr valign="top"><th scope="row">The After String:</th>';
					echo '<td><input type=text value="'.$dbBsOptions['after'].'" name="bs_after">
					<p class=\'help\'>This string is printed after everything. Default is blank.
					</p></td></tr>';
					
					// Show Icons
					echo '<tr valign="top"><th scope="row">Show Icons?</th>';
					echo '<td valign="top"><input type=radio value="true" name="bs_show_icons" ';
						if ($dbBsOptions['show_icons'] == "true") {
							echo 'checked ';
						} 
					
					echo '>Yes, show them! &nbsp; <input type=radio value="false" name="bs_show_icons" ';
						if ($dbBsOptions['show_icons'] == "false") {
							echo 'checked ';
						} 
					echo 	' />No, do not show them.</b>
					<p class=\'help\'>If you choose not to show, put a space after the Before String, otherwise the Browser Name will be "glued" with the Before String.</p></td></tr>';
					
					// show position
					echo '<tr valign="top"><th scope="row">Show position:</th>';
					echo '<td valign="top"><input type=radio value="automagically" name="bs_position" ';
						if ($dbBsOptions['position'] == "automagically") {
							echo 'checked ';
						} 
					
					echo '>Automagically add on the start of each comment &nbsp; <input type=radio value="manually" name="bs_position" ';
						if ($dbBsOptions['position'] == "manually") {
							echo 'checked ';
						} 
					echo 	' />I\'ll manually add the hook pri_print_browser() to my theme</b>
					<p class=\'help\'>Choosing automagically will put the "sniff" right on the beginning of each comment. Choose this if you are not familiar with theme editing. Otherwise, choose manually and hook all by yourself :)</p></td></tr>';
					
					
					echo '<input type="hidden" name="bs_submit" value="true"></input>
					</table>
					
					<p class="submit"><input type="submit" value="Save Options &raquo;"></input></p></form>
					';
				
				
				
				echo '
				<table cellspacing="10">
				<tr>
				<td style="width:50%" valign="top">
				<div>
				If you wanto to know more about Browser Sniff, it\'s functions and the authors, visit <a href="http://brunopedrassani.com/" target="_blank">http://brunopedrassani.com/</a><br />
				</div>
				</td>
				</tr>
				</table>
			';

	echo "</div>";
	echo '</form></div>';
}

function addbssubmenu() {
    add_submenu_page('plugins.php', 'Browser Sniff', 'Browser Sniff', 10, __FILE__, 'bs_options'); 
}
add_action('admin_menu', 'addbssubmenu');

// ####################################################### End adding options page ##############################################

// ###################################### Printing and core functions ###########################################################

function pri_print_browser ($before = '', $after = '', $image = "true", $between = 'on') {
	global $user_ID, $post, $comment;

	$dbBsOptions = unserialize(get_option('bs_options'));

	$before=$dbBsOptions['before'];
	$between=$dbBsOptions['between'];
	$after=$dbBsOptions['after'];
	$image=$dbBsOptions['show_icons'];

	get_currentuserinfo();
	if (!$comment->comment_agent) {
		return;
	}
	if (user_can_edit_post_comments($user_ID, $post->ID)) {
		$uastring = " <a href='#' title='" .htmlspecialchars($comment->comment_agent). "'>*</a>";
	}
	$string = pri_browser_string($comment->comment_agent, $image, $between);
	echo $before . $string . $uastring . $after;
}

function pri_browser_string($ua, $image = "true", $between = 'on') {
	list(  $browser_name, $browser_code, $browser_ver, $os_name, $os_code, $os_ver,
		$pda_name, $pda_code, $pda_ver ) = pri_detect_browser($ua);
	$string = pri_friendly_string($browser_name, $browser_code, $browser_ver, $os_name, $os_code, $os_ver,
		$pda_name, $pda_code, $pda_ver, $image, $between);
	if (!$string) {
		$string = "Unknown browser";
	}
	return $string;
}

function pri_get_image_url ($code, $alt) {
	global $pri_image_url, $pri_image_path;
	
	$dbBsOptions = unserialize(get_option('bs_options'));

	$alt = htmlspecialchars($alt);
	$code = htmlspecialchars($code);
	if (file_exists("$pri_image_path/$code.png")) {
		return " <img src='$pri_image_url/$code.png' alt='$alt' width='".$dbBsOptions['width']."' height='".$dbBsOptions['height']."' class='browsericon' /> ";
	} else {
		return " ";
	}
}

function pri_friendly_string (	$browser_name = '', $browser_code = '', $browser_ver = '',
				$os_name = '', $os_code = '', $os_ver = '',
				$pda_name= '', $pda_code = '', $pda_ver = '', $image = "true", $between = 'on' )
{	
	$out = '';
	$browser_name = htmlspecialchars($browser_name);
	$browser_code = htmlspecialchars($browser_code);
	$browser_ver = htmlspecialchars($browser_ver);
	$os_name = htmlspecialchars($os_name);
	$os_code = htmlspecialchars($os_code);
	$os_ver = htmlspecialchars($os_ver);
	$pda_name = htmlspecialchars($pda_name);
	$pda_code = htmlspecialchars($pda_code);
	$pda_ver = htmlspecialchars($pda_ver);
	$between = htmlspecialchars($between);
	if ($browser_name && $pda_name) {
		if ($image == "true") $out .= pri_get_image_url($browser_code, $browser_name);
		$out .= "$browser_name";
		if ($browser_ver) {
			$out .= " $browser_ver";
		}
		$out .= " $between ";
		if ($image == "true") $out .= pri_get_image_url($pda_code, $pda_name);
		$out .= " $pda_name";
		if ($pda_ver) {
			$out .= " $pda_ver";
		}
	} elseif ($browser_name && $os_name) {
		if ($image == "true") $out .= pri_get_image_url($browser_code, $browser_name);
		$out .= "$browser_name";
		if ($browser_ver) {
			$out .= " $browser_ver";
		}
		$out .= " $between ";
		if ($image == "true") $out .= pri_get_image_url($os_code, $os_name);
		$out .= " $os_name";
		if ($os_ver) {
			$out .= " $os_ver";
		}
	} elseif ($browser_name) {
		if ($image == "true") $out .= pri_get_image_url($browser_code, $browser_name);
		$out .= "$browser_name";
		if ($browser_ver) {
			$out .= " $browser_ver";
		}
	} elseif ($os_name) {
		if ($image == "true") $out .= pri_get_image_url($os_code, $os_name);
		$out .= "$os_name";
		if ($os_ver) {
			$out .= " $os_ver";
		}
	} elseif ($pda_name) {
		if ($image == "true") $out .= pri_get_image_url($pda_code, $pda_name);
		$out .= "$pda_name";
		if ($pda_ver) {
			$out .= " $pda_ver";
		}
	}
	return $out;
}

// ###################################### End of Printing and core functions ####################################################

// ##################################### Detections functions and UAs ###########################################################

function pri_detect_browser ($ua) {
	$ua = preg_replace("/FunWebProducts/i", "", $ua);
	if (preg_match('#MovableType[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'MovableType';
		$browser_code = 'mt';
		$browser_ver = $matches[1];
	} elseif (preg_match('#WordPress[ /]([a-zA-Z0-9.]*)#i', $ua, $matches)) {
		$browser_name = 'WordPress';
		$browser_code = 'wp';
		$browser_ver = $matches[1];
	} elseif (preg_match('#typepad[ /]([a-zA-Z0-9.]*)#i', $ua, $matches)) {
		$browser_name = 'TypePad';
		$browser_code = 'typepad';
		$browser_ver = $matches[1];
	} elseif (preg_match('#drupal#i', $ua)) {
		$browser_name = 'Drupal';
		$browser_code = 'drupal';
		$browser_ver = $matches[1];
	} elseif (preg_match('#avantbrowser#i', $ua) || preg_match('#Avant Browser#i', $ua)) {
		$browser_name = 'Avant Browser';
		$browser_code = 'avantbrowser';
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		}
	} elseif (preg_match('#(Camino|Chimera)[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Camino';
		$browser_code = 'camino';
		$browser_ver = $matches[2];
		$os_name = "Mac OS";
		$os_code = "macos";
		$os_ver = "X";
	} elseif (preg_match('#anonymouse#i', $ua, $matches)) {
		$browser_name = 'Anonymouse';
		$browser_code = 'anonymouse';
	} elseif (preg_match('#PHP#', $ua, $matches)) {
		$browser_name = 'PHP';
		$browser_code = 'php';
	} elseif (preg_match('#danger hiptop#i', $ua, $matches)) {
		$browser_name = 'Danger HipTop';
		$browser_code = 'danger';
	} elseif (preg_match('#w3m/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'W3M';
		$browser_ver = $matches[1];
	} elseif (preg_match('#Shiira[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Shiira';
		$browser_code = 'shiira';
		$browser_ver = $matches[2];
		$os_name = "Mac OS";
		$os_code = "macos";
		$os_ver = "X";
	} elseif (preg_match('#Dillo[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Dillo';
		$browser_code = 'dillo';
		$browser_ver = $matches[1];
	} elseif (preg_match('#Epiphany/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Epiphany';
		$browser_code = 'epiphany';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
	} elseif (preg_match('#UP.Browser/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Openwave UP.Browser';
		$browser_code = 'openwave';
		$browser_ver = $matches[1];
	} elseif (preg_match('#DoCoMo/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'DoCoMo';
		$browser_code = 'docomo';
		$browser_ver = $matches[1];
		if ($browser_ver == '1.0') {
			preg_match('#DoCoMo/([a-zA-Z0-9.]+)/([a-zA-Z0-9.]+)#i', $ua, $matches);
			$browser_ver = $matches[2];
		} elseif ($browser_ver == '2.0') {
			preg_match('#DoCoMo/([a-zA-Z0-9.]+) ([a-zA-Z0-9.]+)#i', $ua, $matches);
			$browser_ver = $matches[2];
		}
	} elseif (preg_match('#(bonecho)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Unbranded Firefox';
		$browser_code = 'bonecho';
		$browser_ver = $matches[2];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#(iceweasel)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Debian IceWeasel';
		$browser_code = 'iceweasel';
		$browser_ver = $matches[2];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#(SeaMonkey)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Mozilla SeaMonkey';
		$browser_code = 'seamonkey';
		$browser_ver = $matches[2];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#Kazehakase/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Kazehakase';
		$browser_code = 'kazehakase';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#Flock/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Flock';
		$browser_code = 'flock';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#(Firefox|Phoenix|Firebird)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Mozilla Firefox';
		$browser_code = 'firefox';
		$browser_ver = $matches[2];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Google Chrome';
		$browser_code = 'google_chrome';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#Minimo/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Minimo';
		$browser_code = 'mozilla';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#MultiZilla/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'MultiZilla';
		$browser_code = 'mozilla';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('/PSP \(PlayStation Portable\)\; ([a-zA-Z0-9.]+)/', $ua, $matches)) {
		$pda_name = "Sony PSP";
		$pda_code = "sony-psp";
		$pda_ver = $matches[1];
	} elseif (preg_match('#Galeon/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Galeon';
		$browser_code = 'galeon';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
	} elseif (preg_match('#iCab/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'iCab';
		$browser_code = 'icab';
		$browser_ver = $matches[1];
		$os_name = "Mac OS";
		$os_code = "macos";
		if (preg_match('#Mac OS X#i', $ua)) {
			$os_ver = "X";
		}
	} elseif (preg_match('#K-Meleon/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'K-Meleon';
		$browser_code = 'kmeleon';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#Lynx/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Lynx';
		$browser_code = 'lynx';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
	} elseif (preg_match('#Links \\(([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Links';
		$browser_code = 'lynx';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
	} elseif (preg_match('#ELinks[/ ]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'ELinks';
		$browser_code = 'lynx';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
	} elseif (preg_match('#ELinks \\(([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'ELinks';
		$browser_code = 'lynx';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
	} elseif (preg_match('#Konqueror/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Konqueror';
		$browser_code = 'konqueror';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		if (!$os_name) {
			list($os_name, $os_code, $os_ver) = pri_pda_detect_os($ua);
		}
	} elseif (preg_match('#NetPositive/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'NetPositive';
		$browser_code = 'netpositive';
		$browser_ver = $matches[1];
		$os_name = "BeOS";
		$os_code = "beos";
	} elseif (preg_match('#OmniWeb#i', $ua)) {
		$browser_name = 'OmniWeb';
		$browser_code = 'omniweb';
		$os_name = "Mac OS";
		$os_code = "macos";
		$os_ver = "X";
	} elseif (preg_match('#Android#i', $ua)) {
		$browser_name = 'Android Browser';
		$browser_code = 'android_browser';
		$browser_ver = "";
		list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
	} elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Safari';
		$browser_code = 'safari';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
		if (!$os_name) {
			list($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver) = pri_pda_detect_os($ua);
		}
	} elseif (preg_match('#NetNewsWire/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'NetNewsWire';
		$browser_code = 'netnewswire';
		$browser_ver = $matches[1];
		$os_name = "Mac OS";
		$os_code = "macos";
		$os_ver = "X";
	} elseif (preg_match('#Opera (Mini|Mobile)/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Opera Mini/Mobile';
		$browser_code = 'opera';
		$browser_ver = $matches[2];
		list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		if (!$os_name) {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
		if (!$os_name) {
			list($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver) = pri_pda_detect_os($ua);
		}
	} elseif (preg_match('#Opera[ /]([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Opera';
		$browser_code = 'opera';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		if (!$os_name) {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
		if (!$os_name) {
			list($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver) = pri_pda_detect_os($ua);
		}
	} elseif (preg_match('#WebPro/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'WebPro';
		$browser_code = 'webpro';
		$browser_ver = $matches[1];
		$os_name = "PalmOS";
		$os_code = "palmos";
	} elseif (preg_match('#WebPro#i', $ua, $matches)) {
		$browser_name = 'WebPro';
		$browser_code = 'webpro';
		$os_name = "PalmOS";
		$os_code = "palmos";
	} elseif (preg_match('#Netfront/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Netfront';
		$browser_code = 'netfront';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver) = pri_pda_detect_os($ua);
	} elseif (preg_match('#Xiino/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Xiino';
		$browser_code = 'xiino';
		$browser_ver = $matches[1];
	} elseif (preg_match('#Blackberry([0-9]+)#i', $ua, $matches)) {
		$pda_name = "Blackberry";
		$pda_code = "blackberry";
		$pda_ver = $matches[1];
	} elseif (preg_match('#Blackberry#i', $ua)) {
		$pda_name = "Blackberry";
		$pda_code = "blackberry";
	} elseif (preg_match('#SPV ([0-9a-zA-Z.]+)#i', $ua, $matches)) {
		$pda_name = "Orange SPV";
		$pda_code = "orange";
		$pda_ver = $matches[1];
	} elseif (preg_match('#LGE-([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "LG";
		$pda_code = 'lg';
		$pda_ver = $matches[1];
	} elseif (preg_match('#MOT-([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "Motorola";
		$pda_code = 'motorola';
		$pda_ver = $matches[1];
	} elseif (preg_match('#Nokia ?([0-9]+)#i', $ua, $matches)) {
		$pda_name = "Nokia";
		$pda_code = "nokia";
		$pda_ver = $matches[1];
	} elseif (preg_match('#NokiaN-Gage#i', $ua)) {
		$pda_name = "Nokia";
		$pda_code = "nokia";
		$pda_ver = "N-Gage";
	} elseif (preg_match('#Blazer[ /]?([a-zA-Z0-9.]*)#i', $ua, $matches)) {
		$browser_name = "Blazer";
		$browser_code = "blazer";
		$browser_ver = $matches[1];
		$os_name = "Palm OS";
		$os_code = "palm";
	} elseif (preg_match('#SIE-([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "Siemens";
		$pda_code = "siemens";
		$pda_ver = $matches[1];
	} elseif (preg_match('#SEC-([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "Samsung";
		$pda_code = "samsung";
		$pda_ver = $matches[1];
	} elseif (preg_match('#SAMSUNG-(S.H-[a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "Samsung";
		$pda_code = "samsung";
		$pda_ver = $matches[1];
	} elseif (preg_match('#SonyEricsson ?([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "SonyEricsson";
		$pda_code = "sonyericsson";
		$pda_ver = $matches[1];
	} elseif (preg_match('#(j2me|midp)#i', $ua)) {
		$browser_name = "J2ME/MIDP Browser";
		$browser_code = "j2me";
	} elseif (preg_match('#IEMobile ([a-zA-Z0-9.]+)#i', $ua, $matches) || preg_match('#IEMobile/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'IE Mobile';
		$browser_code = 'ie';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver) = pri_windows_detect_os($ua);
	} elseif (preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Internet Explorer';
		$browser_code = 'ie';
		$browser_ver = $matches[1];
		list($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver) = pri_windows_detect_os($ua);
	} elseif (preg_match('#Netscape[0-9]?/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Netscape';
		$browser_code = 'netscape';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#^Mozilla/5.0#i', $ua) && preg_match('#rv:([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Mozilla';
		$browser_code = 'mozilla';
		$browser_ver = $matches[1];
		if (preg_match('/Windows/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
		}
	} elseif (preg_match('#^Mozilla/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$browser_name = 'Netscape Navigator';
		$browser_code = 'netscape';
		$browser_ver = $matches[1];
		if (preg_match('/Win/i', $ua)) {
			list($os_name, $os_code, $os_ver) = pri_windows_detect_os($ua);
		} else {
			list($os_name, $os_code, $os_ver) = pri_unix_detect_os($ua);
			if ($os_code == "macos") {
				$browser_name = '';
				$browser_code = '';
				$browser_ver = '';
			}
		}
	} 
	/* vars:
		$browser_name
		$browser_code
		$browser_ver
		$os_name
		$os_code
		$os_ver
		$pda_name
		$pda_code
		$pda_ver
	*/
	return array(  $browser_name, $browser_code, $browser_ver, $os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver );
									
}

function pri_windows_detect_os ($ua) {
	if (preg_match('/Windows 95/i', $ua) || preg_match('/Win95/', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "95";
	} elseif (preg_match('/Windows NT 5.0/i', $ua) || preg_match('/Windows 2000/i', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "2000";
	#} elseif (preg_match('/Win 9x 4.90/i', $ua) && preg_match('/Windows 98/i', $ua)) {
	} elseif (preg_match('/Win 9x 4.90/i', $ua) || preg_match('/Windows ME/i', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "ME";
	} elseif (preg_match('/Windows.98/i', $ua) || preg_match('/Win98/i', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "98";
	} elseif (preg_match('/Windows NT 6.0/i', $ua)) {
		$os_name = "Windows";
		$os_code = "win_vista";
		$os_ver = "Vista";
	} elseif (preg_match('/Windows NT 6.1/i', $ua)) {
		$os_name = "Windows";
		$os_code = "win_7";
		$os_ver = "7";
	} elseif (preg_match('/Windows NT 5.1/i', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "XP";
	} elseif (preg_match('/Windows NT 5.2/i', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		if (preg_match('/Win64/i', $ua)) {
			$os_ver = "XP 64 bit";
		} else {
			$os_ver = "Server 2003";
		}
	} elseif (preg_match('/Mac_PowerPC/i', $ua)) {
		$os_name = "Mac OS";
		$os_code = "macos";
	} elseif (preg_match('/Windows NT 4.0/i', $ua) || preg_match('/WinNT4.0/i', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "NT 4.0";
	} elseif (preg_match('/Windows NT/i', $ua) || preg_match('/WinNT/i', $ua)) {
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "NT";
	} elseif (preg_match('#Windows Phone OS ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$os_name = "Windows Phone OS";
		$os_code = "windowsphone";
		$os_ver = $matches[1];
	} elseif (preg_match('/Windows CE/i', $ua)) {
		list($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver) = pri_pda_detect_os($ua);
		$os_name = "Windows";
		$os_code = "windows";
		$os_ver = "CE";
		if (preg_match('/PPC/i', $ua)) {
			$os_name = "Microsoft PocketPC";
			$os_code = "windows";
			$os_ver = '';
		}
		if (preg_match('/smartphone/i', $ua)) {
			$os_name = "Microsoft Smartphone";
			$os_code = "windows";
			$os_ver = '';
		}
		if (preg_match('#ZuneHD ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$os_name = "ZuneHD";
			$os_code = "zunehd";
			$os_ver = $matches[1];
		}
	}
	return array($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver);
}

function pri_unix_detect_os ($ua) {
	if (preg_match('/Linux/i', $ua)) {
		$os_name = "Linux";
		$os_code = "linux";
		if (preg_match('#Mandrake#i', $ua)) {
			$os_code = "mandrake";
			$os_name = "Mandrake Linux";
		} elseif (preg_match('#SuSE#i', $ua)) {
			$os_code = "suse";
			$os_name = "SuSE Linux";
		} elseif (preg_match('#Novell#i', $ua)) {
			$os_code = "novell";
			$os_name = "Novell Linux";
		} elseif (preg_match('#kubuntu#i', $ua)) {
			$os_code = "kubuntu";
			$os_name = "Kubuntu Linux";
		} elseif (preg_match('#xubuntu#i', $ua)) {
			$os_code = "xubuntu";
			$os_name = "Xubuntu Linux";
		} elseif (preg_match('#Edubuntu#i', $ua)) {
			$os_code = "edubuntu";
			$os_name = "Edubuntu Linux";
		} elseif (preg_match('#Ubuntu#i', $ua)) {
			$os_code = "ubuntu";
			$os_name = "Ubuntu Linux";
		} elseif (preg_match('#Debian#i', $ua)) {
			$os_code = "debian";
			$os_name = "Debian GNU/Linux";
		} elseif (preg_match('#Red ?Hat#i', $ua)) {
			$os_code = "redhat";
			$os_name = "RedHat Linux";
		} elseif (preg_match('#Gentoo#i', $ua)) {
			$os_code = "gentoo";
			$os_name = "Gentoo Linux";
		} elseif (preg_match('#Fedora#i', $ua)) {
			$os_code = "fedora";
			$os_name = "Fedora Linux";
		} elseif (preg_match('#MEPIS#i', $ua)) {
			$os_name = "MEPIS Linux";
		} elseif (preg_match('#Knoppix#i', $ua)) {
			$os_name = "Knoppix Linux";
		} elseif (preg_match('#Slackware#i', $ua)) {
			$os_code = "slackware";
			$os_name = "Slackware Linux";
		} elseif (preg_match('#Xandros#i', $ua)) {
			$os_name = "Xandros Linux";
		} elseif (preg_match('#Kanotix#i', $ua)) {
			$os_name = "Kanotix Linux";
		} elseif (preg_match('#Android ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
			$os_name = "Android";
			$os_ver = $matches[1];
			$os_code = "android";
		}
	} elseif (preg_match('/FreeBSD/i', $ua)) {
		$os_name = "FreeBSD";
		$os_code = "freebsd";
	} elseif (preg_match('/NetBSD/i', $ua)) {
		$os_name = "NetBSD";
		$os_code = "netbsd";
	} elseif (preg_match('/OpenBSD/i', $ua)) {
		$os_name = "OpenBSD";
		$os_code = "openbsd";
	} elseif (preg_match('/IRIX/i', $ua)) {
		$os_name = "SGI IRIX";
		$os_code = "sgi";
	} elseif (preg_match('/SunOS/i', $ua)) {
		$os_name = "Solaris";
		$os_code = "sun";
	} elseif (preg_match('/iPhone/i', $ua) || preg_match('/iPad/i', $ua) || preg_match('/iPod/i', $ua) ) {
		list($os_name, $os_code, $os_ver) = pri_detect_apple_device($ua);
	} elseif (preg_match('/Mac OS X/i', $ua)) {
		$os_name = "Mac OS";
		$os_code = "macos";
		$os_ver = "X";
	} elseif (preg_match('/Macintosh/i', $ua)) {
		$os_name = "Mac OS";
		$os_code = "macos";
	} elseif (preg_match('/Unix/i', $ua)) {
		$os_name = "UNIX";
		$os_code = "unix";
	} elseif (preg_match('#webOS/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$os_name = "webOS";
		$os_ver = $matches[1];
		$os_code = "webos";
	}
	return array($os_name, $os_code, $os_ver);
}

function pri_pda_detect_os ($ua) {
	if (preg_match('#PalmOS#i', $ua)) {
		$os_name = "Palm OS";
		$os_code = "palm";
	} elseif (preg_match('#Windows CE#i', $ua)) {
		$os_name = "Windows CE";
		$os_code = "windows";
	} elseif (preg_match('#QtEmbedded#i', $ua)) {
		$os_name = "Qtopia";
		$os_code = "linux";
	} elseif (preg_match('#Zaurus#i', $ua)) {
		$os_name = "Linux";
		$os_code = "linux";
	} elseif (preg_match('#symbianos/([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$os_name = "SymbianOS";
		$os_ver = $matches[1];
		$os_code = 'symbian';
	} elseif (preg_match('#Symbian#i', $ua)) {
		$os_name = "Symbian OS";
		$os_code = "symbian";
	}

	if (preg_match('#PalmOS/sony/model#i', $ua)) {
		$pda_name = "Sony Clie";
		$pda_code = "sony";
	} elseif (preg_match('#Zaurus ([a-zA-Z0-9.]+)#i', $ua, $matches)) {
		$pda_name = "Sharp Zaurus " . $matches[1];
		$pda_code = "zaurus";
		$pda_ver = $matches[1];
	} elseif (preg_match('#Series ([0-9]+)#i', $ua, $matches)) {
		$pda_name = "Series";
		$pda_code = "nokia";
		$pda_ver = $matches[1];
	} elseif (preg_match('#Nokia ([0-9]+)#i', $ua, $matches)) {
		$pda_name = "Nokia";
		$pda_code = "nokia";
		$pda_ver = $matches[1];
	} elseif (preg_match('#SIE-([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "Siemens";
		$pda_code = "siemens";
		$pda_ver = $matches[1];
	} elseif (preg_match('#dopod([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "Dopod";
		$pda_code = "dopod";
		$pda_ver = $matches[1];
	} elseif (preg_match('#o2 xda ([a-zA-Z0-9 ]+);#i', $ua, $matches)) {
		$pda_name = "O2 XDA";
		$pda_code = "o2";
		$pda_ver = $matches[1];
	} elseif (preg_match('#SEC-([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "Samsung";
		$pda_code = "samsung";
		$pda_ver = $matches[1];
	} elseif (preg_match('#SonyEricsson ?([a-zA-Z0-9]+)#i', $ua, $matches)) {
		$pda_name = "SonyEricsson";
		$pda_code = "sonyericsson";
		$pda_ver = $matches[1];
	} elseif (preg_match('#Wii#i', $ua, $matches)) {
		$pda_name = "Nintendo Wii";
		$pda_code = "wii";
	}
	return array($os_name, $os_code, $os_ver, $pda_name, $pda_code, $pda_ver);
}

function pri_detect_apple_device( $ua ){
	if (preg_match('#iPod#i', $ua ) && preg_match('#OS ([a-zA-Z0-9_]+)#i', $ua, $matches)) {
		$os_ver = str_replace('_','.',$matches[1]);
		$os_name = "iOS";
		$os_code = "macos";
	}
	elseif (preg_match('#iPod#i', $ua )) {
		$os_ver = "";
		$os_name = "iPod";
		$os_code = "macos";
	}
	elseif (preg_match('#iPhone OS ([a-zA-Z0-9_]+)#i', $ua, $matches)) {
		$os_ver = str_replace('_','.',$matches[1]);
		$os_name = "iPhone OS";
		$os_code = "macos";
	}
	elseif (preg_match('#iPhone#i', $ua )) {
		$os_ver = "";
		$os_name = "iPhone";
		$os_code = "macos";
	}
	elseif (preg_match('#iPad#i', $ua ) && preg_match('#OS ([a-zA-Z0-9_]+)#i', $ua, $matches)) {
		$os_ver = str_replace('_','.',$matches[1]);
		$os_name = "iPad";
		$os_code = "macos";
	}
	elseif (preg_match('#iPad#i', $ua )) {
		$os_ver = "";
		$os_name = "iPad";
		$os_code = "macos";
	}

	return array($os_name, $os_code, $os_ver);
}

// ############################# End of Detections functions and UAs ###########################################################

// ############################### This is only if you do not want to edit your template #######################################

function add_automagically($content) {
	$addin=pri_print_browser();
	$content=" ".$addin."\n".$content;
	return $content;
}

$dbBsOptions = unserialize(get_option('bs_options'));

if (!$dbBsOptions['position'] OR $dbBsOptions['position'] == 'automagically') {
	add_filter('comment_text','add_automagically');
}

// ######################################## End of Laziness :D #################################################################