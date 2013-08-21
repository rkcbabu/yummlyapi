<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MainController extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column2';
    
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    /**
     *This baseUrl used by application.
     * @var type baseurl for appliction.
     */
    public $baseUrl;
    /**
     * downloading file with this function.
     * @param type $filesystem_name
     * @param type $expected_name
     */
    public function download($filesystem_name,$expected_name) {
        $real_location =  Yii::app()->params->exportPath.trim($filesystem_name);
        if (file_exists($real_location)) {
            $content = file_get_contents($real_location);
            header('Content-Disposition: attachment; charset=UTF-8; filename="' . trim($expected_name) . '"');
            $utf8_content = mb_convert_encoding($content, "SJIS", "UTF-8");
            echo $utf8_content;
        } else {
            echo "file not exist: " .$expected_name;// $real_location;//$expected_name;
        }
        Yii::app()->end();
    }
    public function beforeAction($action) {
        $this->baseUrl = Yii::app()->baseUrl;
        return parent::beforeAction($action);
    }
    public function beforeRender($view) {
        if (!$this->pageTitle) {
            $this->pageTitle = Yii::app()->name.' - '.ucfirst(Yii::app()->controller->action->id . ' ' . Yii::app()->controller->id);
        }
        return parent::beforeRender($view);
    }

    public function actionEditable() {
        if (isset($_POST['pk'])) {
            $model = $this->loadModel($_POST['pk']);
            $model->{$_POST['name']} = $_POST['value'];
            $model->save();
        }
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                //'actions' => array('create', 'update', 'index', 'view'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->createUpdate();
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->createUpdate($id);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view',array('model'=>$this->loadmodel($id)));
        //$this->actionUpdate($id);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cities-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}