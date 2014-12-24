<?php
function unichr($uniPos) {
	return mb_convert_encoding("&#$uniPos;", 'UTF-8', 'HTML-ENTITIES');
}
function getInput($name) {
	return filter_input(INPUT_GET, $name, FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_ENCODED);
}
$inputChar = getInput('char');
$inputMark = getInput('mark');

$diacritics = array(
	'titlo' => "҃",
	'acute-accent' => unichr(769),
	'grave-accent' => unichr(768),
);
$diacriticTitles = array(
	'titlo' => 'Титло (и҃)',
	'acute-accent' => 'Акут (остро или меко ударение)',
	'grave-accent' => 'Гравис (тежко или твърдо ударение)',
);
?>
<!DOCTYPE html>
<html lang="bg">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<title>Генератор на специални знаци</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
	<style>
.header {
	margin-bottom: 30px;
	border-bottom: 1px solid #e5e5e5;
}
.specialchar {
	font-size: 900%;
	height: 1.8em;
	text-align: center;
	width: 3em;
}
	</style>
</head>

<body>

	<div class="container">

		<div class="header">
			<h3 class="text-muted">Генератор на специални знаци</h3>
		</div>

		<form class="form-horizontal" action="" method="get">
			<div class="form-group">
				<label for="inputChar" class="col-sm-2 control-label">Обикновен знак</label>
				<div class="col-sm-10">
					<input id="inputChar" name="char" class="form-control input" placeholder="Обикновен знак" value="<?= $inputChar ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputMark" class="col-sm-2 control-label">Диакритичен знак</label>
				<div class="col-sm-10">
					<select id="inputMark" name="mark" class="form-control input">
						<option value="">(Избор)</option>
						<?php foreach ($diacriticTitles as $name => $title): ?>
							<option value="<?= $name ?>" <?= $name == $inputMark ? 'selected' : '' ?>><?= $title ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
		</form>

		<input id="outputChar" class="form-control center-block specialchar" readonly>

	</div><!-- /.container -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script>
jQuery(function($) {
	var diacritics = <?= json_encode($diacritics) ?>;
	function generateDiacriticChar() {
		var diacriticName = $("#inputMark").val();
		if (diacritics[diacriticName]) {
			var diacritic = diacritics[diacriticName];
			var outputChar = $("#inputChar").val() + diacritic;
			$("#outputChar").val(outputChar);
		}
	}
	$(".input").on("change keyup", function() {
		generateDiacriticChar();
	});
	$("#outputChar").on("focus", function() {
		$(this).select();
	});
	generateDiacriticChar();
});
</script>
</body>
</html>
