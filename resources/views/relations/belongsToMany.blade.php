@use('GianTiaga\CodeGenerator\Helpers\ClassFormatter')
@php
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Views\ModelsView $view */
    /** @var \GianTiaga\CodeGenerator\Plugins\ModelPlugin\Dto\ModelColumnDto $column */
    $className = ClassFormatter::getClassNameFromTableName($column->column->getName());
    $methodName = $column->column->getName();
@endphp
/**
 * @return BelongsToMany<{{ $className }}>
 */
public function {{ $methodName }}(): BelongsToMany
{
    return $this->belongsToMany({{ $className }}::class);
}
