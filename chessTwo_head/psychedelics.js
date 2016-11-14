// a collection of psychedelic graphic functions
//
//
//
//



function randomColorGenerator(stringType) {
	if (stringType == "HEX") {
		// first get the letters
		var colorString="#";
		var range=16;
		var val;

		for (var i=1; i<7; i++) {
			var randomnumber=Math.floor(Math.random()*(range))
			if (randomnumber < 10) {
				val = randomnumber
			} else if (randomnumber == 10) {
				val = "A";
			} else if (randomnumber == 11) {
				val = "B";
			} else if (randomnumber == 12) {
				val = "C";
			} else if (randomnumber == 13) {
				val = "D";
			} else if (randomnumber == 14) {
				val = "E";
			} else if (randomnumber == 15) {
				val = "F";
			}
			colorString = colorString + val;
		}

		return colorString;
	} else if (stringType == "RGBA") {
		var colorString="rgba(";
		var range=256;
		var val;
		var R=Math.floor(Math.random()*(range));
		var G=Math.floor(Math.random()*(range));
		var B=Math.floor(Math.random()*(range));
		var transparencyFactor = 0.35;

		// this one lets it be partially transparent, used for highlighting
		// "rgba(0, 255, 0, 0.35)"; 

		colorString = colorString + R + "," + G + "," + B + "," + transparencyFactor + ")";
		return colorString;
	
	
	} else {
		return "#000000"
	}
}







function psychedelicRectangleOne(context,x,y,xstep,ystep,xcount,ycount) {
	for (var wipe=0; wipe < ycount; wipe++) {
		for (var stripe=0; stripe < xcount; stripe++) {
			context.fillStyle = randomColorGenerator("HEX");
			context.fillRect(x + (stripe -1)*xstep,y+(wipe-1)*ystep,xstep,ystep);
		}
	}
}

function psychedelicRectangleTwo(context,x,y,xsize,ysize) {
	if (ysize > xsize) {
		for (var step=xsize; step > 1; step--) {
			inc = xsize-step;
			context.fillStyle = randomColorGenerator("HEX");
			context.fillRect(x + inc, y + inc, xsize - 2*inc, ysize - 2*inc);
		}
	} else {
		for (var step=ysize; step > (ysize/2); step--) {
			inc = ysize-step;
			context.fillStyle = randomColorGenerator("HEX");
			context.fillRect(x + inc, y + inc, xsize - 2*inc, ysize - 2*inc);
		}
	}
}
