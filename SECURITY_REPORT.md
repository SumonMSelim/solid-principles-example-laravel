# Dependency Security Analysis & Remediation Report

**Project:** [`sumonmselim/solid-principles-example-laravel`](https://github.com/SumonMSelim/solid-principles-example-laravel/)
**Date:** 2026-08-11
**Scope:** Full dependency security audit of the Composer dependency graph, with remediation of all identified vulnerabilities.
**Tooling:** `composer audit` (Composer 2.8.8) against the GitHub Advisory Database / packagist advisories.

---

## 1. Executive Summary

A full security audit of the project's dependencies (`composer audit`) identified **14 security vulnerability advisories across 3 transitive packages**:

| Package | Vulnerable version (installed) | Advisories | Highest severity |
|---|---|---|---|
| `guzzlehttp/guzzle` | 7.12.1 | 7 | **High** |
| `guzzlehttp/psr7` | 2.12.1 | 1 | Medium |
| `league/commonmark` | 2.8.2 | 6 | **High** |

All three are **transitive dependencies** pulled in indirectly by `laravel/framework` (and, for `guzzlehttp/psr7`, by `guzzlehttp/guzzle`). They were **not** declared in `composer.json`, so the project had no direct control over their resolved versions.

**Remediation:** The three packages were pinned to secure, Laravel-compatible versions directly in `composer.json`, the lockfile was refreshed, and `composer audit` now reports **0 advisories**. The full test suite (**36 tests, 79 assertions**) passes with no regressions.

---

## 2. Findings — Vulnerable Packages & Advisories

### 2.1 `guzzlehttp/guzzle` (HTTP client) — 7 advisories

Installed: **7.12.1** → Upgraded to: **7.15.3**

| CVE / Advisory | Severity | Title | Affected versions | Fixed in |
|---|---|---|---|---|
| CVE-2026-69246 / [GHSA-v5mv-p594-2x33](https://github.com/advisories/GHSA-v5mv-p594-2x33) | **High** | Noncanonical host can bypass host-based checks | `<7.15.2` | 7.15.2 |
| CVE-2026-69245 / [GHSA-f7vp-7xgx-4w4r](https://github.com/advisories/GHSA-f7vp-7xgx-4w4r) | Medium | Noncanonical cookie domain keeps subdomain scope | `<7.15.2` | 7.15.2 |
| CVE-2026-67354 / [GHSA-h95v-h523-3mw8](https://github.com/advisories/GHSA-h95v-h523-3mw8) | Medium | URI fragments disclosed in redirect Referer headers | `<7.15.1` | 7.15.1 |
| CVE-2026-67355 / [GHSA-wm3w-8rrp-j577](https://github.com/advisories/GHSA-wm3w-8rrp-j577) | Medium | Host-only cookie scope is not preserved | `<7.15.1` | 7.15.1 |
| CVE-2026-67353 / [GHSA-f283-ghqc-fg79](https://github.com/advisories/GHSA-f283-ghqc-fg79) | Medium | Unbounded response cookies risk denial of service | `<7.15.1` | 7.15.1 |
| CVE-2026-59883 / [GHSA-g446-98w2-8p5w](https://github.com/advisories/GHSA-g446-98w2-8p5w) | Medium | Cookie disclosure & injection via IP-address domains | `<7.12.3` | 7.12.3 |
| CVE-2026-67339 / [GHSA-94pj-82f3-465w](https://github.com/advisories/GHSA-94pj-82f3-465w) | Medium | Proxy-Authorization headers can leak to origin servers | `<7.14.2` | 7.14.2 |

**Impact:** The single High-severity flaw (CVE-2026-69246) allows a noncanonical request host to bypass application host-based security checks (e.g. CSRF/SameSite/allow-list assertions), enabling cross-origin request forgery and cookie-scope confusion. The remaining Medium issues enable cookie leakage, cookie-scope manipulation, redirect-referer disclosure, DoS, and proxy-credential leakage.

### 2.2 `guzzlehttp/psr7` (PSR-7 message implementation) — 1 advisory

Installed: **2.12.1** → Upgraded to: **2.13.0**

| CVE / Advisory | Severity | Title | Affected versions | Fixed in |
|---|---|---|---|---|
| CVE-2026-59882 / [GHSA-c2w2-prh8-qm98](https://github.com/advisories/GHSA-c2w2-prh8-qm98) | Medium | Host confusion via weak URI host validation | `<2.12.3` | 2.12.3 |

**Impact:** Weak validation of the URI `Host` component lets a crafted host confuse downstream host checks, compounding the Guzzle host-bypass class of issues.

### 2.3 `league/commonmark` (Markdown parser, used by Laravel's Markdown views/mail) — 6 advisories

Installed: **2.8.2** → Upgraded to: **2.9.2**

| CVE / Advisory | Severity | Title | Affected versions | Fixed in |
|---|---|---|---|---|
| CVE-2026-71488 / [GHSA-2q4p-g7hv-5rgv](https://github.com/advisories/GHSA-2q4p-g7hv-5rgv) | **High** | Quadratic-time DoS when parsing crafted Markdown | `>=0.6.0,<2.9.0` | 2.9.0 |
| [GHSA-mh25-x5hq-wrqp](https://github.com/advisories/GHSA-mh25-x5hq-wrqp) (PKSA-cqd6-fg4n-nxpf) | **High** | DoS via colliding heading slugs | `>=2.0.0,<2.9.0` | 2.9.0 |
| [GHSA-jfm3-95jq-q3rf](https://github.com/advisories/GHSA-jfm3-95jq-q3rf) (PKSA-1q6p-sqkj-8mmj) | **High** | DoS via duplicate footnote definitions | `>=1.5.0,<2.9.0` | 2.9.0 |
| [GHSA-g2gp-3wwq-f4ph](https://github.com/advisories/GHSA-g2gp-3wwq-f4ph) (PKSA-mc58-w91n-f5gv) | **High** | DoS via adjacent inline attribute blocks | `>=1.5.0,<2.9.0` | 2.9.0 |
| [GHSA-mj63-m3rc-8ppr](https://github.com/advisories/GHSA-mj63-m3rc-8ppr) (PKSA-5mzr-szzf-z6cn) | Medium | DoS via deeply nested XML output | `>=2.0.0,<2.9.0` | 2.9.0 |
| CVE-2026-71478 / [GHSA-29pj-957v-52mc](https://github.com/advisories/GHSA-29pj-957v-52mc) | Medium | `AttributesExtension` href/src unsafe-link filter bypass via embedded control bytes | `>=1.5.0,<=2.8.3` | 2.8.4 / 2.9.0 |

**Impact:** A crafted Markdown payload can cause quadratic or unbounded parsing time (request-wide CPU exhaustion / denial of service) or bypass the unsafe-link sanitization filter (potential XSS in rendered Markdown).

---

## 3. Remediation

Because the three packages are **transitive** (not declared in `composer.json`), the project had no lever to force secure versions — Composer would otherwise resolve them to whatever the upstream constraints allow. The fix is to **pin** each to a secure, Laravel-compatible version directly in `composer.json`'s `require` section, then refresh the lockfile.

### 3.1 Pinned versions (added to `composer.json`)

```json
"require": {
    "php": "^8.4",
    "guzzlehttp/guzzle": "^7.15.3",
    "guzzlehttp/psr7": "^2.12.3",
    "laravel/framework": "^13.8",
    "laravel/tinker": "^3.0",
    "league/commonmark": "^2.9"
}
```

### 3.2 Before / after

| Package | Before | After | Constraint added |
|---|---|---|---|
| `guzzlehttp/guzzle` | 7.12.1 | **7.15.3** | `^7.15.3` |
| `guzzlehttp/psr7` | 2.12.1 | **2.13.0** | `^2.12.3` |
| `league/commonmark` | 2.8.2 | **2.9.2** | `^2.9` |

Two further transitive packages were advanced by `composer update --with-dependencies` (their constraints did not need pinning):

| Package | Before | After |
|---|---|---|
| `guzzlehttp/promises` | 2.5.0 | 2.5.2 |
| `nette/utils` | v4.1.4 | v4.1.5 |

### 3.3 Compatibility analysis — why nothing breaks

All pinned versions sit **within the same major line** already permitted by the framework, so they are fully backward-compatible with the installed `laravel/framework v13.16.1`:

- `laravel/framework v13.16.1` requires `guzzlehttp/guzzle ^7.8.2` → **7.15.3** satisfies it (and is the latest 7.x patch).
- `guzzlehttp/guzzle 7.15.3` requires `guzzlehttp/psr7 ^2.13` → the `^2.12.3` floor intersects cleanly and resolves to **2.13.0**, satisfying both.
- `laravel/framework v13.16.1` requires `league/commonmark ^2.8.1` → **2.9.2** satisfies it (same major `2.x`).

None of the upgrades cross a major version boundary, so there are no breaking API changes. The application code does not call Guzzle or CommonMark directly (they are framework-internal), eliminating any call-site impact.

---

## 4. Verification

### 4.1 `composer audit` — before vs after

**Before remediation** (`composer audit` on the original `composer.lock`):

```
Found 14 security vulnerability advisories affecting 3 packages:
  guzzlehttp/guzzle   7.12.1   (7 advisories)
  guzzlehttp/psr7     2.12.1   (1 advisory)
  league/commonmark   2.8.2    (6 advisories)
```

**After remediation** (`composer audit` on the updated `composer.lock`):

```
No security vulnerability advisories found.   (exit code 0)
```

All 14 advisories are resolved.

### 4.2 Lockfile integrity

- `composer.lock` refreshed; resolved versions: `guzzlehttp/guzzle 7.15.3`, `guzzlehttp/psr7 2.13.0`, `league/commonmark 2.9.2`.
- `composer validate --strict` → **`./composer.json is valid`**.
- Content hash in `composer.lock` matches `composer.json`.

### 4.3 Test suite — no regressions

Full suite run via `php artisan test` (PHP 8.4.24, sqlite `:memory:`, `APP_KEY` set):

```
Tests:    36 passed (79 assertions)
Duration: 0.64s
[COMMAND_EXIT_CODE="0"]
```

**Result: 36/36 tests pass, 0 failures, 0 errors.** The dependency upgrade introduces no behavioral regressions. Full per-test output is captured in [`test-results.txt`](./test-results.txt).

---

## 5. Recommendations

1. **Keep the pins.** The three `require` entries should remain in `composer.json`; they are the mechanism that prevents these transitive deps from drifting back to vulnerable versions.
2. **Run `composer audit` in CI.** Add it as a step in the GitHub Actions workflow (`.github/workflows/*.yml`) so advisories are caught before merge — currently CI only runs `php artisan test`.
3. **Keep dependencies current.** Periodically run `composer update` (or enable Dependabot/Renovate) to pick up patch-level security fixes promptly.
4. **No application-code changes were required.** Guzzle and CommonMark are used only internally by the framework; the SOLID-principle demo code is unaffected.
