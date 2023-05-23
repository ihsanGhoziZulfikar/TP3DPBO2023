<?php
// Saya Ihsan Ghozi Zulfikar NIM 2103303 mengerjakan soal TP 3 dalam mata kuliah DPBO 
// untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

include('config/db.php');
include('classes/DB.php');
include('classes/Person.php');
include('classes/Template.php');

// inisialisasi data dari database
$person = new Person($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$person->open();

// jika program memiliki get desc (sort descending)
if(isset($_GET['desc'])){
    // jika program memiliki post btn-cari (search)
    if(isset($_POST['btn-cari'])) {
        // person didapat melalui fungsi searchPersonDesc()
        $person->searchPersonDesc($_POST['cari']);
    }else{
        // person didapat melalui fungsi getPersonJoinDesc()
        $person->getPersonJoinDesc();
    }
    $order = 'order: <a href="index.php?">desc</a>';
}else{
    if(isset($_POST['btn-cari'])) {
        $person->searchPerson($_POST['cari']);
    }else{
        $person->getPersonJoin();
    }
    $order = 'order: <a href="index.php?desc">asc</a>';
}

$data = null;

// setting data card untuk template
while ($row = $person->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 person-thumbnail">
        <a href="detail.php?id=' . $row['id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['photo'] . '" class="card-img-top" alt="' . $row['photo'] . '">
            </div>
            <div class="card-body">
                <p class="card-text person-nama my-0">' . $row['name'] . '</p>
                <p class="card-text divisi-nama">' . $row['race_name'] . '</p>
                <p class="card-text jabatan-nama my-0">' . $row['religion_name'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

$person->close();
// memanggil dan mengset data template skin
$home = new Template('templates/skin.html');
$home->replace('DATA_PERSON', $data);
$home->replace('DATA_ORDER', $order);
$home->write();
