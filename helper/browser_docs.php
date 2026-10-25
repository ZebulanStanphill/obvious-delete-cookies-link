<?php
/**
 *
 * Obvious Delete Cookies Link. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, Zebulan Stanphill
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace zebulanstanphill\obviousdeletecookieslink\helper;

/**
 * Finds the browser vendor's documentation for clearing the cache and cookies.
 */
class browser_docs
{
	/**
	 * Patterns for the end of each browser's User-Agent.
	 *
	 * Browsers built on Chrome or Safari send their tokens too, but add their
	 * own, as do in-app browsers and web views. Matching the browser's exact
	 * ending keeps them from being taken for it. Order matters: most specific
	 * first.
	 */
	protected const BROWSER_PATTERNS = [
		'samsung'	=> '#\(KHTML, like Gecko\) SamsungBrowser/[\d.]+ Chrome/[\d.]+ (?:Mobile )?Safari/[\d.]+$#',
		'edge'		=> '#\bEdg(?:A|iOS)?/[\d.]+$|\(KHTML, like Gecko\) Version/[\d.]+ EdgiOS/[\d.]+(?: Mobile/\w+)? Safari/[\d.]+$#',
		'opera'		=> '#\bOPR/[\d.]+(?: \(Edition [^()]*\))?$#',
		'firefox'	=> '#\bGecko/[\d.]+ Firefox/[\d.]+$|\(KHTML, like Gecko\) FxiOS/[\d.]+(?: Mobile/\w+)? Safari/[\d.]+$#',
		'chrome'	=> '#\(KHTML, like Gecko\) Chrome/[\d.]+ (?:Mobile )?Safari/[\d.]+$|\(KHTML, like Gecko\) CriOS/[\d.]+(?: Version/[\d.]+)?(?: Mobile/\w+)? Safari/[\d.]+$#',
		'safari'	=> '#\(KHTML, like Gecko\) Version/[\d.]+(?: Mobile/\w+)? Safari/[\d.]+$#',
	];

	/**
	 * Official documentation for clearing the cache and cookies, by browser and
	 * platform. Where a site has translations, it redirects these URLs to the
	 * reader's language; the anchors only exist in the English pages, so the
	 * translations open at the top. There is no such documentation for Edge on
	 * Android or iOS, or for Opera on Android.
	 */
	protected const URLS = [
		'chrome'	=> [
			'desktop'	=> 'https://support.google.com/accounts/answer/32050?co=GENIE.Platform%3DDesktop',
			'android'	=> 'https://support.google.com/accounts/answer/32050?co=GENIE.Platform%3DAndroid',
			'iphone'	=> 'https://support.google.com/accounts/answer/32050?co=GENIE.Platform%3DiOS',
			'ipad'		=> 'https://support.google.com/accounts/answer/32050?co=GENIE.Platform%3DiOS',
		],
		'edge'		=> [
			'desktop'	=> 'https://support.microsoft.com/edge/view-and-delete-browser-history-in-microsoft-edge',
		],
		'firefox'	=> [
			'desktop'	=> 'https://support.mozilla.org/kb/clear-cookies-and-site-data-firefox#w_clear-all-cookies-site-data-and-cache',
			'android'	=> 'https://support.mozilla.org/kb/clear-your-browsing-history-and-other-personal-data#w_clear-cookies-files-and-other-browsing-data',
			'iphone'	=> 'https://support.mozilla.org/kb/clear-browsing-history-firefox-ios#w_clear-private-data',
			'ipad'		=> 'https://support.mozilla.org/kb/clear-browsing-history-firefox-ios#w_clear-private-data',
		],
		'opera'		=> [
			'desktop'	=> 'https://help.opera.com/latest/security-and-privacy/#clearBrowsingData',
		],
		'safari'	=> [
			'desktop'	=> 'https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac',
			'iphone'	=> 'https://support.apple.com/guide/iphone/clear-your-cache-and-cookies-iphacc5f0202/ios',
			'ipad'		=> 'https://support.apple.com/guide/ipad/clear-your-cache-and-cookies-ipad0bb843d8/ipados',
		],
		// Only available in English.
		'samsung'	=> [
			'android'	=> 'https://www.samsung.com/us/support/answer/ANS10010562/',
		],
	];

	/**
	 * Returns the URL of the documentation for clearing the cache and cookies in
	 * the browser that sent the User-Agent, or an empty string if it isn't known.
	 */
	public function get_clear_data_url(string $user_agent): string
	{
		$browser = $this->get_browser($user_agent);

		if ($browser === null)
		{
			return '';
		}

		return self::URLS[$browser][$this->get_platform($user_agent)] ?? '';
	}

	/**
	 * Returns the browser that sent the User-Agent (a key of BROWSER_PATTERNS),
	 * or null if it can't be told.
	 */
	public function get_browser(string $user_agent): ?string
	{
		foreach (self::BROWSER_PATTERNS as $browser => $pattern)
		{
			if (preg_match($pattern, $user_agent))
			{
				return $browser;
			}
		}

		return null;
	}

	/**
	 * Returns the platform of the User-Agent: 'iphone', 'ipad', 'android' or
	 * 'desktop'.
	 */
	public function get_platform(string $user_agent): string
	{
		// iPads ask for desktop sites by default, with a Mac's User-Agent. Other
		// browsers than Safari still give themselves away with their iOS token.
		if (preg_match('#\biPad\b|\bMacintosh\b.*\b(?:CriOS|EdgiOS|FxiOS)/#', $user_agent))
		{
			return 'ipad';
		}

		if (preg_match('#\b(?:iPhone|iPod)\b#', $user_agent))
		{
			return 'iphone';
		}

		if (preg_match('#\bAndroid\b#', $user_agent))
		{
			return 'android';
		}

		return 'desktop';
	}
}
