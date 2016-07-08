<?php

namespace Creonit\PropelHolderBehavior;

use Propel\Generator\Model\Behavior;
use Propel\Generator\Model\ForeignKey;

class HolderBehavior extends Behavior
{
    public function modifyTable()
    {
        
        $table = $this->getTable();

        $tableColumnName = $table->getCommonName() . '_id';

        $holderTable = $table->getDatabase()->getTable('holder');

        $holderTable->addColumn([
            'name' => $tableColumnName,
            'type' => 'integer'
        ]);

        $fk = new ForeignKey();
        $fk->setName("fk_{$holderTable->getCommonName()}_{$tableColumnName}_{$table->getCommonName()}");
        $fk->setForeignTableCommonName($table->getCommonName());
        $fk->setForeignSchemaName($table->getSchema());
        $fk->setDefaultJoin('LEFT JOIN');
        $fk->setOnDelete(ForeignKey::CASCADE);
        $fk->setOnUpdate(ForeignKey::CASCADE);
        $fk->addReference($tableColumnName, 'id');
        $holderTable->addForeignKey($fk);

    }
}