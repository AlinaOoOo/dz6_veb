<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <h1>Регистрация</h1>
    
    <?php
    // Получаем ошибки из cookies
    $errors = [];
    if (isset($_COOKIE['errors_array'])) {
        $errors = json_decode($_COOKIE['errors_array'], true);
    }
    ?>
    
    <?php if (!empty($errors)): ?>
        <div class="error">
           Пожалуйста, исправьте ошибки ниже:
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <!-- ФИО -->
        <div class="field-group">
            <label>ФИО *</label>
            <input type="text" name="fio" 
                   value="<?php echo htmlspecialchars($_COOKIE['saved_fio'] ?? ''); ?>"
                   class="<?php echo isset($errors['fio']) ? 'error-field' : ''; ?>">
            <?php if (isset($errors['fio'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['fio']); ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Телефон -->
        <div class="field-group">
            <label>Телефон *</label>
            <input type="tel" name="phone" 
                   value="<?php echo htmlspecialchars($_COOKIE['saved_phone'] ?? ''); ?>"
                   class="<?php echo isset($errors['phone']) ? 'error-field' : ''; ?>">
            <?php if (isset($errors['phone'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['phone']); ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Email -->
        <div class="field-group">
            <label>Email *</label>
            <input type="email" name="email" 
                   value="<?php echo htmlspecialchars($_COOKIE['saved_email'] ?? ''); ?>"
                   class="<?php echo isset($errors['email']) ? 'error-field' : ''; ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['email']); ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Дата рождения -->
        <div class="field-group">
            <label>Дата рождения *</label>
            <input type="date" name="brithDate" 
                   value="<?php echo htmlspecialchars($_COOKIE['saved_brithDate'] ?? ''); ?>"
                   class="<?php echo isset($errors['brithDate']) ? 'error-field' : ''; ?>">
            <?php if (isset($errors['brithDate'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['brithDate']); ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Пол -->
        <div class="field-group">
            <label>Пол *</label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="male" <?php echo (($_COOKIE['saved_gender'] ?? '') == 'male') ? 'checked' : ''; ?>> Мужской</label>
                <label><input type="radio" name="gender" value="female" <?php echo (($_COOKIE['saved_gender'] ?? '') == 'female') ? 'checked' : ''; ?>> Женский</label>
            </div>
            <?php if (isset($errors['gender'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['gender']); ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Языки программирования -->
        <div class="field-group">
            <label>Языки программирования *</label>
            <select name="lang_id[]" multiple 
                    class="<?php echo isset($errors['lang_id']) ? 'error-field' : ''; ?>">
                <?php
                $saved_lang = [];
                if (isset($_COOKIE['saved_lang_id'])) {
                    $saved_lang = json_decode($_COOKIE['saved_lang_id'], true);
                }
                $langs = [
                    1 => 'Pascal', 2 => 'C', 3 => 'C++', 4 => 'JavaScript',
                    5 => 'PHP', 6 => 'Python', 7 => 'Java', 8 => 'Haskel',
                    9 => 'Clojure', 10 => 'Prolog', 11 => 'Scala', 12 => 'Go'
                ];
                foreach ($langs as $id => $name):
                    $selected = (is_array($saved_lang) && in_array((string)$id, $saved_lang)) ? 'selected' : '';
                ?>
                    <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
            <small>Зажмите Ctrl (Cmd) для выбора нескольких языков</small>
            <?php if (isset($errors['lang_id'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['lang_id']); ?></div>
            <?php endif; ?>
        </div>
        
        <!-- Биография -->
        <div class="field-group">
            <label>Биография</label>
            <textarea name="bio"><?php echo htmlspecialchars($_COOKIE['saved_bio'] ?? ''); ?></textarea>
        </div>
        
        <!-- Согласие -->
        <div class="field-group">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="contract" value="1" 
                       <?php echo (isset($_COOKIE['saved_contract']) && $_COOKIE['saved_contract'] == '1') ? 'checked' : ''; ?>>
                <span>Я согласен с условиями обработки персональных данных *</span>
            </label>
            <?php if (isset($errors['contract'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['contract']); ?></div>
            <?php endif; ?>
        </div>
        
        <button type="submit">Зарегистрироваться</button>
    </form>
    
    <div class="links">
        <a href="autorization.php">Уже есть аккаунт? Войти</a>
    </div>
</div>

</body>
</html>