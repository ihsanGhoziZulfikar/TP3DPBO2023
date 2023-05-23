<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Person.php');
include('classes/Race.php');
include('classes/Religion.php');
include('classes/Template.php');

$person = new Person($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$race = new Race($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$religion = new Religion($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$person->open();
$race->open();
$religion->open();

$view = new Template('templates/skinFormPerson.html');

if (isset($_POST['submit'])) {
    if ($person->addPerson($_POST,$_FILES) > 0) {
        echo "<script>
            alert('Data berhasil ditambah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'index.php';
        </script>";
    }
}

$btn = 'Add';
$title = 'Add';
$mainTitle = 'Person';
$formLabel = 'Person';
$photo = 'noPhoto.png';

$raceOption = '';
$race->getRace();
while($div = $race->getResult()){
    $raceOption .= '<option value='.$div['id'].'> '.$div['name'].' </option>';
}
$religionOption = '';
$religion->getReligion();
while($jab = $religion->getResult()){
    $religionOption .= '<option value='.$jab['id'].'> '.$jab['name'].' </option>';
}


$race->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_PHOTO_LOC', $photo);
$view->replace('DATA_OPTION_RACE', $raceOption);
$view->replace('DATA_OPTION_RELIGION', $religionOption);
$view->write();
