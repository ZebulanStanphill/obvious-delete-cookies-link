<?php
/**
 *
 * Obvious Delete Cookies Link. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, Zebulan Stanphill
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace zebulanstanphill\obviousdeletecookieslink;

class ext extends \phpbb\extension\base
{
	/**
	 * Requires phpBB 3.3.0 or newer.
	 */
	public function is_enableable(): bool
	{
		return phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>=');
	}
}
