<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::checkSession();

$role = Auth::getRole();
$name = Auth::getName();

$success = null;
$error = null;

// Handle form submissions for clinical staff
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    try {
        if ($role === 'Receptionist') {
            $p_name = trim($_POST['patient_name'] ?? '');
            $p_email = trim($_POST['patientemail'] ?? '');
            $p_age = intval($_POST['patientage'] ?? 0);
            $p_address = trim($_POST['patient_address'] ?? '');
            $p_mobile = trim($_POST['patient_mobileno'] ?? '');
            $p_date = trim($_POST['patient_visitingdate'] ?? '');

            if (empty($p_name) || empty($p_email)) {
                $error = "Patient name and email are required.";
            } else {
                $inserted = Patient::createReceptionistActivity($p_name, $p_email, $p_age, $p_address, $p_mobile, $p_date);
                if ($inserted) {
                    $success = "Patient record successfully registered.";
                } else {
                    $error = "Failed to record patient entry.";
                }
            }
        } elseif ($role === 'Lab Technician') {
            $p_name = trim($_POST['p_name'] ?? '');
            $p_email = trim($_POST['p_email'] ?? '');
            $p_age = intval($_POST['p_age'] ?? 0);
            $p_status = trim($_POST['test_status'] ?? '');
            $p_covid_type = trim($_POST['covid_type'] ?? '');
            $p_date = trim($_POST['test_date'] ?? '');

            if (empty($p_name) || empty($p_email)) {
                $error = "Patient name and email are required.";
            } else {
                $inserted = Patient::createLabActivity($p_name, $p_email, $p_age, $p_status, $p_covid_type, $p_date);
                if ($inserted) {
                    $success = "Patient diagnostic test details recorded.";
                } else {
                    $error = "Failed to log test activity.";
                }
            }
        } elseif ($role === 'Doctor') {
            $p_name = trim($_POST['name'] ?? '');
            $p_email = trim($_POST['email'] ?? '');
            $p_age = intval($_POST['age'] ?? 0);
            $p_status = trim($_POST['test_status'] ?? '');
            $p_covid_type = trim($_POST['covid_type'] ?? '');
            $p_admission_date = trim($_POST['admission_date'] ?? '');
            $p_vaccine_name = trim($_POST['vaccine_name'] ?? '');
            $p_vaccine_dose = intval($_POST['vaccine_dose'] ?? 0);
            $p_vaccination_date = trim($_POST['vaccination_date'] ?? '');
            $p_discharge_date = trim($_POST['discharge_date'] ?? '');

            if (empty($p_name) || empty($p_email)) {
                $error = "Patient name and email are required.";
            } else {
                $inserted = Patient::createDoctorActivity(
                    $p_name, $p_email, $p_age, $p_status, $p_covid_type, 
                    $p_admission_date, $p_vaccine_name, $p_vaccine_dose, 
                    $p_vaccination_date, $p_discharge_date
                );
                if ($inserted) {
                    $success = "Treatment and vaccination details successfully updated.";
                } else {
                    $error = "Failed to update treatment records.";
                }
            }
        }
    } catch (Exception $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}

