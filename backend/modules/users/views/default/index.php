<?php

use yii\helpers\Html;
use rs\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use rs\widgets\ActiveForm;
use common\models\User;
use yii\widgets\LinkPager;

$this->title = 'Benutzer';
$this->params['breadcrumbs'][] = $this->title;
$this->params['headline-buttons'] = Html::a('Neuer Benutzer', ['new'], ['class' => 'btn btn-primary']);

?>

<?= $this->render('_search', ['model' => $searchModel]); ?>
	
<?php Pjax::begin(['id' => 'users', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]);	
	// user models
	echo GridView::widget([
	    'dataProvider' => $dataProvider,
	    'columns' => [
	        [
	        	'attribute' => '', 
	        	'contentOptions' => ['class' => 'fit no-right-padding'],
	        	'format' => 'raw', 
	        	'value' => function ($model) {
		        	if ($model->status == User::STATUS_SUSPENDED) {
			        	return '<span class="glyphicon glyphicon-dot red" aria-hidden="true"></span>';
		        	} else if ($model->status == User::STATUS_PENDING) {
			        	return '<span class="glyphicon glyphicon-dot yellow" aria-hidden="true"></span>';
		        	} else {
			        	return '<span class="glyphicon glyphicon-dot green" aria-hidden="true"></span>';
		        	}
	    		},
			],
			'first_name',
			'last_name',
	        'email:email',
	        [
		        'attribute' => 'created_at',
		        'format' => ['date', 'php:d.m.Y']
	        ],
	        [
	        	'class' => 'rs\grid\ActionColumn',
			    'buttons' => [
			        'delete' => function($url, $model){
			            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
			                'data' => [
			                    'confirm' => 'Willst du den Benutzer wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.',
			                    'method' => 'post',
			                ],
			            ]);
			        }
			    ],
	        ],
	    ],
	]);

Pjax::end(); ?>