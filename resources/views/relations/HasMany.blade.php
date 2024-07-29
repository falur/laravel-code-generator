@use('GianTiaga\CodeGenerator\Helpers\ClassFormatter')
@php
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views\ModelsView $view */
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto\ModelColumnDto $column */
    $className = ClassFormatter::getClassNameFromTableName($column->column->getName());
    $methodName = $column->column->getName();
@endphp
/**
 * @return HasMany<{{ $className }}>
 */
public function {{ $methodName }}(): HasMany
{
    return $this->hasMay({{ $className }}::class);
}
