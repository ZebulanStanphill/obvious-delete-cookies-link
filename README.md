<img src="assets/icon.svg" width="64" height="64" alt="">

# Obvious Delete Cookies Link

A phpBB extension that adds a hint below the Login button on the login form:

> Having trouble logging in? Try <u>deleting site cookies</u> before logging in
> again. If this still doesn’t work, try <u>clearing all browser cache &
> cookies</u>.

- "deleting site cookies" is the board's standard delete cookies link, the same
  one as in the footer: it asks for confirmation, deletes the board's cookies
  and returns to the board index.
- "clearing all browser cache & cookies" links to the official instructions for
  the visitor's browser, which open in a new tab. If the browser isn't
  recognised, it's plain text.

## Browsers with instructions

The browser and platform are recognised from the browser's User-Agent. The
instructions are the vendors' own, and most of them are shown in the reader's
language:

| Browser          | Platforms                                        | Instructions |
| ---------------- | ------------------------------------------------ | ------------ |
| Chrome           | Windows, macOS, Linux, ChromeOS, Android, iOS     | [Google](https://support.google.com/accounts/answer/32050) |
| Edge             | Windows, macOS, Linux                            | [Microsoft](https://support.microsoft.com/edge/view-and-delete-browser-history-in-microsoft-edge) |
| Firefox          | Windows, macOS, Linux, Android, iOS               | [Mozilla](https://support.mozilla.org/kb/clear-cookies-and-site-data-firefox) |
| Opera            | Windows, macOS, Linux                            | [Opera](https://help.opera.com/latest/security-and-privacy/#clearBrowsingData) |
| Safari           | macOS, iPhone, iPad                              | [Apple](https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac) |
| Samsung Internet | Android                                          | [Samsung](https://www.samsung.com/us/support/answer/ANS10010562/) (English only) |

Edge on Android and iOS and Opera on Android have no such instructions, so
they get no link, like in-app browsers (such as Facebook's or Instagram's) and
other browsers. Browsers that send exactly Chrome's User-Agent, such as Brave,
Vivaldi and Arc, get Chrome's instructions. Safari on an iPad and Chrome on a
large Android tablet ask for desktop sites by default, with the same User-Agent
as on a computer, so they get the instructions for computers. Apple's
instructions link to the iPad version, and Google's have tabs for the other
platforms.

## Requirements

- phpBB 3.3.0 or later, including phpBB 4.0
- PHP 7.1.3 or later

## Installation

1. Copy the extension's files into `ext/zebulanstanphill/obviousdeletecookieslink/`
   in your board's directory, so that this README ends up at
   `ext/zebulanstanphill/obviousdeletecookieslink/README.md`.
2. In the ACP, go to **Customise → Manage extensions** and enable
   **Obvious Delete Cookies Link**.

To uninstall, disable the extension in the same place, then delete its data
and its directory. It doesn't store any data.

## Where the hint appears

The hint is shown on the board's login form: the login page, and the login
prompt of pages that require logging in. It isn't shown to bots, on the ACP's
re-authentication form, or in the board index's quick login box.

The login form has no template event below its Login button, so the extension
shows the hint in the space the form keeps for the authentication method's own
content. That content, such as the OAuth login buttons, is still shown below
the hint. The hint uses prosilver's form layout, so it lines up with the Login
button in prosilver and in styles based on it.

## Translations

Only English is included. To add a language, copy `language/en/` to
`language/<language code>/` and translate `common.php`.

## License

[GNU General Public License, version 2](license.txt)

Created in [T3 Code](https://t3.codes).
