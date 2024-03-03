<?php
    class Home {
        use Controller;
        public function index($data = [])
        {
            $book = new Book();
            $book->createDatabaseBookTable();
            $data['title'] = 'Βιβλία Εκδόσεων Κουίντα';
            $data['data'] = $book->find_all_data_from_db();
            $this->view('home', $data); 
        }

        public function add($data = []) {
            $book = new Book();
            $request = new Request();
            if ($request->is_get()) { 
                $data['title'] = 'Εισαγωγή Νέου Βιβλιου';
                $this->view('addnew', $data);
            }else {
                $data['Title'] = $_POST['title'];
                $data['PublisherName'] = $_POST['publisher'];
                $data['Year'] = $_POST['Year'];
                $data['ISBN'] = $_POST['ISBN'];
                $data['Price'] = $_POST['Price'];
                $data['FinalPriceWithVAT'] = $data['Price'] - $data['Price'] * 30/100;
                $data['FinalPriceWithOutVAT'] = round($data['FinalPriceWithVAT'] / 1.06, 2);
                $book->insert_data_to_db($data);
                message("Ή εγγραφή Δημιουργήθηκε με επιτυχία");
                redirect('home');
            }
        }

        public function update($data = []) {
            $request = new Request();
            $book = new Book();
            if ($request->is_GET()) {
                $query['id'] = $_GET['id'];
                $data['data'] = $book->get_first_query_db($query);
                if (!empty($data['data'])) {
                    $data['title'] = 'Αλλαγή Στοιχείων Βιβλίου';
                    $this->view('update', $data);
                }else {
                    redirect('home');
                }
            }else {
                $data['Title'] = $_POST['title'];
                $data['PublisherName'] = $_POST['publisher'];
                $data['Year'] = $_POST['Year'];
                $data['ISBN'] = $_POST['ISBN'];
                $data['Price'] = $_POST['Price'];
                $data['FinalPriceWithVAT'] = $data['Price'] - $data['Price'] * 30/100;
                $data['FinalPriceWithOutVAT'] = round($data['FinalPriceWithVAT'] / 1.06, 2);
                $book->update_data_to_db($_GET['id'],$data);
                message("Τ αστοιχεία της εγγραφής άλλαξαν");
                redirect('home');
            }
        }

        public function delete($data = []) {
            $id = $_GET['id'];
            $book = new Book();
            $book->delete_data_from_db($id);
            redirect('home');
        }

        public function exporttopdf($data = []) {
            $book = new Book();
            $data['data'] = $book->find_all_data_from_db();
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
             //set font 
            $pdf->SetFont('dejavusans', '', 10);
            //Add a Page
            $pdf->AddPage();
            // Set HTML content
            $html = '<h1 class="header">Βιβλία Εκδόσεων Κουιντα</h1>
                <table id="myTable" class="table table-striped" border="1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>ISBN</th>
                        <th>Price</th>
                        <th>FinalPriceWithOutVAT</th>
                        <th>FinalPriceWithVAT</th>
                    </tr>
                </thead>
            ';
            $html .= '<tbody>'; // Start tbody here
            foreach($data['data'] as $d) { 
                $html .= '<tr>
                <td>' . $d->Id . '</td>
                <td>' . $d->Title . '</td>
                <td>' . $d->PublisherName . '</td>
                <td>' . $d->Year . '</td>
                <td>' . $d->ISBN . '</td>
                <td>' . $d->Price . '</td>
                <td>' . $d->FinalPriceWithOutVAT . '</td>
                <td>' . $d->FinalPriceWithVAT . '</td>
                </tr>';
            }
            $html .= '</tbody>'; // End tbody here
            $html .= '</table>';
            // Set font size to auto-scale content
            $font_size = 12; // Initial font size
            $max_height = 280; // Maximum height for the content (adjust as needed)
            // Convert HTML to PDF
            $pdf->writeHTML($html, true, false, true, false, '');
            // Output PDF
            $pdf->Output('example.pdf', 'I'); // 'I' to open in the browser, 'D' to download, 'F' to save to a file.
        }
    }