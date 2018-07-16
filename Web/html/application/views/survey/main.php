<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($is_logged):?>
	<form method="post" onsubmit="return insert(this);">
		<textarea class="form-control terms_text" id="agree_text" cols="30" rows="10" disabled="disabled">
1. 환자의 권리

가. 진료받을 권리
환자는 자신의 건강보호를 위해 적절한 보건의료서비스를 받을 권리를 갖고, 성별·나이·종교·신분 ·경제적 사정 등을 이유로 이를 건강에 관한 권리를 침해받지 아니하며, 의료인은 정당한 사유 없이 진료를 거부하지 못합니다.

나. 알권리 및 자기결정권
환자는 담당 의사·간호사 등으로부터 질병상태, 치료방법·의학적 연구 대상여부, 장기이식 여부, 부작용 등 예상결과 및 진료비용에 관하여 충분한 설명을 듣고 자세히 물어볼 수 있으며, 이에 관한 동의여부를 결정할 권리를 가집니다.

다. 비밀을 보호받을 권리
환자는 진료와 관련된 신체상·건강상 비밀과 사생활의 비밀을 침해받지 아니하며, 의료인과 의료기관은 환자의 동의를 받거나 범죄수사 등 법률에서 정한 경우 외에는 비밀을 누설·발표하지 못합니다.

라. 상담ㆍ조정을 신청할 권리
환자는 의료서비스 관련 분쟁이 발생한 경우 한국의료분쟁조정중재원 등에 상담 및 조정신청을 할 수 있습니다. 

2. 환자의 의무

가. 의료인에 대한 신뢰·존중 의무
환자는 자신의 건강관련 정보를 의료인에게 정확히 알리고, 의료인의 치료계획을 신뢰하고 존중하여야 합니다.

