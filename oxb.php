<?php
declare(strict_types=1);

function oxb_counts(int $userId): array {
    $out = ['domains'=>0,'hosting'=>0,'vps'=>0,'servers'=>0];
    $stmt = db()->prepare('SELECT category, COUNT(*) n FROM oxb_orders WHERE user_id=? AND status IN ("active","provisioning","pending") GROUP BY category');
    $stmt->execute([$userId]);
    foreach ($stmt->fetchAll() as $row) {
        $cat=(string)$row['category'];
        if ($cat==='domains') $out['domains']=(int)$row['n'];
        elseif ($cat==='hosting') $out['hosting']=(int)$row['n'];
        elseif ($cat==='vps') $out['vps']=(int)$row['n'];
        elseif ($cat==='servers') $out['servers']=(int)$row['n'];
    }
    return $out;
}

function oxb_recent_orders(int $userId, int $limit=3): array {
    $limit=max(1,min(20,$limit));
    $stmt=db()->prepare("SELECT id,title,status,created_at FROM oxb_orders WHERE user_id=? ORDER BY id DESC LIMIT {$limit}");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function oxb_badge(string $status): string {
    $safe=htmlspecialchars($status,ENT_QUOTES,'UTF-8');
    return '<span class="badge">'.ucfirst($safe).'</span>';
}
