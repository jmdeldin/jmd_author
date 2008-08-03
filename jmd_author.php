<?php
$plugin = array(
    'description' => "Provides access to an author's username and email.",
    'type' => 0,
    'version' => '0.1',
);

if (!defined('txpinterface')) include_once '../zem_tpl.php';

if (0) {
?>
# --- BEGIN PLUGIN HELP ---

h1. jmd_author
	
This plugin provides access to an author's username and email address. It can also modify the output of an author's name with case and/or separators.

h2(#attributes). @<txp:jmd_author/>@ attributes

|_. Attribute name |_. Available values |_. Default value |_. Function |
| @email@ | 1, 0 | 0 | Displays the author's encoded email address |
| @real_name@ | 1, 0 | 0 | Displays the author's real name |
| @separator@ | * | " " | Replace spaces in an author's full name with any character |
| @lowercase@ | 1, 0 | 0 | Outputs lowercase text (username or full name) |

h2(#examples). Examples

* Username
** @<txp:jmd_author/>@
* Email
** @<txp:jmd_author email="1"/>@
* Real name
** @<txp:jmd_author real_name="1"/>@
* Lowercase real name, separated with underscores
** @<txp:jmd_author lowercase="1" real_name="1" separator="_"/>@

# --- END PLUGIN HELP ---

<?php
}

# --- BEGIN PLUGIN CODE ---

function jmd_author($atts)
{
	global $thisarticle;
	extract(lAtts(array(
		'email' => 0,
		'lowercase' => 0,
		'separator' => ' ',
		'real_name' => 0,
	), $atts));
	assert_article();
	$username = $thisarticle['authorid'];
	$full_name = get_author_name($username);

	if ($email == 1)
	{
		$email = eE(safe_field("email", "txp_users", "name='$username'"));
		$out = $email;
	}
	elseif ($real_name == 1)
	{
		if ($lowercase == 1)
		{
			$full_name = strtolower($full_name);
		}
		$out = str_replace(' ', $separator, $full_name);
	}
	else
	{
		$out = $username;
	}
	
	return $out;
}

# --- END PLUGIN CODE ---

?>
