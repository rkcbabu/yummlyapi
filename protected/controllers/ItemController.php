<?php

/* @var $model Item */

class ItemController extends MainController {

    /**
     * common method for create update operation
     * @param integer $id the ID of the model to be updated
     */
    protected function createUpdate($id = NULL) {
        $model = is_null($id) ? new Item : $this->loadModel($id);
        /* @var $model Item */
        $this->performAjaxValidation($model);
        if (isset($_POST['Item'])) {
            $model->attributes = $_POST['Item'];
            $model->csv = CUploadedFile::getInstance($model, 'csv');
            if ($model->validate()) {
                $filePath = Yii::getPathOfAlias('application.data') . DIRECTORY_SEPARATOR . 'uploaded.csv';
                @unlink($filePath);$model->csv->saveAs($filePath);
                $newItemCount = 0; $updatedItemCount = 0 ;
                if (($handle = fopen($filePath, "r")) !== FALSE) {
                    $columns = array();
                    while (($row = fgetcsv($handle, 0, ",")) !== FALSE) {
                        if (empty($columns)) {
                            $columns = $row;
                            continue;
                        }
                        $recipe_id = str_replace('http://www.yummly.com/recipe/', '', $row[2]);
                        $recipe_ids = explode('?', $recipe_id);
                        $api_call_url = 'http://api.yummly.com/v1/api/recipe/' . $recipe_ids[0] . '?_app_id=' . Yii::app()->params->_app_id . '&_app_key=' . Yii::app()->params->_app_key;
                        $find = Item::model()->findByAttributes(array('url'=>$row[2]));
                        if($find==null){
                            $find = new Item;
                            $find->url = $row[2];
                            $find->value1 = serialize($row);
                            $fetched_data = @json_decode(@file_get_contents($api_call_url), true);
                            $find->value2 = serialize($fetched_data);
                            $find->save(FALSE);
                            $newItemCount ++;
                        }else{
                            
                            $updatedItemCount++;
                        }
                    }
                    Yii::app()->user->setFlash('success',"$newItemCount is added to the system.");
                    fclose($handle);
                    //$model->save(false);
                    $this->redirect(array('index'));
                } else {
                    Yii::app()->user->setFlash('error', 'Unable to read csv file.');
                }
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
    public function actionIndex() {
        $model = new Item('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item']))
            $model->attributes = $_GET['Item'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Item::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
