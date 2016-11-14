// all this does is load the images
//
//
//
//

// set the image directory
// images will be extracted to this directory 
// when the install file will be unzipped
var imageDir = "./images/";

	var whiteClassicPawn = new Image();
	var whiteClassicKnight = new Image();
	var whiteClassicBishop = new Image();
	var whiteClassicRook = new Image();
	var whiteClassicKing = new Image();
	var whiteClassicQueen = new Image();
	var blackClassicPawn = new Image();
	var blackClassicKnight = new Image();
	var blackClassicBishop = new Image();
	var blackClassicRook = new Image();
	var blackClassicKing = new Image();
	var blackClassicQueen = new Image();
	var whiteNemesisPawn = new Image();
	var whiteNemesisKnight = new Image();
	var whiteNemesisBishop = new Image();
	var whiteNemesisRook = new Image();
	var whiteNemesisKing = new Image();
	var whiteNemesisQueen = new Image();
	var blackNemesisPawn = new Image();
	var blackNemesisKnight = new Image();
	var blackNemesisBishop = new Image();
	var blackNemesisRook = new Image();
	var blackNemesisKing = new Image();
	var blackNemesisQueen = new Image();
	var whiteWarriorPawn = new Image();
	var whiteWarriorKnight = new Image();
	var whiteWarriorBishop = new Image();
	var whiteWarriorRook = new Image();
	var whiteWarriorKing = new Image();
	var whiteWarriorQueen = new Image();
	var blackWarriorPawn = new Image();
	var blackWarriorKnight = new Image();
	var blackWarriorBishop = new Image();
	var blackWarriorRook = new Image();
	var blackWarriorKing = new Image();
	var blackWarriorQueen = new Image();
	var whiteEmpoweredPawn = new Image();
	var whiteEmpoweredKnight = new Image();
	var whiteEmpoweredBishop = new Image();
	var whiteEmpoweredRook = new Image();
	var whiteEmpoweredKing = new Image();
	var whiteEmpoweredQueen = new Image();
	var blackEmpoweredPawn = new Image();
	var blackEmpoweredKnight = new Image();
	var blackEmpoweredBishop = new Image();
	var blackEmpoweredRook = new Image();
	var blackEmpoweredKing = new Image();
	var blackEmpoweredQueen = new Image();
	var whiteAnimalPawn = new Image();
	var whiteAnimalKnight = new Image();
	var whiteAnimalBishop = new Image();
	var whiteAnimalRook = new Image();
	var whiteAnimalKing = new Image();
	var whiteAnimalQueen = new Image();
	var blackAnimalPawn = new Image();
	var blackAnimalKnight = new Image();
	var blackAnimalBishop = new Image();
	var blackAnimalRook = new Image();
	var blackAnimalKing = new Image();
	var blackAnimalQueen = new Image();
	var whiteReaperPawn = new Image();
	var whiteReaperKnight = new Image();
	var whiteReaperBishop = new Image();
	var whiteReaperRook = new Image();
	var whiteReaperKing = new Image();
	var whiteReaperQueen = new Image();
	var blackReaperPawn = new Image();
	var blackReaperKnight = new Image();
	var blackReaperBishop = new Image();
	var blackReaperRook = new Image();
	var blackReaperKing = new Image();
	var blackReaperQueen = new Image();
	// empowerment graphics
	var whiteKnightPower = new Image();
	var whiteBishopPower = new Image();
	var whiteRookPower = new Image();
	var blackKnightPower = new Image();
	var blackBishopPower = new Image();
	var blackRookPower = new Image();
	// stones
	var stoneArray = new Array(5);
	stoneArray[0] = new Image();
	stoneArray[1] = new Image();
	stoneArray[2] = new Image();
	stoneArray[3] = new Image();
	stoneArray[4] = new Image();
	//var stone5 = new Image();


