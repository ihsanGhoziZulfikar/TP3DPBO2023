<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Person.php');
include('classes/Template.php');

$person = new Person($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$person->open();

$data = nulL;

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($person->deletePerson($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $person->getPersonById($id);
        $row = $person->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['name'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['photo'] . '" class="img-thumbnail" alt="' . $row['photo'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Age</td>
                                    <td>:</td>
                                    <td>' . $row['age'] . '</td>
                                </tr>
                                <tr>
                                    <td>Race</td>
                                    <td>:</td>
                                    <td>' . $row['race_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Religion</td>
                                    <td>:</td>
                                    <td>' . $row['religion_name'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="editPerson.php?edit='.$row['id'].'"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <a href="detail.php?hapus='.$row['id'].'"><button type="button" class="btn btn-danger">Hapus Data</button></a>
            </div>';
    }
}

$person->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PERSON', $data);
$detail->write();
