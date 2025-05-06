<?php
date_default_timezone_set('Asia/Seoul');
require 'db.php';

$customer_name = $_POST['customer_name'];
$ticket_types = $_POST['ticket_type'];
$child_qtys = $_POST['child_qty'];
$adult_qtys = $_POST['adult_qty'];

$prices = [
    "입장권" => [7000, 10000],
    "BIG3" => [12000, 16000],
    "자유이용권" => [21000, 28000],
    "연간이용권" => [70000, 90000]
];

$total_price = 0;
$order_time = date("Y-m-d H:i:s");

for ($i = 0; $i < count($ticket_types); $i++) {
    $type = $ticket_types[$i];
    $child_qty = (int)$child_qtys[$i];
    $adult_qty = (int)$adult_qtys[$i];

    if ($child_qty === 0 && $adult_qty === 0) continue;

    $price = $child_qty * $prices[$type][0] + $adult_qty * $prices[$type][1];
    $total_price += $price;

    // 개별 항목 저장
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, ticket_type, child_qty, adult_qty, total_price, order_time)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiis", $customer_name, $type, $child_qty, $adult_qty, $price, $order_time);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>구매 완료</title>
</head>
<body>
    <h2>구매 완료</h2>
    <p><?= date("Y년 m월 d일 A h:i") ?> </p>
    <p><?= htmlspecialchars($customer_name) ?> 고객님 감사합니다.</p>

    <ul>
        <?php
        for ($i = 0; $i < count($ticket_types); $i++) {
            $child_qty = (int)$child_qtys[$i];
            $adult_qty = (int)$adult_qtys[$i];
            if ($child_qty > 0) echo "<li>어린이 {$ticket_types[$i]} {$child_qty}매</li>";
            if ($adult_qty > 0) echo "<li>어른 {$ticket_types[$i]} {$adult_qty}매</li>";
        }
        ?>
    </ul>
    <p>합계 <?= number_format($total_price) ?>원입니다.</p>

    <p><a href="index1.php">← 다시 구매하기</a></p>
    <p><a href="list.php">→ 전체 주문 목록 보기</a></p>
</body>
</html>