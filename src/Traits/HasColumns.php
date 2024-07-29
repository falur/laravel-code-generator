<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;

trait HasColumns
{
    /**
     * @var AbstractColumn[]
     */
    private array $columns = [];

    /**
     * @return AbstractColumn[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param AbstractColumn[] $columns
     * @return $this
     */
    public function setColumns(array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param AbstractColumn $unique
     * @return $this
     */
    public function addColumn(AbstractColumn $column): static
    {
        $this->columns[] = $column;

        return $this;
    }
}
