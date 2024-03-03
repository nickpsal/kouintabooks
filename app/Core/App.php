<?php  
    class App{
        //initiate variables 
        private $controller = 'Home';
        private $method = 'index';
        //class constructor 
        public function __construct()
        {
            $url = $this->splitURL();
            //παιρνουμε το url που έχει πληκτρολογήσει ο χρήστης μετά απο την διευθηνση της σελίδας
            //χωρίζουμε το url σε λίστα
            //[0] is the contorller
            //[1] is the method
            $filename = "../app/Controllers/" . ucfirst($url[0]) . ".php";
            //check if the controller file exists
            if (file_exists($filename)){
                $this->controller = ucfirst($url[0]);
                //αφαιρούμε το controller απο την Λίστα
                unset($url[0]); 
                //κανουμε require το αρχείο του contriller 
                require $filename;
            }else {
                // αν δεν υπάρχει ο controller κάνουμε require το _404 controller
                $this->controller = "_404";
                require "../app/Controllers/_404.php";
            }
            $controller = new $this->controller;
            if (isset($url[1])) {
                //έλεγχος αν υπάρχει η μέθοδος στον controller
                if(method_exists($controller, $url[1])) {
                    $this->method = $url[1];
                    //αφαιρουμε την μέθοδο απο την λίστα
                    unset($url[1]);
                }
            }
            call_user_func_array([$controller, $this->method], [$url]);
        }

        //χωρίζουμε το url σε λίσατ
        private function splitURL() {
            if (empty($_GET['url'])) {
                redirect('home');
            }else {
                $url = $_GET['url'];
                return (explode('/', filter_var(trim($url, "/"), FILTER_SANITIZE_URL)));
            }
        }
    }