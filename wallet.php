<?php
declare(strict_types=1);

function wallet_ensure(int $userId): void {
    $stmt=db()->prepare('INSERT IGNORE INTO wallet_accounts(user_id,balance) VALUES(?,0)');
    $stmt->execute([$userId]);
}

function wallet_balance(int $userId): float {
    wallet_ensure($userId);
    $stmt=db()->prepare('SELECT balance FROM wallet_accounts WHERE user_id=?');
    $stmt->execute([$userId]);
    return (float)$stmt->fetchColumn();
}

function wallet_history(int $userId,int $limit=10): array {
    wallet_ensure($userId);
    $limit=max(1,min(50,$limit));
    $stmt=db()->prepare("SELECT type,amount,description,reference,created_at FROM wallet_transactions WHERE user_id=? ORDER BY id DESC LIMIT {$limit}");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function wallet_credit(int $userId,float $amount,string $description,string $reference): void {
    if ($amount<=0) throw new InvalidArgumentException('Amount must be positive.');
    $pdo=db(); $pdo->beginTransaction();
    try {
        wallet_ensure($userId);
        $lock=$pdo->prepare('SELECT balance FROM wallet_accounts WHERE user_id=? FOR UPDATE');
        $lock->execute([$userId]);
        if ($lock->fetchColumn()===false) throw new RuntimeException('Wallet unavailable.');
        $pdo->prepare('UPDATE wallet_accounts SET balance=balance+? WHERE user_id=?')->execute([$amount,$userId]);
        $pdo->prepare('INSERT INTO wallet_transactions(user_id,type,amount,description,reference) VALUES(?,?,?,?,?)')->execute([$userId,'credit',$amount,$description,$reference]);
        $pdo->commit();
    } catch(Throwable $e) { if($pdo->inTransaction()) $pdo->rollBack(); throw $e; }
}

function wallet_debit(int $userId,float $amount,string $description,string $reference): void {
    if ($amount<=0) throw new InvalidArgumentException('Amount must be positive.');
    $pdo=db(); $pdo->beginTransaction();
    try {
        wallet_ensure($userId);
        $lock=$pdo->prepare('SELECT balance FROM wallet_accounts WHERE user_id=? FOR UPDATE');
        $lock->execute([$userId]);
        $balance=(float)$lock->fetchColumn();
        if($balance+0.00001<$amount) throw new RuntimeException('Insufficient wallet balance.');
        $pdo->prepare('UPDATE wallet_accounts SET balance=balance-? WHERE user_id=?')->execute([$amount,$userId]);
        $pdo->prepare('INSERT INTO wallet_transactions(user_id,type,amount,description,reference) VALUES(?,?,?,?,?)')->execute([$userId,'debit',-$amount,$description,$reference]);
        $pdo->commit();
    } catch(Throwable $e) { if($pdo->inTransaction()) $pdo->rollBack(); throw $e; }
}
