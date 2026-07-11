<?php
$headers = $headers ?? [];
$slot = $slot ?? '';
$total = $total ?? 0;
$page = $page ?? 1;
$lastPage = $lastPage ?? 1;
$perPage = $perPage ?? 20;
$search = $search ?? null;
$showPagination = $showPagination ?? ($lastPage > 1);
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

<?php if ($showPagination && $lastPage > 1): ?>
    <div class="flex items-center justify-between mt-4">
        <div class="text-sm text-zinc-500 dark:text-zinc-400">
            Mostrando <?= $perPage ?> de <?= number_format($total, 0, ',', '.') ?> registros
        </div>
        <div class="flex gap-1">
            <?php if ($page > 1): ?>
                <?php
                $url = '?page=' . ($page - 1) . ($search ? '&search=' . urlencode($search) : '');
                echo render_component('button', [
                    'variant' => 'secondary',
                    'size' => 'sm',
                    'label' => 'Anterior',
                    'onclick' => "window.location.href='{$url}'"
                ]);
                ?>
            <?php endif; ?>

            <?php
            $start = max(1, $page - 2);
            $end = min($lastPage, $page + 2);
            ?>

            <?php if ($start > 1): ?>
                <?php
                $url = '?page=1' . ($search ? '&search=' . urlencode($search) : '');
                echo render_component('button', [
                    'variant' => 'secondary',
                    'size' => 'sm',
                    'label' => '1',
                    'onclick' => "window.location.href='{$url}'"
                ]);
                ?>
                <?php if ($start > 2): ?>
                    <span class="btn-secondary btn-sm disabled opacity-50 cursor-default">…</span>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <?php
                $url = '?page=' . $i . ($search ? '&search=' . urlencode($search) : '');
                $variant = ($i === $page) ? 'primary' : 'secondary';
                echo render_component('button', [
                    'variant' => $variant,
                    'size' => 'sm',
                    'label' => (string) $i,
                    'onclick' => "window.location.href='{$url}'"
                ]);
                ?>
            <?php endfor; ?>

            <?php if ($end < $lastPage): ?>
                <?php if ($end < $lastPage - 1): ?>
                    <span class="btn-secondary btn-sm disabled opacity-50 cursor-default">…</span>
                <?php endif; ?>
                <?php
                $url = '?page=' . $lastPage . ($search ? '&search=' . urlencode($search) : '');
                echo render_component('button', [
                    'variant' => 'secondary',
                    'size' => 'sm',
                    'label' => (string) $lastPage,
                    'onclick' => "window.location.href='{$url}'"
                ]);
                ?>
            <?php endif; ?>

            <?php if ($page < $lastPage): ?>
                <?php
                $url = '?page=' . ($page + 1) . ($search ? '&search=' . urlencode($search) : '');
                echo render_component('button', [
                    'variant' => 'secondary',
                    'size' => 'sm',
                    'label' => 'Próxima',
                    'onclick' => "window.location.href='{$url}'"
                ]);
                ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>