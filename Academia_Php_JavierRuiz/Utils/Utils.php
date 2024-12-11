<?php

namespace Utils;


class Utils{
    public static function deleteSession($name):void{
        if(isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }

}


class PDFGenerator {
    public static function renderToString(string $pageName, array $params = null): string {
        $htmlContent = '';

        if ($params != null){
            foreach ($params as $name => $value){
                $$name = $value;
            }
        }

        ob_start();
        require_once "Views/layout/header.php";
        require_once "Views/$pageName.php";
        $htmlContent = ob_get_clean();

        return $htmlContent;
    }
}
