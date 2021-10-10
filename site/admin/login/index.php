<?

$GLOBALS["page"]["body"] .= "<p>Login body</p>" .PHP_EOL;
print_r("<p>");
var_dump(get_defined_vars());
print_r("</p>");

require "Login.php";

print_r("<p>" . getcwd() . "</p>");
$login = new Login;
