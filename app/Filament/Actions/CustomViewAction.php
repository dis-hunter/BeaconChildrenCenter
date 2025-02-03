<?php
namespace App\Filament\Actions;

use Filament\Facades\Filament;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Resources\Form;
use Illuminate\Support\Str;
use Filament\Resources\RelationManagers\RelationManager;

class CustomViewAction extends ViewAction
{
    protected function setUp(): void
    {
        parent::setUp();

        // Extend the mountUsing method to include related records
        $this->mountUsing(function (Forms\ComponentContainer $form, Model $record): void {
            // Get the main record's data
            $data = $record->attributesToArray();

            // Add related records to the data
            foreach ($this->getRelationships($record) as $relationship => $relatedRecords) {
                $data[$relationship] = $relatedRecords->toArray();
            }

            // Mutate the data if needed
            if ($this->mutateRecordDataUsing) {
                $data = $this->evaluate($this->mutateRecordDataUsing, ['data' => $data]);
            }

            // Fill the form with the combined data
            $form->fill($data);
        });

        // Modify the modal content to include related records
        $this->modalContent(function (Model $record) {
            // Get the existing schema from the parent ViewAction
            $schema = $this->getFormSchema();

            // Get the registered relations from the resource
            $relations = $this->getRegisteredRelations($record);

            // Add related records for each registered relation
            foreach ($relations as $relation) {
                $relationship = $relation->getRelationshipName();
                $relatedRecords = $record->$relationship;

                if ($relatedRecords->isNotEmpty()) {
                    // Get the form schema from the RelationManager
                    $relationSchema = $relation->form(Form::make())->getSchema();

                    $schema[] = Forms\Components\Section::make(Str::title($relationship))
                        ->schema([
                            Forms\Components\Repeater::make($relationship)
                                ->schema($relationSchema)
                                ->disableItemCreation()
                                ->disableItemDeletion()
                                ->disableItemMovement()
                                ->columns(2),
                        ]);
                }
            }

            return $schema;
        });
    }

    /**
     * Get the registered relations for the record's resource.
     */
    protected function getRegisteredRelations(Model $record): array
{
    $relations = [];

    // Get the resource class associated with the model
    $resourceClass = $this->getResourceClass($record);

    if ($resourceClass) {
        // Get the registered relations from the resource
        foreach ($resourceClass::getRelations() as $relationClass) {
            $relation = new $relationClass($resourceClass);
            $relations[] = $relation;
        }
    }

    return $relations;
}

/**
 * Get the Filament resource class associated with the model.
 */
protected function getResourceClass(Model $record): ?string
{
    // Loop through all Filament resources to find the one associated with the model
    foreach (Filament::getResources() as $resource) {
        if ($resource::getModel() === get_class($record)) {
            return $resource;
        }
    }

    return null;
}

    /**
     * Get the relationships for the record.
     */
    protected function getRelationships(Model $record): array
    {
        $relationships = [];

        // Detect relationships dynamically
        foreach ((new \ReflectionClass($record))->getMethods() as $method) {
            if ($method->getReturnType() && Str::startsWith($method->getReturnType()->getName(), 'Illuminate\Database\Eloquent\Relations')) {
                $relationship = $method->getName();
                $relatedRecords = $record->$relationship;

                if ($relatedRecords->isNotEmpty()) {
                    $relationships[$relationship] = $relatedRecords;
                }
            }
        }

        return $relationships;
    }
}