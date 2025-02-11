<?php

namespace pxlrbtxjuniyasyos\FilamentExcel\Actions\Pages;

use Filament\Pages\Actions\Action;
use pxlrbtxjuniyasyos\FilamentExcel\Actions\Concerns\ExportableAction;
use pxlrbtxjuniyasyos\FilamentExcel\Exports\ExcelExport;

class ExportAction extends Action
{
    use ExportableAction {
        ExportableAction::setUp as parentSetUp;
    }

    public static function getDefaultName(): ?string
    {
        return 'export';
    }

    protected function setUp(): void
    {
        $this->parentSetUp();

        $this->defaultView(static::BUTTON_VIEW);
        $this->icon('heroicon-o-arrow-up-tray');

        $this->exports = collect([
            ExcelExport::make()->fromForm(),
        ]);
    }

    public function handleExport(array $data)
    {
        $exportable = $this->getSelectedExport($data);
        $livewire = $this->getLivewire();

        return app()->call([$exportable, 'hydrate'], [
            'livewire' => $this->getLivewire(),
            'records' => property_exists($livewire, 'record') ? collect([$livewire->record]) : null,
            'formData' => data_get($data, $exportable->getName()),
        ])->export();
    }
}
