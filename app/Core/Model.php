<?php   
    trait Model{
        use Database;
        //παίρνουμε όλα τα δεδομένα απο συγκεκριμενο πίνακα και κάνουμε ταξινόμηση
        public function find_all_data_from_db() {
            $query = "SELECT * FROM $this->db_table ORDER BY $this->order_col $this->order_type";
            return $this->query($query);
        }

        //Δμηιουργία query select * 
        public function where_query_db($data, $data_not  =  []) {
            //πάιρνουμε τα keys της associative array και υα αποθυκευουμε σε αλλη λιστα για κατασκευή του query 
            $keys = array_keys($data); 
            $keys_not = array_keys($data_not);
            $query = "SELECT * FROM $this->db_table  where ";
            //κατασκευή του query πεδιο=:τιμη
            foreach($keys as $key){
                $query .= $key . "=:" . $key .  " && ";
            }
            //κατασκευή του query πεδιο!=:τιμη
            foreach($keys_not as $key){
                $query .= $key . "!=:" . $key .  " && ";
            }
            //διαγράφουμε το τελευταίο &&
            $query = trim($query, " &&");
            $query .= " limit $this->limit offset $this->offset";
            //ενώνουμε τις 2 λίστες σε μια για να την περάσουμε στην view
            $data = array_merge($data, $data_not);
            return $this->query($query,$data);
        }

        //Δμηιουργία query select * και παίρνομτ μόνο το πρώτο αποτέλεσμα
        public function get_first_query_db($data, $data_not  =  []) {
            //πάιρνουμε τα keys της associative array και υα αποθυκευουμε σε αλλη λιστα για κατασκευή του query 
            $keys = array_keys($data); 
            $keys_not = array_keys($data_not);
            $query = "SELECT * FROM $this->db_table  where ";
            //κατασκευή του query πεδιο=:τιμη
            foreach($keys as $key){
                $query .= $key . "=:" . $key .  " && ";
            }
            //κατασκευή του query πεδιο!=:τιμη
            foreach($keys_not as $key){
                $query .= $key . " !=:" . $key .  " && ";
            }
            //διαγράφουμε το τελευταίο &&
            $query = trim($query, " &&");
            $query .= " limit $this->limit offset $this->offset";
            //ενώνουμε τις 2 λίστες σε μια για να την περάσουμε στην view
            $data = array_merge($data, $data_not);
            $result = $this->query($query, $data);
            //πειστρέφουμε μόνο το πρώτο αποτελεσμα
            if ($result) {
                return $result[0];
            }
            return false;
        }

        //Δημιουργία query εισαγωγής δεδομένων σε Πίνακα στην Βάση Δεδομένων
        public function insert_data_to_db($data){
            //αφαίρεση fields που δεν επιτρέπονται απο την data
            if (!empty($this->allowedColumns)) {
                foreach($data as $key=>$value) {
                    if (!in_array($key, $this->allowedColumns)) {
                        unset($data[$key]);
                    }
                }
            }
            //έλεγχος αν εισάγουμε δεδομενα στον πίνακα user
            if ($this->db_table === 'user') {
                //κωδικοποίηση του κωδικου χρήστη και κάονουμε τον role_user να είαναι ισο με 1
                $data['password_user'] = password_hash($data['password_user'],PASSWORD_DEFAULT);
                $data['role_user'] = 1;
            }
            $keys = array_keys($data);
            $query = "insert into $this->db_table (" . implode(",", $keys) . ") values (:" .implode(",:", $keys) . ")";
            $this->query($query, $data);
            return false;
        }

        //Δημιουργία query ανανέωσης δεδομένων σε Πίνακα στην Βάση Δεδομένων
        public function update_data_to_db($id, $data) {
            //αφαίρεση fields που δεν επιτρέπονται απο την data
            if (!empty($this->allowedColumns)) {
                foreach($data as $key=>$value) {
                    if (!in_array($key, $this->allowedColumns)) {
                        unset($data[$key]);
                    }
                }
            }
            $id_column = $this->update_id;
            $keys = array_keys($data); 
            $query = "UPDATE $this->db_table SET ";
            //κατασκευή του query πεδιο=:τιμη
            foreach($keys as $key){
                $query .= $key . "=:" . $key .  ", ";
            }
            //αφαιρεση τελευταιου ,
            $query = trim($query, ", ");
            $query .= " where $id_column = :$id_column ";
            $data[$id_column] = $id;
            if ($this->db_table === 'user' && !empty($data['password_user'])) {
                $data['password_user'] = password_hash($data['password_user'],PASSWORD_DEFAULT);
            }
            $this->query($query, $data);
            return false;
        }

        //Δημιουργία query διαγραφής δεδομένων σε Πίνακα στην Βάση Δεδομένων
        public function delete_data_from_db($id) {
            $id_column = $this->update_id;
            $data[$id_column] = $id;
            //κατασκευή του query πεδιο=:τιμη
            $query = "DELETE FROM $this->db_table where $id_column = :$id_column";
            $this->query($query, $data);
            return false;
        }
    }