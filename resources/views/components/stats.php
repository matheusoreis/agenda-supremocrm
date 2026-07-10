<?php
$totalContacts = $totalContacts ?? 0;
$totalStates = $totalStates ?? 0;
$totalCities = $totalCities ?? 0;
?>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="card p-4 flex items-center gap-3">
        <div class="h-9 w-9 flex items-center justify-center rounded-md bg-zinc-100 dark:bg-zinc-800 text-lg">📇</div>
        <div>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Total de Contatos</p>
            <p class="text-xl font-semibold text-zinc-900 dark:text-zinc-50"><?= $totalContacts ?></p>
        </div>
    </div>

    <div class="card p-4 flex items-center gap-3">
        <div class="h-9 w-9 flex items-center justify-center rounded-md bg-zinc-100 dark:bg-zinc-800 text-lg">🗺️</div>
        <div>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Total de Estados</p>
            <p class="text-xl font-semibold text-zinc-900 dark:text-zinc-50"><?= $totalStates ?></p>
        </div>
    </div>

    <div class="card p-4 flex items-center gap-3">
        <div class="h-9 w-9 flex items-center justify-center rounded-md bg-zinc-100 dark:bg-zinc-800 text-lg">🏙️</div>
        <div>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Total de Cidades</p>
            <p class="text-xl font-semibold text-zinc-900 dark:text-zinc-50"><?= $totalCities ?></p>
        </div>
    </div>
</div>