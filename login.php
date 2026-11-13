<?php
require_once __DIR__.'/includes/bootstrap.php';
if(logged())go('index.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){checkCsrf();$u=trim($_POST['username']??'');$p=$_POST['password']??'';
$s=$conn->prepare('SELECT ID,USERNAME,PASSWORD,USERTYPE,IMAGE_PATH FROM tbl_account WHERE USERNAME=? LIMIT 1');$s->bind_param('s',$u);$s->execute();$a=$s->get_result()->fetch_assoc();$s->close();
if($a&&password_verify($p,$a['PASSWORD'])){session_regenerate_id(true);$_SESSION['USER_ID']=$a['ID'];$_SESSION['USERNAME']=$a['USERNAME'];$_SESSION['USERTYPE']=strtolower($a['USERTYPE']);$_SESSION['IMAGE_PATH']=$a['IMAGE_PATH']??'';go('index.php');}$error='Incorrect username or password.';}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Sign in · CampusFlow</title><link rel="stylesheet" href="assets/style.css"></head><body class="login"><div class="loginbox"><div class="logo"><b>C</b> Campus<span>Flow</span></div><small class="kicker">ACADEMIC WORKSPACE</small><h1>Welcome back.</h1><p>Sign in to your campus dashboard.</p><?php if($error):?><div class="error"><?=e($error)?></div><?php endif;?><form method="post"><?=csrfInput()?><label>Username</label><input name="username" required autocomplete="username"><label>Password</label><input name="password" type="password" required autocomplete="current-password"><button>Sign in <span>→</span></button></form><small class="secure">● Secure access for authorized users</small></div></body></html>
