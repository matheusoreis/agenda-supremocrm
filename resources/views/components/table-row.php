<?php
$columns = $columns ?? [];
$data = $data ?? [];
$module = $module ?? 'contacts';
?>

<tr class="border-b border-zinc-100 last:border-0 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
    <?php foreach ($columns as $column): ?>
        <td class="px-4 py-3">
            <?php if ($column === 'id'): ?>
                <?php
                $variant = 'default';
                $slot = '#' . htmlspecialchars((string) ($data['id'] ?? ''));
                include __DIR__ . '/badge.php';
                ?>

            <?php elseif (in_array($column, ['abbreviation', 'state_abbr', 'state'], true)): ?>
                <?php
                $variant = 'primary';
                $slot = htmlspecialchars($data[$column] ?? '-');
                include __DIR__ . '/badge.php';
                ?>

            <?php elseif ($column === 'actions'): ?>
                <div class="flex items-center justify-center gap-1">
                    <a href="/<?= $module ?>/<?= $data['id'] ?? '' ?>/edit"
                        class="btn-secondary btn-icon"
                        title="Editar">
                        <?php
                        $name = 'pencil';
                        $class = 'w-4 h-4';
                        include __DIR__ . '/icon.php';
                        ?>
                    </a>
                    <a href="/<?= $module ?>/<?= $data['id'] ?? '' ?>/delete"
                        onclick="return confirm('Tem certeza?')"
                        class="btn-secondary btn-icon hover:!bg-red-50 hover:!text-red-600 dark:hover:!bg-red-950 dark:hover:!text-red-400"
                        title="Excluir">
                        <?php
                        $name = 'trash-2';
                        $class = 'w-4 h-4';
                        include __DIR__ . '/icon.php';
                        ?>
                    </a>
                </div>

            <?php elseif ($column === 'name'): ?>
                <strong class="text-zinc-900 dark:text-zinc-50"><?= htmlspecialchars($data['name'] ?? '-') ?></strong>

            <?php else: ?>
                <?= htmlspecialchars($data[$column] ?? '-') ?>
            <?php endif; ?>
        </td>
    <?php endforeach; ?>
</tr>