<?php
declare(strict_types=1);
require __DIR__.'/bootstrap.php';
require_once __DIR__.'/wallet.php';
require_once __DIR__.'/interserver.php';
$user=require_login();
if($_SERVER['REQUEST_METHOD']!=='POST' || !verify_csrf($_POST['csrf']??null)){http_response_code(400);exit('Invalid request.');}
$productId=trim((string)($_POST['product_id']??''));
if(!preg_match('/^vps:(\d+)$/',$productId)){http_response_code(400);exit('Unsupported product.');}
try{
  $api=new InterServerAPI();
  $products=$api->vpsProducts((float)cfg('interserver.markup',1.00));
  $product=null;foreach($products as $p)if($p['id']===$productId){$product=$p;break;}
  if(!$product)throw new RuntimeException('Product is no longer available.');
  $amount=(float)$product['cost'];$pdo=db();$pdo->beginTransaction();
  wallet_ensure((int)$user['id']);
  $lock=$pdo->prepare('SELECT balance FROM wallet_accounts WHERE user_id=? FOR UPDATE');$lock->execute([(int)$user['id']]);
  if((float)$lock->fetchColumn()+0.00001<$amount)throw new RuntimeException('Insufficient wallet balance.');
  $pdo->prepare('UPDATE wallet_accounts SET balance=balance-? WHERE user_id=?')->execute([$amount,(int)$user['id']]);
  $orderTitle=$product['name'].' VPS';
  $pdo->prepare('INSERT INTO oxb_orders(user_id,category,product_id,title,amount,status) VALUES(?,?,?,?,?,?)')->execute([(int)$user['id'],'vps',$productId,$orderTitle,$amount,'pending']);
  $orderId=(int)$pdo->lastInsertId();$reference='oxb-order-'.$orderId.'-'.bin2hex(random_bytes(5));
  $pdo->prepare('INSERT INTO wallet_transactions(user_id,type,amount,description,reference) VALUES(?,?,?,?,?)')->execute([(int)$user['id'],'debit',-$amount,'VPS order #'.$orderId,$reference]);
  $pdo->commit();
  header('Location: vps_checkout.php?order='.$orderId,true,303);exit;
}catch(Throwable $e){if(isset($pdo)&&$pdo->inTransaction())$pdo->rollBack();header('Location: dashboard.php?wallet_error='.rawurlencode($e->getMessage()),true,303);exit;}
