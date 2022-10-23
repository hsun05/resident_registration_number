<?php


// 생년 검출
function birth_group($number, $type){
	switch($number){
		case '9':
			$year = '18';
			$gender = '남성';
			$nationality = "내국인";
			break;
		case '0':
			$year = '18';
			$gender = '여성';
			$nationality = "내국인";
			break;
		case '1':
			$year = '19';
			$gender = '남성';
			$nationality = "내국인";
			break;
		case '2':
			$year = '19';
			$gender = '여성';
			$nationality = "내국인";
			break;
		case '3':
			$year = '20';
			$gender = '남성';
			$nationality = "내국인";
			break;
		case '4':
			$year = '20';
			$gender = '여성';
			$nationality = "내국인";
			break;
		case '5':
			$year = '19';
			$gender = '남성';
			$nationality = "외국인";
			break;
		case '6':
			$year = '19';
			$gender = '여성';
			$nationality = "외국인";
			break;
		case '7':
			$year = '20';
			$gender = '남성';
			$nationality = "외국인";
			break;
		case '8':
			$year = '20';
			$gender = '여성';
			$nationality = "외국인";
			break;
	}

	if($type == 'year'){
		return $year;
	} elseif($type == 'gender'){
		return $gender;
	} elseif($type == 'nationality'){
		return $nationality;
	}
}

// 지역 검출
function register_area($code){
	if($code >= '00' && $code <= '08'){
		return "서울특별시";
	} else if($code >= '09' && $code <= '12'){
		return "부산광역시";
	} else if($code >= '13' && $code <= '15'){
		return "인천광역시";
	} else if($code >= '16' && $code <= '25'){
		return "경기도";
	} else if($code >= '26' && $code <= '34'){
		return "강원도";
	} else if($code >= '35' && $code <= '39'){
		return "충청북도";
	} else if($code >= '40' && $code <= '41'){
		return "대전광역시";
	} else if($code >= '42' && $code <= '47'){
		return "충청남도";
	} else if($code == '44' || $code == '96'){
		return "세종특별자치시";
	} else if($code >= '48' && $code <= '54'){
		return "전라북도";
	} else if($code >= '55' && $code <= '66'){
		return "전라남도";
	} else if($code == '55' || $code == '56'){
		return "광주광역시";
	} else if(($code >= '67' && $code <= '69') || $code == '76'){
		return "대구광역시";
	} else if(($code >= '70' && $code <= '75') || ($code >= '77' && $code <= '81')){
		return "경상북도";
	} else if(($code >= '82' && $code <= '84') || ($code >= '86' && $code <= '89') || ($code >= '90' && $code <= '92')){
		return "경상남도";
	} else if($code == '85' || $code == '90'){
		return "울산광역시";
	} else if($code >= '93' && $code <= '95'){
		return "제주특별자치도";
	} else{
		return "알 수 없음";
	}
}

function resident_registration_number($number){
	$number_array = str_split($number);

	$numberPattern = '/^[0-9]{2}[0-1]{1}[1-9]{1}[0-9]{1}[0-9]{1}-[0-9]{1}[0-9]{2}[0-9]{4}$/';
	// 유효성 검사
	if(preg_match($numberPattern, $number)){
		// 자릿수에 따른 검사
		if($number_array['13'] == (11 - (2 * $number_array['0'] + 3 * $number_array['1'] + 4 * $number_array['2'] + 5 * $number_array['3'] + 6 * $number_array['4'] + 7 * $number_array['5'] + 8 * $number_array['7'] + 9 * $number_array['8'] + 2 * $number_array['9'] + 3 * $number_array['10'] + 4 * $number_array['11'] + 5 * $number_array['12']) % 11)){
			// echo "입력된 주민등록번호 :  " . $number . "\n\n";
		} else{
			// echo "주민등록번호를 확인하고 다시 입력해 주세요.1\n";
			return "invalid number"; // 유효하지 않은 주민등록번호
		}
	} else {
		// 
		// echo "주민등록번호를 확인하고 다시 입력해 주세요.2\n";
		return "invalid number"; // 유효하지 않은 주민등록번호
	}
	
	$birth_year = $number_array[0].$number_array[1];		// 생년
	$birth_month = $number_array[2].$number_array[3];		// 생월
	$birth_date = $number_array[4].$number_array[5];		// 생일
	
	$birth_year_group = birth_group($number_array[7], 'year');
	$gender = birth_group($number_array[7], 'gender');
	$nationality = birth_group($number_array[7], 'nationality');
	
	$area = register_area($number_array[8].$number_array[9]);
	
	$data = array(
		"RRN" => $number,
		"birth" => array(
			"year" => $birth_year_group.$birth_year,
			"month" => $birth_month,
			"date" => $birth_date
		),
		"nationality" => $nationality,
		"gender" => $gender,
		"area" => $area,
		"area statement" => "(2020년 10월 이후 등록된 번호는 임의번호 부여임으로 맞지 않습니다.)"
	);
	return $data;
}




$number = "000101-3000008";			// 주민등록번호 변경

print_r(resident_registration_number($number));



?>