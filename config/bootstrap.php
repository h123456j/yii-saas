<?php
//模块别名
Yii::setAlias('@backend',dirname(__DIR__).'/modules/admin');
Yii::setAlias('@api',dirname(__DIR__).'/modules/api');
Yii::setAlias('@doc',dirname(__DIR__).'/modules/doc');
Yii::setAlias('@frontend',dirname(__DIR__).'/modules/frontend');
Yii::setAlias('@common',dirname(__DIR__).'/common');
//资源文件别名
Yii::setAlias('@backend/assets',dirname(__DIR__).'/assets/admin');
Yii::setAlias('@frontend/assets',dirname(__DIR__).'/assets/frontend');
Yii::setAlias('@api/assets',dirname(__DIR__).'/assets/api');
//model别名
Yii::setAlias('@backend/models',dirname(__DIR__).'/models/admin');

Yii::setAlias('@webroot',dirname(__DIR__).'/web/static');