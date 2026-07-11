<?php

/** @var array $states */
/** @var int $total */
/** @var int $page */
/** @var int $lastPage */
/** @var int $perPage */
/** @var string|null $search */

require_once __DIR__ . '/../../../src/Helpers/helpers.php';
?>

<div class="flex items-center justify-between mb-10">
    <h2 class="text-xl font-semibold flex items-center gap-2">
        <?= render_component('icon', ['name' => 'map-pin', 'class' => 'w-5 h-5']) ?>
        Estados
        <span class="text-sm font-normal text-zinc-500 dark:text-zinc-400">
            (<?= number_format($total, 0, ',', '.') ?> total)
        </span>
    </h2>

    <div class="flex gap-2">
        <?= render_component('button', [
            'variant' => 'primary',
            'size' => 'md',
            'icon' => 'plus',
            'label' => 'Novo',
            'onclick' => "window.location.href='/states/create'"
        ]) ?>

        <?= render_component('button', [
            'variant' => 'secondary',
            'size' => 'md',
            'icon' => 'cloud-download',
            'label' => 'Importar do IBGE',
            'onclick' => "window.location.href='/states/import'"
        ]) ?>
    </div>
</div>

<div class="flex gap-2 mb-4">
    <form method="GET" action="/states" class="flex gap-2 w-full">
        <div class="flex-1">
            <?= render_component('input', [
                'id' => 'search',
                'name' => 'search',
                'value' => $search ?? '',
                'placeholder' => 'Pesquisar por nome ou sigla...',
                'class' => 'flex-1'
            ]) ?>
        </div>

        <?= render_component('button', [
            'variant' => 'primary',
            'size' => 'md',
            'icon' => 'search',
            'label' => 'Buscar',
            'type' => 'submit'
        ]) ?>

        <?= render_component('button', [
            'variant' => 'destructive',
            'size' => 'md',
            'icon' => 'x',
            'label' => 'Limpar',
            'onclick' => "window.location.href='/states'"
        ]) ?>
    </form>
</div>

<?php
$headers = ['ID', 'Nome', 'Sigla', ['label' => 'Ações', 'align' => 'center']];
ob_start();
?>

<?php if (empty($states)): ?>
    <tr>
        <td colspan="4" class="px-4 py-14 text-center">
            <?= render_component('empty-state', [
                'icon' => 'map-pin',
                'title' => 'Nenhum estado encontrado',
                'description' => 'Clique em "Novo" para adicionar.'
            ]) ?>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($states as $state): ?>
        <?php
        $data = $state;
        $columns = ['id', 'name', 'abbreviation', 'actions'];
        $module = 'states';
        ?>
        <?= render_component('table-row', [
            'data' => $data,
            'columns' => $columns,
            'module' => $module
        ]) ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$slot = ob_get_clean();
?>

<?= render_component('table', [
    'headers' => $headers,
    'slot' => $slot,
    'total' => $total ?? 0,
    'page' => $page ?? 1,
    'lastPage' => $lastPage ?? 1,
    'perPage' => $perPage ?? 20,
    'search' => $search ?? null
]) ?>