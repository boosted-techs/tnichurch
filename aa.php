<?php
session_start();
print_r($_SESSION);
if (!is_writable(session_save_path())) {
    echo 'Session path "'.session_save_path().'" is not writable for PHP!';
}
echo session_save_path();