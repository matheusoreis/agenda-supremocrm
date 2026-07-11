<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos</title>

    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        (function() {
            var theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer base {
            html { @apply font-sans; }
            body { @apply bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-50; }
        }
        @layer components {
            .btn { @apply inline-flex items-center justify-center gap-1.5 whitespace-nowrap rounded-md text-sm font-medium transition-colors h-9 px-4 py-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-2 dark:focus-visible:ring-zinc-300 dark:focus-visible:ring-offset-zinc-950 disabled:pointer-events-none disabled:opacity-50; }
            .btn-primary { @apply btn bg-zinc-900 text-zinc-50 hover:bg-zinc-800 dark:bg-zinc-50 dark:text-zinc-900 dark:hover:bg-zinc-200; }
            .btn-secondary { @apply btn border border-zinc-200 bg-white text-zinc-900 hover:bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:hover:bg-zinc-900; }
            .btn-destructive { @apply btn bg-red-600 text-white hover:bg-red-700; }
            .btn-sm { @apply h-8 px-3 text-xs; }
            .btn-icon { @apply h-8 w-8 p-0 rounded-md; }
            .input { @apply flex h-9 w-full rounded-md border border-zinc-200 bg-white px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-zinc-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-900 focus-visible:ring-offset-1 disabled:opacity-50 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-50 dark:focus-visible:ring-zinc-300 dark:focus-visible:ring-offset-zinc-950; }
            .label { @apply block text-sm font-medium text-zinc-900 dark:text-zinc-50 mb-1.5; }
            .card { @apply rounded-lg border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900; }
            .badge { @apply inline-flex items-center rounded-md border border-zinc-200 px-2 py-0.5 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:text-zinc-300; }
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">

        <nav class="flex items-center justify-between gap-2 mb-6">
            <a href="/contacts" class="flex items-center gap-2 font-semibold text-lg shrink-0">
                <?php
                $name = 'album';
                $class = 'w-7 h-7 sm:w-8 sm:h-8';
                include __DIR__ . '/../components/icon.php';
                ?>
            </a>

            <div class="flex items-center gap-1 overflow-x-auto">
                <?php
                $variant = 'outline';
                $size = 'md';
                $icon = 'users';
                $label = 'Contatos';
                $labelClass = 'hidden sm:inline';
                $onclick = "window.location.href='/contacts'";
                include __DIR__ . '/../components/button.php';
                ?>

                <?php
                $variant = 'outline';
                $size = 'md';
                $icon = 'map-pin';
                $label = 'Estados';
                $labelClass = 'hidden sm:inline';
                $onclick = "window.location.href='/states'";
                include __DIR__ . '/../components/button.php';
                ?>

                <?php
                $variant = 'outline';
                $size = 'md';
                $icon = 'building-2';
                $label = 'Cidades';
                $labelClass = 'hidden sm:inline';
                $onclick = "window.location.href='/cities'";
                include __DIR__ . '/../components/button.php';
                ?>

                <?php
                $variant = 'primary';
                $size = 'icon';
                $id = 'theme-toggle';
                $type = 'button';
                $icon = 'sun';
                $iconPosition = 'left';
                include __DIR__ . '/../components/button.php';
                ?>
            </div>
        </nav>

        <?php if (isset($flash) && $flash): ?>
            <?php
            $type = 'success';
            $message = $flash;
            $dismissible = true;
            include __DIR__ . '/../components/alert.php';
            ?>
        <?php endif; ?>

        <?php if (isset($error) && $error): ?>
            <?php
            $type = 'error';
            $message = $error;
            $dismissible = true;
            include __DIR__ . '/../components/alert.php';
            ?>
        <?php endif; ?>

        <main>
            <?= $content ?? '' ?>
        </main>

        <footer class="mt-12 pt-6 border-t border-zinc-200 dark:border-zinc-800 text-center text-xs text-zinc-400 dark:text-zinc-500">
            &copy; <?= date('Y') ?> Agenda de Contatos Supremo CRM
        </footer>
    </div>

    <script src="/js/script.js"></script>
</body>

</html>