<?php
require_once __DIR__ . '/autoloader.php';
Auth::init();
$currentRole = Auth::getRole();
$currentName = Auth::getName();
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 dark:bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COVID-19 MIS - Management Information System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="h-full text-slate-800 dark:text-slate-100 flex flex-col font-sans transition-colors duration-200">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="web.php" class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-teal-600 flex items-center justify-center text-white shadow-md shadow-teal-500/20">
                            <i class="fa-solid fa-virus-covid text-xl animate-pulse"></i>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent dark:from-teal-400 dark:to-cyan-400">
                            COVID-19 MIS
                        </span>
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg focus:outline-none transition-all">
                        <i id="theme-toggle-dark-icon" class="hidden fa-solid fa-moon text-lg"></i>
                        <i id="theme-toggle-light-icon" class="hidden fa-solid fa-sun text-lg"></i>
                    </button>

                    <?php if ($currentName): ?>
                        <!-- User Info -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100"><?= htmlspecialchars($currentName) ?></p>
                                <p class="text-xs text-slate-500 dark:text-slate-400"><?= htmlspecialchars($currentRole) ?></p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 flex items-center justify-center font-bold uppercase shadow-inner border border-teal-200/50 dark:border-teal-800/50">
                                <?= substr($currentName, 0, 1) ?>
                            </div>
                            <a href="logout.php" class="ml-2 text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 flex items-center gap-1 hover:bg-red-50 dark:hover:bg-red-950/20 px-3 py-1.5 rounded-lg transition-all" onclick="return confirm('Are you sure you want to logout?');">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span class="hidden md:inline">Logout</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
