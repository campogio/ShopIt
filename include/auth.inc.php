<?php


class Auth
{

    static function doLogin()
    {
		
		session_start();

        global $mysqli;
		
		if (isset($_POST['email']) and isset($_POST['password'])) {

            $result = $mysqli->query("
                
                    SELECT services.script,user.id
                    from user
                    left join user_has_roles
                    on user_has_roles.user_id = user.id
                    left join services_has_roles
                    ON services_has_roles.roles_id = user_has_roles.roles_id
                    left JOIN services
                    ON services.id = services_has_roles.services_id
                    where user.username = '{$_POST['email']}' AND user.password = ('{$_POST['password']}')
                
                ");

            if (!$result) {
                echo "Error!";
                exit;
            }


            if ($result->num_rows == 0) {
                Header("Location: index.php?error=0rows");
                exit;
            }

            $script = array();
			$id = 0;

            while ($data = $result->fetch_assoc()) {

                $script[$data['script']] = true;
				$id = $data['id'];
            }

            $_SESSION['auth'] = $script;
			$_SESSION['id']= $id;
			$_SESSION['last_visited']= array();


        } else {
			
			echo json_encode($_SESSION) ;
			
			if(basename($_SERVER['SCRIPT_NAME']) =="index.php"){
				return;
			}

            /* una richiesta di autenticazione fuori da login.php */


            if (!isset($_SESSION['auth'])) {

                Header("Location: index.php?error=fuorilogin");
                exit;

            }


        }
		
		
		$script = basename($_SERVER['SCRIPT_NAME']);
		
		if (!isset($_SESSION['auth'][$script]) and $script !="login.php") {
            Header("Location: index.php?error=non_autorizzato");
            exit;
        }

    }
	
	static function register(){
		
		if (isset($_POST['email']) and isset($_POST['password'])) {
		
			$result=registerUser($_POST['email'],$_POST['password']);
			
			echo $result;
			
			
			if($result == 0){
				Header("Location: register.php?error=username_taken");
				exit;
			}
			
		}else{
			Header("Location: register.php?error=form_errato");
		}
		
	}
	

}

if(isset($_POST['register'])){
	Auth::register();
	unset($_POST['register']);
}

Auth::doLogin();

?>