function setImages() {
// set image sources
whiteClassicPawn.src = imageDir + "whiteClassicPawn.png";
whiteClassicKnight.src = imageDir + "whiteClassicKnight.png";
whiteClassicBishop.src = imageDir + "whiteClassicBishop.png";
whiteClassicRook.src = imageDir + "whiteClassicRook.png";
whiteClassicKing.src = imageDir + "whiteClassicKing.png";
whiteClassicQueen.src = imageDir + "whiteClassicQueen.png";
blackClassicPawn.src = imageDir + "blackClassicPawn.png";
blackClassicKnight.src = imageDir + "blackClassicKnight.png";
blackClassicBishop.src = imageDir + "blackClassicBishop.png";
blackClassicRook.src = imageDir + "blackClassicRook.png";
blackClassicKing.src = imageDir + "blackClassicKing.png";
blackClassicQueen.src = imageDir + "blackClassicQueen.png";
whiteNemesisPawn.src = imageDir + "whiteNemesisPawn.png";
whiteNemesisKnight.src = imageDir + "whiteNemesisKnight.png";
whiteNemesisBishop.src = imageDir + "whiteNemesisBishop.png";
whiteNemesisRook.src = imageDir + "whiteNemesisRook.png";
whiteNemesisKing.src = imageDir + "whiteNemesisKing.png";
whiteNemesisQueen.src = imageDir + "whiteNemesisQueen.png";
blackNemesisPawn.src = imageDir + "blackNemesisPawn.png";
blackNemesisKnight.src = imageDir + "blackNemesisKnight.png";
blackNemesisBishop.src = imageDir + "blackNemesisBishop.png";
blackNemesisRook.src = imageDir + "blackNemesisRook.png";
blackNemesisKing.src = imageDir + "blackNemesisKing.png";
blackNemesisQueen.src = imageDir + "blackNemesisQueen.png";
whiteWarriorPawn.src = imageDir + "whiteWarriorPawn.png";
whiteWarriorKnight.src = imageDir + "whiteWarriorKnight.png";
whiteWarriorBishop.src = imageDir + "whiteWarriorBishop.png";
whiteWarriorRook.src = imageDir + "whiteWarriorRook.png";
whiteWarriorKing.src = imageDir + "whiteWarriorKing.png";
whiteWarriorQueen.src = imageDir + "whiteWarriorQueen.png";
blackWarriorPawn.src = imageDir + "blackWarriorPawn.png";
blackWarriorKnight.src = imageDir + "blackWarriorKnight.png";
blackWarriorBishop.src = imageDir + "blackWarriorBishop.png";
blackWarriorRook.src = imageDir + "blackWarriorRook.png";
blackWarriorKing.src = imageDir + "blackWarriorKing.png";
blackWarriorQueen.src = imageDir + "blackWarriorQueen.png";
whiteEmpoweredPawn.src = imageDir + "whiteEmpoweredPawn.png";
whiteEmpoweredKnight.src = imageDir + "whiteEmpoweredKnight.png";
whiteEmpoweredBishop.src = imageDir + "whiteEmpoweredBishop.png";
whiteEmpoweredRook.src = imageDir + "whiteEmpoweredRook.png";
whiteEmpoweredKing.src = imageDir + "whiteEmpoweredKing.png";
whiteEmpoweredQueen.src = imageDir + "whiteEmpoweredQueen.png";
blackEmpoweredPawn.src = imageDir + "blackEmpoweredPawn.png";
blackEmpoweredKnight.src = imageDir + "blackEmpoweredKnight.png";
blackEmpoweredBishop.src = imageDir + "blackEmpoweredBishop.png";
blackEmpoweredRook.src = imageDir + "blackEmpoweredRook.png";
blackEmpoweredKing.src = imageDir + "blackEmpoweredKing.png";
blackEmpoweredQueen.src = imageDir + "blackEmpoweredQueen.png";
whiteAnimalPawn.src = imageDir + "whiteAnimalPawn.png";
whiteAnimalKnight.src = imageDir + "whiteAnimalKnight.png";
whiteAnimalBishop.src = imageDir + "whiteAnimalBishop.png";
whiteAnimalRook.src = imageDir + "whiteAnimalRook.png";
whiteAnimalKing.src = imageDir + "whiteAnimalKing.png";
whiteAnimalQueen.src = imageDir + "whiteAnimalQueen.png";
blackAnimalPawn.src = imageDir + "blackAnimalPawn.png";
blackAnimalKnight.src = imageDir + "blackAnimalKnight.png";
blackAnimalBishop.src = imageDir + "blackAnimalBishop.png";
blackAnimalRook.src = imageDir + "blackAnimalRook.png";
blackAnimalKing.src = imageDir + "blackAnimalKing.png";
blackAnimalQueen.src = imageDir + "blackAnimalQueen.png";
whiteReaperPawn.src = imageDir + "whiteReaperPawn.png";
whiteReaperKnight.src = imageDir + "whiteReaperKnight.png";
whiteReaperBishop.src = imageDir + "whiteReaperBishop.png";
whiteReaperRook.src = imageDir + "whiteReaperRook.png";
whiteReaperKing.src = imageDir + "whiteReaperKing.png";
whiteReaperQueen.src = imageDir + "whiteReaperQueen.png";
blackReaperPawn.src = imageDir + "blackReaperPawn.png";
blackReaperKnight.src = imageDir + "blackReaperKnight.png";
blackReaperBishop.src = imageDir + "blackReaperBishop.png";
blackReaperRook.src = imageDir + "blackReaperRook.png";
blackReaperKing.src = imageDir + "blackReaperKing.png";
blackReaperQueen.src = imageDir + "blackReaperQueen.png";
// empowerment graphics
whiteKnightPower.src = imageDir + "whiteKnightPower.png";
whiteBishopPower.src = imageDir + "whiteBishopPower.png";
whiteRookPower.src = imageDir + "whiteRookPower.png";
blackKnightPower.src = imageDir + "blackKnightPower.png";
blackBishopPower.src = imageDir + "blackBishopPower.png";
blackRookPower.src = imageDir + "blackRookPower.png";
// stones
stoneArray[0].src = imageDir + "stone1.png";
stoneArray[1].src = imageDir + "stone2.png";
stoneArray[2].src = imageDir + "stone3.png";
stoneArray[3].src = imageDir + "stone4.png";
stoneArray[4].src = imageDir + "stone5.png";

}

setImages();








