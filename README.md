# Magento Agency Demo

A reference architecture for modern Adobe Commerce / Magento Open Source projects. This repository demonstrates clean architecture, API-first integration patterns, and Hyvä-compatible frontend development.

## Features

- **Modular Architecture**: core, integrations, and feature modules separated by domain.
- **Robust Integrations**:
  - **ERP**: Push-based Order Sync using queues.
  - **PIM**: Pull-based Product Import with backoff strategies.
  - **Webhooks**: Secure, signature-validated event merging.
- **Hyvä Compatibility**: Lightweight frontend patterns using Tailwind CSS and Alpine.js.
- **DevOps Ready**: Docker-based local environment, GitHub Actions for CI.

## Quick Start

### Prerequisites

- Docker & Docker Compose
- PHP 8.2+
- Composer 2

### Installation

#### Mac/Linux

1.  **Clone the repo**
    ```bash
    git clone https://github.com/agency/magento-agency-demo.git
    cd magento-agency-demo
    ```
2.  **Start and Install**
    ```bash
    make up
    make install
    ```

#### Windows (PowerShell)

1.  **Clone the repo**
    ```powershell
    git clone https://github.com/agency/magento-agency-demo.git
    cd magento-agency-demo
    ```
2.  **Run Setup Script**
    ```powershell
    ./scripts/setup.ps1
    ```
    For a clean rebuild from scratch (drops DB volumes), run:
    ```powershell
    ./scripts/setup.ps1 -Reset
    ```

### Accessing the Site

- **Frontend**: http://localhost:8080/
- **Admin**: http://localhost:8080/admin (User: `admin`, Pass: `Password123`)
- **Mailhog** (Emails): http://localhost:8025/ (if enabled)

## Documentation

- [Architecture Overview](docs/architecture.md)
- [Integration Guide](docs/integrations.md)
- [Security Model](docs/security.md)
- [API Reference](docs/api.md)

## License

MIT
