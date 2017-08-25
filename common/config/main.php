<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>"zh-cn",
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
       // url地址美化
   'urlManager' => [
   // 生成index.php/xxx/yyy
'enablePrettyUrl' => true,
     //  是否有index.php入口文件
    'showScriptName' => false,
          //是否有后缀
 //        'suffix'=>'.html',
          //规则
//      'rules' => [
  //       ],
],
      'authManager'=>[
          'class'=>\yii\rbac\DbManager::className()
      ]


    ],
];
