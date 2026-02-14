# Security Patterns

## Secrets Management

- No secrets are committed to the repository.
- Secrets are injected via Environment Variables or `env.php`.
- The `Agency_Integration` module uses `Magento\Config\Model\Config\Backend\Encrypted` for storing sensitive keys in the database.

## Input Validation

- All Controller inputs are validated.
- Webhooks enforce HMAC signature validation to prevent tampering and replay attacks (timestamp check recommended for future).

## Output Encoding

- All frontend templates use `$escaper` methods (`escapeHtml`, `escapeUrl`) to prevent XSS.

## Least Privilege

- Integration users/tokens should have restricted scopes.
