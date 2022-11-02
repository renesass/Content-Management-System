<?php

use yii\helpers\Html;
use rs\grid\GridView;
use yii\helpers\Url;

$this->title = 'Navigationen';
$this->params['breadcrumbs'][] = $this->title;
$this->params['headline-buttons'] = Html::a('Neuer Navigationspunkt', ['new'], ['class' => 'btn btn-primary']);

?>

<div class="panel panel-default table-responsive">
    <table class="table">
        
        <?php
        if (empty($items)) {
            echo '<tr><td>Keine Ergebnisse gefunden</td></tr>';
        }
        
        foreach ($items as $item) {
            // $level ...
            echo '<tr>';
            
            echo '<td>'.$item->getIndent();
            if ($item->home == 1) {
                echo '<span class="glyphicon glyphicon-home small" aria-hidden="true"></span> ';
            }
            echo $item->label;
            echo '<br>'.$item->getIndent().'<span class="name small">'.$item->getPath().'</span>';
            echo '</td>';
            
            echo '<td class="icons"><span class="pull-right">';
            echo '<a href="'.Url::to(['/navigations/default/move', 'direction' => 'up', 'id' => $item->order]).'"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a> ';
            echo '<a href="'.Url::to(['/navigations/default/move', 'direction' => 'down', 'id' => $item->order]).'"><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></a> ';
            echo '<a href="'.Url::to(['/navigations/default/edit', 'id' => $item->order]).'" title="Edit" aria-label="Edit" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> ';
            echo '<a href="'.Url::to(['/navigations/default/delete', 'id' => $item->order]).'" data-confirm="Willst du den Navigationspunkt wirklich löschen?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
            echo '</span></td>';
            
            echo '</tr>';
        }
        ?>
    </table>
</div>