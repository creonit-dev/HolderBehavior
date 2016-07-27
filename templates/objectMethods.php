public function getHolder(){
<?php
    /** @var \Propel\Generator\Model\Table $table */
    /** @var \Propel\Generator\Model\Table $holderTable */
    $holderClass = '\\' . $holderTable->getNamespace() . '\\' . $holderTable->getPhpName();
?>
    if(!$holder = <?php echo $holderClass ?>Query::create()->findOneBy<?php echo $table->getPhpName() ?>Id($this->id)){
        $holder = new <?php echo $holderClass ?>;
        $holder->set<?php echo $table->getPhpName() ?>Id($this->id);
        $holder->save();
    }

    return $holder;
}