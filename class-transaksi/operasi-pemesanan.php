<?php 
include('pemesanan.php');
$obj = new pemesanan();
session_start();
$action = $_GET['action'];
if($action == "add") {
    global $obj;
    $harga = $obj->Harga_total($_POST['harga_jual'],$_POST["jumlah"] );
    $HTot = $obj->getHarga_total();
    $tanggal = date('Y-m-d');

    if ($_POST["jumlah"] > $_POST['stock']) {
    echo '<script language="javascript">alert("Pemesanan Melebihi Stock! Silahkan Pesan kembali."); document.location="../konsumen/index.php?page=beranda";</script>';
    }
    else {
        
        $query2 = $_SESSION['user'];
            $result2 = mysqli_query($pesanan->connection, "SELECT * FROM konsumen WHERE username = '$query2'");
            $data3 = mysqli_fetch_assoc($result2);
            $hasil3 = $data3['no_npwp'];
            $id = $data3['no_npwp'];
                                
                if ($hasil3 == '') {
                    $a = $_POST['harga_jual'];
                    $b = $_POST['jumlah'];
                    $ppn = $a * $b * 0.009;
                    // $obj->setPPN($ppn);
                    $obj->insertData('',$_POST['no_reference'], $tanggal, $_POST['id_konsumen'], $_POST['id_produk'],$_POST['jumlah'], $ppn, $_POST['harga_jual'] , "Di Keranjang");
    echo '<script language="javascript">alert("Berhasil dimasukan ke keranjang!"); document.location="../konsumen/index.php?page=cart";</script>';
                }
                else {
                    $a = $_POST['harga_jual'];
                    $b = $_POST['jumlah'];
                    $ppn = $a * $b *0.0045;
                    // $obj->setPPN($ppn);
                    $obj->insertData('',$_POST['no_reference'], $tanggal, $_POST['id_konsumen'], $_POST['id_produk'],$_POST['jumlah'], $ppn, $_POST['harga_jual'] , "Di Keranjang");
    echo '<script language="javascript">alert("Berhasil dimasukan ke keranjang!"); document.location="../konsumen/index.php?page=cart";</script>';
                }
    
    }
}
if($action == "addperak") {
    global $obj;
    $harga = $obj->Harga_total($_POST['harga_jual'],$_POST["jumlah"] );
    $HTot = $obj->getHarga_total();
    $tanggal = date('Y-m-d');

    if ($_POST["jumlah"] > $_POST['stock']) {
    echo '<script language="javascript">alert("Pemesanan Melebihi Stock! Silahkan Pesan kembali."); document.location="../konsumen/index.php?page=beranda";</script>';
    }
    else {
        $a = $_POST['harga_jual'];
        $b = $_POST['jumlah'];
        $ppn = $a * $b * 0.002;
                    // $obj->setPPN($ppn);
        $obj->insertData('',$_POST['no_reference'], $tanggal, $_POST['id_konsumen'], $_POST['id_produk'],$_POST['jumlah'], $ppn, $_POST['harga_jual'] , "Di Keranjang");
        echo '<script language="javascript">alert("Berhasil dimasukan ke keranjang!"); document.location="../konsumen/index.php?page=cart";</script>';
    
    }
}
elseif($action=="update")
{
	$obj->updateData($_POST['nama'],$_POST['stock'],$_POST['kg'],$_POST['harga_awal'],$_POST['harga_jual'],$_POST['id_produk']);
    header('location:../kon');

}

elseif($action=="updateQty")
{
    $kalimat = $_POST['nama'];
    $posisi = strpos($kalimat,"Emas");
    if (preg_match("/Emas/i",$kalimat)){
        $query2 = $_SESSION['user'];
            $result2 = mysqli_query($pesanan->connection, "SELECT * FROM konsumen WHERE username = '$query2'");
            $data3 = mysqli_fetch_assoc($result2);
            $hasil3 = $data3['no_npwp'];
            $id = $data3['no_npwp'];
                                
                if ($hasil3 == '') {
                    $a = $_POST['harga'];
                    $b = $_POST['qty'];
                    $ppn = $a * $b * 0.009;
                    $obj->updateQty($_POST['id'],$_POST['qty'], $ppn);
                    header('location:../konsumen/index.php?page=cart');
                }
                else {
                    $a = $_POST['harga'];
                    $b = $_POST['qty'];
                    $ppn = $a * $b *0.0045;
                    $obj->updateQty($_POST['id'],$_POST['qty'],$ppn);
                    header('location:../konsumen/index.php?page=cart');
                }
        }
    else {
        $a = $_POST['harga'];
        $b = $_POST['qty'];
        $ppn = $a * $b * 0.002;
        $obj->updateQty($_POST['id'],$_POST['qty'], $ppn);
        header('location:../konsumen/index.php?page=cart');
    }
}

elseif($action=="dikirim")
{
    session_start();
    if($_SESSION['jabatan']=="Admin"){
    $no = $_GET['id'];
    $obj->upstat($no);
    $obj->upstat2($no);
    header('location:../karyawan/index.php?page=dashboard');
    }
    else{
        echo '<script language="javascript">alert("Akses hanya untuk Admin"); document.location="../karyawan/index.php?page=dashboard";</script>';
    }
}

elseif($action=="selesai")
{
    $id = $_GET['id'];
    $no = $_GET['no'];
    $obj->upstat3($id);
    $obj->upstat4($no);
    header('location:../konsumen/index.php?page=selesai');

}

elseif($action=="delete")
{
	$id = $_GET['id'];
	$obj->deleteData($id);
    header('location:../konsumen/index.php?page=cart');
    
}

elseif($action=="tanggal")
{
	$obj->keuangan($_POST['start'],$_POST['end']);
    // header('location:../kon');

}
?>
