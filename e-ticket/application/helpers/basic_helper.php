<?php 
function viewurl($s){

	$c = array (' ');

	$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','<','>','�','�','�','�','�','�');

	

	$s = rtrim(str_replace($d, ' ', $s)); // Hilangkan karakter yang telah disebutkan di array $d

	$s = trim($s);

	$s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi 

	return $s;

}
function resultsearch($s){

	$s = trim($s);

	$s = str_replace('-', ' ', $s); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua

	return $s;

}
function pagelink($pages='',$title='',$id=''){

	$link = base_url();

	$link.= (!empty($pages))?$pages:'';

	$link.= (!empty($title))?seo($title):'';

	$link.= (!empty($id))?'-'.$id:'';

	return $link;

}

function random($n) { 
    $characters = '0123456789'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
}

function token($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!_-'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agt',
		'Sep',
		'Okt',
		'Nov',
		'Des'
	);
	$pecahkan = explode('-', $tanggal);

	return substr($pecahkan[2], 0, 2) . ' ' . $bulan[(int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

 ?>