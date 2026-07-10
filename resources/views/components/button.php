<?php
$variant = $variant ?? 'primary';
$size = $size ?? 'md';
$type = $type ?? 'button';
$classes = "btn btn-{$variant} btn-{$size}";
?>

<button type="<?= $type ?>" class="<?= $classes ?>"
    <?= isset($onclick) ? "onclick='{$onclick}'" : '' ?>
    <?= isset($disabled) && $disabled ? 'disabled' : '' ?>>
    <?= $slot ?? '' ?>
</button>