<?php

namespace pxlrbtxjuniyasyos\FilamentExcel\Actions\Tables;

use Filament\Tables\Actions\Action;
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

        $this->exports = collect([
            ExcelExport::make()->fromTable(),
        ]);
    }

    public function handleExport(array $data)
    {
        $exportable = $this->getSelectedExport($data);

        return app()->call([$exportable, 'hydrate'], [
            'livewire' => $this->getLivewire(),
            'formData' => data_get($data, $exportable->getName()),
        ])->export();
    }
}
