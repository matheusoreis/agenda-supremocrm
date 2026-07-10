<?php
$headers = $headers ?? [];
$slot = $slot ?? '';
?>

<div class="overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-800">
    <table class="w-full text-sm">
        <?php if (!empty($headers)): ?>
            <thead>
                <tr class="border-b border-zinc-200 bg-zinc-50/50 text-left text-xs uppercase tracking-wide text-zinc-500 dark:border-zinc-800 dark:bg-zinc-900/50 dark:text-zinc-400">
                    <?php foreach ($headers as $header): ?>
                        <th class="px-4 py-3 font-medium <?= isset($header['align']) ? 'text-' . $header['align'] : '' ?>">
                            <?= $header['label'] ?? $header ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
        <?php endif; ?>
        <tbody>
            <?= $slot ?>
        </tbody>
    </table>
</div>