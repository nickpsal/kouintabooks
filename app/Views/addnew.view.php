    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1><?= $data['title'] ?></h1>
                <form accept-charset="UTF-8" action="" autocomplete="on" method="POST">
                    <div class="error">
                        <?php
                        if (message()) {
                            echo message('', true);
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="title">Τίτλος:</label>
                        <input type="text" class="form-control" name="title" placeholder="Τίτλος Βιβλίου" required />
                    </div>
                    <div class="form-group">
                        <label for="publisher">Συγγραφέας:</label>
                        <input type="text" class="form-control" name="publisher" placeholder="Συγγραφέας" required />
                    </div>

                    <div class="form-group">
                        <label for="Year">Year:</label>
                        <input type="text" class="form-control" name="Year" placeholder="Year" required />
                    </div>
                    <div class="form-group">
                        <label for="ISBN">ISBN:</label>
                        <input type="text" class="form-control" name="ISBN" placeholder="ISBN" required />
                    </div>
                    <div class="form-group">
                        <label for="Price">Price:</label>
                        <input type="text" class="form-control" name="Price" placeholder="Price" required />
                    </div>
                    <div class="form-group">
                        <button type="submit" value="Submit" class="btn btn-primary">Καταχώρηση Νέου Βιβλίου</button>
                        <a href="<?=URL?>home/" class="btn btn-primary" type="button">Επιστροφή</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
