<?php

namespace Db\Mail2dms;

use Db\Mail2dms\func;

class Mail2dms
{
    //请求地址
    protected $post_url;
    //默认 120s 执行一次
    protected $sleep = 120;
    //发件人
    protected $from_addr;
    //主题
    protected $subject;
    //每次获取邮件数
    protected $mail_nums = 10;
    //MailConf
    protected $MailConf;

    public function __construct(MailConf $MailConf)
    {
        $this->MailConf = $MailConf;
    }

    public function setPostUrl($post_url)
    {
        $this->post_url = $post_url;
        return $this;
    }

    public function setSleep($sleep)
    {
        $this->sleep = $sleep;
        return $this;
    }

    public function setFromAddr($from_addr)
    {
        $this->from_addr = $from_addr;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setMailNums($mail_nums)
    {
        $this->mail_nums = $mail_nums;
        return $this;
    }

    protected function receiver()
    {
        print_r('receiver');
        return $this;
    }

    public function ran()
    {
        print_r('ran');
        return $this;
    }
}