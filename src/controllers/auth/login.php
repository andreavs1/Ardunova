<php

require_once__DIR__. '/../../config/bootstrap.php';

if($_SERVER['REQUEST_METHOD'] !=='POST'){
    header ('Localtion: /src/views/auth/login.php');
    exit;
}

$email = trim($_POST['email']??");
$password = $_POST['password']??";"

if($email === " || $password ==="){
    exit ('El email t la contraseña son obligatorios.');
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    exit ('El email no es valido.');
}

try{

    //buscar usuario por gmail 

    $stmt=$pdo->prepare(
        'SELECT id,name,email,password
        FROM users
        WHERE email =:$email
        LIMIT 1'
    );

    $stmt->execute([
    'email'=>$email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //verficar usuario y contraseña
    if(!user || !password_verify($password, $user['password'])){
        exit('Email o contraseña incorrectos');
    }

    //crear sesion 
    session_regenerate_id(true);

    $_SESSION['user']=[
    'id'=>$user['id'],
    'name'=>$user['name'],
    'email'=>$user['email']
    ];

    //ir al inicio
    header('Location:/src/views/index.php');
    exit;
} catch(PDOException $e){
    exit('Ocurrio un error al iniciar sesion');
}
?>