<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="alert alert-info" role="alert">
 	진단 날짜 : <?=$datas['date_regis']?>
</div>
<main role="main" class="container">
	<form method="post">
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">생년월일</legend>
		      <div class="col-sm-4">
		      	<?=$datas['birth_year']?>-<?=$datas['birth_month']?>-<?=$datas['birth_day']?>
		      </div>
		    </div>
		  </fieldset>

		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">성별</legend>
		      <div class="col-sm-4">
		      	<?=($datas['gender']==1)?'남성':'여성';?>
		      </div>
		    </div>
		  </fieldset>


		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">평균적으로 하루에 몇 끼를 드십니까?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['day_meal']) {
		        	case 0 : echo "먹지 않음"; break;
		        	case 1 : echo "1끼 이상"; break;
		        	case 2 : echo "2끼 이상"; break;
		        	case 3 : echo "3끼 이상"; break;
		        	case 4 : echo "4끼 이상"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">평상시에 규칙적으로 식사를 하십니까?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['meal_regular']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">평상시에 밤 8시 이후에 음식을 드십니까?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['meal_after8']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">밤 8시 이후 얼마나 음식(야식)을 드십니까?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['meal_after8_often']) {
		        	case 0 : echo "먹지 않음"; break;
		        	case 1 : echo "일주일 중 1회"; break;
		        	case 2 : echo "일주일 중 2회"; break;
		        	case 3 : echo "일주일 중 3회"; break;
		        	case 4 : echo "일주일 중 4회"; break;
		        	case 5 : echo "일주일 중 5회"; break;
		        	case 6 : echo "일주일 중 6회"; break;
		        	case 7 : echo "일주일 중 7회"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">일주일에 평균 며칠이나 술을 마십니까?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['meal_after8_often']) {
		        	case 0 : echo "먹지 않음"; break;
		        	case 1 : echo "일주일 중 1회"; break;
		        	case 2 : echo "일주일 중 2회"; break;
		        	case 3 : echo "일주일 중 3회"; break;
		        	case 4 : echo "일주일 중 4회"; break;
		        	case 5 : echo "일주일 중 5회"; break;
		        	case 6 : echo "일주일 중 6회"; break;
		        	case 7 : echo "일주일 중 7회"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>


	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">술을 한 번 드실 때 보통 얼마나 마십니까?<br> - 일주일에 1회 이상 음주를 한다고 답변하신 분들만 응답해주시기 바랍니다. <br>
		( 술 종류에 관계없이 각각의 용량으로 계산하며 소주 한병은 약 360ml 정도임.)</legend>
		      <div class="col-sm-4"><?=$datas['drink_many']?>cc (ml)</div>
		    </div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">흡연 여부</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['smoke']) {
		        	case 0 : echo "아니오 (흡연 경험 없음)"; break;
		        	case 1 : echo "끊음 (흡연 경험 있음)"; break;
		        	case 2 : echo "흡연중"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>


		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">고강도 운동을 일주일 중 며칠이나 하시나요?</legend>
		      <div class="col-sm-4"><?=$datas['high_many']?>일</div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">저강도 일주일 중 며칠이나 하시나요?</legend>
		      <div class="col-sm-4"><?=$datas['low_many']?>일</div>
		</fieldset>
		<hr>
	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">고혈압을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['hypertension']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>

		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">당뇨병을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['diabetes']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">간암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['liver_cancer']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">위암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['gastric_cancer']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>


	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">폐암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['lung_cancer']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>


	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">갑상선암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['thyroid_cancer']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>



	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">유방암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['breast_cancer']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>

	    <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-8 pt-0">기타 암을 앓고 계신가요?</legend>
		      <div class="col-sm-4">
		        <?php switch ($datas['etc_cancer']) {
		        	case 'Y' : echo "예"; break;
		        	case 'N' : echo "아니오"; break;
		        	default: echo "-"; break;
		        }?>
		      </div>
		    </div>
		</fieldset>
		<hr>

		<div class="text-center">
			<button type="button" class="btn btn-secondary" onclick="history.back();">목록으로</button>
			<button type="button" class="btn btn-success" onclick="location.href='/survey/me/<?=$datas['seq']?>';">맞춤 정보 확인</button>
		</div>

	</form>
</main>