# Magento Agency Demo

Production-style Magento Open Source demo by Arshia, with custom agency modules, custom storefront branding, and Docker-based local setup.

## What is included

- Agency modules under `app/code/Agency`
- Custom theme under `app/design/frontend/Agency/hyva-demo`
- Docker environment (`docker-compose.yml`, `dev/nginx`, `dev/php`)
- One-command Windows setup script: `scripts/setup.ps1`

## Quick Start (Windows PowerShell)

1. Clone:
```powershell
git clone https://github.com/Arshiamk/magento-agency.git
cd magento-agency
```

2. Setup:
```powershell
./scripts/setup.ps1
```

3. Open:
- Frontend: `http://localhost:8080`
- Admin: `http://localhost:8080/admin`

For a full rebuild:
```powershell
./scripts/setup.ps1 -Reset
```

## Notes

- This repository is intentionally trimmed to keep focus on working application code and local developer experience.
- Heavy Magento test suites and distribution-only boilerplate files were removed from version control.

## License

See `LICENSE`.