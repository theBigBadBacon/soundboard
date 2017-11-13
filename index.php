<?php
	$soundclips = array();

	if ($handle = opendir('public/audio/piano')) {
		while (false !== ($file = readdir($handle))) {
			if (($file <> ".") && ($file <> "..")) {
				array_push($soundclips, $file);
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Soundboard</title>
	<link href="https://fonts.googleapis.com/icon?family=Titillium+Web" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="public/css/main.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>
	<script src="public/js/env.js"></script>
	<script src="public/js/app.js"></script>
	<script src="public/js/soundboard.js"></script>
</head>
<body>
	<div ng-app="soundboardApp" class="base">
		<div ng-controller="SoundboardController as soundboard">
			<input type="hidden" ng-init='clips=<?= json_encode($soundclips); ?>'>
			<h1 class="heading">Keyboard Soundboard 3000</h1>
			<div class="keys">
				<div class="mat">
					<div class="mat-mouse"></div>
				</div>
				<div class="keys-row" ng-repeat="row in soundboard.keys">
					<div class="key key--{{key}} {{!soundboard.clips[key] ? 'is-disabled' : ''}}" ng-repeat="key in row">
						{{key.toUpperCase()}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		const soundClips = <?= json_encode($soundclips); ?>;
		let soundKeys = [];

		soundClips.forEach((sound) => {
			let note = new Audio('public/audio/piano/'+sound);
			let keyCode = sound.split('.wav')[0];

			note.load();
			soundKeys[keyCode] = note;
		});

		document.body.onkeydown = function (e) {
			let key = e.key.match(/[a-z]/);
			let targetKey = key ? document.querySelector('.key--' + key) : false;

			if (targetKey && targetKey.classList.contains('is-disabled')) return;

			let sound = soundKeys[key];

			if (sound) {
				if (sound.currentTime > 0) return;
				sound.pause();
				sound.currentTime = 0;
				sound.play();

				targetKey.classList.add('is-pressed');
			}
		};

		document.body.onkeyup = function (e) {
			let key = e.key.match(/[a-z]/);
			let targetKey = key ? document.querySelector('.key--' + key) : false;

			if (targetKey && targetKey.classList.contains('is-disabled')) return;

			let sound = soundKeys[key];

			if (sound) {
				sound.pause();
				sound.currentTime = 0;

				document.querySelector('.key--' + key).classList.remove('is-pressed');
			}
		};
	</script>
</body>
</html>