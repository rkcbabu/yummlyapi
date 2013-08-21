<?php

class Model extends CActiveRecord {

    public function __construct($scenario = 'insert') {
        parent::__construct($scenario);
    }

    public function beforeSave() {

       if ($this->isNewRecord) {
            if ($this->hasAttribute('created'))
                $this->created = date('d-m-Y H:i:s');

            if ($this->hasAttribute('status') and !isset($this->status))
                $this->status = 1;
        }else {
            

        }
        if ($this->hasAttribute('modified'))
            $this->modified = date('d-m-Y H:i:s');

        foreach ($this->attributes as $key => $value) {
            if (gettype($value) == 'string')
                $this->$key = trim($value, " ");
        }
        foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
                if (preg_match('/timestamp/i', $column->dbType)) {
                $this->$columnName = date("d-m-Y H:i:s",  strtotime($this->$columnName));
            }
        }
        return parent::beforeSave();
    }

    public function afterFind() {
        foreach ($this->attributes as $key => $value) {
            if (gettype($value) == 'string')
                $this->$key = trim($value, " ");
        }
        foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
                if(preg_match('/timestamp/i', $column->dbType)) {
                $this->$columnName = date("d-m-Y H:i:s",  strtotime($this->$columnName));
                //$this->$columnName = DateTime::createFromFormat('Y-m-d H:i:s.u+e', $this->$columnName)->format('d/m/Y H:i:s');
            }
        }
        return parent::afterFind();
    }
}
