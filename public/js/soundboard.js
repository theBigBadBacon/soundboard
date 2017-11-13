
app.controller('SoundboardController', function($scope) {
	let soundboard = this;

	soundboard.clips = {};
	soundboard.keys = {
		'top':['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'],
		'middle':['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l'],
		'bottom':['z', 'x', 'c', 'v', 'b', 'n', 'm']
	};

	$scope.$watch("clips", function(){
		$scope.clips.forEach((name) => {
			soundboard.clips[name.substr(0,1)] = true;
		});
	});
});
