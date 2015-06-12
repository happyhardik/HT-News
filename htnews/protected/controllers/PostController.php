<?php

class PostController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'feed', 'download'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create', 'list' and 'delete' actions
				'actions'=>array('create','list','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'update' actions
				'actions'=>array('update'),
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
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
            /* generate random number and add it to file name to prevent overwriting of same name images */
            $rnd = rand(0,9999);
            $uploadedFile=CUploadedFile::getInstance($model,'image');
            $fileName = "{$rnd}-{$uploadedFile}";
            $model->image_url = $fileName;
            $model->mime_type = $uploadedFile->getType();
			if($model->save()){
                $uploadedFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.Yii::app()->params['uploadPath'].DIRECTORY_SEPARATOR.$fileName);
                $this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('create',array(
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

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
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
		$dataProvider=new CActiveDataProvider('Post',
        array(
            'criteria'=>array(
                'order'=>'published DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
            'totalItemCount' => 10,
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

    /**
     * RSS Feeds
     */
    public function actionFeed() {
        /* importing the rss feed module */
        Yii::import('ext.feed.*');
        /* getting the data from database to feed the feed */
        $dataProvider=new CActiveDataProvider('Post',
            array(
                'criteria'=>array(
                    'order'=>'published DESC',
                ),
                'pagination' => array(
                    'pageSize' => 10,
                ),
                'totalItemCount' => 10,
            ));
        /* lets generate the feeds */
        $this->generateFeeds($dataProvider);
        Yii::app()->end();
    }

    private function generateFeeds($dataProvider) {
        /* creating the feed object and adding basic data to it */
        $feed = new EFeed();

        $feed->title= 'HT News feed';
        $feed->description = 'Subscribe to get the updates on latest news on HT News';
        /* not adding a personalize image at the moment
        $feed->setImage('Testing RSS 2.0 EFeed class','http://www.ramirezcobos.com/rss',
            'http://www.yiiframework.com/forum/uploads/profile/photo-7106.jpg');
        */
        $feed->addChannelTag('language', 'en-us');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', Yii::app()->params['appURL']);

        $feed->addChannelTag('atom:link',Yii::app()->params['appURL'].'index.php?r=post/feed');
        /* for each article lets create a feed element */
        foreach($dataProvider->getData() as $post) {
            $item = $feed->createNewItem();
            $item->title = $post->title;
            /* link to the post */
            $item->link = Yii::app()->params['appURL'].'index.php?r=post/view&id='.$post->id;
            $item->date = $post->published;
            /* description with an image */
            $item->description = '<img src="'.Yii::app()->params['appURL'].Yii::app()->params['uploadPath'].'/'.$post->image_url.'" alt="'.CHtml::encode($post->title).'" /><br />'.$post->body;
            /* lets attach the image with the feed item; checking if file exist and finding its size */
            $filePath = Yii::app()->params['uploadPath'].'/'.$post->image_url;
            if(file_exists($filePath)) {
                $fileSize = filesize($filePath);
                /* lets set the image as encloser */
                $item->setEncloser(Yii::app()->params['appURL'].$filePath, $fileSize, $post->mime_type);
            }
            /* set the author */
            $item->addTag('author', $post->user->email);
            $item->addTag('guid', Yii::app()->params['appURL'].'index.php?r=post/view&id='.$post->id,array('isPermaLink'=>'true'));

            $feed->addItem($item);
        }
        /* finally generate the feed */
        $feed->generateFeed();
    }
    /**
     * download an article in pdf format
     */
    public function actionDownload($id) {
        $model = $this->loadModel($id);
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->WriteHTML($this->renderPartial('_pdf', array('model'=>$model), true));
        $html2pdf->Output();
    }

    /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


    /**
     * Manages all models.
     */
    public function actionList()
    {
        $model=new Post('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Post']))
            $model->attributes=$_GET['Post'];
        /* this page only users articles published by logged in user */
        $model->user_id = Yii::app()->user->getId();

        $this->render('list',array(
            'model'=>$model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}