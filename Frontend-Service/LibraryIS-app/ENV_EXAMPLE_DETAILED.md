# Example .env Configuration

```env
#--------------------------------------------------------------------
# Example Environment Configuration
# 
# Copy this file to .env and update values for your environment
#
#--------------------------------------------------------------------

#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

CI_ENVIRONMENT = development
# CI_ENVIRONMENT = production

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

app.baseURL = 'http://localhost:8080/'
app.forceGlobalSecureRequests = false
app.indexPage = ''

# Encryption key (generate: php spark key:generate)
encryption.key = 'your-encryption-key-here'
encryption.driver = OpenSSL

#--------------------------------------------------------------------
# BACKEND API CONFIGURATION
#--------------------------------------------------------------------

# GraphQL Integration Service (Port 8000)
# Main gateway for books, borrowing, transactions
GRAPHQL_SERVICE_URL = http://127.0.0.1:8000/api/graphql

# Member Service (Port 8001)
# User authentication, registration, profile
MEMBER_SERVICE_URL = http://127.0.0.1:8001/api/graphql

# API Request Timeout (in seconds)
API_TIMEOUT = 10

#--------------------------------------------------------------------
# DATABASE (For Frontend Sessions - Optional)
#--------------------------------------------------------------------

# Database configuration
# If using database for session storage instead of file storage

database.default.hostname = localhost
database.default.database = library_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = 
database.default.port = 3306

# Disable if using file-based sessions
# database.default.encrypt = false

#--------------------------------------------------------------------
# SESSION CONFIGURATION
#--------------------------------------------------------------------

session.driver = 'FileHandler'
# session.driver = 'DatabaseHandler' # Use database if preferred

# Session cookie name
session.cookieName = 'LibraryIS'

# Session expiration (seconds) - 2 hours
session.expiration = 7200

# Session save path
session.savePath = 'writable/session'

# Match IP address to session
session.matchIP = false

# Time to update session (regenerate)
session.timeToUpdate = 300

# Regenerate and destroy old session
session.regenerateDestroy = false

#--------------------------------------------------------------------
# COOKIES
#--------------------------------------------------------------------

cookie.prefix = ''
cookie.expires = 0
cookie.path = '/'
cookie.domain = ''
cookie.secure = false
cookie.httponly = true
cookie.samesite = 'Lax'

#--------------------------------------------------------------------
# LOGGING
#--------------------------------------------------------------------

log.threshold = 4
log.dateFormat = 'Y-m-d H:i:s'
log.handlers = CodeIgniter\Logs\Handlers\FileHandler

# Handlers: CodeIgniter\Logs\Handlers\FileHandler, ChromeLogger
# log.handlers = CodeIgniter\Logs\Handlers\FileHandler,CodeIgniter\Logs\Handlers\ChromeLogger

#--------------------------------------------------------------------
# SECURITY
#--------------------------------------------------------------------

# CSRF
security.csrf.enabled = true
security.csrf.cookieName = 'XSRF-TOKEN'
security.csrf.headerName = 'X-CSRF-TOKEN'
security.csrf.tokenRandomize = false
security.csrf.redirection = true
security.csrf.protection = 'session' # 'session', 'cookie', 'header'

# Content Security Policy
CSPEnabled = false

#--------------------------------------------------------------------
# CONTENT NEGOTIATION
#--------------------------------------------------------------------

# Allowed content types negotiation
negotiateSupport = [
    'application/json',
    'application/xml',
    'text/html',
]

#--------------------------------------------------------------------
# EDITOR
#--------------------------------------------------------------------

# Location of syntax highlighting library
editorTheme = 'monokai'

#--------------------------------------------------------------------
# CURL REQUEST
#--------------------------------------------------------------------

curlrequest.shareOptions = true

#--------------------------------------------------------------------
# KINT DEBUGGER
#--------------------------------------------------------------------

# Kint depth for dump
kint.maxDepth = 10

#--------------------------------------------------------------------
# MAIL CONFIGURATION (Optional)
#--------------------------------------------------------------------

# If using mail features for password reset emails

email.protocol = 'SMTP'
email.SMTPHost = 'smtp.gmail.com'
email.SMTPUser = 'your-email@gmail.com'
email.SMTPPass = 'your-app-password'
email.SMTPPort = 587
email.SMTPCrypto = 'tls'
email.mailType = 'html'
email.charset = 'UTF-8'
email.fromEmail = 'noreply@libraryis.com'
email.fromName = 'LibraryIS'

#--------------------------------------------------------------------
# CACHE
#--------------------------------------------------------------------

# Handler: 'file', 'memcache', 'redis', 'wincache'
cache.handler = 'file'
cache.file.path = 'writable/cache'

# Memcache settings
cache.memcached.host = 'localhost'
cache.memcached.port = 11211
cache.memcached.weight = 1
cache.memcached.raw = false

# Redis settings
cache.redis.host = 'localhost'
cache.redis.password = null
cache.redis.port = 6379
cache.redis.timeout = 0
cache.redis.database = 0

#--------------------------------------------------------------------
# ASSET VERSIONING
#--------------------------------------------------------------------

# Asset version (append to CSS/JS for cache busting)
assetVersion = '1.0'

#--------------------------------------------------------------------
# CONTENT SECURITY POLICY (If Enabled)
#--------------------------------------------------------------------

CSPEnabled = false

# If enabled, define CSP rules
CSPFlags.baseURI.reportOnly = false
CSPFlags.baseURI.allowNone = false
CSPFlags.baseURI.allowSelf = false
CSPFlags.baseURI.allowAny = true

#--------------------------------------------------------------------
# TOOLBAR
#--------------------------------------------------------------------

# Show CodeIgniter toolbar for debugging
toolbar = true

# History database location
toolbar.database = true

#--------------------------------------------------------------------
# ROUTES
#--------------------------------------------------------------------

# Route configuration handled in routes/web.php
# See app/Config/Routes.php for route definitions

#--------------------------------------------------------------------
# PRODUCTION SETTINGS (When CI_ENVIRONMENT = production)
#--------------------------------------------------------------------

# In production, also set:
# app.forceGlobalSecureRequests = true
# app.baseURL = 'https://yourdomain.com/'
# encryption.key = 'real-encryption-key'
# session.driver = 'DatabaseHandler' (more reliable)
# log.threshold = 2 (warnings and errors only)
# toolbar = false
# toolbar.database = false
```

