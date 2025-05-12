<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>티켓 구매 시스템</title>
</head>
<body>
    <form method="POST">
        고객성명 <input type="text" name="customer">
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="submit" name="submit" value="합계"><br><br>
        <table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <th>No</th>
                <th>구분</th>
                <th colspan="2">어린이</th>
                <th colspan="2">어른</th>
                <th>비고</th>
            </tr>
            <?php
            $tickets = [
                ["입장권", 7000 , 10000  ,"입장"],
                ["BIG3", 12000 , 18000,  "입장+놀이3종"],
                ["자유이용권", 21000,  28000 , "입장+놀이자유"],
                ["연간이용권", 70000 , 90000 , "입장+놀이자유"]
            ];
            foreach ($tickets as $i => $ticket) {
                echo "<tr>
                    <td rowspan='2'>" . ($i+1) . "</td>
                    <td rowspan='2'>{$ticket[0]}</td>
                    <td>{$ticket[1]}</td>
                    <td><select name='child_{$i}' style='width:50px;'>";
                for ($j = 0; $j <= 10; $j++)
                    echo "<option value='$j'>$j</option>";
                echo "</select></td>
                    <td>{$ticket[2]}</td>
                    <td><select name='adult_{$i}' style='width:50px;'>";
                for ($j = 0; $j <= 10; $j++)
                    echo "<option value='$j'>$j</option>";
                echo "</select></td>
                    <td rowspan='2'>{$ticket[3]}</td>
                </tr>";

                echo "<tr>
                    
                </tr>";
            }
            ?>
        </table><br>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $total = 0;
        $summary = [];
        $customer = $_POST['customer'];
        date_default_timezone_set('Asia/Seoul');
        echo "<br><br>" . date("Y년 m월 d일 A h:i") . "<br>";

        if ($customer) {
            echo "$customer 고객님 감사합니다.<br>";
        }

        foreach ($tickets as $i => $ticket) {
            $c = intval($_POST["child_$i"]);
            $a = intval($_POST["adult_$i"]);
            $price = $c * $ticket[1] + $a * $ticket[2];
            $total += $price;

            if ($c > 0) $summary[] = "어린이 {$ticket[0]} $c매";
            if ($a > 0) $summary[] = "어른 {$ticket[0]} $a매";
        }

        foreach ($summary as $line) {
            echo "$line<br>";
        }

        echo "<br>합계 " . number_format($total) . "원입니다.";
    }
    ?>
</body>
</html>
