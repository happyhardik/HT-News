<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index', 'create', 'verify' and 'view' actions
				'actions'=>array('index', 'create','view', 'verify'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'update' action
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
            /* set the attributes to model */
			$model->attributes=$_POST['User'];
            /* generate a new verification code with salt and current time stamp */
            $model->verification_code = sha1(mt_rand(10000, 99999).time().Yii::app()->params['salt'])."_".time();
            $activationLink = Yii::app()->createAbsoluteUrl('user/verify', array('code' => $model->verification_code, 'email'=> $model->email));
            /* lets try to save the user */
			if($model->save()) {
                /* lets import the PHP mailer Yii extension */
                Yii::import('application.extensions.phpmailer.JPhpMailer');
                /* Lets send the user email using PHP mailer */
                $mail = new JPhpMailer;
                $mail->SetFrom('happyhardik@gmail.com'); /* that's me */
                $mail->Subject = 'Your account is created on HT News';
                $mail->MsgHTML('<p>Hello,</p><p>Your new account is being created. Click on the verification link below to activate your account:<br /><a target="_blank" href="'.$activationLink.'">'.$activationLink.'</a></p><p>Please note the link will expire in 2 days</p><p>Your friends at HT News</p>');
                $mail->AddAddress($model->email);

                /* lets try to send the email */
                if($mail->Send()) {
                    Yii::app()->user->setFlash('success', "We have sent you an email with verification link. Please click on that link to continue.");
                } else {
                    Yii::app()->user->setFlash('error', "There was a technical problem. Please contact us for support.");
                }
            } else {
                Yii::app()->user->setFlash('error', "There was a technical problem. Please contact us for support.");
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

    public function actionVerify() {
        /* lets get the email and verification code */
        $email = $_GET['email'];
        $verificationCode = $_GET['code'];
        /* find the user */
        $model = User::model()->find("email=:Email", array(":Email"=> $email));
        /* check the verification code */
        if($verificationCode == $model->verification_code) {
            /* check if code has not expired */
            $tokens = explode('_', $verificationCode);
            if(isset($tokens[1]) && (intval($tokens[1])+(48 * 60 * 60)) > time()) {
                Yii::app()->user->setFlash('success', "Your account verified successfully!");
                if(isset($_POST['User']))
                {
                    /* set the attributes to model */
                    $model->attributes=$_POST['User'];
                    /* user is now verified */
                    $model->is_verified = 1;
                    if($model->save()) {
                        Yii::app()->user->setFlash('success', "Account created successfully!");
                        $this->redirect(array('post/create'));
                    }
                    else {
                        Yii::app()->user->setFlash('error', "There was a technical problem. Please contact us for support.");
                    }

                }
            }
            else {
                Yii::app()->user->setFlash('error', 'Verification code has expired. Please contact us.');
            }
        }
        else {
            Yii::app()->user->setFlash('error', 'Invalid verification code');
        }

        $this->render('verify',array(
            'model'=>$model,
        ));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
