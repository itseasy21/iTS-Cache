<?php

    // +----------------------------------------------------------------------+
    // | iTS Cache v1 - Advance Caching Class                                 |
    // +----------------------------------------------------------------------+

ini_set('time_limit','0'); // Prevent script from timing out.

    /**
    * Create And Manage Static Cache From Dynamic Content
    *
    * Usage:
    *   See example.php
    *
    */

class itscache {

    function start ($file_n,$life,$path) {

        if (!$path) {$path = date("Ymd").'/';}
        global $file;
        $file = $file_n;
        $build = '';
        $file_name = $path.$file.'.itscache';

            //Check For Cache Path Existence
                if (!is_dir ($path) and $path) {
                    mkdir ($path , 0777);
                }

            //Check For Cache File Existence
                if (file_exists($file_name)) {
                    $mtime = filemtime($file_name);
                } else {
                    ob_start();
                    $build='set';
                    return $build;
                }

            //Check For Cache File Time
                if ($mtime + $life < time()) {
                    ob_start();
                    $build='set';
                    return $build;
                } else {
                    $this -> read ($file_name);
                    return 0;
                }

    }

    function build ($path) {

        if (!$path) {$path = date("Ymd").'/';}
        global $file;
        $file_name = $path.$file.'.itscache';
        //Read Output Buffer
        $contents = ob_get_contents();
        //Rebuild Inline PHP
        $contents = str_replace ('<sphp' , '<?php' ,$contents );
        $contents = str_replace ('ephp>' , '?>' ,$contents );
        //Clear Output Buffer
        ob_clean();
        //Build Cache File
        $handle = fopen($file_name, 'w+');
        fwrite($handle, $contents);
        $this -> read ($file_name);
    }

    function read ($file_name) {
            include ("$file_name");

    }


    function remove () {
        global $path;
        global $file;
        $file_name = $path.$file.'.itscache';

                if (file_exists ($file_name)) {
                    unlink ($file_name);
                }

        }

}

?>
