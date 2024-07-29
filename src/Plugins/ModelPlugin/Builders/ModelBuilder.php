<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\ModelPlugin\Builders;

use GianTiaga\CodeGenerator\Builders\Target\AbstractBuilder;
use GianTiaga\CodeGenerator\Dto\ClassNameDto;
use GianTiaga\CodeGenerator\Traits\HasExtends;
use GianTiaga\CodeGenerator\Traits\HasImplements;
use GianTiaga\CodeGenerator\Traits\HasUses;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelBuilder extends AbstractBuilder
{
    use HasExtends;
    use HasImplements;
    use HasUses;

    protected function afterMake(): void
    {
        parent::afterMake();
        $this->addUse(new ClassNameDto(HasFactory::class));
    }

    /**
     * @return string
     */
    protected function defaultDestination(): string
    {
        return app_path('Models');
    }

    /**
     * @return string
     */
    protected function defaultFrom(): string
    {
        return 'gian-code-generator::model';
    }
}
