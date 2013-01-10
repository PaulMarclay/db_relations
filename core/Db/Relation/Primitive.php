<?php
    /*
    *   DB_RELATIONS3 version 1.0
    *
    *   Imagina - Plugin.
    *
    *
    *   Copyright (c) 2012 Dolem Labs
    *
    *   Authors:    Paul Marclay (paul.eduardo.marclay@gmail.com)
    *
    */

    class Db_Relation_Primitive extends Ancestor implements IteratorAggregate {
        private $_data = array();
        
        protected $_fieldIndex      = null;
        protected $_fieldIndexValue = null;
        protected $_relationField   = '';
        protected $_modelResult     = null; // modelo de la coleccion de modelos resultante de la relacion.
        protected $_modelBase       = null; // modelo base de la relacion. ( si un usuario tiene muchos permisos,
                                            // entonces el modelo base seria user y el modelo de la coleccion seria
                                            // permission.
//        protected $_modelBridge     = null;
        
        public function __construct($modelBase, $modelResult, $relationField, $fieldIndex, $fieldIndexValue) {
            $this->setModelBase($modelBase);
            $this->setModelResult($modelResult);
            $this->setRelationField($relationField);
            $this->setFieldIndex($fieldIndex); // @todo: no utilizado, evaluar quitar.
            $this->setFieldIndexValue($fieldIndexValue);
        }
        
        public function __destruct() {
			foreach ($this as $index => $value){
				unset($this->$index);
			}
		}
        
        // -- Collection
        
        public function add($record) {
			$recordId = $record->getFieldIndexValue();
	        if (!is_null($recordId)) {
	            if (isset($this->_data[$recordId])) {
                    throw new Php_Exception('Record: ('.get_class($record).') with the same id: "'.$record->getId().'" already exist!');
	            }
	            $this->_data[$recordId] = $record;
	        } else {
	            $this->_data[] = $record;
	        }
            
	        return $this;
		}
        
        public function getIterator() {
			return new ArrayIterator($this->_data);
		}
        
        public function first() {
	
	        if (count($this->_data)) {
	            reset($this->_data);
	            return current($this->_data);
	        }
            
            return null;
	    }
	    
		public function last() {
	
	        if (count($this->_data)) {
	            return end($this->_data);
	        }
	
	        return null;
	    }
	    
	    public function clear() {
	    	$this->_data = array();
	    	return $this;
	    }
        
        public function getAllItemsToArray() {
            return $this->_data;
        }
        
        // -- Countable
        
	    public function count() {
	    	return count($this->_data);
	    }
	    
        public function sum($field) {
            $total = 0;
            
            foreach ($this as $record) {
                $total += $record->getData($field);
            }
            
            return $total;
        }
        
        public function max($field) {
            $max = null;
            
            foreach ($this as $record) {
                if ($max == null || $record->getData($field) > $max) {
                    $max = $record->getData($field);
                }
            }
            
            return $max;
        }
        
        public function min($field) {
            $min = null;
            
            foreach ($this as $record) {
                if ($min == null || $record->getData($field) < $min) {
                    $min = $record->getData($field);
                }
            }
            
            return $min;
        }
        
        public function avg($field) {
            $total = 0;
            
            foreach ($this as $record) {
                $total += $record->getData($field);
            }
            
            return ($total / $this->count());
        }
        
        // -- Getters
        
        public function getModelResult() {
            return $this->_modelResult;
        }
        
        public function getModelBase() {
            return $this->_modelBase;
        }
        
//        public function getModelBridge() {
//            return $this->_modelBridge;
//        }
        
        public function getRelationField() {
            return $this->_relationField;
        }
        
        public function getFieldIndex() {
            return $this->_fieldIndex;
        }
        
        public function getFieldIndexValue() {
            return $this->_fieldIndexValue;
        }
        
        // -- Setters
        
        public function setModelResult($model) {
            $this->_modelResult = $model;
        }
        
        public function setModelBase($model) {
            $this->_modelBase = $model;
        }
        
//        public function setModelBridge($model = null) {
//            $this->_modelBridge = $model;
//        }
        
        public function setRelationField($fieldName) {
            $this->_relationField = $fieldName;
        }
        
        public function setFieldIndex($fieldIndex) {
            $this->_fieldIndex = $fieldIndex;
        }
        
        public function setFieldIndexValue($fieldIndexValue) {
            $this->_fieldIndexValue = $fieldIndexValue;
        }
        
    }