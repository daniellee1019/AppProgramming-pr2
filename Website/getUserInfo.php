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
    echo json_encode(['error' => '데이터베이스 연결 실패']);
    exit(); // 연결 실패 시 스크립트 종료
}

// 세션에서 사용자 ID 확인
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    // 데이터베이스에서 사용자 정보 조회
    $stmt = $conn->prepare("SELECT username, money FROM users WHERE id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userRow = $result->fetch_assoc();
        echo json_encode([
            'username' => $userRow['username'],
            'userMoney' => $userRow['money']
        ]);
    } else {
        echo json_encode(['error' => '사용자 정보를 찾을 수 없습니다.']);
    }
} else {
    echo json_encode(['error' => '사용자가 로그인하지 않았습니다.']);
}

$conn->close(); // 데이터베이스 연결 종료
?>