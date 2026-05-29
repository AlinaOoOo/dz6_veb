<?php
session_start();

if (empty($_SESSION['uLogin'])) {
    header('Location: autorization.php');
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=u82467', 'u82467', '5630801');

$stmt = $db->prepare("SELECT role FROM users WHERE userLogin = ?");
$stmt->execute([$_SESSION['uLogin']]);
$row = $stmt->fetch();

if (!$row || $row['role'] != 'admin') {
    header('Location: redakt.php');
    exit();
}

$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

if ($user_id == 0) {
    header('Location: admin_edit_form.php');
    exit();
}

try {
    $db->beginTransaction();
    
    $sql = "UPDATE users SET 
                userLogin = :userLogin,
                fio = :fio,
                phone = :phone,
                email = :email,
                brithDate = :brithDate,
                gender = :gender,
                role = :role,
                bio = :bio,
                contract = :contract
            WHERE id = :id";
    
    $params = [
        ':userLogin' => $_POST['userLogin'],
        ':fio' => $_POST['fio'],
        ':phone' => $_POST['phone'],
        ':email' => $_POST['email'],
        ':brithDate' => $_POST['brithDate'],
        ':gender' => $_POST['gender'],
        ':role' => $_POST['role'],
        ':bio' => $_POST['bio'] ?? '',
        ':contract' => isset($_POST['contract']) ? 1 : 0,
        ':id' => $user_id
    ];
    
    if (!empty($_POST['userPass'])) {
        $sql = str_replace("WHERE id = :id", ", userPass = :userPass WHERE id = :id", $sql);
        $params[':userPass'] = password_hash($_POST['userPass'], PASSWORD_DEFAULT);
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    
    // Обновляем языки
    $stmt = $db->prepare("DELETE FROM user_languages WHERE user_id = ?");
    $stmt->execute([$user_id]);
    
    $stmt = $db->prepare("INSERT INTO user_languages (user_id, lang_id) VALUES (?, ?)");
    foreach ($_POST['lang_id'] as $lang_id) {
        $stmt->execute([$user_id, $lang_id]);
    }
    
    $db->commit();
    
} catch (PDOException $e) {
    $db->rollBack();
    header("Location: admin_edit_form.php?error=" . urlencode($e->getMessage()));
    exit();
}

header('Location: redakt.php?save=1');
exit();
?>