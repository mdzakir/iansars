<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(YII::app()->user->isGuest) {
			$model=new LoginForm;

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					if( Yii::app()->user->getState('profile_completed') ) {
						$pattern = '/^index.php/';
						if( preg_match($pattern, substr(Yii::app()->user->returnUrl,9), $matches, PREG_OFFSET_CAPTURE) === 1 ) {
							$this->redirect('/profile/dashboard');
						} else {
							$this->redirect(Yii::app()->user->returnUrl);
						}
					} else {
						$this->redirect('/profile/completeprofile');
					}
			}
			// display the login form
			$this->render('index',array('model'=>$model));
		} else {
			$this->redirect('/profile/dashboard');
		}
	}

	public function actionLogin()
	{
		if(YII::app()->user->isGuest) {
			$model=new LoginForm;

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					if( Yii::app()->user->getState('profile_completed') ) {
						$pattern = '/^index.php/';
						if( preg_match($pattern, substr(Yii::app()->user->returnUrl,9), $matches, PREG_OFFSET_CAPTURE) === 1 ) {
							$this->redirect('/profile/dashboard');
						} else {
							$this->redirect(Yii::app()->user->returnUrl);
						}
					} else {
						$this->redirect('/profile/completeprofile');
					}
			}
			// display the login form
			$this->render('index',array('model'=>$model));
		} else {
			$this->redirect('/profile/dashboard');
		}
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout = '//layouts/errorLayout';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	/**
	 * Display registration from
	 */
	public function actionRegister(){
		$allowedID = isset($_SESSION["register"]) && $_SESSION["register"] ? $_SESSION["register"] : null;
		$explodeAllow = explode('_', $allowedID);
		if($explodeAllow[0] != 'allowed') {
			$this->redirect('/');exit;
		}
		
		if(!YII::app()->user->isGuest) {
			$this->redirect('/site/dashboard');exit;
		}
	    $model=new Callers('insert');
	
	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='callers-RegisterForm-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */
		$invitationRecord = Invitation::model()->findByPk($explodeAllow[1]);
		//print_r($invitationRecord);exit;
		
		
	    if(isset($_POST['Callers']))
	    {
	    	if($invitationRecord->invitee_email == $_POST['Callers']['email'])
	    	{
		        $model->attributes=$_POST['Callers'];
		        if($model->validate() && $model->save())
		        {
		        	YII::app()->user->setFlash('success', 'Your account has been created. You may now login with your email ID and password and continue with the registration process');
		            // form inputs are valid, do something here
		            $this->redirect('/');
		        }
	    	}
	    	else{
	    		Yii::app()->user->setFlash('error', 'That was not the invited Email.');
	    	}
	    }
	    $model->email = $invitationRecord->invitee_email;
	    $this->render('RegisterForm',array('model'=>$model));
	}
	
	
	
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionAcceptinvitation() {
		if(!YII::app()->user->isGuest) {
			Yii::app()->user->logout();
		}
		if(isset($_GET['invite_phrase']) && $_GET['invite_phrase']) {
			$model=new Invitation();
			$record=Invitation::model()->findByAttributes(array('lookup_phrase'=>$_GET['invite_phrase'], 'status'=>1));
			if(count($record) > 0) {
				$this->redirect('/');
			} else {
				$recordID=$model->findByAttributes(array('lookup_phrase'=>$_GET['invite_phrase'], 'status'=>0));
				$recordID->status = 1;
				$recordID->updated_at=date('Y-m-d H:i:s');
				if($recordID->validate() && $recordID->save()){
					if(session_id() == '') {
					    session_start();
					}
					$_SESSION["register"] = 'allowed_'.$recordID->id;
					$this->redirect('/site/register');
				}
        		//$ids = $model->updateAll(array( 'status' => 1, 'updated_at'=>date('Y-m-d H:i:s')), 'lookup_phrase = "'.$_POST['invite_phrase'].'" AND status = 0 ' );
			}
		}	
	}

	public function actionDontsendinvitation() {
		if(!YII::app()->user->isGuest) {
			Yii::app()->user->logout();
		}
		if(isset($_GET['invite_phrase']) && $_GET['invite_phrase']) {
			$record=Invitation::model()->findByAttributes(array('lookup_phrase'=>$_POST['invite_phrase'], 'status'=>1));
			if(count($record) > 0) {
				$this->redirect('/');
			} else {
				$recordID=Invitation::model()->findByAttributes(array('lookup_phrase'=>$_POST['invite_phrase'], 'status'=>0));
				$recordID->status = 0;
				$recordID->dont_send = 1;
				$recordID->updated_at=date('Y-m-d H:i:s');
				if($recordID->validate() && $recordID->save()){
					$this->render('dontsendinvitation');
				}
			}
		}
		$this->render('dontsendinvitation');
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionViewImages($id)
	{
		$img = CallersProfile::model()->getProfilePic($id);
        $folder = Yii::getPathOfAlias('webroot.protected.uploads') . DIRECTORY_SEPARATOR;
        $path = $folder . $img;

        $img = Yii::app()->imagemod->load($path);

		$img->file_new_name_body = md5($img->file_src_name);

        header('Content-type: ' . $img->file_src_mime);
        echo $img->process();
    }
    
    public function actionForgotPassword()
	{
		if(!YII::app()->user->isGuest) {
			Yii::app()->user->logout();
		}
		$callers = new Callers;
		if(isset($_POST['Callers']))
	    {
	    	$email = $_POST['Callers']['email'];
	        $callerMail = $callers->findAll('email = "'.$email.'"', 'active_status = 1');
	        if(count($callerMail) > 0) {
	        	$newPassword = $this->randomPassword();
	        	$message = 'Your new password is <strong>'.$newPassword.'</strong> ';
				$message .= 'Please, Change your password after login';
				$transaction = $callers->dbConnection->beginTransaction();
	        	if($this->prepareAndMail($email, 'iAnsar Support', 'New Password', $message)) {
		            if(Callers::model()->updateAll(array('password'=>md5($newPassword)), 'email = "'.$email.'"')) {
		            	$transaction->commit();
		            	YII::app()->user->setFlash('success', 'Password is mailed to <strong> '.$email.' </strong>');
		         		$this->redirect('/');
		            } else {
		            	YII::app()->user->setFlash('error', '<strong> '.$email.' </strong> not found');
		            	$transaction->rollback();		
		            }
	        	} else {
	        		YII::app()->user->setFlash('error', 'Mail not sent. Please try later');
	        	}
	        } else {
				YII::app()->user->setFlash('error', '<strong> '.$email.' </strong> not found');
	        }
	    }
	    $this->render('forgotpassword', array('model'=>$callers));
	}

	protected function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array();
	    $alphaLength = strlen($alphabet) - 1;
	    for ($i = 0; $i < 10; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}
	
	protected function prepareAndMail($to, $name=null, $subject=null, $message=null) {
		$this->mailParams->subject = $subject;
		$this->mailParams->to = $to;
		$this->mailParams->body = $message;
		$this->mailParams->fromName = $name;
		if($this->sendMail()) {
			return true;
		} else {
			return false;
		}
	}
}