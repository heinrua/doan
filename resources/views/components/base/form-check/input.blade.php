@props(['type' => null, 'checked' => 0])

<input
    data-tw-merge
    {{ $checked ? 'checked' : '' }}
    {{ $attributes->class(
            merge([
                
                'transition-all duration-100 ease-in-out',

                $type == 'radio'
                    ? 'shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20'
                    : null,

                $type == 'checkbox'
                    ? 'shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20'
                    : null,

                "[&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10",
                "[&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10",

                '[&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50',

                '[&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50',
                $attributes->whereStartsWith('class')->first(),
            ]),
        )->merge($attributes->whereDoesntStartWith('class')->getAttributes())->merge(['type' => $type]) }}
/>
