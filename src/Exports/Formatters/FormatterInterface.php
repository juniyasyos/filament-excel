<?php

namespace pxlrbtxjuniyasyos\FilamentExcel\Exports\Formatters;

interface FormatterInterface
{
    public function shouldApply($state): bool;

    public function format($state): string;
}
