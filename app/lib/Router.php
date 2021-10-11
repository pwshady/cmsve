<?

namespace app\lib;

use app\lib\database;

class Router extends Basic
{

    public function __construct(string $request)
    {
        if (stripos($request, "api.php"))
        {
            print("Api");
        }else{
            if ((substr($request, -1)) !== "/"){
                $request .= "/";
            };
            if ($this->fileSearch("site" . $request, "page.php")){
                //Получаем название таблици
                $moduleTablesPrefix = str_replace("/", "_", $request);
                $this->createPage($request);
            }else{
                $this->errorList(404);
            }
        }
    }

    public function createPage(string $request)
    {
        $database = new Database("app/config/db-config.php");
        $moduls = $database->getKeyValue("sitemap", "directory", "modul", $request);
        if (count($moduls) === 0){
            exit();
        }
        //Сортируем массив по parrent
        array_multisort(array_column($moduls, 'parrent'), SORT_ASC, $moduls);
        $GLOBALS["page"]["instructions"] = [];
        $GLOBALS["page"]["header"] = "<!DOCTYPE html>" .PHP_EOL . "<header>" .PHP_EOL;
        $GLOBALS["page"]["body"] = "<body>" .PHP_EOL;
        $GLOBALS["page"]["footer"] = "<footer>" .PHP_EOL;
        $_SESSION["page"] = str_replace("/", "_", $request);
        for($i = 0; $i < count($moduls); $i++){
            if((substr($moduls[$i]["modul"], -1)) !== "/"){
                if ($this->fileSearch("site" . $moduls[$i]["directory"] . $moduls[$i]["modul"], "index.php")){
                    $_SESSION["page_modul"] = $_SESSION["page"] . $moduls[$i]["modul"];
                    require "site" . $moduls[$i]["directory"] . $moduls[$i]["modul"] . "/" . "index.php";
                }else{
                    $GLOBALS["page"]["body"] .= "<p>Modul no found</p>" .PHP_EOL;
                }
            }
        }




        print_r($GLOBALS["page"]["body"]);
    }

}
