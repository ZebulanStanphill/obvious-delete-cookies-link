<?php
/**
 *
 * Obvious Delete Cookies Link. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, Zebulan Stanphill
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

namespace zebulanstanphill\obviousdeletecookieslink\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected const HINT_TEMPLATE = '@zebulanstanphill_obviousdeletecookieslink/login_delete_cookies_hint.html';

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \Twig\Loader\LoaderInterface */
	protected $twig_loader;

	public function __construct(\phpbb\language\language $language, \phpbb\template\template $template, \Twig\Loader\LoaderInterface $twig_loader)
	{
		$this->language = $language;
		$this->template = $template;
		$this->twig_loader = $twig_loader;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.login_box_modify_template_data' => 'add_delete_cookies_hint',
		];
	}

	/**
	 * Shows the delete cookies hint below the Login button of the login form.
	 *
	 * login_body.html has no template event below the Login button, but it does
	 * include the authentication provider's template (PROVIDER_TEMPLATE_FILE)
	 * right after it. The hint template takes over that slot and includes the
	 * provider's own template (e.g. the OAuth login buttons) after the hint.
	 */
	public function add_delete_cookies_hint(\phpbb\event\data $event): void
	{
		// A stale container can keep this listener registered after the extension
		// was disabled without purging the cache (e.g. from the CLI). Its template
		// namespace is gone by then, so leave the login form alone.
		if (!$this->twig_loader->exists(self::HINT_TEMPLATE))
		{
			return;
		}

		$this->language->add_lang('common', 'zebulanstanphill/obviousdeletecookieslink');

		$template_data = $event['login_box_template_data'];
		$provider_template_file = $template_data['PROVIDER_TEMPLATE_FILE'] ?? $this->template->retrieve_var('PROVIDER_TEMPLATE_FILE');

		$template_data['OBVIOUSDELETECOOKIESLINK_PROVIDER_TEMPLATE_FILE'] = $provider_template_file;
		$template_data['PROVIDER_TEMPLATE_FILE'] = self::HINT_TEMPLATE;

		$event['login_box_template_data'] = $template_data;
	}
}
