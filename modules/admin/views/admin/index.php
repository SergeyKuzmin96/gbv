<?php

use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Admin panel');
?>

<div class="admin-admin-index">
<?= Html::a(Yii::t('app', 'Home page of the site'), Yii::$app->homeUrl )?>
</div>