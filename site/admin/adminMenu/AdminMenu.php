<?

use app\lib\modul;

class AdminMenu extends Modul
{

    public function __construct($database)
    {
        //Подключаем настройки
        if(file_exists(__DIR__ . "\settings.php")){
            include "settings.php";

            //Проверяем настройки
            if(isset($localization)){
                //Подключаем локализацию
                include $localization . "name-variable.php";
            }else{
                print("</br>");
                print("erloc1           ".__DIR__ . "\settings.php");
                print("</br>");
            }

            //Создаем header
            $header = "login_header" .PHP_EOL;
            $GLOBALS["page"]["header"] .= $header;

            $modulPath = $_SESSION["page_modul"];
            $pagePath = $_SESSION["page"];
            print_r("<p>" . $modulPath . "</p>");

            //body
            if(isset($_SESSION[$modulPath]) && ($_SESSION[$modulPath] >= 1)){
                $siteMap = $database->getTable("sitemap");
                array_multisort(array_column($siteMap, "directory"), SORT_ASC, $siteMap);
                //Сортируем модули внутри директорий
                $adminMenu = [];
                $directoryModules = [];
                $i = 0;
                while($i < count($siteMap)){
                    $currentDirectory = $siteMap[$i]["directory"];
                    $directoryModules = [];
                    $j = 0;
                    do{
                        $directoryModul[0]["directory"] = $siteMap[$i]["directory"];
                        $directoryModul[0]["modul"] = $siteMap[$i]["modul"];
                        $directoryModul[0]["parrent"] = $siteMap[$i]["parrent"];
                        $directoryModules[$j] = $directoryModul[0];
                        $j++;
                        $i++;
                    }
                    while(($i < count($siteMap)) && ($currentDirectory === $siteMap[$i]["directory"]));
                    array_multisort(array_column($directoryModules, "parrent"), SORT_ASC, $directoryModules);
                    foreach ($directoryModules as $directoryModul){
                        array_push($adminMenu, $directoryModul);
                    }
                }
                $this->listElement($adminMenu, $_SESSION[$modulPath]);
                $this->test();
            }
        }else{
            print_r("<p>Settings No found</p>");
        }

    }

    public function listElement($elementMenu, $accesLevel)
    {
        $i = 0;
        echo '<ol>'.PHP_EOL;
        while($i < count($elementMenu)){
            if(($elementMenu[$i]["directory"] == "/")){
                do{
                    echo '<li>'.PHP_EOL;
                    echo $elementMenu[$i]["modul"].PHP_EOL;
                    echo '</li>'.PHP_EOL;
                    $i++;
                }
                while  (($i < count($elementMenu)) && ($elementMenu[$i]["directory"] == "/"));
                if($accesLevel == 2){
                    echo '<li>'.PHP_EOL;
                    echo "<i>Add Module.../Add Page...</i>".PHP_EOL;
                    echo '</li>'.PHP_EOL;
                }
            }
            if($i < count($elementMenu)){
                $currentDirectory = $elementMenu[$i]["directory"];
                $currentElement = [];
                do
                {
                    $pos = strpos($elementMenu[$i]["directory"], '/', strpos($elementMenu[$i]["directory"], '/') + 1);
                    $elementMenu[$i]["directory"] = substr($elementMenu[$i]["directory"], $pos);
                    array_push($currentElement, $elementMenu[$i]);
                    $i++;
                }
                while (($i < count($elementMenu)) && ($elementMenu[$i]["directory"] == $currentDirectory));
            
                if (count($currentElement) > 0){
                    echo "<li><b>" . substr($currentDirectory, 1, $pos - 1) . "</b></li>".PHP_EOL;
                    $this->listElement($currentElement, $accesLevel);
                }
            }
        }
        echo '</ol>'.PHP_EOL;
    }

    public function test()
    {
        $body = "<form action=\"textarea1.php\" method=\"post\">" .PHP_EOL;
        $body .= "<p><textarea rows=\"10\" cols=\"45\" name=\"text\">" . file_get_contents(__DIR__ . "/settings.php") . "</textarea></p>" .PHP_EOL;
        $body .= "<p><input type=\"submit\" value=\"Отправить\"></p>" .PHP_EOL;
        $body .= "</form>" .PHP_EOL;
        $GLOBALS["page"]["body"] .= $body;
    }

}
