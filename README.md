# AppProgramming-pr2
쇼핑몰 반응형 웹앱 제작 - 다담 : 당신의 모든 쇼핑을 한 곳에서

1. 회원가입

db에 저장된 유저이름, 이메일 확인 후 중복된 이름/이메일이 없다면 가입할 수 있음.
비밀번호는 영어 대소문자/특수문자/숫자를 넣어야지 가입할 수 있음

2. 로그인

db에 저장된 이메일, 비밀번호 체크 후 저장된 데이터가 있다면 로그인 가능.

3. 메인 페이지.

먼저, 중앙 상단에 db에 저장된 유저 이름, 유저 머니 데이터 가지고 와서 뿌려줌

총 3개 카테고리가 있는데 (의류/가전/음식) 의류 잡화만 제작함
그리고 메인 아이템 총 6가지가 있음 -> 각 아이템 텍스트 이름 누르면 장바구니로 데이터 전송됨.

왼쪽 상단 토글바 누르면 
6개 항목 있는데 홈, 로그아웃, 장바구니만 클릭되게 만듬
홈은 메인페이지로 이동
로그아웃은 처음화면으로 이동
장바구니는 장바구니로 이동

4. 장바구니

상단 nav 바 로직은 메인페이지와 동일

중앙 메인 콘텐츠는 장바구니에 담은 품목들 데이터 뿌려줘서 시각화 표현.
장바구니 초기화 버튼은 말 그대로 전체 삭제

구매하기 버튼 누를시 db에 저장된 유저 id의 머니 체크 후 물품 살 수 있는지 없는지 확인
물품 사지면 db에 유저 id 별로 뭐 샀는지 데이터 저장됨.

5.구매 목록 추가
nav 바는 동일 로직
db에 저장된 구매 목록 데이터 화면에 뿌려줌. -> 시각화 완료
