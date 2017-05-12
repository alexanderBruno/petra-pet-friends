var stars = ['#p1','#p2','#p3','#p4','#p5'];
var vueltas = 0;
$(document).ready(function(){
	//var value = Math.floor((Math.random() * 5) + 1);
	var floatScore = parseFloat(score);
	pawStar = Math.round(floatScore);
	for (var i = pawStar -1 ; i >= 0; i--) {
		$(stars[i]).css('color', '#ff6868');
	}
});