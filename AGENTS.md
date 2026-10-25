# Agent instructions

These instructions apply throughout this repository.

## Model preference

- The user requests GPT-5.6 Terra (`gpt-5.6-terra`). Use that exact model when the host provides model selection.
- This file records a preference; it cannot change the model of an active session. If the requested model cannot be selected, explain that limitation without claiming a switch occurred.

## Project context

- Package: `hekmatinasser/verta`, an MIT-licensed PHP library for Jalali/Shamsi date and time handling with Laravel integration.
- PHP requirement: `^8.0`. Preserve compatibility with the Laravel versions declared in `composer.json`.
- Production code lives in `src/`; tests live in `tests/`.
- PSR-4 namespace: `Hekmatinasser\Verta\`. Helpers are loaded from `src/helpers.php`.
- Consult `README.md`, `composer.json`, and `phpunit.xml.dist` for usage, dependencies, and test configuration.

## Working conventions

- Read relevant code and follow its existing style before making changes.
- Keep changes focused and preserve unrelated user edits.
- Preserve public API behavior unless the task explicitly requires a change.
- For behavior changes, run relevant tests using the repository's PHPUnit configuration when dependencies are available. Report checks performed and any blockers accurately.

## Persistent memory

Read this section at the start of future tasks. Update it when the user establishes a durable preference or a verified project decision changes. Keep entries concise and current; do not store secrets, speculative facts, or temporary task logs.

- 2026-10-25: The user requested this `AGENTS.md` as persistent project memory.
- 2026-10-25: Preferred model is GPT-5.6 Terra (`gpt-5.6-terra`).
