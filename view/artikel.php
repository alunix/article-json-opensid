<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../object/artikel.php';

// instantiate database and articles object
$database = new Database();
$db = $database->getConnection();
// initialize object
$artikel = new Artikel($db);

// query articles
$stmt = $artikel->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){

    // articles array
    $artikel_arr=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $bulan = array('01' => 'Januari','02' => 'Pebruari','03' => 'Maret','04' => 'April','05' => 'Mei','06' => 'Jnui','07' => 'Juli','08' => 'Agustus','09' => 'September','10' => 'Oktober','11' => 'Nopember','12' => 'Desember');
        $explodes = explode(" ",$row['tgl_upload']);
        $date = $explodes[0];
        $time = $explodes[1];
        $tgl_explode = explode("-",$date);
        $datetime = $tgl_explode[2].' '.$bulan[$tgl_explode[1]].' '.$tgl_explode[0].' '.$time;

        $s = substr(strip_tags($row['isi']), 0, ARTIKEL_SUBSTR);
        $resultstr = substr($s, 0, strrpos($s, ' '));

        $artikel_item=array(
            "id" => $row['idartikel'],
            "isi" => $row['isi'],
            "isi_substr" => $resultstr.' ...',
            "gambar" => $row['gambar'],
            "gambar_kecil" => "kecil_".$row['gambar'],
            "gambar_sedang" => "sedang_".$row['gambar'],
            "enabled" => $row['enabled'],
            "tgl_upload" => $row['tgl_upload'],
            "tgl_upload_indo" => $datetime,
            "id_kategori" => $row['id_kategori'],
            "nama_kategori" => $row['kategori'],
            "id_user" => $row['id_user'],
            "nama_user" => $row['nama'],
            "judul" => $row['judul'],
            "headline" => $row['headline'],
            "urut" => $row['urut'],
            "jenis_widget" => $row['jenis_widget'],
            "url_images" => URL_IMG_ARTIKEL
        );

        array_push($artikel_arr, $artikel_item);
    }

    echo json_encode($artikel_arr);
}
?>
