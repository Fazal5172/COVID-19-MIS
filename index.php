<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::init();

// Support the legacy POST request if it happens
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, '_login') !== false) {
            $role_map = [
                'admin_login' => 'Admin',
                'doctor_login' => 'Doctor',
                'receptionist_login' => 'Receptionist',
                'technician_login' => 'Lab Technician',
                'hhead_login' => 'Hospital Head',
                'cityhead_login' => 'City Head',
                'countryhead_login' => 'Country Head'
            ];
            if (isset($role_map[$key])) {
                $_SESSION['name'] = $role_map[$key];
                header("Location: login.php");
                exit();
            }
        }
    }
}

// Check if already logged in, redirect to portal
if (Auth::getRole()) {
    header("Location: web.php");
    exit();
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto py-12">
    <div class="text-center mb-12 animate-fade-in">
        <h2 class="text-base text-teal-600 dark:text-teal-400 font-semibold tracking-wide uppercase">COVID-19 Portal</h2>
        <p class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
            Management Information System
        </p>
        <p class="mt-4 max-w-2xl text-xl text-slate-500 dark:text-slate-400 mx-auto">
            Select your professional role to access the secure management portal, submit patient activities, and view logs.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php
        $roles = [
            ['name' => 'Doctor', 'icon' => 'fa-user-doctor', 'color' => 'bg-emerald-500', 'desc' => 'Manage clinical activities, treatments & vaccinations.'],
            ['name' => 'Receptionist', 'icon' => 'fa-bell-concierge', 'color' => 'bg-indigo-500', 'desc' => 'Record patient visits and necessary contact details.'],
            ['name' => 'Lab Technician', 'icon' => 'fa-flask-vial', 'color' => 'bg-amber-500', 'desc' => 'Log diagnostic statuses and Covid-19 test types.'],
            ['name' => 'Hospital Head', 'icon' => 'fa-hospital', 'color' => 'bg-rose-500', 'desc' => 'Oversee clinic-level personnel and operations.'],
            ['name' => 'City Head', 'icon' => 'fa-building-shield', 'color' => 'bg-sky-500', 'desc' => 'Monitor local hospital activities and municipal users.'],
            ['name' => 'Country Head', 'icon' => 'fa-globe-asia', 'color' => 'bg-violet-500', 'desc' => 'Access nationwide aggregates and provincial heads.'],
        ];
        foreach ($roles as $role):
        ?>
            <a href="login.php?role=<?= urlencode($role['name']) ?>" class="relative group bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700/80 hover:shadow-xl hover:border-teal-500/50 dark:hover:border-teal-400/50 transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl <?= $role['color'] ?> text-white flex items-center justify-center text-xl shadow-md group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid <?= $role['icon'] ?>"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                        <?= $role['name'] ?>
                    </h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        <?= $role['desc'] ?>
                    </p>
                </div>
                <div class="mt-6 text-sm font-semibold text-teal-600 dark:text-teal-400 flex items-center gap-1 group-hover:gap-2 transition-all">
                    Access Portal <i class="fa-solid fa-arrow-right text-xs"></i>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Admin card at the bottom center -->
    <div class="mt-8 flex justify-center">
        <a href="login.php?role=Admin" class="group bg-white dark:bg-slate-800 px-8 py-5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700/80 hover:shadow-xl hover:border-teal-500/50 dark:hover:border-teal-400/50 transition-all duration-300 flex items-center gap-4 max-w-sm w-full">
            <div class="w-12 h-12 rounded-xl bg-slate-800 dark:bg-slate-700 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                    System Admin
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Manage all system databases and users.
                </p>
            </div>
        </a>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
