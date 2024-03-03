<?php
    //εκτύπωση λίστας διαμορφωμένη με pre
    function show($stuff)
    {
        echo "<pre>";
        print_r($stuff);
        echo "</pre>";
    }

    //function ανακατεύθυνσης
    function redirect($page)
    {
        header("Location: " . URL . $page . '/');
        die();
    }

    //έλεγχος αν ο controller που δίνουμε είναι η τρέχουσα σελίδα
    function check_if_current_page($m)
    {
        $current_page = basename($_SERVER['REQUEST_URI']);
        if ($current_page == $m) {
            return true;
        }
        return false;
    }

    //εμφάνιση μηνύματος μόνο μια φορά
    function message($msg = '',$erase = false)
    {
        if(!empty($msg)){
            $_SESSION['message'] = $msg;
        }else if(!empty($_SESSION['message'])){
            $msg = $_SESSION['message'];
            if($erase){
                unset($_SESSION['message']);
            }
            return $msg;
        }
        return false;
    }