<?php
$headers = $headers ?? [];
$slot = $slot ?? '';
?>

<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th <?= isset($header['align']) ? "style='text-align:{$header['align']}'" : '' ?>>
                        <?= $header['label'] ?? $header ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?= $slot ?? '' ?>
        </tbody>
    </table>
</div>