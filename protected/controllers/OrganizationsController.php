<?php

class OrganizationsController extends Controller
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
				'actions'=>array('index', 'create', 'update', 'delete', 'view', 'softdelete', 'daees'),
				'expression'=>'(Yii::app()->controller->isAdmin())',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->pageTitle = "View Organization :: iAnsar";
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'links'=>$this->orgLinks('view')
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->pageTitle = "Create Organization :: iAnsar";
		$model=new Organizations;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Organizations']))
		{
			$model->attributes=$_POST['Organizations'];
			if($model->isNewRecord) {
				$model->created_at = new CDbExpression("NOW()");
			}
			$model->created_by = Yii::app()->user->id;
			$model->deleted_by = null;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'links'=>$this->orgLinks("create")
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->pageTitle = "Edit Organization :: iAnsar";
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Organizations']))
		{
			$model->attributes=$_POST['Organizations'];
			$model->updated_at = new CDbExpression("NOW()");
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if($this->loadModel($id)->delete()) {
			echo "success";
		} else {
			echo "failed";
		}
		return;
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionSoftDelete($id)
	{
		$model = $this->loadModel($id);
		$model->is_deleted = 1;
		$model->deleted_by = YII::app()->user->id;
		$model->updated_at = new CDbExpression('NOW()');
		if($model->save()) {
			echo "success";
		} else {
			echo "failed";
		}
		return;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$this->pageTitle = "Organization List :: iAnsar";
		$model=new Organizations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Organizations']))
			$model->attributes=$_GET['Organizations'];

		$this->render('admin',array(
			'model'=>$model,
			'links'=>$this->orgLinks("list")
		));
	}

	public function actionDaees() {
		$this->pageTitle = "Daees & Organization :: iAnsar";
		$orgs_callers = Organizations::model()->getOrganizationsDaeeAssoc();
		$this->render('daees', array(
			'orgs_callers' => $orgs_callers,
			'links'=>$this->orgLinks("daee")
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Organizations::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='organizations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function orgLinks($currentpage) {
		$links = '<div class="org_links right">';
		if($currentpage != 'create') {
			$links .= '<a href="/organizations/create" class="grayButtons"><span class="icon-plus-2"></span> Create Organizations</a>';
		}
		if($currentpage != 'list') {
			$links .= '<a href="/organizations" class="grayButtons"><span class="icon-list"></span> Organizations list</a>';
		}
		if($currentpage != 'daee') {
			$links .= '<a href="/organizations/daees" class="grayButtons"><span class="icon-list"></span> Organizations & D\'aee List</a>';
		}
		$links .= '</div>';
		return $links;
	}
}
