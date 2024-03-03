<?php    
    trait Database {
        // Private property για να κράτει το conenction της βασης Δεδομένων
        private $pdo;
        // Private method για σύνδεση σητν Βάση Δεδομένων
        private function connect() {
            // Ελεχος αν έχει γίνει ήδη σύνδεση στην Βάση Δεδομένων
            if (!$this->pdo) {
                try {
                    // κατασκεύη του stirng για σύνδεση στην Βάση Δεδομένων
                    $string = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
                    // Δημιουργία Νέου αντικειμένου pdo με τα credentials της Βασης Δεδομένων
                    $this->pdo = new PDO($string, DB_USER, DB_PASS);
                    // Αναφορα λαθών
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    //Μήνυμα σφάλματος σε περίπτωση που δημιουργηθεί σφάλμα
                    throw new Exception("Database connection failed: " . $e->getMessage());
                }
            }
            // Επιστροφη του αντικειμένου Σύνδεσης
            return $this->pdo;
        }

        // μεθοδος εκτέλεσης query στην βαση δεδομένων
        public function query($query, $query_data = []) {
            // Καταγραφή της ώρας που ξεκίνησε το query
            $start_time = microtime(true);
            // Δημιουργία Σύνδεσης στην Βάση Δεδομένων
            $con = $this->connect();
            try {
                //Προςτοιμασία του sql query
                $stm = $con->prepare($query);
                // Εκτέλεση του query μαζι με παραμέτρους αν έχουν περαστεί
                $check = $stm->execute($query_data);
                // Σε περίπτωση αποτυχίας του query βγάζουμε σφάλμα
                if (!$check) {
                    throw new Exception("Query execution failed: " . implode(" ", $stm->errorInfo()));
                }
                // Παιρνουμε τα αποτελέσματα και τα επιστρέφουμε σε λίστα
                $result = $stm->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } catch (PDOException $e) {
                // Σε περίπτωση αποτυχίας του query βγάζουμε σφάλμα
                throw new Exception("Query execution failed: " . $e->getMessage());
            } finally {
                // Καταγραφή της ώρας που τελείωσε το query
                $end_time = microtime(true);
                // Υπολογισμός του χρόνου εκτέλεσης
                $execution_time = ($end_time - $start_time) * 1000;
                // Κάνουμε καταγραφή του query και του χρόνου εκτέλεσης
                $log_message = $query . " [" . number_format($execution_time, 2) . " ms]";
                //καταγραφή σφαλμάτων στο error log
                error_log($log_message);
            }
        }
    }
