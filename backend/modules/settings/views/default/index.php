<?php

use yii\helpers\Url;
use rs\widgets\ExtensionSettings;

$this->title = 'Einstellungen';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<div class="panel-heading"><h3 class="panel-title">System</h3></div>
	<div class="panel-body no-padding-bottom">
		<div class="row">
			<div class="col-sm-3">
				<a href="<?= Url::to('settings/general'); ?>" class="setting">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<div>Allgemein</div>
				</a>
			</div>
			<div class="col-sm-3">
				<a href="<?= Url::to('settings/email'); ?>" class="setting">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
					<div>E-Mail</div>
				</a>
			</div>
			<div class="col-sm-3">
				<a href="<?= Url::to('settings/users'); ?>" class="setting">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<div>Benutzer</div>
				</a>
			</div>
			<div class="col-sm-3">
				<a class="setting">
					<span class="glyphicon glyphicon-check" aria-hidden="true"></span>
					<div>Captchas</div>
				</a>
			</div>
			<div class="col-sm-3">
				<a href="<?= Url::to('settings/extensions'); ?>" class="setting">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					<div>Erweiterungen</div>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading"><h3 class="panel-title">Inhalte</h3></div>
	<div class="panel-body no-padding-bottom">
		<div class="row">
			<div class="col-sm-3">
				<a href="<?= Url::to('settings/fields'); ?>" class="setting">
					<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
					<div>Felder</div>
				</a>
			</div>
			<div class="col-sm-3">
				<a href="<?= Url::to('settings/globals'); ?>" class="setting">
					<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
					<div>Globale Variablen</div>
				</a>
			</div>
			<div class="col-sm-3">
				<a class="setting">
					<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
					<div>Sektionen</div>
				</a>
			</div>
			<div class="col-sm-3">
				<a class="setting">
					<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
					<div>Dateien</div>
				</a>
			</div>
		</div>
	</div>
</div>

<?= ExtensionSettings::widget([]); ?>