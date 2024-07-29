@use('GianTiaga\CodeGenerator\Helpers\ClassFormatter')
@php
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views\ModelsView $view */
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto\ModelColumnDto $column */
    /** @var \GianTiaga\CodeGenerator\Columns\Relations\AbstractRelation $relationColumn */
    $relationColumn = $column->column;
    $className = $relationColumn->getRelatedModel();
    $methodName = $column->column->getName();
@endphp
/**
 * @return BelongsToMany<{{ $className }}>
 */
public function {{ $methodName }}(): BelongsToMany
{
    return $this->belongsToMany({{ $className }}::class);
}
