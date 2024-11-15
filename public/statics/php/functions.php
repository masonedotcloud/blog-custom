<?php
/*
    functions.php
    varie funzioni del sito
*/

define ("NAME_FOLDER", "/alessandromasone.altervista.org");

require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/functions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/init.php');
//ritorno dei millisecondi attuali
function milliseconds()
{
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}
//se il file esiste
function FileExists($file)
{
    $file_headers = @get_headers($file);
    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        return false;
    } else {
        return true;
    }
}
//ritorna il nome del file o lo stampa
function InternetFIle($url, $result)
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        $redirect = "https://" . $_SERVER['SERVER_NAME'] . NAME_FOLDER . "/" . $url;
    } else {
        $redirect = "http://" . $_SERVER['SERVER_NAME'] . NAME_FOLDER . "/" . $url;
    }
    if ($result) {
        return $redirect;
    } else {
        echo $redirect;
    }
}
//controllo permessi dell'account
class ClassAccountPermission
{
    public const ADMIN = 0;
    public const USER = 1;
    public const AUTHOR = 2;
    public const NOT_VERIFIED = 0;
    public const ACTIVE = 1;
    public const DISABLE = 2;
    private function Redirect($url, $permanent = false)
    {
        if (headers_sent() === false) {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }
        exit();
    }
    private function ToPage($url)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $redirect = "https://" . $_SERVER['SERVER_NAME'] . NAME_FOLDER . "/" . $url;
        } else {
            $redirect = "http://" . $_SERVER['SERVER_NAME'] . NAME_FOLDER . "/" . $url;
        }
        $this->Redirect($redirect, true);
    }
    private function CheckLoginStatus()
    {
        include($_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . '/public/statics/php/database.php');
        $sql = "SELECT * FROM site WHERE 1";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $fetch = mysqli_fetch_array($result);
            if ($fetch['login'] == 0) {
                if (isset($_SESSION['id'])) {
                    if ($_SESSION['type'] != 0) {
                        $this->ToPage("logout");
                    }
                }
            }
        }
    }
    private function StatusAccount()
    {
        if (isset($_SESSION['status']) && $_SESSION['status'] == self::NOT_VERIFIED) {
            $this->ToPage("code");
        } else if (isset($_SESSION['status']) && $_SESSION['status'] == self::DISABLE) {
            $this->ToPage("disable?redirect=" . $this->Actual_Link());
        }
    }
    private function Actual_Link()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
    public function Open()
    {
        $this->CheckLoginStatus();
        $this->StatusAccount();
    }
    public function Guest()
    {
        $this->CheckLoginStatus();
        $this->StatusAccount();
        if (isset($_SESSION['id'])) {
            $this->ToPage("index");
        }
    }
    public function Admin()
    {
        $this->CheckLoginStatus();
        $this->StatusAccount();
        if (isset($_SESSION['id'])) {
            if (isset($_SESSION['type']) && $_SESSION['type'] == self::USER) {
                $this->ToPage("adminonly");
            } else if (isset($_SESSION['type']) && $_SESSION['type'] == self::AUTHOR) {
                $this->ToPage("adminonly");
            }
        } else {
            $this->ToPage("login?redirect=" . $this->Actual_Link());
        }
    }
    public function User()
    {
        $this->CheckLoginStatus();
        $this->StatusAccount();
        if (!isset($_SESSION['id'])) {
            $this->ToPage("login?redirect=" . $this->Actual_Link());
        }
    }
    public function Author()
    {
        $this->CheckLoginStatus();
        $this->StatusAccount();
        if (isset($_SESSION['id'])) {
            if (isset($_SESSION['type']) && $_SESSION['type'] == self::USER) {
                $this->ToPage("login?redirect=" . $this->Actual_Link());
            }
        } else {
            $this->ToPage("login?redirect=" . $this->Actual_Link());
        }
    }
    public function Code()
    {
        $this->CheckLoginStatus();
        if (isset($_SESSION['id'])) {
            if (isset($_SESSION['status']) && $_SESSION['status'] != 0) {
                $this->ToPage("index");
            }
        } else {
            $this->ToPage("index");
        }
    }
    public function Disable()
    {
        $this->CheckLoginStatus();
        if (isset($_SESSION['id'])) {
            if (isset($_SESSION['status']) && $_SESSION['status'] != 2) {
                $this->ToPage("index");
            }
        } else {
            $this->ToPage("index");
        }
    }
}
//chiamata di un alert
class ClassAlert
{
    public function Error($message)
    {
        echo "?message=" . $message . "&type=danger";
        exit();
    }
    public function Success($message)
    {
        echo "?message=" . $message . "&type=success";
        exit();
    }
    public function Warning($message)
    {
        echo "?message=" . $message . "&type=warning";
        exit();
    }
    public function Info($message)
    {
        echo "?message=" . $message . "&type=primary";
        exit();
    }
    public function Custom($message)
    {
        echo $message;
        exit();
    }
}
//classe per i cookie
class ClassCookie
{
    public function Imposta($force = false)
    {
        if ($force) {
            $remember = true;
        } else {
            if (isset($_COOKIE['remember']) && $_COOKIE['remember'] == 'active') {
                $remember = true;
            } else {
                $remember = false;
            }
        }
        if ($remember) {
            if (isset($_SESSION['id'])) {
                setcookie(
                    "id",
                    $_SESSION['id'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['username'])) {
                setcookie(
                    "username",
                    $_SESSION['username'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['name'])) {
                setcookie(
                    "name",
                    $_SESSION['name'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['surname'])) {
                setcookie(
                    "surname",
                    $_SESSION['surname'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['email'])) {
                setcookie(
                    "email",
                    $_SESSION['email'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['password'])) {
                setcookie(
                    "password",
                    $_SESSION['password'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['code'])) {
                setcookie(
                    "code",
                    $_SESSION['code'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['status'])) {
                setcookie(
                    "status",
                    $_SESSION['status'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['type'])) {
                setcookie(
                    "type",
                    $_SESSION['type'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['avatar'])) {
                setcookie(
                    "avatar",
                    $_SESSION['avatar'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['reset_password_otp'])) {
                setcookie(
                    "reset_password_otp",
                    $_SESSION['reset_password_otp'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
            if (isset($_SESSION['create_at'])) {
                setcookie(
                    "create_at",
                    $_SESSION['create_at'],
                    time() + (10 * 365 * 24 * 60 * 60),
                    '/'
                );
            }
        }
    }
    public function Remove()
    {
        $past = time() - 3600;
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, $value, $past, '/');
        }
    }
    public function Load()
    {
        if (isset($_COOKIE['id'])) {
            $_SESSION['id'] = $_COOKIE['id'];
        }
        if (isset($_COOKIE['username'])) {
            $_SESSION['username'] = $_COOKIE['username'];
        }
        if (isset($_COOKIE['name'])) {
            $_SESSION['name'] = $_COOKIE['name'];
        }
        if (isset($_COOKIE['surname'])) {
            $_SESSION['surname'] = $_COOKIE['surname'];
        }
        if (isset($_COOKIE['email'])) {
            $_SESSION['email'] = $_COOKIE['email'];
        }
        if (isset($_COOKIE['password'])) {
            $_SESSION['password'] = $_COOKIE['password'];
        }
        if (isset($_COOKIE['code'])) {
            $_SESSION['code'] = $_COOKIE['code'];
        }
        if (isset($_COOKIE['status'])) {
            $_SESSION['status'] = $_COOKIE['status'];
        }
        if (isset($_COOKIE['type'])) {
            $_SESSION['type'] = $_COOKIE['type'];
        }
        if (isset($_COOKIE['avatar'])) {
            $_SESSION['avatar'] = $_COOKIE['avatar'];
        }
        if (isset($_COOKIE['reset_password_otp'])) {
            $_SESSION['reset_password_otp'] = $_COOKIE['reset_password_otp'];
        }
        if (isset($_COOKIE['create_at'])) {
            $_SESSION['create_at'] = $_COOKIE['create_at'];
        }
    }
}
//creazione delle chiamate per la classi
$Cake = new ClassCookie;
$Alert = new ClassAlert;
$Account = new ClassAccountPermission;
//differenze fra date
function Difference_Date($date1, $date2)
{
    $diff = abs(strtotime($date2) - strtotime($date1));
    $years = floor($diff / (365 * 60 * 60 * 24));
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    $hours   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
    $minuts  = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minuts * 60));
    return array(
        'years' => $years,
        'months' => $months,
        'hours' => $hours,
        'minuts' => $minuts,
        'seconds' => $seconds
    );
}

function Send_Custom_Email($text)
{
    return true;
}

//invio del codice per email
function Send_Code($email, $code)
{
    //codice invio email
    $to = $email;
    $subject = "Codice di verifica";
    $txt = "Ecco il tuo codice di verifica: " . $code;
    $headers = "Da: masonealessandro.altervista.org";

    $result = mail($to, $subject, $txt, $headers);
    return $result;
}

//ritorno indirizzo ip cliente
function Get_client_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function check_email($email)
{
    $find1 = strpos($email, '@');
    $find2 = strpos($email, '.');
    return ($find1 !== false && $find2 !== false && $find2 > $find1);
}

//controllo degli accessi al sito
function Access()
{
    include('database.php');
    $ip = Get_client_ip();
    $temp_date = date("Y-n-j");
    $sql_ip = "SELECT * FROM stats WHERE value = " . "\"$ip\"" . "AND type = 'access' AND date = " . "\"$temp_date\"" . "ORDER BY ID DESC";
    $result_ip = mysqli_query($conn, $sql_ip);
    if ($result_ip) {
        if (mysqli_num_rows($result_ip) == 0) {
            $date = date("Y-m-d");
            $sql_ip = "INSERT INTO stats(value, date, type) VALUES (" . "\"$ip\"" . ", " . "\"$date\"" . ", 'access')";
            $result_ip = mysqli_query($conn, $sql_ip);
        } else if (mysqli_num_rows($result_ip) > 0) {
            $fetch_ip = mysqli_fetch_assoc($result_ip);
            if ($fetch_ip['date'] != date("Y-m-d")) {
                $date = date("Y-m-d");
                $sql_ip = "INSERT INTO stats(value, date, type) VALUES (" . "\"$ip\"" . ", " . "\"$date\"" . ", 'access')";
                $result_ip = mysqli_query($conn, $sql_ip);
            }
        }
    }
}

function CategoryView($id_category)
{
    include('database.php');
    $ip = Get_client_ip();
    $temp_date = date("Y-n-j");
    $sql_ip = "SELECT * FROM stats WHERE value = " . "\"$ip\"" . "AND type = 'category' AND date = " . "\"$temp_date\" AND note = " . $id_category . " ORDER BY ID DESC";
    $result_ip = mysqli_query($conn, $sql_ip);
    if ($result_ip) {
        if (mysqli_num_rows($result_ip) == 0) {
            $date = date("Y-m-d");
            $sql_ip = "INSERT INTO stats(value, date, type, note) VALUES (" . "\"$ip\"" . ", " . "\"$date\"" . ", 'category', '$id_category')";
            $result_ip = mysqli_query($conn, $sql_ip);
        } else if (mysqli_num_rows($result_ip) > 0) {
            $fetch_ip = mysqli_fetch_assoc($result_ip);
            if ($fetch_ip['date'] != date("Y-m-d")) {
                $date = date("Y-m-d");
                $sql_ip = "INSERT INTO stats(value, date, type, note) VALUES (" . "\"$ip\"" . ", " . "\"$date\"" . ", 'category', '$id_category')";
                $result_ip = mysqli_query($conn, $sql_ip);
            }
        }
    }
}

function PostView($id_post)
{
    include('database.php');
    $ip = Get_client_ip();
    $temp_date = date("Y-n-j");
    $sql_ip = "SELECT * FROM stats WHERE value = " . "\"$ip\"" . "AND type = 'post' AND date = " . "\"$temp_date\" AND note = " . $id_post . " ORDER BY ID DESC";
    $result_ip = mysqli_query($conn, $sql_ip);
    if ($result_ip) {
        if (mysqli_num_rows($result_ip) == 0) {
            $date = date("Y-m-d");
            $sql_ip = "INSERT INTO stats(value, date, type, note) VALUES (" . "\"$ip\"" . ", " . "\"$date\"" . ", 'post', '$id_post')";
            $result_ip = mysqli_query($conn, $sql_ip);
        } else if (mysqli_num_rows($result_ip) > 0) {
            $fetch_ip = mysqli_fetch_assoc($result_ip);
            if ($fetch_ip['date'] != date("Y-m-d")) {
                $date = date("Y-m-d");
                $sql_ip = "INSERT INTO stats(value, date, type, note) VALUES (" . "\"$ip\"" . ", " . "\"$date\"" . ", 'post', '$id_post')";
                $result_ip = mysqli_query($conn, $sql_ip);
            }
        }
    }
}

//funzione statistiche iscritto
function SubscriberAdd()
{
    include('database.php');
    $date = date("Y-m-d");
    $sql = "INSERT INTO stats (value, date, type) VALUES (" . "\"1\"" . ", " . "\"$date\"" . ", 'subscriber')";
    mysqli_query($conn, $sql);
}
//funzione statistiche newsletter
function NewsletterAdd()
{
    include('database.php');
    $date = date("Y-m-d");
    $sql = "INSERT INTO stats (value, date, type) VALUES (" . "\"1\"" . ", " . "\"$date\"" . ", 'newsletter')";
    mysqli_query($conn, $sql);
}
//eliminazione di un acartella con relativo contenuto
function deleteAll($dir)
{
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            deleteAll($file);
        else
            unlink($file);
    }
    rmdir($dir);
}
//contorllo stato del login
function LoginStatusSite($type)
{
    include('database.php');
    if ($type != 0) {
        $sql_login = "SELECT * FROM site WHERE 1";
        $result_login = mysqli_query($conn, $sql_login);
        if ($result_login) {
            $fetch_login = mysqli_fetch_array($result_login);
            if ($fetch_login['login'] != 1) {
                return false;
            }
        }
    }
    return true;
}
//contorllo stato dei post
function PoststatusSite()
{
    include('database.php');
    $sql_login = "SELECT * FROM site WHERE 1";
    $result_login = mysqli_query($conn, $sql_login);
    if ($result_login) {
        $fetch_login = mysqli_fetch_array($result_login);
        if ($fetch_login['posts'] != 1) {
            return false;
        }
    }
    return true;
}
//contorllo stato delle registrazioni
function RegisterStatusSite()
{
    include('database.php');
    $sql_login = "SELECT * FROM site WHERE 1";
    $result_login = mysqli_query($conn, $sql_login);
    if ($result_login) {
        $fetch_login = mysqli_fetch_array($result_login);
        if ($fetch_login['register'] != 1) {
            return false;
        }
    }
    return true;
}
//generazione codice per la verifica
function code_for_verify()
{
    return rand(999999, 111111);
}
//se il codice otp pdella password esiste
function opt_password_exists($code)
{
    include('database.php');
    $sql = "SELECT * FROM users WHERE reset_password_otp = '$code'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_array($result);
            if ($fetch['reset_password_otp'] == $code) {
                return true;
            }
        }
    }
    return false;
}
//limita il testo
function limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
function get_article($id)
{
    include('database.php');
    $sql = '
        SELECT
            e.*,
            m.username AS author_username,
            c.name AS category_name,
            c.id AS category_id,
            s.status AS category_status,
            u.status AS author_status,
            u.type AS author_type
        FROM
            posts e
        LEFT JOIN users m ON
            e.author = m.id
        LEFT JOIN category c ON
            e.category = c.id
        LEFT JOIN category s ON
            e.category = s.id
        LEFT JOIN users u ON
            e.author = u.id
        WHERE
            e.status <> "0" AND s.status <> "0" AND u.status <> "2" AND u.status <> "0" AND u.type <> "1" AND e.id = ' . $id;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $fetch = mysqli_fetch_assoc($result);
            return $fetch;
        } else {
            return true;
        }
    } else {
        return false;
    }
    return false;
}
//ritorna un nome casuale
if (isset($_GET['random_name'])) {
    $file = InternetFIle("public/statics/txt/usernames.txt", true);
    if (FileExists($file)) {
        $file_arr = file($file);
        $num_lines = count($file_arr);
        $last_arr_index = $num_lines - 1;
        $rand_index = rand(0, $last_arr_index);
        $rand_text = $file_arr[$rand_index];
        $Alert->Custom($rand_text);
    } else {
        $Alert->Error("Errore nella generazione");
    }
}
//controlla l'invio del codice
if (isset($_GET['send_code'])) {
    //controllo se è stata fatta una richiesta globale nell'ultimo minuto
    if (isset($_SESSION['last_send_code'])) {
        $date = Difference_Date(date("Y-m-d H:i:s"), $_SESSION['last_send_code']);
        if ($date['minuts'] < 1) {
            $Alert->Warning('Devi attendere ' . (60 - intval($date['seconds'])) . ' secondi prima di richiedere un nuovo codice');
        }
    }
    $_SESSION['last_send_code'] = date("Y-m-d H:i:s");
    //Invio del codice per email
    $_SESSION['code'] = code_for_verify();
    if (isset($_SESSION['id'])) {
        $sql = "UPDATE users SET code = ".$_SESSION['code']." WHERE id = ".$_SESSION['id'];
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $Alert->Error("Errore nell'invio");
        }
    }
    $result = Send_Code($_SESSION['email'], $_SESSION['code']);
    if ($result) {
        $Alert->Success("Codice inviato");
    } else {
        $Alert->Error("Errore nell'invio");
    }
}
//controlla il debug
if (isset($_GET['debug_js'])) {
    if (isset($_SESSION['debug']) && $_SESSION['debug'] == 'true') {
        $Alert->Custom('true');
    }
    $Alert->Custom('false');
}