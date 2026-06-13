<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::checkSession();

$role = Auth::getRole();
$name = Auth::getName();

// Clinical roles can view lists of patient records
$clinicalRoles = ['Receptionist', 'Lab Technician', 'Doctor'];
if (!in_array($role, $clinicalRoles)) {
    header("Location: web.php");
    exit();
}

$records = [];
$error = null;

try {
    if ($role === 'Receptionist') {
        $records = Patient::getReceptionistActivities();
    } elseif ($role === 'Lab Technician') {
        $records = Patient::getLabActivities();
    } elseif ($role === 'Doctor') {
        $records = Patient::getDoctorActivities();
    }
} catch (Exception $e) {
    $error = "Database Error: " . $e->getMessage();
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-7xl mx-auto py-6 animate-fade-in">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="web.php" class="inline-flex items-center gap-1 text-sm font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 hover:-translate-x-1 transition-all">
                <i class="fa-solid fa-arrow-left"></i> Back to Form Dashboard
            </a>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-4"><?= htmlspecialchars($role) ?> Patient Ledger</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Viewing registered clinical activities and patient medical histories.
            </p>
        </div>
        
        <div>
            <a href="web.php" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold px-5 py-2.5 rounded-xl shadow-md shadow-teal-500/10 hover:shadow-lg transition-all text-sm">
                <i class="fa-solid fa-plus"></i> Add Patient Entry
            </a>
        </div>
    </div>

    <?php if ($error): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200/50 dark:border-red-900/50 text-red-700 dark:text-red-400 flex gap-3 items-center text-sm">
            <i class="fa-solid fa-triangle-exclamation text-base"></i>
            <div><?= htmlspecialchars($error) ?></div>
        </div>
    <?php endif; ?>

    <!-- Stats Ledger Banner -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Records Found</p>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white"><?= count($records) ?></h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">System Status</p>
                <h3 class="text-base font-bold text-emerald-600 dark:text-emerald-400">Live Database Synced</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-shield-virus"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Department</p>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-200"><?= htmlspecialchars($role) ?></h3>
            </div>
        </div>
    </div>

    <!-- Patient Records Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700/80 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Patient Record Ledger</h3>
            <span class="text-xs px-2.5 py-1 rounded-full bg-teal-50 dark:bg-teal-950 text-teal-700 dark:text-teal-400 font-semibold uppercase border border-teal-100/50 dark:border-teal-900/50">
                <?= htmlspecialchars($role) ?> Data
            </span>
        </div>

        <div class="overflow-x-auto">
            <?php if (empty($records)): ?>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-950 flex items-center justify-center text-slate-400 dark:text-slate-600 text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No Patient Records</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                        There are no patient records logged in this division yet. Create a new patient entry to populate the ledger.
                    </p>
                </div>
            <?php else: ?>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-900/40 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase border-b border-slate-200 dark:border-slate-700/50">
                            <?php if ($role === 'Receptionist'): ?>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Age</th>
                                <th class="px-6 py-4">Address</th>
                                <th class="px-6 py-4">Mobile Number</th>
                                <th class="px-6 py-4">Visiting Date</th>
                            <?php elseif ($role === 'Lab Technician'): ?>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Age</th>
                                <th class="px-6 py-4">Test Status</th>
                                <th class="px-6 py-4">Covid Type</th>
                                <th class="px-6 py-4">Test Date</th>
                            <?php elseif ($role === 'Doctor'): ?>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Age</th>
                                <th class="px-6 py-4">Test Status</th>
                                <th class="px-6 py-4">Covid Type</th>
                                <th class="px-6 py-4">Admission Date</th>
                                <th class="px-6 py-4">Vaccine Details</th>
                                <th class="px-6 py-4">Dates (Vac / Dis)</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/40">
                        <?php foreach ($records as $record): ?>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/20 transition-all text-sm text-slate-700 dark:text-slate-300">
                                <?php if ($role === 'Receptionist'): ?>
                                    <td class="px-6 py-4 font-mono font-bold text-slate-400 dark:text-slate-500"><?= htmlspecialchars($record['Id']) ?></td>
                                    <td class="px-6 py-4 font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($record['patient_name']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($record['patientemail']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($record['patientage']) ?> yrs</td>
                                    <td class="px-6 py-4 max-w-xs truncate"><?= htmlspecialchars($record['patient_address']) ?></td>
                                    <td class="px-6 py-4 font-mono"><?= htmlspecialchars($record['patient_mobileno']) ?></td>
                                    <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white"><?= htmlspecialchars($record['patient_visitingdate']) ?></td>
                                <?php elseif ($role === 'Lab Technician'): ?>
                                    <td class="px-6 py-4 font-mono font-bold text-slate-400 dark:text-slate-500"><?= htmlspecialchars($record['ID']) ?></td>
                                    <td class="px-6 py-4 font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($record['p_name']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($record['p_email']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($record['p_age']) ?> yrs</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full font-bold text-xs <?= strpos(strtolower($record['test_status']), '+ve') !== false || strpos(strtolower($record['test_status']), 'positive') !== false ? 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-100 dark:border-rose-900/50' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50' ?>">
                                            <?= htmlspecialchars($record['test_status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium"><?= htmlspecialchars($record['covid_type']) ?></td>
                                    <td class="px-6 py-4 font-mono"><?= htmlspecialchars($record['test_date']) ?></td>
                                <?php elseif ($role === 'Doctor'): ?>
                                    <td class="px-6 py-4 font-mono font-bold text-slate-400 dark:text-slate-500"><?= htmlspecialchars($record['iD']) ?></td>
                                    <td class="px-6 py-4 font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($record['name']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($record['email']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($record['age']) ?> yrs</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full font-bold text-xs <?= strpos(strtolower($record['test_status']), '+ve') !== false || strpos(strtolower($record['test_status']), 'positive') !== false ? 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400' ?>">
                                            <?= htmlspecialchars($record['test_status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($record['covid_type']) ?></td>
                                    <td class="px-6 py-4 font-mono"><?= htmlspecialchars($record['admission_date']) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($record['vaccine_name']) ?></div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Doses: <span class="font-bold"><?= htmlspecialchars($record['vaccine_dose']) ?></span></div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs space-y-1">
                                        <div>Vac: <span class="text-slate-900 dark:text-white font-semibold"><?= htmlspecialchars($record['vaccination_date']) ?></span></div>
                                        <div>Dis: <span class="text-slate-900 dark:text-white font-semibold"><?= htmlspecialchars($record['discharge_date']) ?></span></div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
