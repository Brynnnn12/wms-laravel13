<?php

if (! function_exists('rupiah')) {
    function rupiah(int|float|string $value, int $decimals = 0): string
    {
        $numeric = is_numeric($value) ? (float) $value : 0;

        return 'Rp ' . number_format($numeric, $decimals, ',', '.');
    }
}
