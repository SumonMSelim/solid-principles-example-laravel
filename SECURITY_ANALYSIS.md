# Security analysis of Composer and npm dependencies

**Project:** sumonmselim/solid-principles-example-laravel
**Date:** 7 October 2026 (CEST)
**Branch:** chore/security-dependency-upgrade-task
**Scope:** composer.lock (107 packages) and the installed npm tree (shell-quote via concurrently)

## 1. Summary

The current dependency tree has 6 known advisories.

Composer has 5. They are in laravel/framework, league/commonmark, and league/flysystem.

npm has 1. It is a shell-quote command injection via concurrently.

The fix stays inside the version constraints already set in composer.json and package.json.

The regression baseline is green. `composer test` reports 36 passed and 0 failed.

After the upgrade, `mise run audit` must exit 0. `mise run test` must stay green.

## 2. Tool output

### 2.1 mise run audit (osv-scanner)

The mise audit task runs:

```
mise exec -- osv-scanner scan --format json --all-packages -L 'composer.lock'
```

Run on 7 October 2026. The task exited 1.

```
Scanned /workspace/missions/coding/048d389e-b110-45d6-9e8e-18c925c249bf/wt/composer.lock file and found 107 packages
[audit] ERROR task failed
```

Vulnerable groups from that JSON. Package versions beside them are the lockfile versions the same scan reported.

laravel/framework v13.16.1:

```json
[
  {
    "ids": ["GHSA-jh5r-qr3c-85q8"],
    "aliases": ["CVE-2026-102279", "GHSA-jh5r-qr3c-85q8"],
    "max_severity": "3.1"
  }
]
```

league/commonmark 2.9.2:

```json
[
  {
    "ids": ["GHSA-3q6v-r5mr-hxv8"],
    "aliases": ["GHSA-3q6v-r5mr-hxv8"],
    "max_severity": "7.5"
  },
  {
    "ids": ["GHSA-8rr7-cvq3-gmfh"],
    "aliases": ["CVE-2026-86428", "GHSA-8rr7-cvq3-gmfh"],
    "max_severity": "7.5"
  },
  {
    "ids": ["GHSA-97jj-33gv-5xf9"],
    "aliases": ["GHSA-97jj-33gv-5xf9"],
    "max_severity": "6.1"
  }
]
```

league/flysystem 3.34.0:

```json
[
  {
    "ids": ["GHSA-cxf4-7mrp-vvpr"],
    "aliases": ["CVE-2026-102601", "GHSA-cxf4-7mrp-vvpr"],
    "max_severity": "3.5"
  }
]
```

Fixed versions come from the `fixed` events in that same JSON. laravel/framework 13.x is fixed at 13.30.0. league/commonmark is fixed at 2.10.2, 2.10.0, and 2.10.2. league/flysystem is fixed at 3.35.3.

The same lockfile, printed by osv-scanner in markdown, matches those 5 rows:

```
Total 3 packages affected by 5 known vulnerabilities (0 Critical, 2 High, 1 Medium, 2 Low, 0 Unknown) from 1 ecosystem.
5 vulnerabilities can be fixed.

| OSV URL | CVSS | Ecosystem | Package | Version | Fixed Version | Source |
| --- | --- | --- | --- | --- | --- | --- |
| https://osv.dev/GHSA-jh5r-qr3c-85q8 | 3.1 | Packagist | laravel/framework | v13.16.1 | 13.30.0 | composer.lock |
| https://osv.dev/GHSA-3q6v-r5mr-hxv8 | 7.5 | Packagist | league/commonmark | 2.9.2 | 2.10.2 | composer.lock |
| https://osv.dev/GHSA-8rr7-cvq3-gmfh | 7.5 | Packagist | league/commonmark | 2.9.2 | 2.10.0 | composer.lock |
| https://osv.dev/GHSA-97jj-33gv-5xf9 | 6.1 | Packagist | league/commonmark | 2.9.2 | 2.10.2 | composer.lock |
| https://osv.dev/GHSA-cxf4-7mrp-vvpr | 3.5 | Packagist | league/flysystem | 3.34.0 | 3.35.3 | composer.lock |
```

No other Packagist package in this lockfile has a known advisory.

### 2.2 npm audit

The repo has no package-lock.json. `npm audit` was run against the installed tree. concurrently is 9.2.4. shell-quote is 1.9.0. Exit code 1.

```
# npm audit report

shell-quote  1.8.4 - 1.10.0
Severity: critical
shell-quote: `quote()` command injection via a line terminator in a token after a `{ comment }` token - https://github.com/advisories/GHSA-pqg4-j6r4-53mv
fix available via `npm audit fix`
node_modules/shell-quote
  concurrently  >=9.2.3
  Depends on vulnerable versions of shell-quote
  node_modules/concurrently

2 critical severity vulnerabilities

To address all issues, run:
  npm audit fix
```

That is one advisory. npm lists it on shell-quote and again on concurrently, because concurrently depends on the vulnerable release.

## 3. Findings

### 3.1 laravel/framework: XSS on the debug page

| Field | Value |
| --- | --- |
| Advisory ID | GHSA-jh5r-qr3c-85q8 (CVE-2026-102279) |
| Installed version | v13.16.1 |
| Affected range | >= 13.0.0, < 13.30.0 |
| Severity | Low |
| CVSS v3.1 | 3.1 (`CVSS:3.1/AV:N/AC:H/PR:N/UI:R/S:U/C:N/I:L/A:N`) |
| Fixed version | 13.30.0 |