나. 부정한 방법으로 진료를 받지 않을 의무
환자는 진료 전에 본인의 신분을 밝혀야하고, 타인의 명의로 진료를 받는 등 거짓이나 부정한 방법으로 진료를 받지 아니합니다.
		</textarea><br>
		<div class="form-check text-right">
		  <input class="form-check-input" type="checkbox" name="agree" value="Y" id="agree_y">
		  <label class="form-check-label" for="agree_y">동의합니다</label>
		</div>

		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-4 pt-0">생년월일</legend>
		      <div class="col-sm-8 text-right">
		        <div class="form-check">
					<input type="number" name="birth_year">-
					<input type="number" name="birth_month">-
					<input type="number" name="birth_day">
		        </div>
		      </div>
		    </div>
		  </fieldset>

		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">성별</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="gender" id="gender1" value="1">
		          <label class="form-check-label" for="gender1">남자</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="gender" id="gender2" value="2">
		          <label class="form-check-label" for="gender2">여자</label>
		        </div>
		      </div>
		    </div>
		  </fieldset>


		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">평균적으로 하루에 몇 끼를 드십니까?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="day_meal" id="day_meal_1" value="0">
		          <label class="form-check-label" for="day_meal_1">먹지않음</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="day_meal" id="day_meal_2" value="1">
		          <label class="form-check-label" for="day_meal_2">1끼</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="day_meal" id="day_meal_3" value="2">
		          <label class="form-check-label" for="day_meal_3">2끼</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="day_meal" id="day_meal_4" value="3">
		          <label class="form-check-label" for="day_meal_4">3끼</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="day_meal" id="day_meal_5" value="4">
		          <label class="form-check-label" for="day_meal_5">4끼 이상</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">평상시에 규칙적으로 식사를 하십니까?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_regular" id="meal_regular_y" value="Y">
		          <label class="form-check-label" for="meal_regular_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_regular" id="meal_regular_n" value="N">
		          <label class="form-check-label" for="meal_regular_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">평상시에 밤 8시 이후에 음식을 드십니까?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8" id="meal_after8_y" value="Y">
		          <label class="form-check-label" for="meal_after8_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8" id="meal_after8_n" value="N">
		          <label class="form-check-label" for="meal_after8_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">밤 8시 이후 얼마나 음식(야식)을 드십니까?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_0" value="0">
		          <label class="form-check-label" for="meal_after8_often_0">먹지않음</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_1" value="1">
		          <label class="form-check-label" for="meal_after8_often_1">일주일 중 1회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_2" value="2">
		          <label class="form-check-label" for="meal_after8_often_2">일주일 중 2회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_3" value="3">
		          <label class="form-check-label" for="meal_after8_often_3">일주일 중 3회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_4" value="4">
		          <label class="form-check-label" for="meal_after8_often_4">일주일 중 4회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_5" value="5">
		          <label class="form-check-label" for="meal_after8_often_5">일주일 중 5회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_6" value="6">
		          <label class="form-check-label" for="meal_after8_often_6">일주일 중 6회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="meal_after8_often" id="meal_after8_often_7" value="7">
		          <label class="form-check-label" for="meal_after8_often_7">일주일 중 7회</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">일주일에 평균 며칠이나 술을 마십니까?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_0" value="0">
		          <label class="form-check-label" for="drink_often_0">먹지않음</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_1" value="1">
		          <label class="form-check-label" for="drink_often_1">일주일 중 1회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_2" value="2">
		          <label class="form-check-label" for="drink_often_2">일주일 중 2회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_3" value="3">
		          <label class="form-check-label" for="drink_often_3">일주일 중 3회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_4" value="4">
		          <label class="form-check-label" for="drink_often_4">일주일 중 4회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_5" value="5">
		          <label class="form-check-label" for="drink_often_5">일주일 중 5회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_6" value="6">
		          <label class="form-check-label" for="drink_often_6">일주일 중 6회</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="drink_often" id="drink_often_7" value="7">
		          <label class="form-check-label" for="drink_often_7">일주일 중 7회</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>


	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">술을 한 번 드실 때 보통 얼마나 마십니까?<br> - 일주일에 1회 이상 음주를 한다고 답변하신 분들만 응답해주시기 바랍니다. <br>
		( 술 종류에 관계없이 각각의 용량으로 계산하며 소주 한병은 약 360ml 정도임.)</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
					<input type="number" name="drink_many" value="0">cc (ml)
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">흡연 여부</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="smoke" id="smoke_n" value="0">
		          <label class="form-check-label" for="smoke_n">아니오 (흡연 경험 없음)</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="smoke" id="smoke_yn" value="1">
		          <label class="form-check-label" for="smoke_yn">끊음 (흡연 경험 있음)</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="smoke" id="smoke_y" value="2">
		          <label class="form-check-label" for="smoke_y">흡연중</label>
		        </div>
		      </div>
		    </div>
		</fieldset>


		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">고강도 운동을 일주일 중 며칠이나 하시나요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input type="number" name="high_many" value="0">일
		        </div>
		    </div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">저강도 일주일 중 며칠이나 하시나요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input type="number" name="low_many" value="0">일
		        </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">고혈압을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="hypertension" id="hypertension_y" value="Y">
		          <label class="form-check-label" for="hypertension_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="hypertension" id="hypertension_n" value="N">
		          <label class="form-check-label" for="hypertension_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>

		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">당뇨병을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="diabetes" id="diabetes_y" value="Y">
		          <label class="form-check-label" for="diabetes_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="diabetes" id="diabetes_n" value="N">
		          <label class="form-check-label" for="diabetes_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">간암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="liver_cancer" id="liver_cancer_y" value="Y">
		          <label class="form-check-label" for="liver_cancer_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="liver_cancer" id="liver_cancer_n" value="N">
		          <label class="form-check-label" for="liver_cancer_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">위암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="gastric_cancer" id="gastric_cancer_y" value="Y">
		          <label class="form-check-label" for="gastric_cancer_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="gastric_cancer" id="gastric_cancer_n" value="N">
		          <label class="form-check-label" for="gastric_cancer_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>


	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">폐암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="lung_cancer" id="lung_cancer_y" value="Y">
		          <label class="form-check-label" for="lung_cancer_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="lung_cancer" id="lung_cancer_n" value="N">
		          <label class="form-check-label" for="lung_cancer_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>


	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">갑상선암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="thyroid_cancer" id="thyroid_cancer_y" value="Y">
		          <label class="form-check-label" for="thyroid_cancer_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="thyroid_cancer" id="thyroid_cancer_n" value="N">
		          <label class="form-check-label" for="thyroid_cancer_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>



	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">유방암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="breast_cancer" id="breast_cancer_y" value="Y">
		          <label class="form-check-label" for="breast_cancer_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="breast_cancer" id="breast_cancer_n" value="N">
		          <label class="form-check-label" for="breast_cancer_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">기타 암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="etc_cancer" id="etc_cancer_y" value="Y">
		          <label class="form-check-label" for="etc_cancer_y">예</label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="etc_cancer" id="etc_cancer_n" value="N">
		          <label class="form-check-label" for="etc_cancer_n">아니오</label>
		        </div>
		      </div>
		    </div>
		</fieldset>
		<hr>

		<div class="text-center">
			<button type="button" class="btn btn-secondary">이전으로</button>
			<button type="submit" class="btn btn-success">제출</button>
		</div>

	</form>
<?php else:?>
	<div class="data_wrap border padding-10">
		로그인이 필요합니다.
	</div>
<?php endif;?>
<script>
	function insert(formobj){
		var form_data = $(formobj).serialize();
		$.ajax({
			type: "POST",
			url: "/survey/insert",
			data: form_data,
			success: function(response) {
				results = JSON.parse(response);
				console.log(results);
				if(results.msg) alert(results.msg);
				if(results.code == 100) location.href="/survey";
			}
		});
		return false;
	}
</script>