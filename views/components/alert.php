<?php
$message = $message ?? null;
$type = $type ?? 'info';
$dismissible = $dismissible ?? false;
$icon = $icon ?? null;

$alertId = 'alert-' . uniqid();
?>

<?php if ($message): ?>
    <div id="<?= $alertId ?>" class="mb-4 rounded-md border px-4 py-3 text-sm flex items-center justify-between
        <?php if ($type === 'success'): ?>
            border-green-200 bg-green-50 text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-300
        <?php elseif ($type === 'danger' || $type === 'error'): ?>
            border-red-200 bg-red-50 text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-300
        <?php elseif ($type === 'warning'): ?>
            border-yellow-200 bg-yellow-50 text-yellow-800 dark:border-yellow-900 dark:bg-yellow-950 dark:text-yellow-300
        <?php else: ?>
            border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-900 dark:bg-blue-950 dark:text-blue-300
        <?php endif; ?>
    ">
        <div class="flex items-center gap-2">
            <?php if ($icon): ?>
                <span><?= $icon ?></span>
            <?php endif; ?>
            <span><?= htmlspecialchars($message) ?></span>
        </div>

        <?php if ($dismissible): ?>
            <?php
            $variant = 'ghost';
            $size = 'sm';
            $icon = 'x';
            $type = 'button';
            $class = 'h-6 w-6 p-0 text-current hover:bg-transparent opacity-70 hover:opacity-100 flex-shrink-0';
            $onclick = "document.getElementById('{$alertId}').remove()";
            include __DIR__ . '/button.php';
            ?>
        <?php endif; ?>
    </div>
<?php endif; ?>