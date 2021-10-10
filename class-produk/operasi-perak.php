<?php 
include('perak.php');
$obj = new perak();
session_start();
if($_SESSION['jabatan']=="Gudang"){


$action = $_GET['action'];
if($action == "add") {
    global $produk;
    $query = mysqli_query($produk->connection, "SELECT max(id_produk) as id_produkTerbesar FROM produk");
    $data = mysqli_fetch_array($query);
    $id_produk = $data['id_produkTerbesar'];

    $urutan = (int) substr($id_produk, 4, 4);
    $urutan++;

    $huruf = "BRG";
    $id_produk = $huruf . sprintf("%04s", $urutan);

    $gambar = $_FILES['gambar']['name'];
    $source = $_FILES['gambar']['tmp_name'];
    $folder = '../img/upload/';

    move_uploaded_file($source, $folder.$gambar);

    $obj->insertData($id_produk, $_POST['kode'], $gambar, $_POST['nama'],$_POST['stock'], $_POST['Kg'], $_POST['harga_awal'],  $_POST['harga_jual'], "Perak");
    echo '<script language="javascript">alert("Berhasil Ditambahkan"); document.location="../karyawan/index.php?page=data-perak";</script>';
}

elseif($action=="update")
{
	$obj->updateData($_POST['nama'],$_POST['stock'],$_POST['kg'],$_POST['harga_awal'],$_POST['harga_jual'],$_POST['id_produk']);
    header('location:../karyawan/index.php?page=data-perak');

}

elseif($action=="updateKode")
{
	$obj->updateKode($_POST['kode'],$_POST['id_produk']);
    header('location:../karyawan/index.php?page=data-perak');

}

elseif($action=="delete")
{
	$id_bahan = $_GET['id'];
	$obj->deleteData($id_bahan);
    header('location:../index.php?page=data-perak');
    
}
}
else{
    echo '<script language="javascript">alert("Akses hanya untuk Gudang"); document.location="../karyawan/index.php?page=data-emas";</script>';
}
?>
