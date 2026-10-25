# Working in this repo

This is a phpBB extension, `zebulanstanphill/obviousdeletecookieslink`. The
repository root is the extension's root: boards install it as
`ext/zebulanstanphill/obviousdeletecookieslink/`.

## Commit early, commit often

- Always commit your changes. Uncommitted work is lost work.
- Keep commits digestible: one logical change per commit, with a message that
  says what changed and why. Prefer several small commits over one large one.
- Commit as soon as a step is working, before moving on to the next step.
- Include a change's documentation (`README.md`, this file) in the same commit
  as the change. Split unrelated changes into separate commits, even when
  they're made in the same session.

## Versioning

The version is defined only in `composer.json` (`version`, with the release
date in `time`). Every commit that changes the extension's code or behavior
(PHP, templates, language files, `config/`) must bump it in that same commit,
following [Semantic Versioning](https://semver.org): patch for fixes, minor for
new features or changed behavior, major for incompatible changes such as
dropping support for a phpBB or PHP version. Commits that only change
documentation or agent instructions don't need a bump.

## Commit attribution

Every commit created or amended with agent assistance must name the agents and
models that contributed in the commit message. Use the body or trailers; keep the
subject focused on the change. List each participating agent and its actual model,
and preserve existing attribution when amending a commit.

For example:

```text
Agent: Claude Code (Opus 5.5)
Model: claude-opus-5-5
```

Preserve the human Git author identity. Do not invent model names or attribute
earlier work to the current agent.

## Delegating work

To reduce token usage, a more capable agent should hand routine work to
subagents rather than doing it itself, and keep the design decisions, reviews
and replies to the user. Give each subagent a self-contained brief: the
settled design, constraints, and the commit attribution to use.

- Menial tasks (mechanical edits, searches, log extraction, documentation
  updates): prefer Haiku 5.5, falling back to the latest GPT Luna model.
- Medium tasks (implementing a settled design, focused fixes, writing tests):
  prefer GPT-6.1-Sol, falling back to Sonnet 5.5.

When a task splits into independent pieces (different files, different
concerns), run the subagents concurrently. Give each a narrow, explicit brief:
the goal, the files it owns, what has already been ruled out, and how to verify
its work. Avoid having two agents edit the same file at the same time; if that
is unavoidable, use an isolated worktree per agent and merge afterwards.

Review a subagent's changes before committing or pushing them.

## Compatibility

- The extension supports phpBB 3.3.0 or later, including phpBB 4.0, on PHP
  7.1.3 or later. Keep the PHP compatible with PHP 7.1: no typed properties,
  union types, constructor property promotion, `match`, enums or named
  arguments.
- Declare the return types that Symfony and phpBB document, such as
  `getSubscribedEvents(): array`, even where their interfaces don't declare
  them yet. phpBB 4.0 runs Symfony's DebugClassLoader on every request, which
  reports missing ones as deprecations.
- `login_body.html` has no template event below the Login button, so the hint
  is rendered in the login form's authentication provider slot
  (`PROVIDER_TEMPLATE_FILE`); see `event/main_listener.php`. The provider's
  own template (e.g. OAuth login buttons) must still be included after the
  hint.

## Testing

Test on throwaway boards, never on a real one:

- Use the latest phpBB 3.3.x and 4.0 releases from
  <https://download.phpbb.com/pub/release/>, plus phpBB's `master` branch (run
  `composer install --no-dev` in its `phpBB/` directory). Put each in a
  temporary directory, install it with SQLite through
  `php install/phpbbcli.php install <config.yml>` (see
  `docs/install-config.sample.yml`), then delete its `install/` directory.
- Copy this repository into the board's
  `ext/zebulanstanphill/obviousdeletecookieslink/`, enable it with
  `php bin/phpbbcli.php extension:enable zebulanstanphill/obviousdeletecookieslink`
  and serve the board with `php -S`.
- `phpbbcli.php` doesn't purge the cache that the web server uses. After
  changing the extension's files or enabling or disabling it from the command
  line, run `php bin/phpbbcli.php cache:purge` before checking the board.
- Check the login form (also with a CAPTCHA after failed logins, and with an
  OAuth provider), the ACP's re-authentication form, and the delete cookies
  link's AJAX confirmation. Look for notices and deprecations from the
  extension in the PHP error log; phpBB hides deprecations from the page.
- phpBB rejects forms submitted in the same second as they were displayed
  ("The submitted form was invalid"), so automated logins must wait before
  submitting.
- Run phpBB's [Extension Pre Validator](https://github.com/phpbb/epv) (its
  `master` and `epv-phpbb4` branches) on a copy laid out as
  `zebulanstanphill/obviousdeletecookieslink/`, and
  [PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility) with
  `--runtime-set testVersion 7.1-`.
- The user works on this computer while agents test, so use headless
  browsers only, and don't install browsers or other software for testing.
  Google Chrome isn't installed; Playwright's cached Chrome for Testing in
  `~/Library/Caches/ms-playwright/` works.
