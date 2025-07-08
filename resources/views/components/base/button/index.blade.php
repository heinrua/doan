@props(['as' => 'button', 'variant' => null, 'elevated' => null, 'size' => null, 'rounded' => null])

@php
    
    $generalStyles = [
        'transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer', 
        'focus:ring-4 focus:ring-primary focus:ring-opacity-20', 
        'focus-visible:outline-none', 
        'dark:focus:ring-slate-700', 
        '[&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90', 
        '[&:not(button)]:text-center', 
        'disabled:opacity-70 disabled:cursor-not-allowed', 
    ];

    $small = ['text-xs py-1.5 px-2'];
    $large = ['text-lg py-1.5 px-4'];

    $primary = [
        'bg-primary border-primary text-white', 
    ];
    $secondary = [
        'bg-secondary/70 border-secondary/70 text-slate-500', 
        'dark:border-darkmode-400', 
        '[&:hover:not(:disabled)]:bg-slate-100 [&:hover:not(:disabled)]:border-slate-100', 
        '[&:hover:not(:disabled)]:dark:border-darkmode-300/80 [&:hover:not(:disabled)]:dark:bg-darkmode-300/80', 
    ];
    $success = [
        'bg-success border-success text-slate-900', 
        'dark:border-success', 
    ];
    $warning = [
        'bg-warning border-warning text-slate-900', 
        'dark:border-warning', 
    ];
    $pending = [
        'bg-pending border-pending text-white', 
        'dark:border-pending', 
    ];
    $danger = [
        'bg-danger border-danger text-white', 
        'dark:border-danger', 
    ];
    $dark = [
        'bg-dark border-dark text-white', 
        'dark:bg-darkmode-800', 
        '[&:hover:not(:disabled)]:dark:dark:bg-darkmode-800/70', 
    ];

    $facebook = ['bg-[#3b5998] border-[#3b5998] text-white'];
    $twitter = ['bg-[#4ab3f4] border-[#4ab3f4] text-white'];
    $instagram = ['bg-[#517fa4] border-[#517fa4] text-white'];
    $linkedin = ['bg-[#0077b5] border-[#0077b5] text-white'];

    $outlinePrimary = [
        'border-primary text-primary', 
        'dark:border-primary', 
        '[&:hover:not(:disabled)]:bg-primary/10', 
    ];
    $outlineSecondary = [
        'border-secondary text-slate-500', 
        'dark:border-darkmode-100/40', 
        '[&:hover:not(:disabled)]:bg-secondary/20', 
        '[&:hover:not(:disabled)]:dark:bg-darkmode-100/10', 
    ];
    $outlineSuccess = [
        'border-success text-success', 
        'dark:border-success', 
        '[&:hover:not(:disabled)]:bg-success/10', 
    ];
    $outlineWarning = [
        'border-warning text-warning', 
        'dark:border-warning', 
        '[&:hover:not(:disabled)]:bg-warning/10', 
    ];
    $outlinePending = [
        'border-pending text-pending', 
        'dark:border-pending', 
        '[&:hover:not(:disabled)]:bg-pending/10', 
    ];
    $outlineDanger = [
        'border-danger text-red-700', 
        'dark:border-danger', 
        '[&:hover:not(:disabled)]:bg-danger/10', 
    ];
    $outlineDark = [
        'border-dark text-dark', 
        'dark:border-darkmode-800', 
        '[&:hover:not(:disabled)]:bg-darkmode-800/30', 
        '[&:hover:not(:disabled)]:dark:bg-opacity-30', 
    ];

    $softPrimary = [
        'bg-primary border-primary bg-opacity-20 border-opacity-5 text-primary', 
        'dark:border-opacity-100', 
        '[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10', 
        '[&:hover:not(:disabled)]:dark:border-opacity-60', 
    ];
    $softSecondary = [
        'bg-slate-300 border-secondary bg-opacity-20 text-slate-500', 
        'dark:bg-darkmode-100/20', 
        '[&:hover:not(:disabled)]:bg-opacity-10', 
        '[&:hover:not(:disabled)]:dark:bg-darkmode-100/10 [&:hover:not(:disabled)]:dark:border-darkmode-100/20', 
    ];
    $softSuccess = [
        'bg-success border-success bg-opacity-20 border-opacity-5 text-success', 
        'dark:border-success', 
        '[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10', 
    ];
    $softWarning = [
        'bg-warning border-warning bg-opacity-20 border-opacity-5 text-warning', 
        'dark:border-warning', 
        '[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10', 
    ];
    $softPending = [
        'bg-pending border-pending bg-opacity-20 border-opacity-5 text-pending', 
        'dark:border-pending', 
        '[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10', 
    ];
    $softDanger = [
        'bg-danger border-danger bg-opacity-20 border-opacity-5 text-red-700', 
        'dark:border-danger', 
        '[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10', 
    ];
    $softDark = [
        'bg-dark border-dark bg-opacity-20 border-opacity-5 text-dark', 
        'dark:bg-darkmode-800/30', 
        '[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10', 
        '[&:hover:not(:disabled)]:dark:bg-darkmode-800/50 [&:hover:not(:disabled)]:dark:border-darkmode-800', 
    ];
@endphp

<{{ $as }}
    data-tw-merge
    {{ $attributes->class(
            merge([
                $generalStyles,
                $size == 'sm' ? $small : null,
                $size == 'lg' ? $large : null,
                $variant == 'primary' ? $primary : null,
                $variant == 'secondary' ? $secondary : null,
                $variant == 'success' ? $success : null,
                $variant == 'warning' ? $warning : null,
                $variant == 'pending' ? $pending : null,
                $variant == 'danger' ? $danger : null,
                $variant == 'dark' ? $dark : null,
                $variant == 'outline-primary' ? $outlinePrimary : null,
                $variant == 'outline-secondary' ? $outlineSecondary : null,
                $variant == 'outline-success' ? $outlineSuccess : null,
                $variant == 'outline-warning' ? $outlineWarning : null,
                $variant == 'outline-pending' ? $outlinePending : null,
                $variant == 'outline-danger' ? $outlineDanger : null,
                $variant == 'outline-dark' ? $outlineDark : null,
                $variant == 'soft-primary' ? $softPrimary : null,
                $variant == 'soft-secondary' ? $softSecondary : null,
                $variant == 'soft-success' ? $softSuccess : null,
                $variant == 'soft-warning' ? $softWarning : null,
                $variant == 'soft-pending' ? $softPending : null,
                $variant == 'soft-danger' ? $softDanger : null,
                $variant == 'soft-dark' ? $softDark : null,
                $variant == 'facebook' ? $facebook : null,
                $variant == 'twitter' ? $twitter : null,
                $variant == 'instagram' ? $instagram : null,
                $variant == 'linkedin' ? $linkedin : null,
                $rounded ? 'rounded-full' : null,
                $elevated ? 'shadow-md' : null,
                $attributes->whereStartsWith('class')->first(),
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
>{{ $slot }}</{{ $as }}>
