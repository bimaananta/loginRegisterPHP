<?php
$conn = mysqli_connect('localhost', 'root', '', 'data_siswa'); // mysqli_connect berfungsi untuk menyambungkan ke database, ada 4 parameter dalam fungsi mysqli_connect yaitu host yaitu localhost, username database, password, dan nama database
$error = false;

function validate_login($data) // membuat fungsi untuk mengimplementasikan logika validasi pada username dan password
{
    global $conn, $error; // global akan membuat variabel conn dan error menjadi variabel global dan bisa digunakan dalam berbagai scope termasuk di dalam fungsi
    $username = $data["username"]; // mengambil isi dari kolom input dengan nama username dan memasukkannya dalam variabel
    $password = $data["password"]; // mengambil isi dari kolom input dengan nama password dan memasukkannya dalam variabel

    $username_validate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"); // menggunakan mysqli_query untuk melakukan query database, bertujuan untuk mencari apakah username yang di input user terdapat dalam tabel users atau tidak

    if(!mysqli_num_rows($username_validate)){ // mysqli_num_rows berfungsi untuk menghitung jumlah baris yang didapatkan setelah melakukan query database, jika bernilai lebih dari satu maka query menghasilkan satu baris, artinya username ditemukan, namun jika 0, username tidak ditemukan dan fungsi menghasilkan nilai false, kita menggunakan kondisi false untuk mengecek gagalnya validasi untuk menyelesaikan fungsi sesegera mungkin 
        $error = true;
        return; // untuk menghentikan fungsi dan mengembalikan nilai (jika ada nilai)
    }

    $password_find = mysqli_query($conn, "SELECT password FROM users WHERE username = '$username'");  // menggunakan mysqli_query untuk melakukan pencarian password pada username yang sudah ada, yang nantinya akan dibandingkan dengan input dari user  
    $password_query_result = mysqli_fetch_assoc($password_find); // fungsi mysqli_query menghasilkan sebua objek, untuk mengambil password yang sudah dicari, kita harus memetakan objek tadi menjadi array asosiatif dengan fungsi mysqli_fetch_assoc, kemudian hasilnya ditampung dalam variabel password_query_result
    $correct_password = $password_query_result["password"]; // mengambil nilai password dari array asosiatif pada variabel $password_query_result

    if ($password != $correct_password) { // melakukan pengecekan apakah password yang diinput oleh user sama dengan password yang ada dalam database, jika tidak, validasi gagal dan fungsi akan dihentikan
        $error = true;
        return;
    } 

    // jika sudah sampai disini, validasi login sudah berhasil, baik username dan password sudah benar
    $error = false;
    header('Location: home.php'); // header berfungsi untuk mengarahkan program ke halaman lain
    exit; // exit untuk menghentikan program di halaman ini
}

if (isset($_POST["login"])) { // mengecek apakah variabel superglobals post sudah terbuat dengan menggunakan fungsi isset (apakah user sudah menekan button dengan name login)
    validate_login($_POST); // menggunakan fungsi validate_login dengan variabel superglobals $_POST sebagai parameter
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Login</title>
</head>

<body>
    <div class="container py-5">
        <div class="row mt-5 w-100 d-flex justify-content-center">
            <div class="col-md-4 border px-4 py-5 rounded-3">
                <h1 class="text-center">Log In</h1>
                <form action="" method="post">
                    <div class="d-flex flex-column mb-3">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="d-flex flex-column mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <a href="register.php" class="d-block text-center mb-3 text-decoration-none">Create Account</a>
                    <button type="submit" name="login" class="btn btn-primary form-control">Masuk</button>
                </form>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Username dan email tidak valid !
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>