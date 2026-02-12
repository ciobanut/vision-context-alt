If the user asks a question in Romanian, respond with explanations in Romanian, but code must be in English. Do not ignore the instructions in this file. If they are not followed, respond with "Instructiunile din .github/copilot-instructions.md nu au fost respectate.".

---

# ✅ Copilot Instructions – WordPress Plugin Architecture

## 🎯 Objective

Generate code for a WordPress plugin using:

* Strict OOP
* Namespace + PSR-4
* Single Responsibility Principle
* Scalable architecture
* Clear separation of responsibilities
* No procedural logic outside the bootstrap

---

## 📁 Mandatory structure

```
my-plugin/
│
├── my-plugin.php (bootstrap only)
├── composer.json
├── src/
│   ├── Core/
│   │   └── Plugin.php
│   │
│   ├── Admin/
│   │   ├── AdminPage.php
│   │   ├── Assets.php
│   │   └── Settings.php
│   │
│   ├── Api/
│   │   ├── AjaxHandler.php
│   │   └── ExternalApi.php
│   │
│   ├── Services/
│   │   └── DataService.php
│   │
│   └── Helpers/
│
└── assets/
```

DO NOT generate code outside this structure.

---

## 🧠 Architecture rules

### 1️⃣ Clean bootstrap

`my-plugin.php` must:

* Define plugin metadata
* Load Composer autoload
* Initialize only the main class

No hooks here.
No logic here.

---

### 2️⃣ Core Plugin class

* Is the orchestrator
* Initializes modules
* Contains no business logic
* Contains no HTML
* Makes no API requests

---

### 3️⃣ Admin layer

AdminPage:

* Contains only UI
* Only add_menu_page and render
* Contains no business logic

Assets:

* Only enqueue scripts/styles
* Only localize_script

Settings:

* register_setting
* get_option
* validation

---

### 4️⃣ API layer

ExternalApi:

* Only communication with external API
* Only wp_remote_get / wp_remote_post
* Does not use WP hooks
* Does not echo
* Does not send JSON

AjaxHandler:

* Only wp_ajax hooks
* Only nonce validation
* Calls the Service layer
* Sends JSON response

---

### 5️⃣ Service layer

* Contains business logic
* Processes data
* Transforms data
* May use caching
* Contains no HTML
* Contains no hooks

---

## 🔒 Strict rules

* Each class = one reason to change
* No global functions
* No procedural code
* No mixing HTML and logic
* No direct API calls from AdminPage
* No wp_remote_* calls from AjaxHandler

---

## 🧩 Namespace

All classes must use:

```
namespace VisionContextAlt\...
```

PSR-4 via Composer.

---

## ⚙️ Dependency Injection

* Do not instantiate in methods if it can be injected.
* Prefer constructor injection.
* Avoid new ExternalApi() inside methods if it can be injected.

---

## 🔐 Security

* Use nonces for AJAX
* Escape output (esc_html, esc_attr)
* Sanitize input
* Check capability (manage_options)

---

## 🎨 JS Rules

* JS in assets/js
* No inline JS in PHP
* Communication only via AJAX or REST
* Use data from wp_localize_script

---

## ❌ What must NOT be generated

* Procedural code
* Single-file plugin
* HTML mixed with API logic
* Missing namespace
* Missing composer.json
* Hardcoded dependencies

---

## 🎯 Quality standard

Code must be:

* Easy to test
* Modular
* Extensible
* Clearly separated by layers
* Ready to scale

---

For commit messages, use Conventional Commits v1 (feat, fix, refactor, docs, style, test, chore) + a clear change description. Example: `feat: add new API endpoint for fetching data` or `fix: resolve nonce validation issue in AJAX handler`.
