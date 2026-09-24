<?php
declare(strict_types=1);
require __DIR__.'/bootstrap.php';
require_once __DIR__.'/wallet.php';
require_once __DIR__.'/interserver.php';
$user=require_login();
$orderId=(int)($_GET['order']??$_POST['order']??0);
$stmt=db()->prepare('SELECT * FROM oxb_orders WHERE id=? AND user_id=? LIMIT 1');$stmt->execute([$orderId,(int)$user['id']]);$order=$stmt->fetch();
if(!$order){http_response_code(404);exit('Order not found.');}
$error=null;
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(!verify_csrf($_POST['csrf']??null)){http_response_code(400);exit('Invalid request.');}
 try{
  if($order['status']!=='pending')throw new RuntimeException('This order has already been processed.');
  $api=new InterServerAPI();
  $res=$api->buyVps(['os'=>trim((string)$_POST['os']),'slices'=>max(1,(int)($_POST['slices']??1)),'platform'=>trim((string)$_POST['platform']),'controlpanel'=>trim((string)($_POST['controlpanel']??'')),'period'=>1,'location'=>(int)$_POST['location'],'version'=>trim((string)$_POST['version']),'hostname'=>trim((string)$_POST['hostname']),'coupon'=>'','rootpass'=>(string)$_POST['rootpass'],'comment'=>'Oxbothost order #'.$orderId,'ipv6only'=>false]);
  if(strtolower((string)($res['status']??''))!=='ok')throw new RuntimeException((string)($res['status_text']??'InterServer rejected the order.'));
  $pdo=db();$pdo->prepare('UPDATE oxb_orders SET status="provisioning",provider_invoice_id=?,metadata_json=? WHERE id=?')->execute([(string)($res['invoices']??''),json_encode($res,JSON_UNESCAPED_SLASHES),$orderId]);
  header('Location: dashboard.php?bought='.rawurlencode($order['title']),true,303);exit;
 }catch(Throwable $e){
  $error=$e->getMessage();
  try{
   $pdo=db();$pdo->beginTransaction();$q=$pdo->prepare('SELECT status,amount,user_id FROM oxb_orders WHERE id=? FOR UPDATE');$q->execute([$orderId]);$row=$q->fetch();
   if($row&&$row['status']==='pending'){
    $pdo->prepare('UPDATE wallet_accounts SET balance=balance+? WHERE user_id=?')->execute([(float)$row['amount'],(int)$row['user_id']]);
    $ref='refund-'.$orderId.'-'.bin2hex(random_bytes(5));$pdo->prepare('INSERT INTO wallet_transactions(user_id,type,amount,description,reference) VALUES(?,?,?,?,?)')->execute([(int)$row['user_id'],'refund',(float)$row['amount'],'Refund for failed VPS order #'.$orderId,$ref]);
    $pdo->prepare('UPDATE oxb_orders SET status="failed",metadata_json=? WHERE id=?')->execute([json_encode(['error'=>$error],JSON_UNESCAPED_SLASHES),$orderId]);
   }$pdo->commit();
  }catch(Throwable $refundError){if(isset($pdo)&&$pdo->inTransaction())$pdo->rollBack();error_log('Oxbothost VPS refund failed: '.$refundError->getMessage());}
 }
}
try{$api=new InterServerAPI();$locations=$api->call('get_vps_locations_array');$templates=$api->call('get_vps_templates');$platforms=$api->call('get_vps_platforms_array');}catch(Throwable $e){$locations=$templates=$platforms=[];$error=$error?:$e->getMessage();}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>VPS checkout | oxbothost</title><style>body{font:15px system-ui;max-width:760px;margin:40px auto;padding:20px}form{display:grid;gap:12px}input,select,button{padding:12px;border:1px solid #999;border-radius:10px}button{background:#000;color:#fff}.error{padding:12px;border:1px solid #c00;margin-bottom:16px}</style></head><body><h1><?=htmlspecialchars($order['title'])?></h1><p>Order #<?=$orderId?> · $<?=number_format((float)$order['amount'],2)?></p><?php if($error):?><div class="error"><?=htmlspecialchars($error)?></div><?php endif;?><form method="post"><input type="hidden" name="csrf" value="<?=htmlspecialchars(csrf_token())?>"><input type="hidden" name="order" value="<?=$orderId?>"><label>OS<input name="os" required placeholder="ubuntu"></label><label>Version<input name="version" required placeholder="22.04"></label><label>Platform<select name="platform" required><?php foreach((array)$platforms as $p):$a=(array)$p;?><option value="<?=htmlspecialchars((string)($a['platform']??''))?>"><?=htmlspecialchars((string)($a['name']??''))?></option><?php endforeach;?></select></label><label>Location<select name="location" required><?php foreach((array)$locations as $p):$a=(array)$p;?><option value="<?=htmlspecialchars((string)($a['id']??''))?>"><?=htmlspecialchars((string)($a['name']??''))?></option><?php endforeach;?></select></label><label>Slices<input type="number" name="slices" min="1" value="1" required></label><label>Hostname<input name="hostname" required></label><label>Root password<input type="password" name="rootpass" minlength="8" required></label><label>Control panel<input name="controlpanel" placeholder=""></label><button type="submit">Provision VPS</button></form></body></html>
