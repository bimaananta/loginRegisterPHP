<?php
$conn = mysqli_connect('localhost', 'root', '', 'data_siswa');  // mysqli_connect berfungsi untuk menyambungkan ke database, ada 4 parameter dalam fungsi mysqli_connect yaitu host yaitu localhost, username database, password, dan nama database

if (isset($_POST["register"])) { // mengecek apakah variabel superglobals post sudah terbuat dengan menggunakan fungsi isset (apakah user sudah menekan button dengan name register)
    $username = $_POST["username"]; // mengambil isi dari kolom input dengan nama username dan memasukkannya dalam variabel
    $email = $_POST["email"]; // mengambil isi dari kolom input dengan nama email dan memasukkannya dalam variabel
    $password = $_POST["password"]; // mengambil isi dari kolom input dengan nama password dan memasukkannya dalam variabel

    $find_username = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"); // menggunakan mysqli_query untuk melakukan query database, bertujuan untuk mencari apakah username yang di input user terdapat dalam tabel users atau tidak, jika tidak maka user bisa melakukan registrasi dengan input username yang diberikan

    if(mysqli_num_rows($find_username)){ // mysqli_num_rows berfungsi untuk menghitung jumlah baris yang didapatkan setelah melakukan query database, jika bernilai lebih dari satu maka query menghasilkan satu baris, artinya username ditemukan, namun jika 0, username tidak ditemukan dan fungsi menghasilkan nilai false.
        $error = true; // jika ada username di database yang sama seperti yang diinput oleh user, maka register akan gagal, karena tidak boleh ada user dengan nama yang sama
    }
    else{ // jika tidak ada username yang sama maka validasi berhasil, dan sekarang masuk pada tahap akhir yaitu memasukkan data user ke dalam database
        $query = "INSERT INTO users VALUES('','$username','$email','$password')"; // menulis query untuk memasukkan username, email, dan password ke dalam tabel users menggunakan sintaks mysql yaitu INSERT
        $result = mysqli_query($conn, $query); // melakukan query dengan menggunakan sintaks dari variabel query, berhasil atau tidak nya query akan ditampung dalam variabel result

        if ($result) { // kondisi jika varibel result menghasilkan nilai true maka halaman akan mengarah ke halaman home.php
            header('Location: index.php'); // header berfungsi mengarahkan halaman
            exit; // berfungsi menghentikan program di halaman ini
        } else { // jika $result bernilai false maka error akan true, dan registrasi tidak berhasil
            $error = true;
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Register</title>
</head>

<body>
    <div class="container h-100 py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row mt-5 mb-3">
                    <div class="col-md-12">
                        <h1>Register Form</h1>
                    </div>
                </div>
                <div class="row w-100">
                    <div class="col-md-12">
                        <form action="" method="post">
                            <div class="mb-2">
                                <label for="username" class="mb-1">Username</label>
                                <input type="text" name="username" id="username" placeholder="Enter Username" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="email" class="mb-1">Email</label>
                                <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="mb-1">Password</label>
                                <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control">
                            </div>
                            <div class="action d-flex flex-row gap-2">
                                <button type="reset" class="btn btn-danger btn-md">Reset</button>
                                <button type="submit" name="register" class="btn btn-success btn-md ml-4">Daftar</button>
                            </div>
                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    Username dan email tidak valid !
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>