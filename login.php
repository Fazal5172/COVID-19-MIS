<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::init();

$role = $_GET['role'] ?? $_SESSION['name'] ?? null;
if (!$role) {
    header("Location: index.php");
    exit();
}
$_SESSION['name'] = $role; // Keep in session for retro-compatibility

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $loginResult = Auth::login($email, $password, $role);
    if ($loginResult === true) {
        header("Location: web.php");
        exit();
    } else {
        $error = $loginResult;
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-md mx-auto my-12 bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700/50">
    <div class="text-center mb-8">
        <a href="index.php" class="inline-flex items-center gap-1 text-sm font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 mb-4 hover:-translate-x-1 transition-all">
            <i class="fa-solid fa-arrow-left"></i> Back to roles
        </a>
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Secure Portal Login</h2>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
            Access as <span class="font-bold text-teal-600 dark:text-teal-400"><?= htmlspecialchars($role) ?></span>
        </p>
    </div>

    <?php if ($error): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200/50 dark:border-red-900/50 text-red-700 dark:text-red-400 flex gap-3 items-center text-sm animate-shake">
            <i class="fa-solid fa-triangle-exclamation text-base"></i>
            <div><?= htmlspecialchars($error) ?></div>
        </div>
    <?php endif; ?>

    <form method="post" class="space-y-5">
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input type="email" name="email" id="email" required placeholder="name@hospital.com" 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all text-sm">
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input type="password" name="password" id="password" required placeholder="••••••••" 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all text-sm">
            </div>
        </div>

        <button type="submit" 
                class="w-full mt-2 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-teal-500/20 hover:shadow-xl hover:shadow-teal-500/30 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In
        </button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
