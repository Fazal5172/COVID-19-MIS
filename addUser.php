<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::checkSession();

$currentUserRole = Auth::getRole();
$managedRoles = User::getManagedRoles($currentUserRole);

$targetRole = $_GET['role'] ?? $_SESSION['user'] ?? null;
if (!$targetRole || !in_array($targetRole, $managedRoles)) {
    header("Location: web.php");
    exit();
}
$_SESSION['user'] = $targetRole; // Keep in session for backward compatibility

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['f_name'] ?? '');
    $email = trim($_POST['f_email'] ?? '');
    $password = $_POST['f_password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        try {
            $existing = User::findByEmail($email);
            if ($existing) {
                $error = "An account with this email address already exists.";
            } else {
                $created = User::create($username, $email, $password, $targetRole);
                if ($created) {
                    $success = "Account for " . htmlspecialchars($username) . " as " . htmlspecialchars($targetRole) . " has been registered successfully.";
                } else {
                    $error = "Something went wrong. Could not register account.";
                }
            }
        } catch (Exception $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-md mx-auto my-12 bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-md border border-slate-200 dark:border-slate-700/50">
    <div class="text-center mb-8">
        <a href="addnew.php" class="inline-flex items-center gap-1 text-sm font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 mb-4 hover:-translate-x-1 transition-all">
            <i class="fa-solid fa-arrow-left"></i> Back to options
        </a>
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Register Account</h2>
        <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
            Adding new <span class="font-bold text-teal-600 dark:text-teal-400"><?= htmlspecialchars($targetRole) ?></span>
        </p>
    </div>

    <?php if ($error): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200/50 dark:border-red-900/50 text-red-700 dark:text-red-400 flex gap-3 items-center text-sm animate-shake">
            <i class="fa-solid fa-triangle-exclamation text-base"></i>
            <div><?= htmlspecialchars($error) ?></div>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200/50 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 flex gap-3 items-center text-sm">
            <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
            <div><?= htmlspecialchars($success) ?></div>
        </div>
    <?php endif; ?>

    <form method="post" class="space-y-5">
        <div>
            <label for="f_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Full Name</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-user"></i>
                </span>
                <input type="text" name="f_name" id="f_name" required placeholder="John Doe" 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all text-sm">
            </div>
        </div>

        <div>
            <label for="f_email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input type="email" name="f_email" id="f_email" required placeholder="john.doe@company.com" 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all text-sm">
            </div>
        </div>

        <div>
            <label for="f_password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input type="password" name="f_password" id="f_password" required placeholder="Choose a strong password" 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all text-sm">
            </div>
        </div>

        <button type="submit" name="submit"
                class="w-full mt-2 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold py-3 rounded-xl shadow-lg shadow-teal-500/20 hover:shadow-xl hover:shadow-teal-500/30 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-user-plus"></i> Save Personnel Account
        </button>
    </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
