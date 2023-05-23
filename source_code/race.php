<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Race.php');
include('classes/Template.php');

// inisialisasi data dari database
$race = new Race($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$race->open();

// memanggil template skintabel
$view = new Template('templates/skintabel.html');

// jika program tidak memiliki get edit
if (!isset($_GET['edit'])) {
    // jika program memiliki post submit (add data)
    if (isset($_POST['submit'])) {
        // data ditambah melalui fungsi addRace()
        if ($race->addRace($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'race.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'race.php';
            </script>";
        }
    }

    $btn = 'Add';
    $title = 'Add';
}

// jika program memiliki get edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    if ($id > 0) {
        // jika id valid dan program memiliki post submit (edit data)
        if (isset($_POST['submit'])) {
            // update data melalui fungsi updateRace()
            if ($race->updateRace($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'race.php?';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'race.php';
            </script>";
            }
        }

        $race->getRaceById($id);
        $row = $race->getResult();

        $dataUpdate = $row['name'];
        $btn = 'Save';
        $title = 'Edit';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

// jika program memiliki get hapus (delete data)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // hapus data melalui fungsi deleteRace()
        if ($race->deleteRace($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'race.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'race.php';
            </script>";
        }
    }
}

// set data untuk template
$mainTitle = 'Race';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Race Name</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'race';

// handler btn-cari dan sort data
if(isset($_GET['desc'])){
    if(isset($_POST['btn-cari'])) {
        $race->searchRaceDesc($_POST['cari']);
    }else{
        $race->getRaceDesc();
    }
    $order = 'order: <a href="race.php?">desc</a>';
}else{
    if(isset($_POST['btn-cari'])) {
        $race->searchRace($_POST['cari']);
    }else{
        $race->getRace();
    }
    $order = 'order: <a href="race.php?desc">asc</a>';
}

// set data untuk template (table)
while ($row = $race->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $row['name'] . '</td>
    <td style="font-size: 22px;">
        <a href="race.php?edit=' . $row['id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="race.php?hapus=' . $row['id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

$race->close();

// set template
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('DATA_ORDER', $order);
$view->write();
