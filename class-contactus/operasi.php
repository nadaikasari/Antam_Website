<?php 
include('contact.php');
$obj = new contact();

session_start();
$action = $_GET['action'];
if($action == "add") {

    $obj->insertData('', $_POST['nama'],$_POST['email'], $_POST['tlpn'], $_POST['pesan'], '0');
    echo '<script language="javascript">alert("Pesan Anda Telah Terkirim dan akan segera di proses."); document.location="../konsumen/index.php?page=beranda";</script>';

}

elseif($action=="update")
{
	if($_SESSION['jabatan']=="Admin"){
	$obj->update($_POST['id']);
    header('location:../karyawan/index.php?page=dashboard');
	}
	else{
		echo '<script language="javascript">alert("Akses hanya untuk Admin"); document.location="../karyawan/index.php?page=dashboard";</script>';
	}
}

elseif($action=="getid")
{
	$id = $_GET['id'];
	// echo $id;
	$obj->GetId($id);
    // header('location:../karyawan/index.php?page=ada');
    
}


?>

<script type="text/javascript">
		$(document).ready(function(){
		    $("#iconText").click(function(){
		    	Swal.fire(
				  'BERHASIL',
				  'Data Berhasil Disimpan',
				  'success'
				)
		    });

		});
	</script>