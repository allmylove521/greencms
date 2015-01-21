<?php
/**
 * Created by PhpStorm.
 * User: zts1993
 * Date: 2014/11/20
 * Time: 13:00
 */

namespace Common\Util;


class GreenEmail {


    public $config = array();


    function __construct()
    {
        include Extend_PATH . 'PHPMailer/phpmailer.class.php'; //从PHPMailer目录导phpmailer.class.php类文件


        $this->config = array(
            'smtp_host' => get_opinion('smtp_host'),
            'smtp_port' => get_opinion('smtp_port'),
            'smtp_user' => get_opinion('smtp_user'),
            'smtp_pass' => get_opinion('smtp_pass'),
            'from_email' => get_opinion('from_email'),
            'from_name' => get_opinion('title'),
            'mailer' => get_opinion('mail_method',true,'smtp')
        );
    }




    public function send_mail($to, $name, $subject = '', $body = '', $attachment = null, $config = '')
    {
         $config = is_array($config) ? $config :  $this->config; //从数据库读取smtp配置


        $mail = new PHPMailer(); //PHPMailer对象
        $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP(); // 设定使用SMTP服务

  //    $mail->IsHTML(true);
        $mail->SMTPDebug = 0; // 关闭SMTP调试功能 1 = errors and messages2 = messages only
        $mail->SMTPAuth = true; // 启用 SMTP 验证功能
        if ($config['smtp_port'] == 465)  $mail->SMTPSecure = 'ssl'; // 使用安全协议
        $mail->Host = $config['smtp_host']; // SMTP 服务器
        $mail->Port = $config['smtp_port']; // SMTP服务器的端口号
        $mail->Username = $config['smtp_user']; // SMTP服务器用户名
        $mail->Password = $config['smtp_pass']; // SMTP服务器密码
        $mail->SetFrom($config['from_email'], $config['from_name']);
        $replyEmail = $config['reply_email'] ? $config['reply_email'] : $config['reply_email'];
        $replyName = $config['reply_name'] ? $config['reply_name'] : $config['reply_name'];
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to, $name);
        if (is_array($attachment)) { // 添加附件
            foreach ($attachment as $file) {
                if (is_array($file)) {
                    is_file($file['path']) && $mail->AddAttachment($file['path'], $file['name']);
                } else {
                    is_file($file) && $mail->AddAttachment($file);
                }
            }
        } else {
            is_file($attachment) && $mail->AddAttachment($attachment);
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }


} 