
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'status' => null,   // 'pending' | 'active' | 'inactive'  — auto-resolves label+tone
    'label'  => null,
    'tone'   => null,
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
    'status' => null,   // 'pending' | 'active' | 'inactive'  — auto-resolves label+tone
    'label'  => null,
    'tone'   => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Auto-resolve label and tone from member status if not explicitly provided
    if ($status !== null) {
        $statusMap = [
            'active'   => ['label' => 'Aktif',         'tone' => 'green'],
            'pending'  => ['label' => 'Menunggu',       'tone' => 'amber'],
            'inactive' => ['label' => 'Nonaktif',       'tone' => 'slate'],
            'open'     => ['label' => 'Buka',           'tone' => 'green'],
            'closed'   => ['label' => 'Tutup',          'tone' => 'slate'],
            'canceled' => ['label' => 'Dibatalkan',     'tone' => 'red'],
        ];
        $resolved = $statusMap[$status] ?? ['label' => ucfirst($status), 'tone' => 'slate'];
        $label    = $label ?? $resolved['label'];
        $tone     = $tone  ?? $resolved['tone'];
    }

    $toneMap = [
        'slate'  => 'bg-slate-100 text-slate-600 border-slate-200 ring-slate-100',
        'blue'   => 'bg-blue-50  text-blue-700  border-blue-200  ring-blue-50',
        'navy'   => 'bg-[#1a307b]/10 text-[#1a307b] border-[#1a307b]/20',
        'green'  => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-50',
        'amber'  => 'bg-amber-50  text-amber-700  border-amber-200  ring-amber-50',
        'red'    => 'bg-red-50    text-red-700    border-red-200    ring-red-50',
    ];

    $dotMap = [
        'slate'  => 'bg-slate-400',
        'blue'   => 'bg-blue-500',
        'navy'   => 'bg-[#1a307b]',
        'green'  => 'bg-emerald-500',
        'amber'  => 'bg-amber-500',
        'red'    => 'bg-red-500',
    ];

    $resolvedTone    = $toneMap[$tone ?? 'slate']  ?? $toneMap['slate'];
    $resolvedDotTone = $dotMap[$tone  ?? 'slate']  ?? $dotMap['slate'];
?>

<span <?php echo e($attributes->class([
    'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[11px] font-semibold tracking-wide whitespace-nowrap select-none',
    $resolvedTone,
])); ?>>
    <span class="w-1.5 h-1.5 rounded-full <?php echo e($resolvedDotTone); ?>"></span>
    <?php echo e($label); ?>

</span>
<?php /**PATH C:\laragon\www\Project\club-panahan\resources\views\components\ui\status-badge.blade.php ENDPATH**/ ?>