<?php

namespace Db\Mail2dms;

use function Db\Mail2dms\func\createDir;
use GuzzleHttp\Client;
use PhpImap\Exceptions\ConnectionException;
use PhpImap\Mailbox;

class Mail2dms
{
    //请求地址
    protected $post_url = '';
    //默认 120s 执行一次
    protected $sleep = 120;
    //发件人
    protected $from_addr = '';
    //主题
    protected $subject = '';
    //每次获取邮件数
    protected $mail_nums = 10;
    //MailConf
    protected $MailConf;

    protected $log_file;
    protected $yesterday_log_file;
    protected $client;
    protected $param = [];

    public function __construct(MailConf $MailConf)
    {
        $this->MailConf = $MailConf;
        $this->setLog();
        $this->client = new Client();
    }

    public function setParam($param)
    {
        $this->param = $param;
        return $this;
    }

    public function setLog()
    {
        //log 目录
        $log_dir = __DIR__ . '/log/';
        createDir($log_dir);
        $ext = '.txt';

        //昨天的 log
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $yesterday_log_file = $log_dir . $yesterday . $ext;

        //当天的 log
        $date = date('Y-m-d');
        $log_file = $log_dir . $date . $ext;

        //初始化 log
        if (!file_exists($yesterday_log_file)) {
            fopen($yesterday_log_file, 'w');
            fopen($log_file, 'w');
        }
        $this->log_file = $log_file;
        $this->yesterday_log_file = $yesterday_log_file;
        return $this;
    }

    public function setPostUrl($post_url = '')
    {
        $this->post_url = $post_url;
        return $this;
    }

    public function setSleep($sleep = 120)
    {
        $this->sleep = $sleep;
        return $this;
    }

    public function setFromAddr($from_addr = '')
    {
        $this->from_addr = $from_addr;
        return $this;
    }

    public function setSubject($subject = '')
    {
        $this->subject = $subject;
        return $this;
    }

    public function setMailNums($mail_nums = 10)
    {
        $this->mail_nums = $mail_nums;
        return $this;
    }

    protected function receiver()
    {
        $mail_conf = $this->MailConf->getMailConf();
        $mailbox = new Mailbox(
            '{' . $mail_conf['MAIL_HOST'] . ':' . $mail_conf['MAIL_PORT'] . '/' . $mail_conf['MAIL_DRIVER'] . '/' . $mail_conf['MAIL_ENCRYPTION'] . '}INBOX',
            $mail_conf['MAIL_USERNAME'], // Username for the before configured mailbox
            $mail_conf['MAIL_PASSWORD'], // Password for the before configured username
            __DIR__, // Directory, where attachments will be saved (optional)
            'UTF-8' // Server encoding (optional)
        );

        try {
            $mailsIds = $mailbox->searchMailbox('ALL');
        } catch(ConnectionException $ex) {
            echo "IMAP connection failed: " . $ex;
            die();
        }


        // If $mailsIds is empty, no emails could be found
        if(!$mailsIds) {
            die('Mailbox is empty');
        }


        $mails_id_arr = array_slice($mailsIds, -$this->mail_nums);

        $mails = $mailbox->getMailsInfo($mails_id_arr);

        foreach ($mails as $mail) {
            $uid = $mail->uid;
            $old_uid_str = file_get_contents($this->yesterday_log_file);
            if (strpos($old_uid_str, "$uid") !== false) {
                continue;
            }
            $uid_str = file_get_contents($this->log_file);
            if (strpos($uid_str, "$uid") !== false) {
                continue;
            }
            file_put_contents($this->log_file, "{$uid},", FILE_APPEND);

            //发送人
            if (strpos($mail->from , $this->from_addr) !== false) {
                $new_mail = $mailbox->getMail($mail->uid);
                //主题
                if (trim($new_mail->subject) == $this->subject) {
                    //提交 bug
                    $content = $new_mail->textPlain;
                    $this->param['BugInfo'] = $content;
                    $this->client->request('post', $this->post_url, ['form_params'=>$this->param]);
                }
            }
        }
    }

    public function ran()
    {
        $i = 0;
        while (true) {
            $this->receiver();
            $i++;
            print_r($i . "\r\n");
            sleep($this->sleep);
        }
    }
}