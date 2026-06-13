# 🦠 COVID-19 MIS (Management Information System)

A professional, enterprise-grade **COVID-19 Management Information System** built using robust **Object-Oriented PHP**, **PDO Prepared Statements**, and **Tailwind CSS**. Designed to represent modern development standards and clean coding practices, this system features role-based portal access with layered managerial authorization and responsive design.

---

## 🚀 Key Highlights & Architectural Standards
This system was refactored from legacy, procedurally-styled code into a modern code layout. It serves as a prime demonstration of **job-ready PHP engineering**, exhibiting:

*   **Object-Oriented Design (OOP)**: Fully encapsulated business logic across clear, modular classes (such as `Database`, `Auth`, `User`, and `Patient`).
*   **PSR-Compliant Dynamic Autoloading**: Leverages PHP's `spl_autoload_register` to eliminate tedious manual inclusion statements and enable seamless, automated class imports.
*   **Prepared Statements & Security (PDO)**: Complete protection against SQL injection vulnerabilities. All database interactions utilize parameterized PDO queries.
*   **Secure Authentication & Session Controls**: High-strength password verification with dynamic session validations and hierarchy authorizations.
*   **Layered Role Hierarchy**: Built-in authorization tree controlling exactly which actions a user can perform based on their administrative clearance level.
*   **Stunning UI with System-Wide Dark Mode**: Fully responsive UI crafted with Tailwind CSS and FontAwesome icons, supporting immediate light/dark toggle and fluid grid layouts.

---

## 🛠️ System Directory Layout
The project follows a neat, professional layout separating views, configurations, and core models:

```text
├── classes/                     # Encapsulated Business & Database Models
│   ├── Database.php             # Core PDO singleton connection class
│   ├── Auth.php                 # User session, login, and authorization logic
│   ├── User.php                 # Administrative personnel and hierarchy model
│   └── Patient.php              # Patient medical record model & logging
├── includes/                    # Shared Layouts and Global Helpers
│   ├── autoloader.php           # Class loader bridge
│   ├── header.php               # Tailwind Navbar and global header template
│   └── footer.php               # Global footer and theme-mode script engine
├── index.php                    # Landing role-selection page
├── login.php                    # Role-specific authentication panel
├── logout.php                   # Secure session termination controller
├── web.php                      # Contextual dashboard (form builder / user list)
├── addnew.php                   # Contextual account registry router
├── addUser.php                  # Account provision controller
├── deleteUser.php               # Account revocation handler
├── display.php                  # Patient records ledger (division filter views)
├── covidrecord_database.php     # Legacy retro-compatibility database bridge
└── covidrecorddatabase.sql      # Consolidated SQL schema & seed dataset
```

---

## 🔐 Dynamic Role-Based Hierarchy
The system supports seven functional roles organized into two primary divisions:

### A. Clinical Division (Data Logging & Processing)
1.  **Doctor**: Records patient status, vaccine brand, dose count, admission & discharge details. Accesses the medical records ledger.
2.  **Lab Technician**: Logs patient diagnostic test statuses and variant classifications. Accesses the medical records ledger.
3.  **Receptionist**: Registers patient visits, personal addresses, and contact numbers. Accesses the medical records ledger.

### B. Administrative Division (Layered Management & Registry Authorization)
The administrative division can audit, delete, and provision accounts according to an strict hierarchical tree:
*   **Admin**: Absolute access. Manages Country Heads, City Heads, Hospital Heads, Doctors, Lab Technicians, and Receptionists.
*   **Country Head**: Manages City Heads, Hospital Heads, Doctors, Lab Technicians, and Receptionists.
*   **City Head**: Manages Hospital Heads, Doctors, Lab Technicians, and Receptionists.
*   **Hospital Head**: Manages local clinic staff (Doctors, Lab Technicians, and Receptionists).

---

## 💻 Technical Setup & Installation Guide

To deploy this project locally on your machine using **XAMPP** or **Wampserver**:

### 1. Database Configuration
1.  Open **phpMyAdmin** in your browser (`http://localhost/phpmyadmin`).
2.  Create a new database named **`covidrecorddatabase`**.
3.  Navigate to the import panel, choose the **`covidrecorddatabase.sql`** file from this project's root folder, and click **Import**.

### 2. File Placement
1.  Copy the entire extracted folder to your server's root directory:
    *   For **XAMPP**: `C:/xampp/htdocs/`
    *   For **WampServer**: `C:/wamp64/www/`
2.  Ensure the directory is named `covid-19-mis` or similar.

### 3. Running the App
1.  Start your Apache and MySQL servers.
2.  Open your browser and navigate to:
    `http://localhost/covid-19-mis` (or your customized directory name).
3.  Access the default credentials from the list below to begin exploring.

---

## 🔑 Demo Seed Accounts
The database comes pre-seeded with the following default credentials for testing and review:

| User Type | Name | Email | Password | Clearance Level |
| :--- | :--- | :--- | :--- | :--- |
| **Admin** | Mr. Sajjad | `Sajjad@gmail.com` | `12345` | Global Audit & Management |
| **Country Head** | Aftaab Ahmad | `Aftaab@gmail.com` | `12345` | National Scope |
| **City Head** | Nasir Ameen | `Nasir@gmail.com` | `12345678` | Regional Scope |
| **Hospital Head** | Mr. Adnan | `Adnan@gmail.com` | `123456` | Hospital Staff Authorization |
| **Doctor** | Abid | `Abid@gmail.com` | `123789` | Clinic Operations |
| **Lab Technician** | Ahmad | `Ahmad@gmail.com` | `Ahmad123` | Patient Diagnostics |
| **Receptionist** | Ali | `Ali@gmail.com` | `12345` | Patient Registration |

*(Note: Legacy plaintext password entries are supported alongside secure BCRYPT hashes for backward database compatibility.)*

---

## 👤 Portfolio and Job Readiness Profile
This project showcases high-performance engineering qualities highly sought after by modern tech companies:
*   **Modern PHP Standards**: Demonstrates separation of concerns without reliance on monolithic frameworks, reflecting true raw PHP competence.
*   **Defensive Security Practices**: Complete protection against parameters hacking, SQL injection, and session hijacking.
*   **Optimized UX Design**: Tailored responsive aesthetics, interactive confirmation prompts, beautiful dark theme triggers, and robust visual feedbacks.

---
*Created as a high-performance demonstration of professional code refactoring.*
