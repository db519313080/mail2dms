<?php

require_once 'vendor/autoload.php';

use Db\Mail2dms\Mail2dms;
use Db\Mail2dms\MailConf;


//请求地址
define('POST_URL', 'http://xxx');

//10s 执行一次
define('SLEEP', 120);

//发件人
define('FROM' , 'xx@xx.com');

//主题
define('SUBJECT' , 'xxx');

//没次获取邮件数
define('MAIL_NUM', 10);

//请求参数
$param = [
    'user'=>'xx',
    'Notification'=>'xx',
    'BugLevel'=>2,
    'BugAbstract'=>'邮件自动转到 dms',
    'BugInfo'=>'',//todo：在邮件中获取
    'BugFile'=>'--',
    'BugPosition'=>'--',
];


$mail2dms = new Mail2dms(new MailConf([
    'MAIL_DRIVER'=>'pop',
    'MAIL_HOST'=>'imap.exmail.qq.com',
    'MAIL_PORT'=>995,
    'MAIL_USERNAME'=>'xxx',
    'MAIL_PASSWORD'=>'xxxx',//todo 修改密码
    'MAIL_ENCRYPTION'=>'ssl',
]));
$mail2dms->setPostUrl(POST_URL)->setSleep(SLEEP)
    ->setFromAddr(FROM)
    ->setSubject(SUBJECT)
    ->setParam($param)
    ->setMailNums(MAIL_NUM)
    ->ran();