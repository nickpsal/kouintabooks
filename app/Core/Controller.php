<?php
    trait Controller {
        //προβολή της view της σελίδας
        public function view($view, $data = []){
            //τοποθεσία του header
            $header = "../app/Views/includes/header.php";
            //ορισμοί path της view
            $filename = "../app/Views/" . $view . ".view.php";
            //τοποθεσία footer 
            $footer = "../app/Views/includes/footer.php";
            //Κάνουμε έλεγχο αν υπάρχει το header και το φορτώνουμε
            if (file_exists($header)) {
                require $header;
            }else {
                echo "not found";
            }
            //Κάνουμε έλεγχο αν υπάρχει το view και το φορτώνουμε
            if (file_exists($filename)){
                require $filename;
            }else {
                require "../app/Views/404.view.php";
            }
            //Κάνουμε έλεγχο αν υπάρχει το footer και το φορτώνουμε
            if (file_exists($footer)) {
                require $footer;
            }else {
                echo "not found";
            }
        }
    }