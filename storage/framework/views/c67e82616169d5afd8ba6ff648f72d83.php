<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'maxWidth' => 'max-w-lg',
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
    'title' => null,
    'maxWidth' => 'max-w-lg',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->class(['fixed inset-0 z-50'])); ?> x-cloak>
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full <?php echo e($maxWidth); ?> bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden">
            <?php if($title): ?>
                <div class="px-5 py-4 border-b border-slate-200">
                    <h3 class="text-base font-bold text-slate-900"><?php echo e($title); ?></h3>
                </div>
            <?php endif; ?>

            <div class="px-5 py-4">
                <?php echo e($slot); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Project\club-panahan\resources\views\components\ui\modal.blade.php ENDPATH**/ ?>