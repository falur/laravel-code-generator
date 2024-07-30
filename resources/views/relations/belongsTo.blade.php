@use('GianTiaga\CodeGenerator\Helpers\ClassFormatter')
@php
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views\ModelsView $view */
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto\ModelColumnDto $column */
    /** @var \GianTiaga\CodeGenerator\Columns\Relations\BelongsTo $relationColumn */
    $relationColumn = $column->column;
    $className = $relationColumn->getRelatedModel();
    $methodName = ClassFormatter::getBelongsToMethodNameFromFieldName($column->column->getName());
@endphp
/**
* @return BelongsTo<{!! $className !!}, self>
*/
public function {!! $methodName !!}(): BelongsTo
{
return $this->belongsTo({!! $className !!}::class @if($relationColumn->getColumn()), '{{ $relationColumn->getColumn() }}' @endif);
}
