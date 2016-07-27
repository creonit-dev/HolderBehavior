<?php

namespace Creonit\PropelHolderBehavior;

use Propel\Generator\Model\Behavior;

class HolderModelBehavior extends Behavior
{

    public function objectMethods($builder)
    {
        return $this->renderTemplate('modelObjectMethods', ['table' => $this->getTable()]);
    }
    
}