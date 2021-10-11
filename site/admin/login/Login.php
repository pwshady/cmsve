<?

use app\lib\modul;

class Login extends Modul
{

    public function __construct($database)
    {
        //Подключаем настройки
        if(file_exists(__DIR__ . "\settings.php")){
            include "settings.php";

            //Проверяем настройки
            if (isset($localization) && isset($accessTable)){
                //Подключаем локализацию
                include $localization . "name-variable.php";
            }else{
                print("</br>");
                print("erloc");
                print("</br>");
            }
            //Создаем header
            $header = "login_header" .PHP_EOL;
            $GLOBALS["page"]["header"] .= $header;

            $modulPath = $_SESSION["page_modul"];
            $pagePath = $_SESSION["page"];
            var_dump($_SESSION);
            
            //body
            if(isset($_SESSION[$modulPath]) && ($_SESSION[$modulPath] == 1) && isset($_SESSION[$modulPath . "-login"]) && isset($_SESSION[$modulPath . "-pass"])){
                $body = "<div>" .PHP_EOL;
                $body .= "    <form action=\"" . str_replace("_", "/", $pagePath) . "\" method=\"post\">" .PHP_EOL;
                $body .= "        <p><button type=\"submit\" name=\"" . $modulPath . "-exit\">" . $nameLoginExit . "</button></p>" .PHP_EOL;
                $body .= "    </form>" .PHP_EOL;
                $body .= "</div>" .PHP_EOL;
                //Удаляем сессии
                if($_SERVER['REQUEST_METHOD'] === "POST"){
                    print("<p>444</p>");
                    if (isset($_POST[$modulPath . "-exit"]) ){
                        //Получаем список модулей доступных для данного логина и пароля
                        $accessLevels = $database->getAccessLevel($accessTable, $_SESSION[$modulPath . "-login"], $_SESSION[$modulPath . "-pass"], "", "login", "pass", "", "session", "accessLevel");
                        foreach($accessLevels as $accessLevel){
                            unset($_SESSION[$accessLevel["session"]]); 
                        }
                        unset($_SESSION[$modulPath . "-login"]); 
                        unset($_SESSION[$modulPath . "-pass"]); 
                        $this->gotoPage(str_replace("_", "/", $pagePath));
                    }
                }
            }else{
                $body = "<div>" .PHP_EOL;
                $body .= "    <form action=\"" . str_replace("_", "/", $pagePath) . "\" method=\"post\">" .PHP_EOL;
                $body .= "        <p>" . $nameLoginLogin . "<input type=\"text\" name=\"" . $modulPath . "-login\"></p>" .PHP_EOL;
                $body .= "        <p>" . $nameLoginPass . "<input type=\"password\" name=\"" . $modulPath . "-pass\"></p>" .PHP_EOL;
                $body .= "        <p><button type=\"submit\">" . $nameLoginEnter . "</button></p>" .PHP_EOL;
                $body .= "    </form>" .PHP_EOL;
                $body .= "</div>" .PHP_EOL;
                //Создаем сессии
                if($_SERVER['REQUEST_METHOD'] === "POST"){
                    print("<p>POST</p>");
                    if ((isset($_POST[$modulPath . "-login"])) && (isset($_POST[$modulPath . "-pass"]))){
                        //Получаем список модулей доступных для данного логина и пароля
                        $accessLevels = $database->getAccessLevel($accessTable, $_POST[$modulPath . "-login"], $_POST[$modulPath . "-pass"], "", "login", "pass", "", "session", "accessLevel");
                        foreach($accessLevels as $accessLevel){
                            $_SESSION[$accessLevel["session"]] = $accessLevel["accessLevel"];
                        }
                        $_SESSION[$modulPath . "-login"] = $_POST[$modulPath . "-login"];
                        $_SESSION[$modulPath . "-pass"] = $_POST[$modulPath . "-pass"];
                        $this->gotoPage(str_replace("_", "/", $pagePath));
                    }
                }
            }
        }
        $GLOBALS["page"]["body"] .= $body;
    }

}