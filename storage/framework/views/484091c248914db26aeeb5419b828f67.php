<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'button',
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
    'type' => 'button',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<button
    type="<?php echo e($type); ?>"
    <?php echo e($attributes->class([
        'inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#1a307b] text-white text-sm font-semibold hover:bg-[#162a69] disabled:opacity-50 disabled:cursor-not-allowed transition',
    ])); ?>

>
    <?php echo e($slot); ?>

</button>
<?php /**PATH C:\laragon\www\Project\club-panahan\resources\views\components\button\primary.blade.php ENDPATH**/ ?>