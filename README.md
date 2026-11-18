# MagicPort

Laravel skeleton application with Docker Compose orchestration.

## Overview

MagicPort is a vanilla Laravel starter application, ready for business-domain implementation. It provides a baseline Laravel installation with PHP, MySQL, nginx, and Docker Compose.

## Installation

```shell
# Clone the repository
git clone https://github.com/RasimAghayev/MagicPort.git
cd MagicPort

# Copy environment example
cp src/be/.env.example src/be/.env

# Start the stack (runs verification first)
make up
```

## Usage

```shell
# Verify (build + test)
make verify

# Run tests
make test

# Start all services
make up

# Stop all services
make down

# Open a shell in the PHP container
make shell

# Run migrations
make migrate
```

## Testing

```shell
make test
```

See `docs/TESTING_STRATEGY.md` and `docs/TEST_REPORT.md` for details.

## Documentation

- [Deployment](docs/DEPLOYMENT.md)
- [Operations](docs/OPERATIONS.md)
- [Security Review](docs/SECURITY_REVIEW.md)
- [Architecture](docs/ARCHITECTURE.md)
- [Repository Audit](docs/REPOSITORY_AUDIT.md)
- [Technical Debt](docs/TECHNICAL_DEBT.md)
- [Improvement Roadmap](docs/IMPROVEMENT_ROADMAP.md)

## Community

- [Code of Conduct](CODE_OF_CONDUCT.md)
- [Contributing](CONTRIBUTING.md)
- [Security Policy](SECURITY.md)
- [Support](SUPPORT.md)
- [Accessibility](ACCESSIBILITY.md)

## License

[MIT](LICENSE)
