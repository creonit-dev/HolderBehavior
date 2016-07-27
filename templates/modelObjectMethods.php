public function getObject(){
    switch(true){
<?php
    /** @var \Propel\Generator\Model\Table $table */
    foreach($table->getForeignKeys() as $foreign):
?>
        case $this-><?php echo $foreign->getLocalColumn()->getName() ?>:
            return $this->get<?php echo $foreign->getForeignTable()->getPhpName() ?>();
<?php
    endforeach;
?>
        default:
            throw new \Exception('Object not found');
    }
}