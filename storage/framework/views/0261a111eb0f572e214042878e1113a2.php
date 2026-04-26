<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'info',
    'title' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'type' => 'info',
    'title' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $classes = [
        'info' => 'bg-blue-50 border-blue-200 text-blue-900',
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-900',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-900',
        'error' => 'bg-red-50 border-red-200 text-red-900',
    ];
?>

<div <?php echo e($attributes->class(['border rounded-xl p-4', $classes[$type] ?? $classes['info']])); ?>>
    <?php if($title): ?>
        <p class="text-sm font-bold"><?php echo e($title); ?></p>
    <?php endif; ?>
    <div class="text-sm mt-1"><?php echo e($slot); ?></div>
</div>
<?php /**PATH C:\laragon\www\Project\club-panahan\resources\views\components\ui\alert-box.blade.php ENDPATH**/ ?>