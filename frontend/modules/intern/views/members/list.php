<?php

use common\models\User;

?>

<style type="text/css">
<!--
page { font-size: 10px; font-family: Arial; }
h1 {
	font-size: 22px;
	font-weight: normal;
	padding: 0px;
	margin: 0px 0px 8px 0px;
	color: #389fa7;
}

h1 span {
	margin-left: 10px;
	font-size: 10px;
	color: #000000;
}

table {
	margin: 20px 0px;
	width: 100%;
	font-size: 10px;
}
td, th {
	text-align: left;
	border: 0px;
	padding: 6px 0px;
	border-bottom: 1px solid #eeeeee;
	white-space: pre;
}
th {
	font-weight: bold;
	border-bottom: 1px solid #e6e6e6;
}
-->
</style>
<?php

	
function getInformation($position) {
    $users = Yii::$app->userGroupManager->getUsersByGroup($position);
    $position = Yii::$app->userGroupManager->getGroup($position)->label;
    
	echo '<tr><th style="padding-top: 20px;">'.$position.'</th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>';
    
    foreach ($users as $user) {
        echo '<tr>';
		echo '<td style="width: 9%;">'.$user->first_name.'</td>';
		echo '<td style="width: 9%;">'.$user->last_name.'</td>';
		echo '<td style="width: 16%;">'.$user->getProfile('address').'</td>';
		echo '<td style="width: 8%;">'.$user->getProfile('zip').'</td>';
		echo '<td style="width: 10%;">'.$user->getProfile('location').'</td>';
		echo '<td style="width: 11%;">'.$user->getProfile('telephone').'</td>';
		echo '<td style="width: 11%;">'.$user->getProfile('mobilephone').'</td>';
		echo '<td style="width: 20%;">'.$user->email.'</td>';
		echo '<td style="width: 6%;">';
        if (!empty($user->getProfile('birthday'))) {
            echo date("d.m.Y", DateTime::createFromFormat('Y-m-d', $user->getProfile('birthday'))->getTimestamp());
        }
        echo '</td>';
		echo '</tr>';
    }
}
?>

<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm">
	<h1>Adressliste von We for G<span>Stand: <?php echo date('d.m.Y');?></span></h1>
	
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th>Vorname</th>
			<th>Nachname</th>
			<th>Adresse</th>
			<th>Postleitzahl</th>
			<th>Ort</th>
			<th>Telefon</th>
			<th>Mobiltelefon</th>
			<th>E-Mail</th>
			<th>Geburtstag</th>
		</tr>
		<?php
		getInformation('soprano');
		getInformation('alto');
		getInformation('tenor');
		getInformation('bass');
		getInformation('conductor');
		?>
	</table>
</page>