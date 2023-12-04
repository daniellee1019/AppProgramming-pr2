<!-- signup.php -->
<?php
// 데이터베이스 연결 정보
$host = 'localhost'; // 데이터베이스 호스트
$username = 'jungmin'; // 데이터베이스 사용자명
$password = '1234'; // 데이터베이스 암호
$dbname = 'website'; // 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 양식에서 제출된 데이터 가져오기
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 데이터 유효성 검사
    if (empty($username) || empty($email) || empty($password)) {
        echo "모든 필드를 입력해야 합니다.";
    } else {
        // 중복된 사용자명이 있는지 확인
        $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
        $checkUsernameResult = $conn->query($checkUsernameQuery);

        // 중복된 이메일이 있는지 확인
        $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
        $checkEmailResult = $conn->query($checkEmailQuery);

        if ($checkUsernameResult->num_rows > 0) {
            header("Location: Signup.html?error=중복된 사용자명입니다. 다른 사용자명을 입력해주세요.");
            exit();
        } else if ($checkEmailResult->num_rows > 0) {
            header("Location: Signup.html?error=중복된 이메일입니다. 다른 이메일을 입력해주세요.");
            exit();
        } else {
            // 데이터 삽입을 위한 SQL 쿼리 작성
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

            // 데이터 삽입 실행
            if ($conn->query($sql) === TRUE) {
                // 회원가입이 성공적으로 처리되면 사용자의 money를 20000으로 설정
                $updateMoneySql = "UPDATE users SET money = 100000 WHERE username = '$username'";

                if ($conn->query($updateMoneySql) === TRUE) {
                    header("Location: Loginpage.html");
                    exit();
                } else {
                    echo "Error: " . $updateMoneySql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

// 데이터베이스 연결 닫기
$conn->close();
?>
