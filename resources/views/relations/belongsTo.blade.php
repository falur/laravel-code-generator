@use('GianTiaga\CodeGenerator\Helpers\ClassFormatter')
@php
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views\ModelsView $view */
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto\ModelColumnDto $column */
    $className = ClassFormatter::getBelongsToClassNameFromFieldName($column->column->getName());
    $methodName = ClassFormatter::getBelongsToMethodNameFromFieldName($column->column->getName());
@endphp
/**
* @return BelongsTo<{!! $className !!}, self>
*/
public function {!! $methodName !!}(): BelongsTo
{
    return $this->belongsTo({!! $className !!}::class);
}
