<?php

class SpecialOTP extends FormSpecialPage {
    function __construct() {
		parent::__construct( 'OTP' );
    }

    protected function getFormFields() {
		return [
            'otp' => [
                'id' => 'otp_input',
                'type' => 'text',
                'label-message' => 'password'
            ]
		];
    }

    public function onSubmit( array $params ) {
        if ($_SESSION["otp"] == $params["otp"]) {
            $this->getUser()->addGroup('phoneautheticated');
            echo "<script type='text/javascript'>";
            echo " alert(\"Bạn đã đăng kí số điện thoại thành công. Bạn hãy vui lòng quay lại trang chủ để bắt đầu viết và sửa bài\")";
            echo "</script>";
        } else {
            echo "<script type='text/javascript'>";
            echo " alert(\"Sai mã OTP, vui lòng nhập lại.\")";
            echo "</script>";
        }
	}
    
    function generateOTP() {
        $otp = "";
        for ($x = 0; $x < 6; $x++) {
            $temp = random_int(0, 9);
            $otp = $otp . (string) $temp;
        }
        return $otp;
    }
    
    function execute($par) {
        $this->setParameter( $par );
        $this->setHeaders();
        $userphonenumber = (string) $this->getUser()->getRealName();
        $group = $this->getUser()->getGroups();

		// This will throw exceptions if there's a problem
		$this->checkExecutePermissions( $this->getUser() );

		$securityLevel = $this->getLoginSecurityLevel();
		if ( $securityLevel !== false && !$this->checkLoginSecurityLevel( $securityLevel ) ) {
			return;
        }
        
        if(array_search('phoneautheticated', $group)) {
            $output = $this->getOutput();
            $wikitext = 'Số điện thoại của bạn đã được xác nhận. Hãy quay trở lại trang chủ để bắt đầu viết và sửa bài.';
            $output->addWikiTextAsInterface( $wikitext );
            $output->returnToMain();
            return;
        }

        if($userphonenumber == "") {
            $output = $this->getOutput();
            $wikitext = 'Bạn chưa có số điện thoại. Vui lòng đến trang cá nhân để thêm số điện thoại.';
            $output->addWikiTextAsInterface( $wikitext );
            $output->returnToMain();
        }

        if ($_SESSION["otp"] == "") {
            $_SESSION["otp"] = $this->generateOTP();
        } 
        
        $otp = $_SESSION["otp"];

        print_r($group);
             
        $curl = curl_init();
        $headers = array(
            'Authorization: 1a940adc0c45374d659c6da03de19789',
            'Content-Type: application/json'
        );
        $options = array(
            CURLOPT_URL => "https://callcenter.fpt.ai/api/campaigns-direct-call-out/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\r\n\t\"phone_number\": \"$userphonenumber\",\r\n    \"name\": \"admin\",\r\n\t\"otp\": \"$otp\"\r\n}",
            CURLOPT_HTTPHEADER => $headers,
        );

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        curl_close($curl);


		$form = $this->getForm();
		if ( $form->show() ) {
			$this->onSuccess();
        }
    }
}