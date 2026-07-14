<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * Email pengirim
     */
    public string $fromEmail  = 'netnat251@gmail.com'; // Ganti dengan email pengirim
    public string $fromName   = 'pencatatan dpo'; // Nama aplikasi Anda
    public string $recipients = '';

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * Mail sending protocol: mail, sendmail, smtp
     */
    public string $protocol = 'smtp';

    /**
     * SMTP Server Hostname
     */
    public string $SMTPHost = 'smtp.gmail.com';

    /**
     * SMTP Username
     */
    public string $SMTPUser = 'netnat251@gmail.com'; // Ganti dengan email Anda

    /**
     * SMTP Password (gunakan App Password, bukan password akun Google)
     */
    public string $SMTPPass = 'tarc wxbj opej bvnt'; // Ganti dengan App Password dari Google

    /**
     * SMTP Port (gunakan 587 untuk TLS atau 465 untuk SSL)
     */
    public int $SMTPPort = 465;

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 60;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption (TLS atau SSL)
     */
    public string $SMTPCrypto = 'ssl'; // Gunakan 'ssl' jika menggunakan Port 465

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * Type of mail: 'text' or 'html'
     */
    public string $mailType = 'html';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

    /**
     * Validate the email address
     */
    public bool $validate = true;

    /**
     * Email Priority: 1 = highest, 5 = lowest, 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character. Use "\r\n" to comply with RFC 822.
     */
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable delivery status notification (DSN)
     */
    public bool $DSN = false;
}
