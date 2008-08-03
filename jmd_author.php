<?php
$plugin = array(
    'description' => "Provides access to an author's username and email.",
    'type' => 0,
    'version' => '0.2',
);
if (!defined('txpinterface')) include_once '../zem_tpl.php';

if (0) {
?>
# --- BEGIN PLUGIN HELP ---

h1. jmd_author

"Forum thread":http://forum.textpattern.com/viewtopic.php?id=26080, "hg repo":http://www.bitbucket.org/jmdeldin/jmd_author/

This plugin provides access to an author's username and email address. It can also modify the output of an author's name with case and/or separators.

h2(#attributes). @<txp:jmd_author/>@ attributes

|_. Attribute |_. Available values |_. Default value |_. Description |
| @display@ | @email@, @name@, @username@ | @username@ | Outputs an available value |
| @lowercase@ | @0@, @1@ | @0@ | Lowercases @display@ text |
| @separator@ | @*@ | @' '@ | Replaces spaces in @display@ with any character |

h2(#examples). Examples

* Username
** @<txp:jmd_author/>@
* Link to author profile
** @<txp:site_url/>staff/<txp:jmd_author display="name" lowercase="1" separator="-"/>@
* Email address
** @<txp:jmd_author display="email"/>@
* Author profiles
** "TextBook article":http://textpattern.net/wiki/index.php?title=Author_profiles

# --- END PLUGIN HELP ---
<?php
}

# --- BEGIN PLUGIN CODE ---

if (txpinterface === 'public')
{
    global $textarray;
    $l10n = array(
        'jmd_author_invalid_display' => 'Invalid display value',
    );
    $textarray = array_merge($textarray, $l10n);
}

/**
 * Provides access to an author's username and email address.
 * Replaces the spaces in an author's real name with any character.
 *
 * @param array $atts
 * @param string $atts['display'] 'email', 'name', 'username'
 * @param bool $atts['lowercase'] Lowercases $display
 * @param string $atts['separator'] Replace spaces in $display with any char.
 */
function jmd_author($atts)
{
    global $thisarticle;
    extract(lAtts(array(
        'display' => 'username',
        'lowercase' => 0,
        'separator' => ' ',
    ), $atts));
    assert_article();
    $username = $thisarticle['authorid'];
    $name = get_author_name($username);
    $out = '';

    switch ($display)
    {
        case 'username':
            $out = $username;
            break;

        case 'email':
            $out = eE(safe_field("email", "txp_users", "name='$username'"));
            break;

        case 'name':
            $out = get_author_name($username);
            break;

        default:
            trigger_error(gTxt('jmd_author_invalid_display'));
    }

    if ($lowercase == 1)
    {
        $out = strtolower($out);
    }

    return str_replace(' ', $separator, $out);
}

# --- END PLUGIN CODE ---

?>
