<?php
 	/*
	*	DB_RELATIONS3 version 1.0
	*
	*	Imagina - Plugin.
	*
	*
	*	Copyright (c) 2012 Dolem Labs
	*
	*	Authors:	Paul Marclay (paul.eduardo.marclay@gmail.com)
	*
	*/

    class Db_Relation_Hasmany extends Db_Relation_Primitive {
        public function create() {
            $modelResult            = Db::getModel($this->getModelResult());
            $valueForRelationField  = $this->getFieldIndexValue();
            $record                 = $modelResult->create();
            
            $record->_setData($this->getRelationField(), $valueForRelationField);
            
            return $record;
        }
    }