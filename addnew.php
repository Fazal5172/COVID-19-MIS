<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::checkSession();

$role = Auth::getRole();
$managedRoles = User::getManagedRoles($role);

if (empty($managedRoles)) {
    header("Location: web.php");
    exit();
}

// Support legacy POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_login') !== false) {
            $role_map = [
                'doctor_login' => 'Doctor',
                'receptionist_login' => 'Receptionist',
                'technician_login' => 'Lab Technician',
                'hhead_login' => 'Hospital Head',
                'cityhead_login' => 'City Head',
                'countryhead_login' => 'Country Head'
            ];
            if (isset($role_map[$key])) {
                $_SESSION['user'] = $role_map[$key];
                header("Location: addUser.php");
                exit();
            }
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-2xl mx-auto py-12">
    <div class="mb-8">
        <a href="web.php" class="inline-flex items-center gap-1 text-sm font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 hover:-translate-x-1 transition-all">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-4">Add New Personnel</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            As a <span class="font-bold text-teal-600 dark:text-teal-400"><?= htmlspecialchars($role) ?></span>, you can register and authorize the following user types:
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <?php
        $roleDetails = [
            'Doctor' => ['icon' => 'fa-user-doctor', 'color' => 'bg-emerald-500'],
            'Receptionist' => ['icon' => 'fa-bell-concierge', 'color' => 'bg-indigo-500'],
            'Lab Technician' => ['icon' => 'fa-flask-vial', 'color' => 'bg-amber-500'],
            'Hospital Head' => ['icon' => 'fa-hospital', 'color' => 'bg-rose-500'],
            'City Head' => ['icon' => 'fa-building-shield', 'color' => 'bg-sky-500'],
            'Country Head' => ['icon' => 'fa-globe-asia', 'color' => 'bg-violet-500'],
        ];

        foreach ($managedRoles as $managedRole):
            $details = $roleDetails[$managedRole] ?? ['icon' => 'fa-user', 'color' => 'bg-slate-500'];
        ?>
            <a href="addUser.php?role=<?= urlencode($managedRole) ?>" class="group bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm hover:shadow-md hover:border-teal-500/40 dark:hover:border-teal-400/40 flex items-center justify-between transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl <?= $details['color'] ?> text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition-all">
                        <i class="fa-solid <?= $details['icon'] ?>"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-950 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                            <?= htmlspecialchars($managedRole) ?>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Authorize new accounts</p>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-900 group-hover:bg-teal-50 dark:group-hover:bg-teal-950/50 flex items-center justify-center text-slate-400 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-all text-sm">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
