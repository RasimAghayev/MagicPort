# Contributing

## How to Contribute

We welcome contributions to MagicPort! Whether you're reporting a bug,
suggesting a feature, or submitting a pull request, your help is appreciated.

## Reporting Bugs

Use the bug issue template to report bugs. Include:

- Environment (Docker image tag, PHP version, Laravel version)
- Steps to reproduce
- Expected vs actual behavior
- Evidence (logs, screenshots, redacted output)
- Severity level

## Suggesting Features

Use the feature issue template. Describe:

- The problem you're trying to solve
- Your proposed solution
- Alternative solutions you've considered
- Additional context

## Submitting a Pull Request

1. Fork the repository and create a branch from `preview`
2. Branch name: `phase-<n>/<topic>` (e.g., `phase-9/hardening`)
3. Make your changes
4. Run `make verify` (Docker build + test stage) and ensure it passes
5. Commit using Conventional Commits (e.g., `feat:`, `fix:`, `build(deps):`)
6. One logical change per commit
7. Open a PR against `preview`
8. Ensure CI is green
9. A maintainer will review and merge

## Development Setup

```shell
# Clone the repository
git clone https://github.com/RasimAghayev/MagicPort.git
cd MagicPort

# Start the stack (runs `make verify` first)
make up

# Or run verification only
make verify

# Run tests
make test

# Open a shell in the PHP container
make shell
```

## Code Style

- PHP: PSR-12 (enforced by PHP-CS-Fixer)
- Commit messages: Conventional Commits
- Branch naming: `phase-<n>/<topic>`

## Review Process

- One PR per phase per repo
- Maintainers merge after CI is green
- Required status checks must pass
- No `--no-verify` commits

## AI Attribution

No AI co-author or session trailers (e.g., `Co-Authored-By: Claude ...`,
`Claude-Session: ...`) are permitted in commits, PRs, or comments. Authorship
is the contributor's alone.
