<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Builders;

use DirectoryIterator;
use GianTiaga\CodeGenerator\Plugins\PluginInterface;
use GianTiaga\CodeGenerator\Traits\Makeable;

class CodeGenerator
{
    use Makeable;

    /**
     * @var PluginInterface[]
     */
    protected array $plugins = [];

    /**
     * @var TableBuilder[]
     */
    protected array $tables = [];

    protected ?string $directory = null;

    /**
     * @param  TableBuilder[]  $tables
     */
    protected function __construct(array $tables = [])
    {
        $this->setTables($tables);
    }

    /**
     * @return TableBuilder[]
     */
    public function getTables(): array
    {
        if ($this->directory) {
            foreach (new DirectoryIterator($this->directory) as $file) {
                if (! $file->isFile() || $file->getExtension() !== 'php') {
                    continue;
                }

                $this->tables[$file->getFilename()] = include $file->getPathname();
                ksort($this->tables);
            }
        }

        return $this->tables;
    }

    /**
     * @param  TableBuilder[]  $tables
     * @return $this
     */
    public function setTables(array $tables): static
    {
        $this->tables = $tables;

        return $this;
    }

    /**
     * @return $this
     */
    public function setTablesFromDir(?string $dir): static
    {
        $this->directory = $dir;

        return $this;
    }

    /**
     * @return $this
     */
    public function addTable(TableBuilder $table): static
    {
        $this->tables[] = $table;

        return $this;
    }

    /**
     * @return PluginInterface[]
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /**
     * @param  PluginInterface[]  $plugins
     * @return $this
     */
    public function registerPlugins(array $plugins): static
    {
        $this->plugins = $plugins;

        foreach ($this->plugins as $plugin) {
            $plugin->register($this);
        }

        return $this;
    }

    public function generate(): void
    {
        foreach ($this->plugins as $plugin) {
            $plugin->generate();
        }
    }
}
