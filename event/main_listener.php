<?php
/**
 *
 * Obvious Delete Cookies Link. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2026, Zebulan Stanphill
 * @license GNU General Public License, version 2 or later (GPL-2.0-or-later)
 *
 */

namespace zebulanstanphill\obviousdeletecookieslink\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected const HINT_TEMPLATE = '@zebulanstanphill_obviousdeletecookieslink/login_delete_cookies_hint.html';

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \Twig\Loader\LoaderInterface */
	protected $twig_loader;

	/** @var \zebulanstanphill\obviousdeletecookieslink\helper\browser_docs */
	protected $browser_docs;

	public function __construct(\phpbb\language\language $language, \phpbb\request\request_interface $request, \phpbb\template\template $template, \Twig\Loader\LoaderInterface $twig_loader, \zebulanstanphill\obviousdeletecookieslink\helper\browser_docs $browser_docs)
	{
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->twig_loader = $twig_loader;
		$this->browser_docs = $browser_docs;
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

		$clear_data_url = $this->browser_docs->get_clear_data_url($this->request->header('User-Agent'));
		$template_data['OBVIOUSDELETECOOKIESLINK_U_CLEAR_BROWSER_DATA'] = utf8_htmlspecialchars($clear_data_url);

		$event['login_box_template_data'] = $template_data;
	}
}
