<?php

/**
 * EnergydbCRUDCode class file.
 * @author Ramkrishna Chaulgain <rkcbabu@gmail.com>
 */

Yii::import('gii.generators.crud.CrudCode');

class EnergydbCRUDCode extends CrudCode
{
        public function __construct() {
            $this->baseControllerClass = 'MainController';
        }
	public function generateActiveRow($modelClass, $column)
	{
		if ($column->type === 'boolean')
			return "\$form->checkBoxRow(\$model,'{$column->name}')";
		else if (stripos($column->dbType,'text') !== false)
			return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span'))";
		else
		{
			if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordFieldRow';
			else
				$inputField='textFieldRow';

			if ($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span'))";
			else
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span','maxlength'=>$column->size))";
		}
	}
}
