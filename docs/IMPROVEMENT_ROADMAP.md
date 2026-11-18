# Improvement Roadmap — MagicPort

## Phase 4 — Git/GitHub hygiene

- [ ] gitleaks full-history scan on `secrets/` and all branches
- [ ] Create `preview` and `test` branches from `develop` tip
- [ ] Rename `develop` → `main` (Gate 4)
- [ ] Add `.github/dependabot.yml` (weekly Mon 06:00 UTC, target `preview`, limits 10/5/5)
- [ ] Enable Discussions + Wiki on GitHub (standing decision 13)
- [ ] Classify 1 open issue ("Frontend Development")
- [ ] Add `.gitignore`/`.gitattributes`/pre-commit secret-scan hook

## Phase 5 — Container baseline

- [ ] Pin `composer` image to digest
- [ ] Add `.dockerignore` (exclude `.env`, keys, `.git`)
- [ ] Add `Makefile` (build/test/verify/up/run/down)
- [ ] Create `.env.example` with placeholders only
- [ ] Run existing tests in Docker `test` stage; record baseline in `docs/BASELINE.md`

## Phase 6 — Upgrade to latest

- [ ] Resolve composer manifest/lock mismatch (regenerate lock for `laravel/framework ^12.0` or correct manifest)
- [ ] Upgrade Laravel v11.21.0 → latest v12.x
- [ ] Upgrade PHP runtime to latest 8.x
- [ ] Upgrade all Composer deps to latest stable
- [ ] Create `package-lock.json`; upgrade npm deps to latest stable
- [ ] `make verify` green after each step

## Phase 7 — Dead code & restructure

- [ ] Confirm commented-out compose services (`npmnx`, `npm`, `npx`, `redis`) are dead; remove if unused
- [ ] No custom business code to clean (skeleton only)

## Phase 8 — Architecture

n/a — no real domain boundaries yet.

## Phase 8B — Feature enhancement

n/a — skeleton, no business domain to extend.

## Phase 9 — Hardening

- [ ] Remove `secrets/` plaintext files; rotate all credentials (Gate 1)
- [ ] Add `/health/live` + `/health/ready` endpoints
- [ ] Add CORS restriction, security headers, trust hosts
- [ ] Add PHPStan + PHP-CS-Fixer
- [ ] APP_KEY generated at runtime, not hardcoded
- [ ] Secret scanning in CI

## Phase 10 — CI/CD

- [ ] GitHub Actions workflow (format/lint/secret-scan → test → build → scan)
- [ ] SHA-pinned actions, least-privilege permissions, timeouts
- [ ] Docker build to GHCR on tag from `main`

## Phase 11 — Tests

- [ ] Expand beyond 2 default tests (unit + feature + API)
- [ ] Coverage report in `docs/TEST_REPORT.md`
- [ ] `docs/TESTING_STRATEGY.md`

## Phase 15 — Docs, manifest, diagrams

- [ ] README with install/run/test/deploy instructions
- [ ] `docs/DEPLOYMENT.md`, `docs/OPERATIONS.md`
- [ ] Community files: CODE_OF_CONDUCT, CONTRIBUTING, LICENSE, SECURITY, ACCESSIBILITY, SUPPORT, CHANGELOG, CODEOWNERS
- [ ] Issue/PR templates
- [ ] `repo-manifest.yaml`
- [ ] Mermaid diagrams

## Not applicable

- Phase 12 (merge small repos): standalone skeleton, no merge candidates
- Phase 13 (shared library): no duplication across repos
- Phase 14 (rename): no rename requested
- Phase 16 (platform repo): no cluster deployment planned
