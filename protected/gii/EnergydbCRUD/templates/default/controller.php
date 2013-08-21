<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php\n"; ?>
 /* @var $model <?php echo $this->modelClass; ?> */
class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	/**
        * common method for create update operation
        * @param integer $id the ID of the model to be updated
        */
       protected function createUpdate($id = NULL) {
           $model = is_null($id) ? new <?php echo $this->modelClass; ?> : $this->loadModel($id);
           /* @var $model <?php echo $this->modelClass; ?> */
           $this->performAjaxValidation($model);
           if (isset($_POST['<?php echo $this->modelClass; ?>'])) {
               $model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
               if ($model->validate()){
                    $model->save(false);
                   $this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
                   }
           }
           $data = array(
               'model' => $model,
           );
           is_null($id) ? $this->render('create', $data) : $this->render('update', $data);
       }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
