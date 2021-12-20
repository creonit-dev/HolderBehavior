<?php

namespace Creonit\PropelHolderBehavior;

use Propel\Generator\Model\Behavior;
use Propel\Generator\Model\ForeignKey;

class HolderBehavior extends Behavior
{
    protected $holderTable;
    protected $holderTableName = 'holder';
    protected $parameters = [
        'parameter' => null,
    ];

    public function modifyTable()
    {
        $table = $this->getTable();

        $tableColumnName = $table->getCommonName() . '_id';

        $this->addHolderTable();

        $holderTable = $table->getDatabase()->getTable($this->holderTableName);
        $holderTable->addColumn([
            'name' => $tableColumnName,
            'type' => 'integer'
        ]);

        $fkName = $this->getParameter('parameter') ?: sprintf('fk_%s_%s_%s', ...[
            $holderTable->getCommonName(),
            $tableColumnName,
            $table->getCommonName()
        ]);

        $fk = new ForeignKey();
        $fk->setName($fkName);
        $fk->setForeignTableCommonName($table->getCommonName());
        $fk->setForeignSchemaName($table->getSchema());
        $fk->setDefaultJoin('LEFT JOIN');
        $fk->setOnDelete(ForeignKey::CASCADE);
        $fk->setOnUpdate(ForeignKey::CASCADE);
        $fk->addReference($tableColumnName, 'id');
        $holderTable->addForeignKey($fk);
    }

    protected function addHolderTable()
    {
        if (null !== $this->holderTable) {
            return;
        }

        $database = $this->getTable()->getDatabase();
        $tableName = $this->holderTableName;

        if ($database->hasTable($tableName)) {
            $table = $this->holderTable = $database->getTable($tableName);

        } else {
            $table = $this->holderTable = $database->addTable(['name' => $tableName]);
            $table->setPackage($database->getPackage());
            $table->addColumn([
                'name' => 'id',
                'type' => 'integer',
                'primaryKey' => true,
                'autoIncrement' => true
            ]);
        }

        if (!$table->hasColumn('complete')) {
            $table->addColumn([
                'name' => 'complete',
                'type' => 'boolean',
                'required' => true,
                'default' => 0
            ]);
        }

        $table->addBehavior(new HolderModelBehavior());

        foreach ($database->getBehaviors() as $behavior) {
            $behavior->modifyDatabase();
        }
    }

    public function objectMethods($builder)
    {
        return $this->renderTemplate('objectMethods', [
            'table' => $this->getTable(),
            'holderTable' => $this->holderTable
        ]);
    }
}
