<?php

/** @var array $state */
/** @var array $errors */

require_once __DIR__ . '/../../../src/Helpers/helpers.php';
?>

<div class="w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <?= render_component('icon', ['name' => 'pencil', 'class' => 'w-5 h-5']) ?>
            Editar Estado
        </h2>

        <?= render_component('button', [
            'variant' => 'secondary',
            'size' => 'md',
            'icon' => 'arrow-left',
            'label' => 'Voltar',
            'onclick' => "window.location.href='/states'"
        ]) ?>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-300">
            <ul class="list-disc list-inside space-y-0.5">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/states/<?= $state['id'] ?>/update" method="POST" class="card p-6 space-y-4 w-full">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <?= render_component('input', [
                    'id' => 'name',
                    'label' => 'Nome',
                    'name' => 'name',
                    'value' => $state['name'] ?? '',
                    'required' => true
                ]) ?>
            </div>

            <div class="flex-1">
                <?= render_component('input', [
                    'id' => 'abbreviation',
                    'label' => 'Sigla (2 caracteres)',
                    'name' => 'abbreviation',
                    'value' => $state['abbreviation'] ?? '',
                    'placeholder' => 'Ex: SP',
                    'required' => true,
                    'maxlength' => 2
                ]) ?>
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <?= render_component('button', [
                'variant' => 'primary',
                'size' => 'md',
                'icon' => 'save',
                'label' => 'Atualizar',
                'type' => 'submit'
            ]) ?>

            <?= render_component('button', [
                'variant' => 'secondary',
                'size' => 'md',
                'icon' => 'x',
                'label' => 'Cancelar',
                'onclick' => "window.location.href='/states'"
            ]) ?>
        </div>
    </form>
</div>