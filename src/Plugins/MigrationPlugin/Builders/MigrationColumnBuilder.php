<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\MigrationPlugin\Builders;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Dto\ArgumentDto;
use GianTiaga\CodeGenerator\Dto\MethodDto;
use GianTiaga\CodeGenerator\Traits\HasEventAfter;
use GianTiaga\CodeGenerator\Traits\HasEventsBefore;
use GianTiaga\CodeGenerator\Traits\HasFluent;
use GianTiaga\CodeGenerator\Traits\Makeable;

class MigrationColumnBuilder
{
    use HasEventAfter;
    use HasEventsBefore;
    use HasFluent;
    use Makeable;

    /**
     * @var ?MethodDto
     */
    protected ?MethodDto $method = null;

    /**
     * @param  ?MethodDto  $method
     * @param  MethodDto[]  $fluent
     */
    protected function __construct(
        ?MethodDto $method = null,
        array $fluent = []
    ) {
        $this->setMethod($method);
        $this->setFluent($fluent);
    }

    public static function makeFromColumn(
        string $mainMethod,
        AbstractColumn $column
    ): MigrationColumnBuilder {
        return static::make(
            new MethodDto($mainMethod, [
                ArgumentDto::string($column->getDatabaseColumn()),
            ]),
        )
            ->addFluentWhen(
                ! $column->isRequired(),
                new MethodDto('nullable')
            )
            ->addFluentWhen(
                $column->isUnique(),
                new MethodDto('unique')
            )
            ->addFluentWhen(
                $column->getDefaultValue() !== null,
                new MethodDto('default', [
                    ArgumentDto::any($column->getDefaultValue()),
                ]),
            )
            ->addFluentWhen(
                (bool) $column->getComment(),
                new MethodDto('comment', [
                    ArgumentDto::string($column->getComment()),
                ]),
            );
    }

    /**
     * @return ?MethodDto
     */
    public function getMethod(): ?MethodDto
    {
        return $this->method;
    }

    /**
     * @param  ?MethodDto  $method
     * @return $this
     */
    public function setMethod(?MethodDto $method): static
    {
        $this->method = $method;

        return $this;
    }
}
