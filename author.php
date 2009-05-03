<?php
/**
 * @name            jmd_author
 * @description     Provides access to an author's username and email.
 * @author          Jon-Michael Deldin
 * @author_uri      http://jmdeldin.com
 * @version         0.3
 * @type            0
 * @order           5
 */

/**
 * Provides access to an author's username and email address.
 * Replaces the spaces in an author's real name with any character.
 *
 * @param array  $atts
 * @param string $atts['display']   'email', 'name', 'username'
 * @param bool   $atts['lowercase'] Lowercases $display
 * @param string $atts['separator'] Replace spaces in $display with any char.
 * @param string $atts['username']  Username to base output on. Default: 
 *                                  article author
 */
function jmd_author($atts)
{
    global $thisarticle;
    extract(lAtts(array(
        'display'   => 'username',
        'lowercase' => 0,
        'separator' => ' ',
        'username'  => $thisarticle['authorid'],
    ), $atts));

    $out = $username;
    switch ($display)
    {
        case 'email':
            $out = eE(safe_field("email", "txp_users", "name='$username'"));
            break;
        case 'name':
            $out = get_author_name($username);
            break;
        default:
    }

    if ($lowercase == 1)
        $out = strtolower($out);

    return str_replace(' ', $separator, $out);
}

