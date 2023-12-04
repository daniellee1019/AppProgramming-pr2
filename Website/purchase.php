<?php
session_start();
header('Content-Type: application/json');

// 데이터베이스 연결 정보
$host = 'localhost';
$username = 'jungmin';
$password = '1234';
$dbname = 'website';

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die(json_encode(['error' => '데이터베이스 연결 실패']));
}

if (!isset($_SESSION['userid'])) {
    echo json_encode(['error' => '사용자가 로그인하지 않았습니다.']);
    exit();
}

$userid = $_SESSION['userid'];
$cart = json_decode(file_get_contents('php://input'), true);

if (!$cart) {
    echo json_encode(['error' => '장바구니 정보가 없습니다.']);
    exit();
}

$totalPrice = 0;
foreach ($cart as $productName => $quantity) {
    // 상품 가격을 데이터베이스에서 조회 (예시 가격: 20000원)
    $totalPrice += 20000 * $quantity;
}

// 사용자의 현재 잔액을 조회
$userMoneyQuery = "SELECT money FROM users WHERE id = $userid";
$userMoneyResult = $conn->query($userMoneyQuery);
if ($userMoneyResult->num_rows > 0) {
    $userMoneyRow = $userMoneyResult->fetch_assoc();
    $userMoney = $userMoneyRow['money'];

    if ($userMoney >= $totalPrice) {
        // 구매 처리
        $newUserMoney = $userMoney - $totalPrice;

        // 사용자 잔액 업데이트
        $updateMoneyQuery = "UPDATE users SET money = $newUserMoney WHERE id = $userid";
        $conn->query($updateMoneyQuery);

        // 구매 내역 저장
        foreach ($cart as $productName => $quantity) {
            $purchaseQuery = "INSERT INTO purchase_history (user_id, product_name, quantity, total_price) VALUES ($userid, '$productName', $quantity, $totalPrice)";
            $conn->query($purchaseQuery);
        }

        echo json_encode(['success' => '구매가 완료되었습니다.']);
    } else {
        echo json_encode(['error' => '잔액이 부족합니다.']);
    }
} else {
    echo json_encode(['error' => '사용자 정보를 찾을 수 없습니다.']);
}

$conn->close();
?>
