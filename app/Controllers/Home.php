<?php
    class Home {
        use Controller;
        public function index($data = [])
        {
            $books = new Book();
            $books->createDatabaseBookTable();
            $data['title'] = 'Βιβλία Εκδόσεων Κουίντα';
            $data['data'] = $books->find_all_data_from_db();
            $this->view('home', $data); 
        }

        public function add($data = []) {
            $book = new Book();
            $request = new Request();
            if ($request->is_get()) { 
                $data['title'] = 'Εισαγωγή Νέου Βιβλιου';
                $this->view('addnew', $data);
            }else {
                $data['title'] = $_POST['title'];
                $data['publisher'] = $_POST['publisher'];
                $data['Year'] = $_POST['Year'];
                $data['ISBN'] = $_POST['ISBN'];
                $data['Price'] = $_POST['Price'];
                $data['FinalPriceWithVAT'] = $data['Price'] - $data['Price'] * 30/100;
                $data['FinalPriceWithOutVAT'] = round($data['FinalPriceWithVAT'] / 1.06, 2);
                $book->insert_data_to_db($data);
                redirect('home');
            }
        }

        public function update($data = []) {
            $request = new Request();
            $book = new Book();
            if ($request->is_GET()) {
                $query['id'] = $_GET['id'];
                $data['data'] = $book->get_first_query_db($query);
                $data['title'] = 'Αλλαγή Στοιχείων Βιβλίου';
                show($data); die();
                $this->view('update', $data);
            }else {
                $data['title'] = $_POST['title'];
                $data['publisher'] = $_POST['publisher'];
                $data['Year'] = $_POST['Year'];
                $data['ISBN'] = $_POST['ISBN'];
                $data['Price'] = $_POST['Price'];
                $data['FinalPriceWithVAT'] = $data['Price'] - $data['Price'] * 30/100;
                $data['FinalPriceWithOutVAT'] = round($data['FinalPriceWithVAT'] / 1.06, 2);
                $book->update_data_to_db($_GET['id'],$data);
                redirect('home');
            }
        }

        public function delete($data = []) {
            $id = $_GET['id'];
            $book = new Book();
            $book->delete_data_from_db($id);
        }
    }