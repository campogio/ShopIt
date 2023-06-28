<?php


class Auth
{

    static function doLogin()
    {
		
		session_start();

        global $mysqli;
		
		if (isset($_POST['email']) and isset($_POST['password'])) {

            $result = $mysqli->query("
                
                    SELECT services.script
                    from user
                    left join user_has_groups
                    on user_has_groups.user_iduser = user.iduser
                    left join services_has_groups 
                    ON services_has_groups.groups_idgroups = user_has_groups.groups_idgroups
                    left JOIN services
                    ON services.idservices = services_has_groups.services_idservices
                    where user.username = '{$_POST['email']}' AND user.password = ('{$_POST['password']}')
                
                ");

            if (!$result) {
                echo "Error!";
                exit;
            }


            if ($result->num_rows == 0) {
                Header("Location: index.php?error?0rows");
                exit;
            }

            $script = array();

            while ($data = $result->fetch_assoc()) {

                $script[$data['script']] = true;

            }

            $_SESSION['auth'] = $script;


        } else {
			
			if(basename($_SERVER['SCRIPT_NAME']) =="index.php"){
				return;
			}

            /* una richiesta di autenticazione fuori da login.php */


            if (!isset($_SESSION['auth'])) {

                Header("Location: index.php?error?fuorilogin");
                exit;

            }


        }
		
		
		$script = basename($_SERVER['SCRIPT_NAME']);
		
		if (!isset($_SESSION['auth'][$script]) and $script !="login.php") {
            Header("Location: index.php?error&non_autorizzato");
            exit;
        }

    }

}

Auth::doLogin();


?>