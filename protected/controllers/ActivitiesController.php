<?php

class ActivitiesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/fullwidth';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index', 'deleteactivity'),
				'expression'=>'(Yii::app()->controller->isAdmin())',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Activities('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Activities']))
			$model->attributes=$_GET['Activities'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionDeleteActivity() {
		if(isset($_POST["isAjaxRequest"]) && $_POST["isAjaxRequest"]) {
			if(isset($_POST["id"])) {
				$id_s = $_POST["id"];
				if(isset($_POST["isMultiple"]) && $_POST["isMultiple"]) {
					Activities::model()->deleteActivity(explode(",", $id_s), $_POST["type"], true);
				} else {
					Activities::model()->deleteActivity($id_s, $_POST["type"], null);
				}
			}
		} else {
			echo "failed";
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Activities::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='activities-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
