<?php


namespace Mail2dms;

define('MAIL_DRIVER', 'pop');
define('MAIL_HOST', 'imap.exmail.qq.com');
define('MAIL_PORT', 995);
define('MAIL_USERNAME', 'bing.dang@zebra-c.com');
define('MAIL_PASSWORD', '123456');
define('MAIL_ENCRYPTION', 'ssl');

class MailConf
{

    private $mail_conf = [];

    public function __construct(array $mail_conf)
    {
        if (!isset($mail_conf['MAIL_DRIVER'])) {
            throw new \Exception('Please set MAIL_DRIVER');
        }
        if (!isset($mail_conf['MAIL_HOST'])) {
            throw new \Exception('Please set MAIL_HOST');
        }
        if (!isset($mail_conf['MAIL_PORT'])) {
            throw new \Exception('Please set MAIL_PORT');
        }
        if (!isset($mail_conf['MAIL_USERNAME'])) {
            throw new \Exception('Please set MAIL_USERNAME');
        }
        if (!isset($mail_conf['MAIL_PASSWORD'])) {
            throw new \Exception('Please set MAIL_PASSWORD');
        }
        if (!isset($mail_conf['MAIL_ENCRYPTION'])) {
            throw new \Exception('Please set MAIL_ENCRYPTION');
        }

        $this->mail_conf = $mail_conf;
    }

    public function getMailConf()
    {
        return $this->mail_conf;
    }
}