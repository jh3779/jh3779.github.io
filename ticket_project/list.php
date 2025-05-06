<?php
require 'db.php';

$sql = "SELECT * FROM orders ORDER BY order_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>주문 리스트</title>
    <style>
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>전체 주문 내역</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>고객 성명</th>
                <th>티켓 종류</th>
                <th>어린이 수량</th>
                <th>어른 수량</th>
                <th>합계 금액 (원)</th>
                <th>주문 시간</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= htmlspecialchars($row['ticket_type']) ?></td>
                        <td><?= $row['child_qty'] ?></td>
                        <td><?= $row['adult_qty'] ?></td>
                        <td><?= number_format($row['total_price']) ?></td>
                        <td><?= $row['order_time'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">주문 내역이 없습니다.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="text-align: center;">
        <a href="index.php">← 다시 구매하기</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
