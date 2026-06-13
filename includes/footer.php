    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 py-6 mt-12 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500 dark:text-slate-400">
            <p>&copy; <?= date('Y') ?> COVID-19 Management Information System. Designed with High-Performance Standards.</p>
            <div class="mt-2 flex justify-center gap-4 text-xs">
                <span class="px-2 py-1 rounded bg-teal-50 dark:bg-teal-950 text-teal-700 dark:text-teal-400 border border-teal-100 dark:border-teal-900">OOP PHP</span>
                <span class="px-2 py-1 rounded bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-900">PDO Prepared</span>
                <span class="px-2 py-1 rounded bg-purple-50 dark:bg-purple-950 text-purple-700 dark:text-purple-400 border border-purple-100 dark:border-purple-900">Tailwind CSS</span>
            </div>
        </div>
    </footer>

    <!-- Theme toggler script -->
    <script>
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (document.documentElement.classList.contains('dark')) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('dark-mode', 'false');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('dark-mode', 'true');
            }
        });
    </script>
</body>
</html>