## Configuration Notes

### API Service URLs

For **development**:
```env
GRAPHQL_SERVICE_URL = http://127.0.0.1:8000/api/graphql
MEMBER_SERVICE_URL = http://127.0.0.1:8001/api/graphql
```

For **production** (example):
```env
GRAPHQL_SERVICE_URL = https://api.libraryis.com/graphql
MEMBER_SERVICE_URL = https://auth.libraryis.com/graphql
```

### Session Storage

**File-based (default, good for development):**
```env
session.driver = 'FileHandler'
session.savePath = 'writable/session'
```

**Database (better for production):**
```env
session.driver = 'DatabaseHandler'
database.default.hostname = localhost
database.default.database = library_sessions
```

### Security Settings

**Development:**
```env
app.forceGlobalSecureRequests = false
security.csrf.enabled = true
CSPEnabled = false
toolbar = true
log.threshold = 4  # Everything
```

**Production:**
```env
app.forceGlobalSecureRequests = true
security.csrf.enabled = true
CSPEnabled = true
toolbar = false
log.threshold = 2  # Warnings and errors only
```

### Mail Configuration

Only needed if implementing password reset emails:

**Gmail (with App Password):**
```env
email.protocol = 'SMTP'
email.SMTPHost = 'smtp.gmail.com'
email.SMTPUser = 'your-email@gmail.com'
email.SMTPPass = 'your-16-char-app-password'
email.SMTPPort = 587
email.SMTPCrypto = 'tls'
```

**Mailtrap (for testing):**
```env
email.protocol = 'SMTP'
email.SMTPHost = 'smtp.mailtrap.io'
email.SMTPUser = 'your-mailtrap-user'
email.SMTPPass = 'your-mailtrap-password'
email.SMTPPort = 2525
```

### Encryption Key Generation

```bash
# Generate new encryption key
php spark key:generate
```

Copy the generated key to `.env`:
```env
encryption.key = 'base64:...'
```

### Generating .env from Example

```bash
cd Frontend-Service/LibraryIS-app

# Copy example
cp .env.example .env

# Generate encryption key
php spark key:generate

# Update backend URLs
nano .env  # or use your editor

# Verify configuration
php spark env
```

---

**Note:** Keep `.env` file private - never commit to version control
