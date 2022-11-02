<?php
	
use yii\helpers\Url;
use yii\helpers\Html;
use rs\grid\GridView;
use yii\bootstrap\Alert;
use common\extensions\events\common\models\EventDeregistration;
use rs\widgets\ActiveForm;

$this->title = 'Termine';
$this->params['breadcrumbs'][] = $this->title;

$this->params['headline-buttons'] = Html::a('Neuer Termin', ['new'], ['class' => 'btn btn-primary']);
?>

<?php // $form = ActiveForm::begin(['action' => ['change'], 'options' => ['method' => 'post']]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        [
	    	'attribute' => 'date',
			'value' => function ($model) {
	        	return $model->getDate();
	    	}
	    ],
        [
	    	'attribute' => 'time',
			'value' => function ($model) {
	        	return $model->getTime();
	    	}
	    ],
        'type',
        'location',
        [
            'attribute' => '',
            'format' => 'raw',
            'value' => function ($model) {
                $userId = Yii::$app->user->identity->id;
                if (array_key_exists($userId, $model->getDeregistrations())) {
                    $label = 'Anmelden';
                    $color = 'success';
                    $action = 'register';
                    $content = '';
                } else {
                    $label = 'Abmelden';
                    $color = 'danger';
                    $action = 'deregister';
                    $content = '<input name="reason" placeholder="Grund" class="form-control input-sm" style="display: inline-block; width: 150px;">';
                }
                
                $body = Html::beginForm([$action]);
                $body .= '<div class="pull-right" style="white-space: nowrap;">';
                $body .= '<input name="id" type="hidden" value="'.$model->id.'">';
                $body .= $content;
                $body .= Html::submitButton($label, ['class' => 'btn-sm btn-'.$color.'', 'style' => 'display: inline-block']);
                $body .= '</div>';
                $body .= Html::endForm();
                
                // return '<span class="pull-right">'.$input.Html::a($label, Url::to([Yii::$app->controller->navigationItem->getPath().'/default/'.$action, 'id' => $model->id])
                   // , ['class'=>'btn-sm btn-'.$color.'']).'</span>';
                return $body;
                
            },
        ]
    ],
]); ?>

<?php // ActiveForm::end(); ?>

<h2>Abgemeldete Mitglieder</h2>
<?= EventDeregistration::listDeregisteredUsers() ?>