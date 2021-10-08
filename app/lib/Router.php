<?

namespace app\lib;

class Router extends Basic
{

    public function __construct(string $request)
    {
        if (stripos($request, "api.php"))
        {
            print("Api");
        }else{
            if ($this->fileSearch("site" . $request, "page.php")){
                print("page");
            }else{
                $this->errorList(404);
            }
        }
    }

    public function createPage(string $request)
    {
        
    }

}
