<?

use app\lib\modul;

class Login extends Modul
{
    public function __construct()
    {
        //Подключаем настройки
        if(file_exists(__DIR__ . "\settings.php")){
            include "settings.php";

            //Проверяем настройки
            if (isset($localization) && $accessTable){
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
            //body
            if(isset($_SESSION[$modulPath]) && ($_SESSION[$modulPath] == 1)){
                print("<p>exit</p>");
            }else{
                var_dump($_POST);
                var_dump($_SESSION["page_modul"]);
                $body = "<div>" .PHP_EOL;
                $body .= "    <form action=\"/admin/\" method=\"post\">" .PHP_EOL;
                $body .= "        <p>" . $nameLoginLogin . "<input type=\"text\" name=\"" . $modulPath . "_login\"></p>" .PHP_EOL;
                $body .= "        <p>" . $nameLoginPass . "<input type=\"password\" name=\"" . $modulPath . "_pass\"></p>" .PHP_EOL;
                $body .= "        <p><button type=\"submit\">" . $nameLoginEnter . "</button></p>" .PHP_EOL;
                $body .= "    </form>" .PHP_EOL;
                $body .= "</div>" .PHP_EOL;
                if($_SERVER['REQUEST_METHOD'] === "POST"){
                    print("<p>POST</p>");
                    if ((isset($_POST[$modulPath . "_login"])) && (isset($_POST[$modulPath . "_pass"]))){
                        //Получаем список модулей доступных для данного логина и пароля
                        $accessLevels = 
                    }
                }
            }
        }
        $GLOBALS["page"]["body"] .= $body;
    }

}