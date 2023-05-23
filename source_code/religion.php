<?php
include('config/db.php');
include('classes/DB.php');
include('classes/Religion.php');
include('classes/Template.php');

// inisialisasi data dari database
$religion = new Religion($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$religion->open();

// memanggil template skintabel
$view = new Template('templates/skintabel.html');

// jika program tidak memiliki get edit
if(!isset($_GET['edit'])){
    // jika program memiliki post submit (add data)
    if(isset($_POST['submit'])){
        // data ditambah melalui fungsi addReligion()
        if($religion->addReligion($_POST) > 0){
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'religion.php';
            </script>";
        }else{
            echo "<script>
            alert('Data gagal ditambah!');
            document.location.href = 'religion.php';
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
            // update data melalui fungsi updateReligion()
            if ($religion->updateReligion($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'religion.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'religion.php';
            </script>";
            }
        }

        $religion->getReligionById($id);
        $row = $religion->getResult();

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
        // hapus data melalui fungsi deleteReligion()
        if ($religion->deleteReligion($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'religion.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'religion.php';
            </script>";
        }
    }
}

// set data untuk template
$mainTitle = 'Religion';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Religion Name</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'religion';

// handler btn-cari dan sort data
if(isset($_GET['desc'])){
    if(isset($_POST['btn-cari'])) {
        $religion->searchReligionDesc($_POST['cari']);
    }else{
        $religion->getReligionDesc();
    }
    $order = 'order: <a href="religion.php?">desc</a>';
}else{
    if(isset($_POST['btn-cari'])) {
        $religion->searchReligion($_POST['cari']);
    }else{
        $religion->getReligion();
    }
    $order = 'order: <a href="religion.php?desc">asc</a>';
}

// set data untuk template (table)
while ($row = $religion->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $row['name'] . '</td>
    <td style="font-size: 22px;">
        <a href="religion.php?edit=' . $row['id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="religion.php?hapus=' . $row['id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

$religion->close();

// set template
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('DATA_ORDER', $order);
$view->write();

?>