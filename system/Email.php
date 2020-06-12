<?php


 if (!defined('INDEX')) {
   die("Erro no sistema!");
 }

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
 
 
 require 'vendor/autoload.php';

	class Email
	{
		
		private $mailer;

		public function __construct($host,$username,$senha,$name)
		{
			
			$this->mailer = new PHPMailer(true);

			$this->mailer->isSMTP();                                     
			$this->mailer->Host = $host;  				  
			$this->mailer->SMTPAuth = true;                        
			$this->mailer->Username = $username;                 
			$this->mailer->Password = $senha;                    
			$this->mailer->SMTPSecure = 'ssl';                   
			$this->mailer->Port = 465;                           

			$this->mailer->setFrom($username,$name);
			$this->mailer->isHTML(true);                                 
			$this->mailer->CharSet = 'UTF-8';

		}

		public function addAdress($email,$nome){
			$this->mailer->addAddress($email,$nome);
		}

		public function formatarEmail($titulo,$corpo){
			$this->mailer->Subject = $titulo;
			$this->mailer->Body    = $corpo;
		}

		public function enviarEmail(){
			if($this->mailer->send()){
				return true;
			}else{
				return false;
			}
		}

	}
