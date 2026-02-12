Userul poate sa te intrebe in limba romana iar tu raspunzi in explicatii in romana, dar in cod trebuie sa raspunzi in engleza. Nu ignora instructiunile din acest fisier. Daca nu sunt respectate, raspunde cu "Instructiunile din .github/copilot-instructions.md nu au fost respectate.".

---

# ✅ Copilot Instructions – WordPress Plugin Architecture

## 🎯 Obiectiv

Generează cod pentru un plugin WordPress folosind:

* OOP strict
* Namespace + PSR-4
* Single Responsibility Principle
* Arhitectură scalabilă
* Separarea clară a responsabilităților
* Fără logică procedurală în afara bootstrap-ului

---

## 📁 Structura obligatorie

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

NU genera cod în afara acestei structuri.

---

## 🧠 Reguli de Arhitectură

### 1️⃣ Bootstrap curat

`my-plugin.php` trebuie să:

* Definească metadata plugin
* Încarce autoload Composer
* Inițializeze doar clasa principală

Fără hook-uri aici.
Fără logică aici.

---

### 2️⃣ Clasa Core Plugin

* Este orchestrator
* Inițializează modulele
* Nu conține logică de business
* Nu conține HTML
* Nu face request-uri API

---

### 3️⃣ Admin Layer

AdminPage:

* Conține doar UI
* Doar add_menu_page și render
* Nu conține logică business

Assets:

* Doar enqueue scripts/styles
* Doar localize_script

Settings:

* register_setting
* get_option
* validare

---

### 4️⃣ API Layer

ExternalApi:

* Doar comunicare cu API extern
* Doar wp_remote_get / wp_remote_post
* Nu folosește hook-uri WP
* Nu face echo
* Nu trimite JSON

AjaxHandler:

* Doar hook-uri wp_ajax
* Doar validare nonce
* Apelează Service layer
* Trimite JSON response

---

### 5️⃣ Service Layer

* Conține logică business
* Procesează date
* Transformă date
* Poate folosi caching
* Nu conține HTML
* Nu conține hook-uri

---

## 🔒 Reguli stricte

* Fiecare clasă = un singur motiv de modificare
* Fără funcții globale
* Fără cod procedural
* Fără amestec de HTML și logică
* Fără apel API direct din AdminPage
* Fără apel wp_remote_* din AjaxHandler

---

## 🧩 Namespace

Toate clasele trebuie să folosească:

```
namespace MyPlugin\...
```

PSR-4 prin Composer.

---

## ⚙️ Dependency Injection

* Nu crea instanțe direct în metode dacă pot fi injectate.
* Constructor injection preferat.
* Evită new ExternalApi() în interiorul metodelor dacă poate fi injectat.

---

## 🔐 Securitate

* Folosește nonces pentru AJAX
* Escape la output (esc_html, esc_attr)
* Sanitize la input
* Verifică capability (manage_options)

---

## 🎨 JS Rules

* JS separat în assets/js
* Nu inline JS în PHP
* Comunicarea doar prin AJAX sau REST
* Folosește datele din wp_localize_script

---

## ❌ Ce NU trebuie generat

* Cod procedural
* Plugin într-un singur fișier
* HTML amestecat cu logică API
* Lipsa namespace
* Lipsa composer.json
* Dependințe hardcodate

---

## 🎯 Standard de calitate

Codul trebuie să fie:

* Ușor testabil
* Modular
* Extensibil
* Clar separat pe layere
* Pregătit pentru scalare

---

pentru denumirile commiturilor folosește următoarele convenția: Conventional Commits (feat, fix, refactor, docs, style, test, chore) + o descriere clară a schimbării. De exemplu: `feat: add new API endpoint for fetching data` sau `fix: resolve nonce validation issue in AJAX handler`.