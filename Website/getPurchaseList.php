<?php
session_start();
header('Content-Type: application/json');

// 데이터베이스 연결 설정
$host = 'localhost';
$username = 'jungmin'; // 사용자명 변경
$password = '1234'; // 비밀번호 변경
$dbname = 'website'; // 데이터베이스명 변경

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// 사용자 ID 가져오기
$userId = $_SESSION['userid'];

// 구매목록 조회
$sql = "SELECT product_name, quantity, total_price, purchase_date FROM purchase_history WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$purchaseList = array();

while($row = $result->fetch_assoc()) {
    array_push($purchaseList, array(
        "productName" => $row["product_name"],
        "quantity" => $row["quantity"],
        "totalPrice" => $row["total_price"],
        "purchasedate" => $row["purchase_date"]
    ));
}

echo json_encode($purchaseList);

$conn->close();
?>