When `APP_DEBUG` is true, attacker input is copied into a Tippy.js tooltip with `allowHTML` set. A hover can run that HTML in the browser. This is cross-site scripting (XSS).

### 3.2 league/commonmark: three advisories

Installed version: 2.9.2. The direct constraint in composer.json is `^2.9`.

#### Table-scanning DoS

| Field | Value |
| --- | --- |
| Advisory ID | GHSA-3q6v-r5mr-hxv8 |
| Affected range | >= 2.0.0, <= 2.10.1 |
| Severity | High |
| CVSS v3.1 | 7.5 (`CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:N/I:N/A:H`) |
| Fixed version | 2.10.2 |

The GitHub Flavoured Markdown table parser scans the whole paragraph again on each line. A long pipe-free paragraph burns CPU in quadratic time.

#### Attributes DoS

| Field | Value |
| --- | --- |
| Advisory ID | GHSA-8rr7-cvq3-gmfh (CVE-2026-86428) |
| Affected range | >= 1.5.0, < 2.10.0 |
| Severity | High |
| CVSS v3.1 | 7.5 (`CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:N/I:N/A:H`) |
| Fixed version | 2.10.0 |

Each new distinct attribute makes the extension walk the whole set again. Cost grows with the square of the attribute count. Apps that never register `AttributesExtension` are not affected.

#### DisallowedRawHtml bypass

| Field | Value |
| --- | --- |
| Advisory ID | GHSA-97jj-33gv-5xf9 |
| Affected range | >= 1.3.0, <= 2.10.1 |
| Severity | Medium |
| CVSS v3.1 | 6.1 (`CVSS:3.1/AV:N/AC:L/PR:N/UI:R/S:C/C:L/I:L/A:N`) |
| Fixed version | 2.10.2 |

The filter misses a disallowed tag when the tag name ends the raw HTML. A line that is only `<script` is left unchanged. With the default GFM settings this is stored XSS.

One bump to 2.10.2 or later clears all three.

### 3.3 league/flysystem: path normalization

| Field | Value |
| --- | --- |
| Advisory ID | GHSA-cxf4-7mrp-vvpr (CVE-2026-102601) |
| Installed version | 3.34.0 |
| Affected range | <= 3.35.2 |
| Severity | Low |
| CVSS v3.1 | 3.5 (`CVSS:3.1/AV:N/AC:L/PR:L/UI:R/S:U/C:N/I:L/A:N`) |
| Fixed version | 3.35.3 |

`WhitespacePathNormalizer` rejects control characters with `preg_match`. If the path is not valid UTF-8, `preg_match` returns false. The check treats that as a clean path and skips the rejection. Every adapter that uses the default normaliser is affected.

### 3.4 shell-quote: command injection via concurrently

| Field | Value |
| --- | --- |
| Advisory ID | GHSA-pqg4-j6r4-53mv (CVE-2026-102422) |
| Installed version | shell-quote 1.9.0, via concurrently 9.2.4 |
| Affected range | >= 1.8.4, < 1.11.0 |
| Severity | Critical (npm audit and the GitHub advisory) |
| CVSS v3.1 | 8.1 (`CVSS:3.1/AV:N/AC:H/PR:N/UI:N/S:U/C:H/I:H/A:H`) |
| CVSS v4.0 | 9.2 (`CVSS:4.0/AV:N/AC:L/AT:P/PR:N/UI:N/VC:H/VI:H/VA:H/SC:N/SI:N/SA:N`) |
| Fixed version | 1.11.0 |

`quote()` can inject a shell command. The bad case is a line terminator in a token that follows a `{ comment }` token. concurrently 9.2.4 depends on shell-quote 1.9.0, which is inside the affected range. package.json allows concurrently `^9.0.1`. That range still installs 9.2.4. concurrently 10.0.5 still depends on shell-quote 1.9.0, so a major bump of concurrently does not clear this advisory.

## 4. Remediation plan

Keep every change inside the constraints already declared.

Composer constraints today:

- `laravel/framework` is `^13.8`. That already allows 13.30.0. The newest 13.x release is v13.35.0.
- `league/commonmark` is `^2.9`. That already allows 2.10.2. The newest 2.x release is 2.10.3.
- league/flysystem is not a direct requirement. laravel/framework requires `league/flysystem: ^3.25.1`, including on v13.35.0. That range allows 3.35.3. The newest 3.x release is 3.36.0.

Targeted Composer update. Do not edit those constraints:

```
composer update laravel/framework league/commonmark league/flysystem
```

Minimum versions that clear the five Composer advisories:

- laravel/framework 13.30.0
- league/commonmark 2.10.2
- league/flysystem 3.35.3

npm stays on concurrently `^9.0.1`. Add a package.json override so the install uses a fixed shell-quote:

```json
"overrides": {
  "shell-quote": "^1.11.0"
}
```

That is the package.json fix for shell-quote. It does not change the concurrently range.

## 5. Regression baseline and post-upgrade gates

Baseline, recorded before this upgrade. Command: `composer test` (also `mise run test`).

- 36 passed
- 0 failed
- 0 warnings

Post-upgrade gates:

1. `mise run audit` exits 0. osv-scanner must report no known advisories on composer.lock.
2. `mise run test` stays green. The suite must still report 36 passed and 0 failed.

npm audit must no longer report GHSA-pqg4-j6r4-53mv after the shell-quote override.

No application code changes are in this plan. The demo reaches these libraries through Laravel and the Vite dev tools.
