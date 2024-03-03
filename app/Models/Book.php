<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class Book {
        use Model;
        protected $db_table = 'book';
        protected $order_col = "Year";
        protected $order_type = "desc";
        protected $limit = 20;
        protected $offset = 0;
        protected $update_id = 'id';
        //allowed columns of the db
        protected $allowedColumns = [
            'Title',
            'PublisherName',
            'Year',
            'ISBN',
            'Price',
            'FinalPriceWithOutVAT',
            'FinalPriceWithVAT'
        ];

        public function createDatabaseBookTable() 
        {
            $sql = "CREATE TABLE IF NOT EXISTS book (
                `Id` int NOT NULL AUTO_INCREMENT,
                `Title` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
                `PublisherName` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
                `Year` int NOT NULL,
                `ISBN` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
                `Price` float NOT NULL,
                `FinalPriceWithOutVAT` float NOT NULL,
                `FinalPriceWithVAT` float NOT NULL,
                PRIMARY KEY (`Id`)
            )";
            $this->query($sql);
            $data = $this->find_all_data_from_db();
            if (empty($data)) {
                $data = $this->getBooksfromExcel();
                for ($i = 1; $i < count($data); $i++) {
                    $insertedData['Title'] = $data[$i][0];
                    $insertedData['PublisherName'] = $data[$i][1];
                    $insertedData['Year'] = $data[$i][2];
                    $insertedData['ISBN'] = $data[$i][3];
                    $insertedData['Price'] = $data[$i][4];
                    $insertedData['FinalPriceWithOutVAT'] = $data[$i][5];
                    $insertedData['FinalPriceWithVAT'] = $data[$i][6];
                    $this->insert_data_to_db( $insertedData );
                }
            }
        }

        public function getBooksfromExcel() {
            $filePath = "files/books.xlsx";
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            // Convert the worksheet data to an array
            $data = $worksheet->toArray();
            unset($data[0]);
            return $data;
        }
    }