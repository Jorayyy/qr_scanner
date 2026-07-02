# 🏫 Campus Visitor Log & ID Verification System with Multi-Office QR Tracking

An enterprise-ready, offline-hardened web application built to digitalize traditional paper logbooks at state universities. This system enables real-time visitor profiling, automated check-in/check-out timestamps, dynamic single-use QR pass generation, and multi-office chronological tracking across campus departments.

---

## 🚀 System Architecture Overview
The application utilizes a **centralized client-server architecture**. The entire ecosystem (database and routing engines) runs from a single laptop or PC acting as the central host network server. Other department devices (office desktops, laptops, tablets, or security phones) require **no installation**—they simply access the portal interfaces natively via a web browser over the shared local campus network line.

---

## 🛠️ Phase 1: Installing the Core Backend Prerequisites

Before running the application, you must install the fundamental runtime environments on your target laptop or PC server machine.

### 1. Download and Configure Standalone PHP 8.2+
Since the application runs locally without complex packages, a clean standalone zip distribution of PHP is required.

1. Go to the official repository layout page: [PHP for Windows Downloads](https://php.net).
2. Download the **VS16 x64 Thread Safe** ZIP file distribution.
3. Extract the contents of the ZIP folder directly to a new directory named `C:\php`.
4. Open `C:\php`, find the file named `php.ini-development`, and rename it exactly to **`php.ini`**.
5. Open `php.ini` inside a text editor (like VS Code or Notepad) and configure these core engine rows:
   * **Uncomment the Extensions Path (Around Line 758):** Change `;extension_dir = "ext"` to:
     ```text
     extension_dir = "C:\php\ext"
     ```
   * **Enable Core Framework Extensions:** Locate the following lines and **remove the leading semicolon (`;`)** from the front of each to activate them:
     ```text
     extension=curl
     extension=mbstring
     extension=openssl
     extension=pdo_sqlite
     ```
6. **Register PHP in System Environment Variables:**
   * Search for **"Environment Variables"** in the Windows Start Menu and select it.
   * Click on **Environment Variables...** at the bottom right.
   * Under *System variables*, click on the **Path** variable and choose **Edit...**.
   * Click **New** and paste the exact folder string: `C:\php`.
   * Click **OK** to close all prompt windows. Open a fresh terminal and run `php -v` to verify successful installation.

### 2. Install Composer (Dependency Manager for PHP)
Composer compiles and tracks internal Laravel framework classes.

1. Navigate to the installation hub page: [GetComposer.org](https://getcomposer.org).
2. Download and run the **Composer-Setup.exe** installer binary file.
3. During setup, the installer will automatically detect your active PHP path layout line (`C:\php\php.exe`). Keep clicking Next to finish.
4. Open your terminal window and verify the configuration by typing:
   ```bash
   composer --version
   ```

### 3. Install Node.js & NPM (Frontend Assets Processor)
Node handles asset compiler tasks for compiling local styling templates.

1. Navigate to the distribution hub: [Node.js Official Downloads](https://nodejs.org).
2. Download the **LTS (Long Term Support)** installer package for Windows.
3. Run the installer and click through the prompt steps until finished.
4. Verify deployment inside your terminal by checking the version codes:
   ```bash
   node -v
   npm -v
   ```

---

## 💻 Phase 2: Local Project Setup and Deployment Instructions

Once your prerequisites are active, pull down the repository and run through these commands to fire up the system data loops:

### 1. Clone or Move into the Repository Layout Folder
Open your terminal window and switch straight into your project folder workspace:
```powershell
cd campus-visitor-system
```

### 2. Install Framework Backend Dependencies
Compile all the vendor framework core classes using Composer:
```powershell
composer install
```

### 3. Install Frontend Interface Dependencies
Install and process the Tailwind UI compiling engines:
```powershell
npm install
```

### 4. Create the Local Environment Configurations File
Duplicate Laravel's configuration template blueprint so your backend server can read local storage profiles:
```powershell
copy .env.example .env
```

### 5. Generate the Secure Application Encryption Key
Stamp an encrypted application key into your `.env` configuration data:
```powershell
php artisan key:generate
```

### 6. Build the Local SQLite Database Table Structures
Initialize a fresh database file storage point and push your structural tracking tables into it:
1. Make an empty file inside your directory tree named exactly: `database/database.sqlite`.
2. Push your code migration blueprints straight into the active schema by running:
   ```powershell
   php artisan migrate:fresh
   ```

---

## 🚀 Phase 3: Launching the Active Development Servers

To fully operate the portal systems, you must run **two concurrent server streams** in the background. Open separate terminal tabs inside your VS Code panel workspace to fire up each branch:

### Tab 1: Boot Up the Core Backend PHP Engine
This maps and compiles the database data triggers:
```powershell
php artisan serve
```
*Your application is now hosted locally at: `http://127.0.0.1:8000` (or `http://localhost:8000`)*

### Tab 2: Fire Up the Vite Live Styling Monitor
This keeps the design engines active:
```powershell
npm run dev
```

---

## 📱 Phase 4: Deploying Multi-Office Smart Mobile Tracking Over Wi-Fi

To connect physical smartphones (like a guard's mobile or a department clerk's device) straight to your host server without any cloud hosting fees, follow these steps:

### 1. Locate Your Host Machine’s Local Network IP Address
Open a fresh terminal tab on your host PC and execute:
```powershell
ipconfig
```
Look down the output lines under *Wireless LAN adapter Wi-Fi* and copy your **`IPv4 Address`** string (e.g., `192.168.1.15`).

### 2. Force the Backend Server to Bind Globally
Stop your running `php artisan serve` thread using `Ctrl + C`, and launch it using this global connection link command (replace with your exact IPv4 address found above):
```powershell
php artisan serve --host=YOUR_IP_ADDRESS --port=8000
```
*Example: `php artisan serve --host=192.168.1.15 --port=8000`*

### 3. Link External Client Devices Over the Shared Network
1. Make sure your testing smartphone or target desktop device is connected to the **exact same Wi-Fi network line** as your host laptop server.
2. Open a standard web browser on that smartphone and type the IP route link to access the terminal interfaces directly:

*   **To Register New Guests:** `http://YOUR_IP_ADDRESS:8000/register`
*   **The Security Guard/Office Scanner Portal:** `http://YOUR_IP_ADDRESS:8000/gate/scanner`
*   **The Central Admin Control Dashboard:** `http://YOUR_IP_ADDRESS:8000/admin/dashboard`

---

## 🔒 Master System Security Access Credentials

The Administration Log panel is protected behind a firewall check. Use these default security authorization login codes to enter:

*   **Security Username:** `admin`
*   **Security Password:** `password123`

---

## 📊 Live Verification and Tracking Lifecycle Validation Flow
To demonstrate the system to your research panel, follow this exact lifecycle sequence:
1. **Register:** Access `/register`, fill out the fields, and click **Download QR Pass**. A clean `.png` file will download to your device folder.
2. **Check-In:** Go to `/gate/scanner`, leave the location selector set to **Main Gate**, and upload the file. Access is granted and the time-in is stamped.
3. **Inner Tracking Hop:** Return to the scanner, switch the station location menu dropdown option to **Registrar Office**, and re-upload the file. The card states **"Location Tracked"**.
4. **Dashboard Audit:** Refresh `/admin/dashboard`. The rows matrix will update live, displaying **Registrar Office** as their active location, alongside a permanent chronological history breadcrumb tracking trail matching their hops!
5. **Check-Out:** Return to the scanner, change the selector option back to **Main Gate**, and upload the pass file one final time. The system approves departure, closes the data loops, and securely deactivates the token pass forever.
