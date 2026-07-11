<?php

/** @var array $cities */
/** @var int $total */
/** @var int $page */
/** @var int $lastPage */
/** @var int $perPage */
/** @var string|null $search */

require_once __DIR__ . '/../../../src/Helpers/helpers.php';
?>

<div class="flex items-center justify-between mb-10">
    <h2 class="text-xl font-semibold flex items-center gap-2">
        <?= render_component('icon', ['name' => 'building-2', 'class' => 'w-5 h-5']) ?>
        Cidades
    </h2>

    <div class="flex gap-2">
        <?= render_component('button', [
            'variant' => 'primary',
            'size' => 'md',
            'icon' => 'plus',
            'label' => 'Nova',
            'onclick' => "window.location.href='/cities/create'"
        ]) ?>

        <?= render_component('button', [
            'variant' => 'secondary',
            'size' => 'md',
            'icon' => 'cloud-download',
            'label' => 'Importar do IBGE',
            'onclick' => "window.location.href='/cities/import'"
        ]) ?>
    </div>
</div>

<div class="flex gap-2 mb-4">
    <form method="GET" action="/cities" class="flex gap-2 w-full">
        <div class="flex-1">
            <?= render_component('input', [
                'id' => 'search',
                'name' => 'search',
                'value' => $search ?? '',
                'placeholder' => 'Pesquisar por nome ou estado...',
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
            'onclick' => "window.location.href='/cities'"
        ]) ?>
    </form>
</div>

<?php
$headers = ['ID', 'Nome', 'Estado', 'Sigla', ['label' => 'Ações', 'align' => 'center']];
ob_start();
?>

<?php if (empty($cities)): ?>
    <tr>
        <td colspan="5" class="px-4 py-14 text-center">
            <?= render_component('empty-state', [
                'icon' => 'building-2',
                'title' => 'Nenhuma cidade encontrada',
                'description' => 'Clique em "Nova" para adicionar.'
            ]) ?>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($cities as $city): ?>
        <?php
        $data = [
            'id' => $city['id'],
            'name' => $city['name'],
            'state_name' => $city['state_name'] ?? '-',
            'state_abbr' => $city['state_abbr'] ?? '-'
        ];
        $columns = ['id', 'name', 'state_name', 'state_abbr', 'actions'];
        $module = 'cities';
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