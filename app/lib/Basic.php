<?

namespace app\lib;

class Basic
{

    public function fileSearch(string $dir, string $name): bool
    {
        if (file_exists($dir)){
            $files = scandir($dir);
            foreach($files as $file){
                if($file != '.' && $file != '..'){
                    if ($file === $name) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function errorList(int $numberError)
    {
        switch($numberError){
            case 404:
                require_once "error\\404.php";
        }

    }


}
