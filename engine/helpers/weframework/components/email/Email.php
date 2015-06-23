<?php
namespace helpers\weframework\components\email;
use helpers\weframework\classes\Config;

/**
 * Class Sender
 * @package helpers\weframework\components\email
 */
class Email extends \PHPMailer
{

    /**
     * Layout do corpo do e-mail
     * @var string
     */
    public $layout = 'default.php';

    /**
     * $processError
     * Erro de processamento
     *
     * @var null
     */
    public $processError = null;

    /**
     * __construct
     * Lendo arquivo de configuração de e-mail e alimentando o PHPMailer
     */
    public function __construct($loadConfig = true)
    {
        if($loadConfig === true)
            $this->loadMailerConfiguration();
    }

    /**
     * loadMailerConfiguration
     * Leitrua e definição do arquivo configuração email.ini para o servidor de e-mail
     * @return void
     */
    public function loadMailerConfiguration()
    {
        //Carregando arquivo de configuração
        $config = Config::GetFileConfig('email.ini');

        // Validando dados necessários
        $validateInfo = array('host', 'username', 'password', 'from_email', 'from_name');
        $validate = true;
        foreach($validateInfo as $prop)
        {
            if(isset($config[$prop]) && empty($config[$prop]))
            {
                $validate = false;
                continue;
            }
        }

        if($validate === true)
        {
            //Alimentando PHPMailer
            //Host
            $this->Host = $config['host'];
            //Username
            $this->Username = $config['username'];
            //Senha
            $this->Password = $config['password'];
            //Porta
            $this->Port = $config['port'];
            //From
            $this->From = $config['from_email'];

            //From Name
            if(!empty($config['from_name']))
                $this->FromName = $config['from_name'];

            // Cópia
            if(!empty($config['cc']))
                $this->addCC($config['cc']);

            // Cópia Oculta
            if(!empty($config['bcc']))
                $this->addBCC($config['bcc']);

            //Charset
            if(!empty($config['charset']))
                $this->CharSet = $config['charset'];
        }
        else
            $this->processError = 'Check email.ini to configure smtp server. File not configured correctly.';
    }

    /**
     * quickySend
     * Envio rápido de mensagens
     *
     * @param $address
     * @param $subject
     * @param $message
     * @return bool
     */
    public function quickySend($address, $subject, $message)
    {

        $this->IsSMTP(); // Define que a mensagem será SMTP
        //$mail->SMTPDebug = 1;
        $this->SMTPAuth = true;
        //HTML Message
        $this->IsHTML(true);
        //Assunto
        $this->Subject = $subject;
        //Destinatário
        $this->addAddress($address);
        //E-mail de Resposta
        $this->addReplyTo($address);
        //Corpo da mensagem
        $body = $this->setBodyLayout($message);
        if($body !== false)
        {
            $this->Body = $body;
            //Envia mensagem
            if($this->send())
                return true;
        }

        return false;
    }

    /**
     * setLayout
     * @param $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }


    /**
     * setLayoutPath
     * Configura caminho do layout do e-mail
     * @return void
     */
    private function setLayoutPath()
    {
        if(strpos($this->layout, '/') === false)
            $this->layout = __DIR__ . "/layout/" . $this->layout;
    }

    /**
     * setLayout
     *
     * @param $body
     * @param null $layout
     * @return bool|string
     */
    public function setBodyLayout($body, $layout = null)
    {
        if(isset($layout))
           $this->setLayout($layout);

        //Caminho do arquivo de layout
        $path = __DIR__ . "/layout/" . $this->layout;
        if(file_exists($path))
        {
            //Set Layout Path
            $this->setLayoutPath();
            ob_start();
            include $this->layout;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        $this->processError = 'Layout ' . $this->layout . 'not found.';
        return false;
    }

    /**
     * getError
     * @return string
     */
    public function getError()
    {
        if(!empty($this->processError))
            return $this->processError;

        return $this->ErrorInfo;
    }
}