// Flash messages from other actions (like delete)
if (isset($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}
if (isset($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-7xl mx-auto py-6 animate-fade-in">
    <!-- Portal Banner -->
    <div class="mb-8 p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-teal-600 to-cyan-700 text-white shadow-xl shadow-teal-600/10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black tracking-tight">Welcome, <?= htmlspecialchars($name) ?>!</h2>
            <p class="text-teal-100 text-sm sm:text-base font-semibold mt-1">
                You are logged into the secure <span class="bg-teal-700/60 px-2 py-0.5 rounded-lg border border-teal-500/30"><?= htmlspecialchars($role) ?></span> Workspace.
            </p>
        </div>
        
        <?php if (in_array($role, ['Receptionist', 'Lab Technician', 'Doctor'])): ?>
            <a href="display.php" class="bg-white hover:bg-teal-50 text-teal-800 font-bold px-5 py-3 rounded-xl shadow-lg transition-all flex items-center gap-2 text-sm">
                <i class="fa-solid fa-file-invoice"></i> View Patient Ledger
            </a>
        <?php else: ?>
            <a href="addnew.php" class="bg-white hover:bg-teal-50 text-teal-800 font-bold px-5 py-3 rounded-xl shadow-lg transition-all flex items-center gap-2 text-sm">
                <i class="fa-solid fa-user-plus"></i> Add New Personnel
            </a>
        <?php endif; ?>
    </div>

    <!-- Feedback Alerts -->
    <?php if ($success): ?>
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200/50 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 flex gap-3 items-center text-sm">
            <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
            <div><?= htmlspecialchars($success) ?></div>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200/50 dark:border-red-900/50 text-red-700 dark:text-red-400 flex gap-3 items-center text-sm animate-shake">
            <i class="fa-solid fa-circle-exclamation text-base"></i>
            <div><?= htmlspecialchars($error) ?></div>
        </div>
    <?php endif; ?>

    <?php if ($role === 'Receptionist'): ?>
        <!-- RECEPTIONIST WORKSPACE -->
        <div class="max-w-2xl mx-auto bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-bell text-indigo-500"></i> Register New Patient Visit
            </h3>
            
            <form method="post" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Patient Full Name</label>
                        <input type="text" name="patient_name" required placeholder="Ahmad Ali" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
                        <input type="email" name="patientemail" required placeholder="ahmad@gmail.com" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Patient Age</label>
                        <input type="number" name="patientage" required placeholder="32" min="1" max="120"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Mobile Number</label>
                        <input type="text" name="patient_mobileno" placeholder="03001234567" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Patient Address</label>
                    <input type="text" name="patient_address" placeholder="123 Block, Gulberg, Lahore" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Visiting Date</label>
                    <input type="text" name="patient_visitingdate" placeholder="DD-MM-YYYY" value="<?= date('d-m-Y') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                </div>

                <button type="submit" name="submit"
                        class="w-full mt-2 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-teal-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> Register Patient Visit
                </button>
            </form>
        </div>

    <?php elseif ($role === 'Lab Technician'): ?>
        <!-- LAB TECHNICIAN WORKSPACE -->
        <div class="max-w-2xl mx-auto bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-flask text-amber-500"></i> Log Patient Covid Diagnostic Test
            </h3>
            
            <form method="post" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Patient Full Name</label>
                        <input type="text" name="p_name" required placeholder="Ahmad Ali" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
                        <input type="email" name="p_email" required placeholder="ahmad@gmail.com" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Patient Age</label>
                        <input type="number" name="p_age" required placeholder="32" min="1" max="120"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Test Status</label>
                        <select name="test_status" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                            <option value="+ve">Positive (+ve)</option>
                            <option value="-ve">Negative (-ve)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Covid Type / Variant</label>
                        <input type="text" name="covid_type" placeholder="SARS-CoV-2 (Delta / Omicron)" value="SARS-CoV-2"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Test Date</label>
                        <input type="text" name="test_date" placeholder="DD-MM-YYYY" value="<?= date('d-m-Y') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                </div>

                <button type="submit" name="submit"
                        class="w-full mt-2 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-teal-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> Submit Test Details
                </button>
            </form>
        </div>

    <?php elseif ($role === 'Doctor'): ?>
        <!-- DOCTOR WORKSPACE -->
        <div class="max-w-2xl mx-auto bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-stethoscope text-emerald-500"></i> Update Patient Treatment & Vaccine
            </h3>
            
            <form method="post" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Patient Full Name</label>
                        <input type="text" name="name" required placeholder="Ahmad Ali" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
                        <input type="email" name="email" required placeholder="ahmad@gmail.com" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Patient Age</label>
                        <input type="number" name="age" required placeholder="32" min="1" max="120"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Test Status</label>
                        <select name="test_status" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                            <option value="+ve">Positive (+ve)</option>
                            <option value="-ve">Negative (-ve)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Covid Type</label>
                        <input type="text" name="covid_type" placeholder="SARS-CoV-2" value="SARS-CoV-2"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Admission Date</label>
                        <input type="text" name="admission_date" placeholder="DD-MM-YYYY" value="<?= date('d-m-Y') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Discharge Date</label>
                        <input type="text" name="discharge_date" placeholder="DD-MM-YYYY"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-sm">
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700/80 space-y-4">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">Vaccine Particulars</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">Vaccine Brand</label>
                            <input type="text" name="vaccine_name" placeholder="AstraZeneca / Pfizer" 
                                   class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">Dose Count</label>
                            <input type="number" name="vaccine_dose" placeholder="2" min="0" max="5" value="1"
                                   class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">Vaccination Date</label>
                        <input type="text" name="vaccination_date" placeholder="DD-MM-YYYY"
                               class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 text-xs">
                    </div>
                </div>

                <button type="submit" name="submit"
                        class="w-full mt-2 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-teal-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> Save Treatment Plan
                </button>
            </form>
        </div>

    <?php else: ?>
        <!-- MANAGEMENT WORKSPACE (Hospital Head, City Head, Country Head, Admin) -->
        <?php
        $managedRoles = User::getManagedRoles($role);
        $managedUsers = [];
        try {
            $managedUsers = User::getByRoles($managedRoles);
        } catch (Exception $e) {
            $error = "Could not fetch user directory: " . $e->getMessage();
        }
        ?>
        
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700/50 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50 dark:bg-slate-800/50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Authorized Clinical & Administrative Personnel</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Directory of accounts authorized under your administrative scope.</p>
                </div>
                
                <a href="addnew.php" class="bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 shadow-md">
                    <i class="fa-solid fa-user-plus text-xs"></i> Add New Account
                </a>
            </div>

            <div class="overflow-x-auto">
                <?php if (empty($managedUsers)): ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-950 flex items-center justify-center text-slate-400 dark:text-slate-600 text-2xl mx-auto mb-4">
                            <i class="fa-solid fa-users-slash"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">No Personnel Registered</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                            No active accounts have been registered under your jurisdiction yet. Click the Add button above to provision a new staff account.
                        </p>
                    </div>
                <?php else: ?>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/40 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase border-b border-slate-200 dark:border-slate-700/50">
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Avatar</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email Address</th>
                                <th class="px-6 py-4">Authorization Role</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/40">
                            <?php foreach ($managedUsers as $user): ?>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/20 transition-all text-sm text-slate-700 dark:text-slate-300">
                                    <td class="px-6 py-4 font-mono font-bold text-slate-400 dark:text-slate-500"><?= htmlspecialchars($user['id']) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-xs">
                                            <?= substr($user['name'], 0, 1) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($user['name']) ?></td>
                                    <td class="px-6 py-4 font-mono text-xs"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $badges = [
                                            'Doctor' => 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/50',
                                            'Receptionist' => 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-400 border-indigo-100 dark:border-indigo-900/50',
                                            'Lab Technician' => 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border-amber-100 dark:border-amber-900/50',
                                            'Hospital Head' => 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border-rose-100 dark:border-rose-900/50',
                                            'City Head' => 'bg-sky-50 dark:bg-sky-950/40 text-sky-700 dark:text-sky-400 border-sky-100 dark:border-sky-900/50',
                                            'Country Head' => 'bg-violet-50 dark:bg-violet-950/40 text-violet-700 dark:text-violet-400 border-violet-100 dark:border-violet-900/50',
                                        ];
                                        $badgeStyle = $badges[$user['usertype']] ?? 'bg-slate-50 text-slate-700';
                                        ?>
                                        <span class="px-2.5 py-0.5 rounded-lg border text-xs font-semibold <?= $badgeStyle ?>">
                                            <?= htmlspecialchars($user['usertype']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="deleteUser.php?id=<?= $user['id'] ?>" 
                                           class="inline-flex items-center gap-1 text-xs font-bold text-red-600 hover:text-red-700 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-950/30 px-2.5 py-1.5 rounded-lg transition-all"
                                           onclick="return confirm('WARNING: Are you sure you want to permanently revoke this account and remove them from the registry?');">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Revoke
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
