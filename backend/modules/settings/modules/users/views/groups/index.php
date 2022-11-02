<?php
	
use yii\helpers\Url;
use yii\helpers\Html;
use rs\grid\GridView;

$this->title = 'Gruppen';
$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = ['label' => 'Benutzer', 'url' => ['/settings/users']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['headline-buttons'] = Html::a('Neue Gruppe', ['new'], ['class' => 'btn btn-primary']);

?>

<div class="panel panel-default">
	<ul class="nav nav-tabs">
		<li role="presentation"><a href="<?= Url::to(['/settings/users']); ?>">Allgemein</a></li>
		<li role="presentation" class="active"><a href="<?= Url::to(['/settings/users/groups']); ?>">Gruppen</a></li>
	</ul>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'label',
        [
	        'attribute' => 'name',
	        'contentOptions' => ['class' => 'name']
        ],
        [
        	'class' => 'rs\grid\ActionColumn',
		    'buttons' => [
		        'delete' => function($url, $model){
		            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
		                'data' => [
		                    'confirm' => 'Willst du die Gruppe wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.',
		                    'method' => 'post',
		                ],
		            ]);
		        }
		    ],
        ],
    ],
]); ?>
