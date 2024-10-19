<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Koneksi */
$conn = mysqli_connect("127.0.0.1", "root", "root", "otodu");


if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function query($query){
    global $conn;
    
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function upload($gambar){
    
    $namaFile = $gambar["name"];
    $ukuranFile = $gambar["size"];
    $error = $gambar["error"];
    $tmp_name = $gambar["tmp_name"];
    
    if($error === 4){
        echo "
                <script>
                    alert(`Upload Gambar Terlebih Dahulu`);
               </script>
            ";
       return false;
    }
    
    $ekstensiGambarValid = ["jpg", "jpeg", "png"];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "
                <script>
                    alert(`Hanya Menerima File Gambar (jpg, jpeg, png)`);
               </script>
            ";
       return false;
    }
    
    if($ukuranFile > 2097152){
        echo "
                <script>
                    alert(`Ukuran Gambar Terlalu Besar (Maks 2 MB)`);
               </script>
            ";
       return false;
    }
    
    $namaFile = uniqid();
    $namaFile .= "." . $ekstensiGambar;
    
    move_uploaded_file($tmp_name, "img/" .$namaFile);
    
    return $namaFile;
}

function tambah($data){
    
    global $conn;
    
    /* htmlspecialchar berguna agar element/tag html dan css tidak dieksekusi langsung 
    <div style=position:absolute; top:0; bottom:0; left:0; right:0; background-color:black; font-size:100px; color:red; text-align:center;>HAHAHAHAH ANDA TERKENA RANSOMWARE</div>
    */
    
    $nama =  htmlspecialchars($data["nama"]);
    $email =  htmlspecialchars($data["email"]);
    
    /* Upload Gambar */
    $gambar = upload($_FILES["gambar"]);
    if(!$gambar){
        return false;
    }
    
    $query = "INSERT INTO murid (nama, email, gambar) 
          VALUES ('$nama', '$email', '$gambar')";
          
    return mysqli_query($conn, $query);
}

function hapus($id){
    global $conn;
    
    return mysqli_query($conn, "DELETE FROM murid WHERE id = $id
");
}

function ubah($dataLama, $id, $dataGambarLama, $dataGambarBaru){
    global $conn;
    
    $nama =  htmlspecialchars($dataLama["nama"]);
    $email =  htmlspecialchars($dataLama["email"]);
    $gambarLama =  htmlspecialchars($dataGambarLama);
    
    if($dataGambarBaru["error"] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar = upload($dataGambarBaru);
    }
    
    $query = "UPDATE murid
SET nama = '$nama', email = '$email', gambar = '$gambar' WHERE id = $id;";

    return mysqli_query($conn, $query);
}

function cari($keyword){
    global $conn;
    
    $query = "SELECT * FROM murid
                WHERE
                nama like '%$keyword%' OR
                email like '%$keyword%' OR            
    ";
    return mysqli_query($conn, $query);
}

function registrasi($data){
    global $conn;
    
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasiPassword = mysqli_real_escape_string($conn, $data["konfirmasiPassword"]);
    
    $cekNama = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    
    /* Jika True/Dapat Username Yang Sama Maka Keluar Dari Function */
    if(mysqli_fetch_assoc($cekNama)){
        echo "<script>
              alert(`Username Sudah Terdaftar`)
              </script>";
        
        return false;
    }
    
    if($password !== $konfirmasiPassword){
        echo "<script>
                alert(`Password Dan Konfirmasi Password Tidak Sesuai`);
              </script>";
        return false;
    }
    
    /* Enkripsi */
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO user (username, password) 
          VALUES ('$username', '$password')";
          
    return mysqli_query($conn, $query);
}
    
