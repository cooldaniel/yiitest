
<h1>Yii Log Test</h1>


<?php
$app = Yii::app();

// -----   log profile 

Yii::beginProfile('two');

// DAO查询数据库
$sql = "SELECT * FROM user LIMIT 10";
$conn = $app->db;
$comm = $conn->createCommand($sql);
$data = $comm->queryAll();


Yii::beginProfile('one');

// DAO查询数据库
$sql = "SELECT * FROM user LIMIT 10";
$conn = $app->db;
$comm = $conn->createCommand($sql);
$data = $comm->queryAll();

Yii::endProfile('one');
Yii::endProfile('two');


// -----   


