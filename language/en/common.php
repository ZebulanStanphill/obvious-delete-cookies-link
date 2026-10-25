<?php
/**
 *
 * Obvious Delete Cookies Link. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, Zebulan Stanphill
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	// %1$s and %2$s wrap the link that deletes the board's cookies. %3$s and %4$s
	// wrap the link to the browser's instructions for clearing its cache and
	// cookies; they are empty when the browser isn't recognised.
	'OBVIOUSDELETECOOKIESLINK_LOGIN_HINT'	=> 'Having trouble logging in? Try %1$sdeleting site cookies%2$s before logging in again. If this still doesn’t work, try %3$sclearing all browser cache &amp; cookies%4$s.',
]);
