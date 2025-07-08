@props(['as' => 'div', 'variant' => null, 'dismissible' => null])

@pushOnce('vendors')
    @vite('resources/js/vendors/alert.js')
@endPushOnce

@php
    
    $primary = [
        'bg-primary border-primary text-white', 
        'dark:border-primary', 
    ];
    $secondary = [
        'bg-secondary/70 border-secondary/70 text-slate-500', 
        'dark:border-darkmode-400', 
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
    ];

    $outlinePrimary = [
        'border-primary text-primary', 
        'dark:border-primary', 
    ];
    $outlineSecondary = [
        'border-secondary text-slate-500', 
        'dark:border-darkmode-100/40', 
    ];
    $outlineSuccess = [
        'border-success text-success', 
        'dark:border-success', 
    ];
    $outlineWarning = [
        'border-warning text-warning', 
        'dark:border-warning', 
    ];
    $outlinePending = [
        'border-pending text-pending', 
        'dark:border-pending', 
    ];
    $outlineDanger = [
        'border-danger text-red-700', 
        'dark:border-danger', 
    ];
    $outlineDark = [
        'border-dark text-dark', 
        'dark:border-darkmode-800', 
    ];

    $softPrimary = [
        'bg-primary border-primary bg-opacity-20 border-opacity-5 text-primary', 
        'dark:border-opacity-100', 
    ];
    $softSecondary = [
        'bg-slate-300 border-secondary bg-opacity-10 text-slate-500', 
        'dark:bg-darkmode-100/20', 
    ];
    $softSuccess = [
        'bg-success border-success bg-opacity-20 border-opacity-5 text-success', 
        'dark:border-success', 
    ];
    $softWarning = [
        'bg-warning border-warning bg-opacity-20 border-opacity-5 text-warning', 
        'dark:border-warning', 
    ];
    $softPending = [
        'bg-pending border-pending bg-opacity-20 border-opacity-5 text-pending', 
        'dark:border-pending', 
    ];
    $softDanger = [
        'bg-danger border-danger bg-opacity-20 border-opacity-5 text-red-700', 
        'dark:border-danger', 
    ];
    $softDark = [
        'bg-dark border-dark bg-opacity-20 border-opacity-5 text-dark', 
        'dark:bg-darkmode-800/30', 
    ];
@endphp

<{{ $as }}
    role="alert"
    {{ $attributes->class(
            merge([
                'alert relative border rounded-md px-5 py-4',
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
                $dismissible ? 'pl-5 pr-16' : null,
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
>{{ $slot }}</{{ $as }}>
