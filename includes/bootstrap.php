<?php
if(session_status()!==PHP_SESSION_ACTIVE) session_start();
require_once __DIR__.'/database.php';
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function go($p){header('Location: '.$p);exit;}
function logged(){return !empty($_SESSION['USER_ID'])&&!empty($_SESSION['USERNAME']);}
function role(){ $r=strtolower($_SESSION['USERTYPE']??''); return ['administrator'=>'admin','teacher'=>'instructor','professor'=>'instructor'][$r]??$r; }
function csrf(){if(empty($_SESSION['_csrf']))$_SESSION['_csrf']=bin2hex(random_bytes(32));return $_SESSION['_csrf'];}
function csrfInput(){return '<input type="hidden" name="_csrf" value="'.e(csrf()).'">';}
function checkCsrf(){if(!hash_equals($_SESSION['_csrf']??'',$_POST['_csrf']??'')){http_response_code(419);exit('Session expired. Refresh and retry.');}}
function cols($t){$ok=['tbl_course','tbl_instructors','tbl_schoolyear','tbl_term','tbl_section','tbl_yearlevel','tbl_students','tbl_account'];if(!in_array($t,$ok,true))return [];return $GLOBALS['conn']->query("SHOW COLUMNS FROM `$t`")->fetch_all(MYSQLI_ASSOC);}
function countRows($t){$ok=['tbl_course','tbl_instructors','tbl_schoolyear','tbl_term','tbl_section','tbl_yearlevel','tbl_students','tbl_account'];if(!in_array($t,$ok,true))return 0;return (int)$GLOBALS['conn']->query("SELECT COUNT(*) n FROM `$t`")->fetch_assoc()['n'];}
