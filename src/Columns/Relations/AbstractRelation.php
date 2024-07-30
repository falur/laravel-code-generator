<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Relations;

use GianTiaga\CodeGenerator\Columns\AbstractColumn;
use GianTiaga\CodeGenerator\Helpers\ClassFormatter;

abstract class AbstractRelation extends AbstractColumn
{
    protected ?string $relatedModel = null;

    public function getRelatedModel(): ?string
    {
        if ($this->relatedModel) {
            return $this->relatedModel;
        }

        if ($this->getName()) {
            return ClassFormatter::getRelatedModelNameFromFieldName($this->getName());
        }

        return null;
    }

    public function setRelatedModel(?string $relatedModel): AbstractRelation
    {
        $this->relatedModel = $relatedModel;

        return $this;
    }
}
