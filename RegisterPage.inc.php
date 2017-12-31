<?php
	require_once(__DIR__ . "/../Config.inc.php");
	require_once(__DIR__ . "/../Register.inc.php");
	
	require_once(__DIR__ . "/Common.inc.php");
	
	class RegisterPage extends Registration{
		function __construct(){
			parent::__construct("Register");
			
			$this->user = $this->GetUser();
			
			ob_start();
			PageTop("Register");
				
			$this->Begin();
			
			return;
			}
			
		function Begin(){			
			if ($this->user === false){
				if (isset($_POST['SubmitRegistration'])){
					$this->ProcessRegistration();
					} else {
					$this->ShowRegistrationForm(parent::GetRegistrationForm("register"));
					}
				} else {
				$this->TabbedHtmlOut("<P CLASS=\"invalid\">You cannot register while logged in.</P>");
				}
				
			return;
			}
			
		function ShowRegistrationForm($rForm, $invalids = false){
			$this->TabbedHtmlOut($rForm->GenerateHtml());
			
			$this->TabLevel++;
			
			$this->TabbedHtmlOut($rForm->Contents['submitField']->GenerateHtml());
			
			$this->TabbedHtmlOut($rForm->Contents['usernameLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['usernameLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['usernameLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['usernameField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$this->TabbedHtmlOut($rForm->Contents['emailLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['emailLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['emailLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['emailField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$this->TabbedHtmlOut($rForm->Contents['passwordLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['passwordLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['passwordLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['passwordField']->GenerateHtml());
			
			$this->TabbedHtmlOut("<BR>");
			
			$this->TabbedHtmlOut($rForm->Contents['birthDateLabel']->GenerateHtml(), false);
			$this->HtmlOut($rForm->Contents['birthDateLabel']->Contents, false);
			$this->HtmlOut($rForm->Contents['birthDateLabel']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['birthYearField']->GenerateHtml());
			
			$this->TabLevel++;
				foreach ($rForm->Contents['birthYearField']->Contents as $year){
					$this->TabbedHtmlOut($year->GenerateHtml(), false);
					$this->HtmlOut($year->Contents, false);
					$this->HtmlOut($year->ClosingTag());
					}			
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->Contents['birthYearField']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['birthMonthField']->GenerateHtml());
			
			$this->TabLevel++;
				foreach ($rForm->Contents['birthMonthField']->Contents as $month){
					$this->TabbedHtmlOut($month->GenerateHtml(), false);
					$this->HtmlOut($month->Contents, false);
					$this->HtmlOut($month->ClosingTag());
					}
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->Contents['birthMonthField']->ClosingTag());
			
			$this->TabbedHtmlOut($rForm->Contents['birthDateField']->GenerateHtml());
			
			$this->TabLevel++;
				foreach ($rForm->Contents['birthDateField']->Contents as $date){
					$this->TabbedHtmlOut($date->GenerateHtml(), false);
					$this->HtmlOut($date->Contents, false);
					$this->HtmlOut($date->ClosingTag());
					}
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->Contents['birthDateField']->ClosingTag());
			
			$this->TabbedHtmlOut("<BR>");
			
			$this->TabbedHtmlOut($rForm->Contents['submitButton']->GenerateHtml());
			$this->TabbedHtmlOut($rForm->Contents['resetButton']->GenerateHtml());
			
			$this->TabLevel--;
			
			$this->TabbedHtmlOut($rForm->ClosingTag());
			return;
			}
			
		function ProcessRegistration(){
			try {
				if(($invalids = $this->Register()) != REGISTRATION_SUCCEEDED){
					if (isset($invalids['userName'])){
						$this->TabbedHtmlOut("Invalid user name.");
						}
					if (isset($invalids['email'])){
						$this->TabbedHtmlOut("Invalid email address.");
						}
					if (isset($invalids['password'])){
						$this->TabbedHtmlOut("Invalid password.");
						}
					if (isset($invalids['birthDay'])){
						$this->TabbedHtmlOut("Invalid birth date.");
						}
					} else {
					$this->TabbedHtmlOut("Registration succeeded.");
					return;
					}
				} catch (Exception $e){
				switch ($e->getCode()){
					case E_USERNAME_EXISTS:
						$this->TabbedHtmlOut("Username already in use");
						$invalids['userName'] = true;
						break;
					case E_EMAIL_EXISTS:
						$this->TabbedHtmlOut("Email address already in use");
						$invalids['email'] = true;
						break;
					default:
						$this->TabbedHtmlOut("Unrecoverable error");
						ob_end_flush();
						exit();
					}
				}
				
			$this->ShowRegistrationForm(parent::GetRegistrationForm("register"), $invalids);
			
			return;
			}
		
		function __destruct(){
			PageBottom();
			
			parent::__destruct();
			
			ob_end_flush();
			
			return;
			}
		}
?>