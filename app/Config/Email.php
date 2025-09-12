<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail  = '';
    public $fromName   = '';
    public $recipients = '';

    public $protocol   = 'smtp';
    public $SMTPHost   = '';
    public $SMTPUser   = '';
    public $SMTPPass   = '';
    public $SMTPPort   = 587;
    public $SMTPCrypto = 'tls';

    public $mailType   = 'html';
    public $charset    = 'utf-8';
    public $wordWrap   = true;

    public function __construct()
    {
        parent::__construct();

        $this->fromEmail  = env('email.from', '');
        $this->fromName   = env('email.fromName', 'Alerto Marikeno');

        $this->SMTPHost   = env('email.smtp.host', 'smtp.gmail.com');
        $this->SMTPUser   = env('email.smtp.user', '');
        $this->SMTPPass   = env('email.smtp.pass', '');
        $this->SMTPPort   = (int) env('email.smtp.port', 587);
        $this->SMTPCrypto = env('email.smtp.crypto', 'tls');
    }
}
