<?php

require_once 'vendor/autoload.php';

use Db\Mail2dms\Mail2dms;
use Db\Mail2dms\MailConf;

$mail2dms = new Mail2dms(new MailConf([
    'MAIL_DRIVER'=>'pop',
    'MAIL_HOST'=>'imap.exmail.qq.com',
    'MAIL_PORT'=>995,
    'MAIL_USERNAME'=>'bing.dang@zebra-c.com',
    'MAIL_PASSWORD'=>'123456',
    'MAIL_ENCRYPTION'=>'ssl',
]));

$mail2dms->setPostUrl('aa')->setFromAddr('aa')->ran();