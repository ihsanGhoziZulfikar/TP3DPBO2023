<?php

// jika program tidak memiliki get edit, kembalikan ke addPerson
if(!isset($_GET['edit'])){
    header("Location: addPerson.php");
    exit();
}

include('config/db.php');
include('classes/DB.php');
include('classes/Person.php');
include('classes/Race.php');
include('classes/Religion.php');
include('classes/Template.php');

// inisialisasi data dari database
$person = new Person($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$race = new Race($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$religion = new Religion($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$person->open();
$race->open();
$religion->open();

// memanggil template skinFormPerson
$view = new Template('templates/skinFormPerson.html');

// jika program memiliki post submit (edit data)
if (isset($_POST['submit'])) {
    // edit data melalui fungsi updatePerson()
    if ($person->updatePerson($_GET['edit'],$_POST,$_FILES) > 0) {
        echo "<script>
            alert('Data berhasil diubah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diubah!');
            document.location.href = 'index.php';
        </script>";
    }
}

// setting data untuk template
$btn = 'Edit';
$title = 'Edit';
$mainTitle = 'Person';
$formLabel = 'Person';

// menyimpan data sebelumnya
$person->getPersonById($_GET['edit']);
$prevPerson = $person->getResult();
$name = $prevPerson['name'];
$age = $prevPerson['age'];
$photo = $prevPerson['photo'];
$prevPhoto = '<input type="hidden" name="prevPhoto" value="'.$photo.'">';

$raceOption = '';
$race->getRace();
while($row = $race->getResult()){
    $raceOption .= '<option value='.$row['id'].' '.($row['id']==$prevPerson['race_id']? 'selected' : '').'> '.$row['name'].' </option>';
}
$religionOption = '';
$religion->getReligion();
while($row = $religion->getResult()){
    $religionOption .= '<option value='.$row['id'].' '.($row['id']==$prevPerson['religion_id']? 'selected' : '').'> '.$row['name'].' </option>';
}


$race->close();

// setting template
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);

$view->replace('DATA_NAMA', $name);
$view->replace('DATA_AGE', $age);
$view->replace('DATA_PHOTO_LOC', $photo);
$view->replace('DATA_PHOTO_PREV', $prevPhoto);

$view->replace('DATA_OPTION_RACE', $raceOption);
$view->replace('DATA_OPTION_RELIGION', $religionOption);
$view->write();
