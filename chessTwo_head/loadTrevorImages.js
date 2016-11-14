// all this does is load the images
//
// loads Trevor's image set
//
//

// set the image directory
// images will be extracted to this directory 
// when the install file will be unzipped
var imageDirTrevor = "./trevorImages/";
var imageDirOrig = "./images/";

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



function setImagesTrevor() {
// set image sources
whiteClassicPawn.src = imageDirTrevor + "whitePawn.png";
whiteClassicKnight.src = imageDirTrevor + "whiteKnight.png";
whiteClassicBishop.src = imageDirTrevor + "whiteBishop.png";
whiteClassicRook.src = imageDirTrevor + "whiteRook.png";
whiteClassicKing.src = imageDirTrevor + "whiteKing.png";
whiteClassicQueen.src = imageDirTrevor + "whiteQueen.png";
blackClassicPawn.src = imageDirTrevor + "blackPawn.png";
blackClassicKnight.src = imageDirTrevor + "blackKnight.png";
blackClassicBishop.src = imageDirTrevor + "blackBishop.png";
blackClassicRook.src = imageDirTrevor + "blackRook.png";
blackClassicKing.src = imageDirTrevor + "blackKing.png";
blackClassicQueen.src = imageDirTrevor + "blackQueen.png";
whiteNemesisPawn.src = imageDirTrevor + "whiteRebel.png";
whiteNemesisKnight.src = imageDirTrevor + "whiteKnight.png";
whiteNemesisBishop.src = imageDirTrevor + "whiteBishop.png";
whiteNemesisRook.src = imageDirTrevor + "whiteRook.png";
whiteNemesisKing.src = imageDirTrevor + "whiteKing.png";
whiteNemesisQueen.src = imageDirTrevor + "whiteNemesis.png";
blackNemesisPawn.src = imageDirTrevor + "blackRebel.png";
blackNemesisKnight.src = imageDirTrevor + "blackKnight.png";
blackNemesisBishop.src = imageDirTrevor + "blackBishop.png";
blackNemesisRook.src = imageDirTrevor + "blackRook.png";
blackNemesisKing.src = imageDirTrevor + "blackKing.png";
blackNemesisQueen.src = imageDirTrevor + "blackNemesis.png";
whiteWarriorPawn.src = imageDirTrevor + "whitePawn.png";
whiteWarriorKnight.src = imageDirTrevor + "whiteKnight.png";
whiteWarriorBishop.src = imageDirTrevor + "whiteBishop.png";
whiteWarriorRook.src = imageDirTrevor + "whiteRook.png";
whiteWarriorKing.src = imageDirTrevor + "whiteWarriorKing.png";
whiteWarriorQueen.src = imageDirTrevor + "whiteWarriorKing.png";
blackWarriorPawn.src = imageDirTrevor + "blackPawn.png";
blackWarriorKnight.src = imageDirTrevor + "blackKnight.png";
blackWarriorBishop.src = imageDirTrevor + "blackBishop.png";
blackWarriorRook.src = imageDirTrevor + "blackRook.png";
blackWarriorKing.src = imageDirTrevor + "blackWarriorKing.png";
blackWarriorQueen.src = imageDirTrevor + "blackWarriorKing.png";
whiteEmpoweredPawn.src = imageDirTrevor + "whitePawn.png";
whiteEmpoweredKnight.src = imageDirTrevor + "whiteKnight.png";
whiteEmpoweredBishop.src = imageDirTrevor + "whiteBishop.png";
whiteEmpoweredRook.src = imageDirTrevor + "whiteRook.png";
whiteEmpoweredKing.src = imageDirTrevor + "whiteKing.png";
whiteEmpoweredQueen.src = imageDirTrevor + "whiteQueen.png";
blackEmpoweredPawn.src = imageDirTrevor + "blackPawn.png";
blackEmpoweredKnight.src = imageDirTrevor + "blackKnight.png";
blackEmpoweredBishop.src = imageDirTrevor + "blackBishop.png";
blackEmpoweredRook.src = imageDirTrevor + "blackRook.png";
blackEmpoweredKing.src = imageDirTrevor + "blackKing.png";
blackEmpoweredQueen.src = imageDirTrevor + "blackQueen.png";
whiteAnimalPawn.src = imageDirTrevor + "whitePawn.png";
whiteAnimalKnight.src = imageDirTrevor + "whiteHorse.png";
whiteAnimalBishop.src = imageDirTrevor + "whiteTiger.png";
whiteAnimalRook.src = imageDirTrevor + "whiteElephant.png";
whiteAnimalKing.src = imageDirTrevor + "whiteKing.png";
whiteAnimalQueen.src = imageDirTrevor + "whiteJungleQueen.png";
blackAnimalPawn.src = imageDirTrevor + "blackPawn.png";
blackAnimalKnight.src = imageDirTrevor + "blackHorse.png";
blackAnimalBishop.src = imageDirTrevor + "blackTiger.png";
blackAnimalRook.src = imageDirTrevor + "blackElephant.png";
blackAnimalKing.src = imageDirTrevor + "blackKing.png";
blackAnimalQueen.src = imageDirTrevor + "blackJungleQueen.png";
whiteReaperPawn.src = imageDirTrevor + "whitePawn.png";
whiteReaperKnight.src = imageDirTrevor + "whiteKnight.png";
whiteReaperBishop.src = imageDirTrevor + "whiteBishop.png";
//whiteReaperRook.src = imageDirTrevor + "whiteGhost.png";
whiteReaperRook.src = imageDirOrig + "whiteGhostGhost.png";
whiteReaperKing.src = imageDirTrevor + "whiteKing.png";
whiteReaperQueen.src = imageDirTrevor + "whiteReaper.png";
blackReaperPawn.src = imageDirTrevor + "blackPawn.png";
blackReaperKnight.src = imageDirTrevor + "blackKnight.png";
blackReaperBishop.src = imageDirTrevor + "blackBishop.png";
//blackReaperRook.src = imageDirTrevor + "blackGhost.png";
blackReaperRook.src = imageDirOrig + "blackGhostGhost.png";
blackReaperKing.src = imageDirTrevor + "blackKing.png";
blackReaperQueen.src = imageDirTrevor + "blackReaper.png";
// empowerment graphics
whiteKnightPower.src = imageDirOrig+ "whiteKnightPower.png";
whiteBishopPower.src = imageDirOrig+ "whiteBishopPower.png";
whiteRookPower.src = imageDirOrig+ "whiteRookPower.png";
blackKnightPower.src = imageDirOrig+ "blackKnightPower.png";
blackBishopPower.src = imageDirOrig+ "blackBishopPower.png";
blackRookPower.src = imageDirOrig+ "blackRookPower.png";
// stones
stoneArray[0].src = imageDirOrig+ "stone1.png";
stoneArray[1].src = imageDirOrig+ "stone2.png";
stoneArray[2].src = imageDirOrig+ "stone3.png";
stoneArray[3].src = imageDirOrig+ "stone4.png";
stoneArray[4].src = imageDirOrig+ "stone5.png";

}



setImagesTrevor();






