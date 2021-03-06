
<!DOCTYPE HTML>
<html>

<title>Chess 2</title>

<head>
	<script src="loadImages.js"></script>
	<script src="loadTrevorImages.js"></script>
	<script src="psychedelics.js"></script>
<script type="text/javascript">

	// global variables
	//
	//
	// enables psychedelic graphics
	var psych = false;

	// image set toggler
	var imageSetToggler = 0;

	// NOTATION
	// builds up the move notation
	var moveString="";

	// objects
	//
	function piece (positionID,pieceID) {
		this.positionID = positionID;
		this.pieceID = pieceID;
		this.image = getImageFromPieceID(this.pieceID);
		this.highlight="";
		// the letter that the piece maps to in notation
		this.notation = getNotationFromPieceID(this.pieceID);
	}


	// the last square that was clicked
	function clickedSquare (x,y,piece,source) {
		this.x = x;
		this.y = y;
		this.piece = piece;
		this.src = source;
	}



	// the move list
	function moveList () {
		this.whiteMoveList = new Array(1);
		this.blackMoveList = new Array(1);
		this.whiteListLength = 0;
		this.blackListLength = 0;
		this.turn=0;
		this.moveNumber=1;
		this.addMove = addMove;
		this.addBlank = addBlank;
		this.addDuelMove = addDuelMove;
		this.deleteMove = deleteMove;
		this.printList = printList;
	}
	// the move list object's methods
	function addMove(moveString){
		if (this.turn == 0) {
			this.whiteMoveList[this.whiteListLength] = (this.moveNumber) + ". " + moveString;
			this.turn = 1;
			this.whiteListLength++;
		} else {
			this.blackMoveList[this.blackListLength] = moveString;
			this.turn = 0;
			this.blackListLength++;
			this.moveNumber++;
		}
	}
	function addBlank(moveString){
		if (this.turn == 0) {
			this.whiteMoveList[this.whiteListLength] = "   " + moveString;
			this.turn = 1;
			this.whiteListLength++;
		} else {
			this.blackMoveList[this.blackListLength] = moveString;
			this.turn = 0;
			this.blackListLength++;
		}
	}
	function addDuelMove(moveString){
		if (this.turn == 0) {
			this.addBlank(moveString);
			this.addBlank("-----");
		} else {
			this.addBlank(moveString);
			this.addBlank("-----");
		}
	}

	function deleteMove(){
		if (this.turn == 1) {
			this.whiteMoveList[this.whiteListLength] = null;
			this.whiteListLength--;
			this.moveNumber--;
			this.turn = 0;
		} else {
			this.blackMoveList[this.blackListLength] = null;
			this.blackListLength--;
			this.turn = 1;
		}
	}
	function printList(context){
		// clear previous content
		context.fillStyle = "#FFFFFF"
		context.fillRect(0,0,200,900);

		context.fillStyle = "#000000"
		ypos = 10;
		xshift = 90;
		fontHeight=10;
		total=this.whiteListLength+this.blackListLength;
		for (i=0; i<this.blackListLength; i++) {
			context.fillText(this.whiteMoveList[i],10,ypos);
			context.fillText(this.blackMoveList[i],10+xshift,ypos);
			ypos+=fontHeight;
		}
		// if it is black's turn, then white has already made a move
		// so the list is currently one greater for white
		if (this.turn == 1) {
			context.fillText(this.whiteMoveList[this.whiteListLength-1],10,ypos);
		}
	}


	//var lastClickedSquare = new Array(0,0,new piece(0,0));
	var lastClickedSquare = new clickedSquare(0,0,new piece(0,0),0);
	var lastClickedButton=0;
	var didPieceJustMove = new Boolean(false);

	// player names
	var player1Name = "Agustus";
	var player2Name = "x1372";

	// army IDs
	// 1 - classic
	// 2 - nemesis
	// 3 - empowered
	// 4 - reaper
	// 5 - warrior king
	// 6 - animal
	var whiteArmyID = 1 + Math.floor(Math.random()*(6)); 
	var blackArmyID = 1 + Math.floor(Math.random()*(6)); 


	// stone counts
	var whiteStoneCount = 3;
	var blackStoneCount = 3;

	// position and drawing related global variables
	// the board
	var boardXBase = 10;
	var boardYBase = 10;
	var boardSquareWidth=50;
	var boardSquareHeight=50;
	var boardSquareSize=50; // the size of the square
	var numberOfSquares=8;
	var boardSquareTotalWidth = boardSquareWidth * numberOfSquares;
	var boardSquareTotalHeight = boardSquareHeight * numberOfSquares;
	var boardSize = boardSquareSize * numberOfSquares;
	var borderThickness=10;
	// black square color from Sirlin's Chess 2 Rulebook
	var blackSquareColorString="#C6C6C6"
	// white square color from Sirlin's Chess 2 Rulebook
	var whiteSquareColorString="#FFFFFF"

	// the capture zone
	var captureZoneXBase = 430;
	var captureZoneYBase = 260;
	var captureZoneCellHeight = 20; 
	var captureZoneCellWidth = 20;
	var captureZoneWidth =  8*captureZoneCellWidth;
	var captureZoneHeight = 4*captureZoneCellHeight;

	var pixelOffset=1; // what is this parameter?
	var ten=10; // what is this parameter?
	var one=1; // the variable that stores the value one


	// dueling global variables
	// DUEL GLOBAL VARIABLES FLAGS
	// dueling state
	var duelState = 0;

	// 0 = white
	// 1 = black
	var duelingArmy=0;
	var dueledArmy=(duelingArmy + 1) % 2; 

	var whiteBet = 0;
	var blackBet = 0;

	// 0 = if duel starter wins
	// 1 = if duel starter loses or draws
	// 2 = if both bet 0
	var betComparison = 0;

	// did the duelingArmy bid a stone
	// to initiate the duel?
	var duelInitiationCost=0;

	// tracks whether the piece stays 
	// or is removed as a result of the duel
	var doesPieceStay=true;

	// colors of the duel
	var	duelStartColor="";
	var	dueledColor="";

	// bluff state
	var doSkipStateSix=false;

	// automaticDuelFlag for when defender has 
	// zero stones
	automaticDuelFlag=false;

	// dueling box dimensions
	var duelingZoneXBase=430;
	var duelingZoneYBase=80;
	var duelingZoneWidth=234;
	var duelingZoneHeight=160;

	// quick display
	var displayDuelingStates=true;
	var ddcw=duelingZoneWidth;
	var ddch=duelingZoneHeight;
	var bd=10;
	var ddcx=0 - ddcw;
	var ddcy=bd;


	// whirlwind zone
	var whirlwindZoneXBase = captureZoneXBase + captureZoneWidth + 2*borderThickness;
	var whirlwindZoneYBase = captureZoneYBase;
	var whirlwindZoneWidth = duelingZoneWidth - (captureZoneWidth + (2 * borderThickness));
	var whirlwindZoneHeight = captureZoneHeight;
	

	// button array
	var numberOfButtons = 20;
	var buttonArray = new Array(numberOfButtons);
	for (i=0; i<numberOfButtons; i++){
		buttonArray[i]=null;
	}
	
	// rgba() allows a transparency parameter
	// that allows for highlighting
	//this one lets it be partially transparent, used for highlighting
	var squareHighlightString = "rgba(0, 255, 0, 0.35)";  




	// debugging variables
	//
	// zones where debug text is placed
	// on the debugging canvas
	var dx1 = 10;
	var dy1 = 10;
	var dx2 = 130;
	var dy2 = 10;
	var dx3 = 210;
	var dy3 = 10;
	var dx4 = 10;
	var dy4 = 30;
	var dx5 = 10;
	var dy5 = 50;
	var dx6 = 200;
	var dy6 = 50;
	var dx7 = 400;
	var dy7 = 10;
	var dx8 = 400;
	var dy8 = 30;
	var dx9 = 400;
	var dy9 = 50;
	



	function rulesReference() {alert('Please read the rules.');}


	function incrementWhiteStoneCount() 
	{ if (whiteStoneCount < 6) whiteStoneCount++; drawStones(cxt);}
	function incrementBlackStoneCount() 
	{ if (blackStoneCount < 6) blackStoneCount++; drawStones(cxt); }
	function decrementWhiteStoneCount() 
	{ if (whiteStoneCount > 0) whiteStoneCount--; drawStones(cxt); }
	function decrementBlackStoneCount() 
	{ if (blackStoneCount > 0) blackStoneCount--; drawStones(cxt); }

	function decreaseWhiteStoneCountBy(decreaseByAmount) { 
		whiteStoneCount = whiteStoneCount - decreaseByAmount; 
		if (whiteStoneCount < 0) {
			whiteStoneCount=0;
		}
		drawStones(cxt);
	}
	function decreaseBlackStoneCountBy(decreaseByAmount) { 
		blackStoneCount = blackStoneCount - decreaseByAmount; 
		if (blackStoneCount < 0) {
			blackStoneCount=0;
		}
		drawStones(cxt);
	}


	//defining the 10x10 array that will determine the board
	//default will be null pieces for all values, and piece adding will be done with a different function

	var boardArray = new Array(10);
	for (i=0; i<10; i++){
		boardArray[i]=new Array(10);
	}
	
	for(var i=0;i<10;i++){
		for(var j=0;j<10;j++){	
			// default value for an empty square is a "null" piece
			boardArray[i][j]=new piece(0,0);
		}
	}
	
	// stores the capture zone
	// in an array
	var captureArray = new Array(8);
	for (i=0; i<8; i++){
		captureArray[i]=new Array(4);
	}
	
	for(var i=0;i<8;i++){
		for(var j=0;j<4;j++){	
			captureArray[i][j]=new piece(0,0);
		}
	}


	// END GLOBAL SECTION
	// ------------------*



// this is a piece object
// the id determines its original position, 
// and therefore the type of piece that it is;
// i.e. if the ID is 7, then from this table:
//
//
// 1 white rook   at a1    25 black rook   at a8
// 2 white knight at b1    26 black knight at b8
// 3 white bishop at c1    27 black bishop at c8
// 4 white queen  at d1    28 black queen  at d8
// 5 white king   at e1    29 black king   at e8
// 6 white bishop at f1    30 black bishop at f8
// 7 white knight at g1    31 black knight at g8
// 8 white rook   at h1    32 black rook   at h8
// 9-16 white pawns starting from a2 to h2
// 17-24 black pawns starting from a7 to h7
//
//
// it can be determined that piece is a 
// white bishop type. of course, the image
// of this type of piece will change
// depending on the army
// each piece object has a highlight value,
// which is set to "" by default; but if 
// set to a color string, the square it is on
// will be highlighted whenever the board is redrawn
function piece (positionID,pieceID) {
	this.positionID = positionID;
	this.pieceID = pieceID;
	this.image = getImageFromPieceID(this.pieceID);
	this.highlight=""
}




function pieceSet(whiteArmyID,blackArmyID) {
/*	
0 - empty square
1 - white classic pawn
2 - white classic knight
3 - white classic bishop
4 - white classic rook
5 - white classic queen
6 - white classic king
7 - black classic pawn
8 - black classic knight
9 - black classic bishop
10 - black classic rook
11 - black classic queen
12 - black classic king

13 - white nemesis pawn
14 - white nemesis knight
15 - white nemesis bishop
16 - white nemesis rook
17 - white nemesis queen
18 - white nemesis king
19 - black nemesis pawn
20 - black nemesis knight
21 - black nemesis bishop
22 - black nemesis rook
23 - black nemesis queen
24 - black nemesis king

25 - white empowered pawn
26 - white empowered knight
27 - white empowered bishop
28 - white empowered rook
29 - white empowered queen
30 - white empowered king
31 - black empowered pawn
32 - black empowered knight
33 - black empowered bishop
34 - black empowered rook
35 - black empowered queen
36 - black empowered king

37 - white reaper pawn
38 - white reaper knight
39 - white reaper bishop
40 - white reaper rook
41 - white reaper queen
42 - white reaper king
43 - black reaper pawn
44 - black reaper knight
45 - black reaper bishop
46 - black reaper rook
47 - black reaper queen
48 - black reaper king

49 - white warrior pawn
50 - white warrior knight
51 - white warrior bishop
52 - white warrior rook
53 - white warrior queen
54 - white warrior king
55 - black warrior pawn
56 - black warrior knight
57 - black warrior bishop
58 - black warrior rook
59 - black warrior queen
60 - black warrior king

61 - white animal pawn
62 - white animal knight
63 - white animal bishop
64 - white animal rook
65 - white animal queen
66 - white animal king
67 - black animal pawn
68 - black animal knight
69 - black animal bishop
70 - black animal rook
71 - black animal queen
72 - black animal king
etc.
*/
		// this value can be added to each piece
		// value to transform it to the next
		// army set
		var transformBase = 12;
		var whiteTransform = transformBase * (whiteArmyID - 1);
		var blackTransform = transformBase * (blackArmyID - 1);


		// start with CLASSIC values
		// then convert them to other 
		// army sets if necessary
		//
		// the first row
		boardArray[1][1]=new piece(1,4);
		boardArray[2][1]=new piece(2,2);
		boardArray[3][1]=new piece(3,3);
		boardArray[4][1]=new piece(4,5);
		boardArray[5][1]=new piece(5,6);
		boardArray[6][1]=new piece(6,3);
		boardArray[7][1]=new piece(7,2);
		boardArray[8][1]=new piece(8,4);

		// the second row of pawns
		for(var i=1;i<9;i++){
			boardArray[i][2]=new piece(i+8,1);
		}

		// black piece set
		// first row of black pieces
		boardArray[1][8]=new piece(25,10);
		boardArray[2][8]=new piece(26,8);
		boardArray[3][8]=new piece(27,9);
		boardArray[4][8]=new piece(28,11);
		boardArray[5][8]=new piece(29,12);
		boardArray[6][8]=new piece(30,9);
		boardArray[7][8]=new piece(31,8);
		boardArray[8][8]=new piece(32,10);

		// second row of black pawns
		for(var i=1;i<9;i++){
			boardArray[i][7]=new piece(i+16,7);
		}






		// the white army
		for (var i=1; i<9; i++){
			for (var j=1; j<3; j++){
				(boardArray[i][j]).pieceID+= whiteTransform;
				boardArray[i][j].image = getImageFromPieceID(boardArray[i][j].pieceID);
			}
		}


		// the black army
		for (var i=1; i<9; i++){
			for (var j=8; j>6; j--){
				(boardArray[i][j]).pieceID+= blackTransform;
				boardArray[i][j].image = getImageFromPieceID(boardArray[i][j].pieceID);
			}
		}

}	

// set the image directory
// images will be extracted to this directory 
// when the install file will be unzipped
var imageDir = "./images/";

// TODO: cite this code, because it 
// was gotten from somewhere else
//
// what is e here? answer: event
function getCursorPosition(e) {
    var x=0;
    var y=0;

	if (e.pageX || e.pageY) {
		x = e.pageX;
		y = e.pageY;
    } else {
		x = e.clientX + document.body.scrollLeft +
				document.documentElement.scrollLeft;
		y = e.clientY + document.body.scrollTop +
				document.documentElement.scrollTop;
    }

	//alert('x:'+x+'\ny:'+y);

    // Convert to coordinates relative to the canvas
    x -= c.offsetLeft;
    y -= c.offsetTop;

	// display for debugging
	//alert('x:'+x+'\ny:'+y);

	// I think the way to return is below, instead
	// of return [x,y]
	// you can access these variables by result.x and result.y;
	// see example for mousecoords variable
    //return [x,y]
	return {'x':x, 'y':y};
	//return {x:x, y:y};

	// found some other code that does the same thing, I think:
	/*
	return e.pageX ? {'x':e.pageX, 'y':e.pageY} : {'x':e.clientX + document.documentElement.scrollLeft + document.body.scrollLeft, 'y':e.clientY + document.documentElement.scrollTop + document.body.scrollTop}; 
*/

}


// not used now; 
// these extra functions should be used
function showMousePos(e)
{
	if (!e) e = event; // make sure we have a reference to the event
	var mp = getCursorPosition(e);
	x=mp.x;
	y=mp.y;
	// brings up an alert box
	alert('x:'+x+'\ny:'+y);
}

function init()
{
	// do x whenever the mouse moves
	//document.onmousemove = showMousePos;

	// do x whenever the mouse is clicked (pressed down)
	// this, for some reason, is case sensitive,
	// and needs to be all lower case, 
	// even though the documentations capitalize it
	//document.onMouseDown = showMousePos;
	//document.onmousedown = showMousePos;

	// do x whenever the mouse is released (pressed up)
	//document.onMouseUp = showMousePos;
	//document.onmouseup = showMousePos;
	//document.onmouseup = showMousePos;

	// SHOW YOUR MOVES!
	MLcxt.fillStyle = "#000000"
	MLcxt.fillText("SHOW ME YOUR MOVES!", 10, 10);

}


// this function is where canvasElement first gets defined
function initGame(canvasElement, moveCountElement) {
    if (!canvasElement) {
        canvasElement = document.createElement("canvas");
	canvasElement.id = "halma_canvas";
	document.body.appendChild(canvasElement);
    }
    if (!moveCountElement) {
        moveCountElement = document.createElement("p");
	document.body.appendChild(moveCountElement);
    }
    gCanvasElement = canvasElement;
    gCanvasElement.width = kPixelWidth;
    gCanvasElement.height = kPixelHeight;
    gCanvasElement.addEventListener("click", halmaOnClick, false);
    gMoveCountElem = moveCountElement;
    gDrawingContext = gCanvasElement.getContext("2d");
    if (!resumeGame()) {
	newGame();
    }
}



// function that draws the board
// this function is called whenever the board
// is updated after a move or anything else
function drawBoard() {
	for (var i=1;i<=8;i++) {
		//document.write("testing loop<br />");
		
		for (var j=1;j<=8;j++) {
			// k is the factor that determines 
			// if a square is white or black
			k=(i+j)%2;  
			l=boardXBase + (i-1)*boardSquareSize +0.5;
			m=boardYBase + (j-1)*boardSquareSize +0.5;
		   
			if (k==1) {
				// draw the black squares
				if (psych == true) {
					cxt.fillStyle=randomColorGenerator("HEX");
					cxt.fillRect(l,m,boardSquareSize - pixelOffset, boardSquareSize - pixelOffset);
				} else {
					cxt.fillStyle=blackSquareColorString;
					cxt.fillRect(l,m,boardSquareSize - pixelOffset, boardSquareSize - pixelOffset);
				}

			} else if (k==0) {
				// draw the white squares as well
				cxt.fillStyle=whiteSquareColorString;
				cxt.fillRect(l,m,boardSquareSize - pixelOffset, boardSquareSize - pixelOffset);
			}
		}
	}
}


// draw the capture zone
function drawCaptureZone() {
	var sy = captureZoneCellHeight;
	var sx = captureZoneCellWidth;
	for (var i=1;i<=8;i++) {
		//document.write("testing loop<br />");
		
		for (var j=1;j<=4;j++) {
			// k is the factor that determines 
			// if a square is one type or another
			k=(i+j)%2;  
			l=captureZoneXBase + (i-1)*sx +0.5;
			m=captureZoneYBase + (j-1)*sy +0.5;
		   
			if (k==1) {
				// draw one type square
				if (psych == true) {
					cxt.fillStyle=randomColorGenerator("HEX");
				} else {
					cxt.fillStyle="#CC0000";
				}
			} else if (k==0) {
				// draw the other type square
				if (psych == true) {
					cxt.fillStyle=randomColorGenerator("HEX");
				} else {
					cxt.fillStyle="#990000";
				}
			}
			cxt.fillRect(l,m,sx-1,sy-1);
		}
	}
}


// sets a piece in the capture zone
function putPieceInCaptureZone(piece) {
	// depending on the value of the piece, 
	// determine which piece it is, 
	// and draw the appropriate image
	// in the appropriate square

	var piecePositionI=0;
	var piecePositionJ=0;
	var arrayOffset = 1;

	// white major pieces
	if (piece.positionID < 9) {
		var piecePositionI=piece.positionID - arrayOffset;
		var piecePositionJ=4 - arrayOffset;
	// black major pieces
	} else if (piece.positionID > 24) {
		var piecePositionI=piece.positionID - 24 - arrayOffset;
		var piecePositionJ=1 - arrayOffset;
	// white pawns
	} else if (piece.positionID < 17){
		var piecePositionI=piece.positionID - 8 - arrayOffset;
		var piecePositionJ=3 - arrayOffset;
	// black pawns
	} else {
		var piecePositionI=piece.positionID - 16 - arrayOffset;
		var piecePositionJ=2 - arrayOffset;
	}

	// adjust piecePosition indices,
	// since the board array and the capture array 
	// start off at different indices
	// captureArray starts at (0,0) and ends at (7,3)
	//piecePositionI--;
	//piecePositionJ--;


	captureArray[piecePositionI][piecePositionJ] = piece;

	// reset highlight (don't think this is necessary)
	//piece.highlight = "";
	//alert('Piece ' + pieceValue + ' will be placed in capture zone \n at ' + piecePosition + ',' + colorOfPiece);

	debugMSG2("Piece "  + piece.pieceID + " captured into " + piecePositionI + "," + piecePositionJ, dx6,dy6,200);

	updateCaptureZone();
}





function updateCaptureZone () {
	var sx = captureZoneCellWidth;
	var sy = captureZoneCellHeight;

	// redraw the capture zone board
	drawCaptureZone();

	// draw the piece images on the capture zone,
	// as indicated by the captureArray

	var n;
	var m;

	// step through the captureArray and 
	// draw on each square
	for(var i=0;i<8;i++){
		for(var j=0;j<4;j++){	
			// set the coordinates
			n = captureZoneXBase + i*captureZoneCellWidth;
			m = captureZoneYBase + j*captureZoneCellHeight;
			//alert('n,m = ' + n + ',' + m);

			//document.write("<br>captureArray" + i + j + ": " + captureArray[i][j]);


			if (captureArray[i][j].pieceID == 0) {
				//alert('square=0');
				// do nothing if the square is empty
			} else {
				// draw the image of the piece
				cxt.drawImage((captureArray[i][j]).image,n,m,sx,sy);


				// if highlight is set, highlight the square
				if (captureArray[i][j].highlight != "") {
					cxt.fillStyle = captureArray[i][j].highlight;
					cxt.fillRect(n,m,sx,sy);
				}
			} 


		} // END FOR J
	} // END FOR I
}

// function that returns the image of a pieceID
function getImageFromPieceID(pieceID) {

			if (pieceID==0) {
				// do nothing if the square is empty
				return new Image();
			} else if (pieceID==1) {
				return whiteClassicPawn;
			} else if (pieceID==2) {
				return whiteClassicKnight;
			} else if (pieceID==3) {
				return whiteClassicBishop;
			} else if (pieceID==4) {
				return whiteClassicRook;
			} else if (pieceID==5) {
				return whiteClassicQueen;
			} else if (pieceID==6) {
				return whiteClassicKing;
			} else if (pieceID==7) {
				return blackClassicPawn;
			} else if (pieceID==8) {
				return blackClassicKnight;
			} else if (pieceID==9) {
				return blackClassicBishop;
			} else if (pieceID==10) {
				return blackClassicRook;
			} else if (pieceID==11) {
				return blackClassicQueen;
			} else if (pieceID==12) {
				return blackClassicKing;




			} else if (pieceID==13) {
				return whiteNemesisPawn;
			} else if (pieceID==14) {
				return whiteNemesisKnight;
			} else if (pieceID==15) {
				return whiteNemesisBishop;
			} else if (pieceID==16) {
				return whiteNemesisRook;
			} else if (pieceID==17) {
				return whiteNemesisQueen;
			} else if (pieceID==18) {
				return whiteNemesisKing;
			} else if (pieceID==19) {
				return blackNemesisPawn;
			} else if (pieceID==20) {
				return blackNemesisKnight;
			} else if (pieceID==21) {
				return blackNemesisBishop;
			} else if (pieceID==22) {
				return blackNemesisRook;
			} else if (pieceID==23) {
				return blackNemesisQueen;
			} else if (pieceID==24) {
				return blackNemesisKing;



			} else if (pieceID==25) {
				return whiteEmpoweredPawn;
			} else if (pieceID==26) {
				return whiteEmpoweredKnight;
			} else if (pieceID==27) {
				return whiteEmpoweredBishop;
			} else if (pieceID==28) {
				return whiteEmpoweredRook;
			} else if (pieceID==29) {
				return whiteEmpoweredQueen;
			} else if (pieceID==30) {
				return whiteEmpoweredKing;
			} else if (pieceID==31) {
				return blackEmpoweredPawn;
			} else if (pieceID==32) {
				return blackEmpoweredKnight;
			} else if (pieceID==33) {
				return blackEmpoweredBishop;
			} else if (pieceID==34) {
				return blackEmpoweredRook;
			} else if (pieceID==35) {
				return blackEmpoweredQueen;
			} else if (pieceID==36) {
				return blackEmpoweredKing;




			} else if (pieceID==37) {
				return whiteReaperPawn;
			} else if (pieceID==38) {
				return whiteReaperKnight;
			} else if (pieceID==39) {
				return whiteReaperBishop;
			} else if (pieceID==40) {
				return whiteReaperRook;
			} else if (pieceID==41) {
				return whiteReaperQueen;
			} else if (pieceID==42) {
				return whiteReaperKing;
			} else if (pieceID==43) {
				return blackReaperPawn;
			} else if (pieceID==44) {
				return blackReaperKnight;
			} else if (pieceID==45) {
				return blackReaperBishop;
			} else if (pieceID==46) {
				return blackReaperRook;
			} else if (pieceID==47) {
				return blackReaperQueen;
			} else if (pieceID==48) {
				return blackReaperKing;




			} else if (pieceID==49) {
				return whiteWarriorPawn;
			} else if (pieceID==50) {
				return whiteWarriorKnight;
			} else if (pieceID==51) {
				return whiteWarriorBishop;
			} else if (pieceID==52) {
				return whiteWarriorRook;
			} else if (pieceID==53) {
				return whiteWarriorQueen;
			} else if (pieceID==54) {
				return whiteWarriorKing;
			} else if (pieceID==55) {
				return blackWarriorPawn;
			} else if (pieceID==56) {
				return blackWarriorKnight;
			} else if (pieceID==57) {
				return blackWarriorBishop;
			} else if (pieceID==58) {
				return blackWarriorRook;
			} else if (pieceID==59) {
				return blackWarriorQueen;
			} else if (pieceID==60) {
				return blackWarriorKing;




			} else if (pieceID==61) {
				return whiteAnimalPawn;
			} else if (pieceID==62) {
				return whiteAnimalKnight;
			} else if (pieceID==63) {
				return whiteAnimalBishop;
			} else if (pieceID==64) {
				return whiteAnimalRook;
			} else if (pieceID==65) {
				return whiteAnimalQueen;
			} else if (pieceID==66) {
				return whiteAnimalKing;
			} else if (pieceID==67) {
				return blackAnimalPawn;
			} else if (pieceID==68) {
				return blackAnimalKnight;
			} else if (pieceID==69) {
				return blackAnimalBishop;
			} else if (pieceID==70) {
				return blackAnimalRook;
			} else if (pieceID==71) {
				return blackAnimalQueen;
			} else if (pieceID==72) {
				return blackAnimalKing;
			}

}

// function that returns a letter from algebraic notation 
// when given the column in numerical format
function getColumnLetter(x) {
	if (x == 1) return "a";
	if (x == 2) return "b";
	if (x == 3) return "c";
	if (x == 4) return "d";
	if (x == 5) return "e";
	if (x == 6) return "f";
	if (x == 7) return "g";
	if (x == 8) return "h";
}

// function that returns the notation of a pieceID
function getNotationFromPieceID(pieceID) {

			if (pieceID==0) {
				// do nothing if the square is empty
				return "";
			} else if (pieceID==1) {
				return "P";
			} else if (pieceID==2) {
				return "N";
			} else if (pieceID==3) {
				return "B";
			} else if (pieceID==4) {
				return "R";
			} else if (pieceID==5) {
				return "Q";
			} else if (pieceID==6) {
				return "K";
			} else if (pieceID==7) {
				return "P";
			} else if (pieceID==8) {
				return "N";
			} else if (pieceID==9) {
				return "B";
			} else if (pieceID==10) {
				return "R";
			} else if (pieceID==11) {
				return "Q";
			} else if (pieceID==12) {
				return "K";



			// NEMESIS
			} else if (pieceID==13) {
				return "A";
			} else if (pieceID==14) {
				return "N";
			} else if (pieceID==15) {
				return "B";
			} else if (pieceID==16) {
				return "R";
			} else if (pieceID==17) {
				return "M";
			} else if (pieceID==18) {
				return "K";
			} else if (pieceID==19) {
				return "A";
			} else if (pieceID==20) {
				return "N";
			} else if (pieceID==21) {
				return "B";
			} else if (pieceID==22) {
				return "R";
			} else if (pieceID==23) {
				return "M";
			} else if (pieceID==24) {
				return "K";



			} else if (pieceID==25) {
				return "P";
			} else if (pieceID==26) {
				return "N";
			} else if (pieceID==27) {
				return "B";
			} else if (pieceID==28) {
				return "R";
			} else if (pieceID==29) {
				return "I";
			} else if (pieceID==30) {
				return "K";
			} else if (pieceID==31) {
				return "P";
			} else if (pieceID==32) {
				return "N";
			} else if (pieceID==33) {
				return "B";
			} else if (pieceID==34) {
				return "R";
			} else if (pieceID==35) {
				return "I";
			} else if (pieceID==36) {
				return "K";




			} else if (pieceID==37) {
				return "P";
			} else if (pieceID==38) {
				return "N";
			} else if (pieceID==39) {
				return "B";
			} else if (pieceID==40) {
				return "G";
			} else if (pieceID==41) {
				return "C";
			} else if (pieceID==42) {
				return "K";
			} else if (pieceID==43) {
				return "P";
			} else if (pieceID==44) {
				return "N";
			} else if (pieceID==45) {
				return "B";
			} else if (pieceID==46) {
				return "G";
			} else if (pieceID==47) {
				return "C";
			} else if (pieceID==48) {
				return "K";




			} else if (pieceID==49) {
				return "P";
			} else if (pieceID==50) {
				return "N";
			} else if (pieceID==51) {
				return "B";
			} else if (pieceID==52) {
				return "R";
			} else if (pieceID==53) {
				return "W";
			} else if (pieceID==54) {
				return "W";
			} else if (pieceID==55) {
				return "P";
			} else if (pieceID==56) {
				return "N";
			} else if (pieceID==57) {
				return "B";
			} else if (pieceID==58) {
				return "R";
			} else if (pieceID==59) {
				return "W";
			} else if (pieceID==60) {
				return "W";




			} else if (pieceID==61) {
				return "P";
			} else if (pieceID==62) {
				return "Z";
			} else if (pieceID==63) {
				return "T";
			} else if (pieceID==64) {
				return "E";
			} else if (pieceID==65) {
				return "J";
			} else if (pieceID==66) {
				return "K";
			} else if (pieceID==67) {
				return "P";
			} else if (pieceID==68) {
				return "Z";
			} else if (pieceID==69) {
				return "T";
			} else if (pieceID==70) {
				return "E";
			} else if (pieceID==71) {
				return "J";
			} else if (pieceID==72) {
				return "K";
			}

			return pieceID;
}





// function that updates the board
function updateBoard() {

	// redraw the board background
	drawBoard();


	// draw the piece images on the board,
	// as indicated by the boardArray
	// see pieceSet() for map

	// step through the boardArray and 
	// draw on each square
	for(var i=0;i<10;i++){
		for(var j=0;j<10;j++){	
			// set the coordinates
			var n = boardXBase + (i-1)*boardSquareSize;
			var m = (boardYBase + (8*boardSquareSize - one*boardSquareSize)) - (j-1)*boardSquareSize;

			bsx = boardSquareWidth;
			bsy = boardSquareHeight;

			if (boardArray[i][j].pieceID == 0) {
				//alert('square=0');
				// do nothing if the square is empty
			} else {
				// draw the image of the piece
				cxt.drawImage((boardArray[i][j]).image,n,m,bsx,bsy);

				// draw empowerment graphics if applicable
				if ((boardArray[i][j]).pieceID == 26) {
					if (isFourAdjacentToPieceID(i,j,27) == true){
						//alert('Adjacent to a bishop!');
						cxt.drawImage(whiteBishopPower,n,m,bsx,bsy);
					}
					if (isFourAdjacentToPieceID(i,j,28) == true){
						//alert('Adjacent to a rook!');
						cxt.drawImage(whiteRookPower,n,m,bsx,bsy);
					}
				
				} else if (boardArray[i][j].pieceID==27) {
					if (isFourAdjacentToPieceID(i,j,26) == true){
						cxt.drawImage(whiteKnightPower,n,m,bsx,bsy);
					}
					if (isFourAdjacentToPieceID(i,j,28) == true){
						cxt.drawImage(whiteRookPower,n,m,bsx,bsy);
					}
				} else if (boardArray[i][j].pieceID==28) {
					if (isFourAdjacentToPieceID(i,j,26) == true){
						cxt.drawImage(whiteKnightPower,n,m,bsx,bsy);
					}
					if (isFourAdjacentToPieceID(i,j,27) == true){
						cxt.drawImage(whiteBishopPower,n,m,bsx,bsy);
					}
				} else if (boardArray[i][j].pieceID==32) {
					if (isFourAdjacentToPieceID(i,j,33) == true){
						cxt.drawImage(blackBishopPower,n,m,bsx,bsy);
					}
					if (isFourAdjacentToPieceID(i,j,34) == true){
						cxt.drawImage(blackRookPower,n,m,bsx,bsy);
					}
				} else if (boardArray[i][j].pieceID==33) {
					if (isFourAdjacentToPieceID(i,j,32) == true){
						cxt.drawImage(blackKnightPower,n,m,bsx,bsy);
					}
					if (isFourAdjacentToPieceID(i,j,34) == true){
						cxt.drawImage(blackRookPower,n,m,bsx,bsy);
					}
				} else if (boardArray[i][j].pieceID==34) {
					if (isFourAdjacentToPieceID(i,j,32) == true){
						cxt.drawImage(blackKnightPower,n,m,bsx,bsy);
					}
					if (isFourAdjacentToPieceID(i,j,33) == true){
						cxt.drawImage(blackBishopPower,n,m,bsx,bsy);
					}
				} 



				// if highlight is set, highlight the square
				if (boardArray[i][j].highlight != "") {
					cxt.fillStyle = boardArray[i][j].highlight;
					cxt.fillRect(n,m,boardSquareWidth,boardSquareHeight);
				}


			} // END IF PIECE

		} // END FOR J
	} // END FOR I


}



// gets the army name
function getArmyName(armyID) {
	if (armyID == 1) return "Classic"
	if (armyID == 2) return "Nemesis"
	if (armyID == 3) return "Empowered"
	if (armyID == 4) return "Reaper"
	if (armyID == 5) return "Warrior King"
	if (armyID == 6) return "Animal"
	else return "ERROR"
}

// empowerment checking functions
function isFourAdjacentToPieceID(i,j,pieceID) {
	//alert('Checking ('+n+','+m+')...');
	if (boardArray[i-1][j].pieceID == pieceID) return true;
	if (boardArray[i+1][j].pieceID == pieceID) return true;
	if (boardArray[i][j-1].pieceID == pieceID) return true;
	if (boardArray[i][j+1].pieceID == pieceID) return true;
	return false;
}

function togglePsych() {
	if (psych == true) {
		psych = false;
	} else {
		psych = true;
	}
	//drawOutlineRectangles(context,x,y,xht,yht,borderThickness)
	drawOutlineRectangles(cxt,boardXBase,boardYBase,boardSize,boardSize,borderThickness);
	drawCaptureZoneBorder(cxt); 
	drawDuelingZoneBorder(cxt);
	drawWhirlwindZoneBorder(cxt);

	clearDebugCanvas();

	updateBoard();
	updateCaptureZone();
	drawDuelingBox();

}

function clearDebugCanvas() {
	debuggingContext.fillStyle="#FFFFFF";
	debuggingContext.fillRect(0,0,520,60);	

}

// deletes a move from the move list
// does not really take back anything on the board
function takeBack () {

	ML.deleteMove();
	ML.printList(MLcxt);
}

// used for displaying warrior king moves better
function addBlankMove() {
	ML.addBlank("-----");
	ML.printList(MLcxt);

}

function toggleWhite() {
	whiteArmyID = (whiteArmyID % 6) + 1;

	for(var i=1;i<9;i++){
		for(var j=1;j<9;j++){	
			var currentSquareValue = boardArray[i][j].pieceID;
			// a piece is a value greater than 0
			if (currentSquareValue > 0) {
				// check if the piece is a white piece
				if ( (( (currentSquareValue - 1) % 12) + 1) < 7) {
					// transform the piece to 
					// the next army set by
					// adding twelve and moduloing 72
					boardArray[i][j].pieceID = ((currentSquareValue + 12 - 1) % 72) + 1; 
					boardArray[i][j].image = getImageFromPieceID(boardArray[i][j].pieceID);
					//alert('pieceID = ' + boardArray[i][j].pieceID);
				}
			}
		}
	}
	updateBoard();
	drawPlayerNames(cxt);
}
function toggleBlack() {
	blackArmyID = (blackArmyID % 6) + 1;

	for(var i=1;i<9;i++){
		for(var j=1;j<9;j++){	
			var currentSquareValue = boardArray[i][j].pieceID;
			// a piece is a value greater than 0
			if (currentSquareValue > 0) {
				// check if the piece is a black piece
				if ( (( (currentSquareValue - 1) % 12) + 1) > 6) {
					// transform the piece to 
					// the next army set by
					// adding twelve and moduloing 72
					boardArray[i][j].pieceID = ((currentSquareValue + 12 - 1) % 72) + 1; 
					boardArray[i][j].image = getImageFromPieceID(boardArray[i][j].pieceID);
				}
			}
		}
	}

	updateBoard();
	drawPlayerNames(cxt);
}

// must have clicked on a piece last
// piece must be a pawn
function promotePiece(clickedSquare) {

	newpieceID = clickedSquare.piece.pieceID;
	debugMSG2("pieceID is " + newpieceID, dx7,dy7, 100);
	debugMSG2("positionID is " + clickedSquare.piece.positionID, dx7,dy7, 100);
	armyID = Math.floor ((newpieceID+12) / 12);

	// 1 - white classic pawn
	// 2 - white classic knight
	// 3 - white classic bishop
	// 4 - white classic rook
	// 5 - white classic queen
	// 6 - white classic king
	// 7 - black classic pawn
	// 8 - black classic knight
	// 9 - black classic bishop
	// 10 - black classic rook
	// 11 - black classic queen
	// 12 - black classic king

	// ensure that the clicked piece is in
	// the boardArray, and not the capture zone
	if (clickedSquare.src == 2) {
		alert('Piece not on board! Cannot promote.');
	}
	// white or black pawns
	else if ( (clickedSquare.piece.positionID > 8 && clickedSquare.piece.positionID < 17) || 
	     (clickedSquare.piece.positionID > 16 && clickedSquare.piece.positionID < 25) ) {
	
		// get pieceID range 1-12
		newpieceID = ((newpieceID-1) % 12) + 1;

		// get pieceID black pawn or white pawn
		newpieceIDBase = newpieceID - (newpieceID % 6);
		newpieceID = newpieceID % 6;  

		// cycle 1-5
		newpieceID = (newpieceID % 5) + 1;

		// add pieceIDBase back
		newpieceID += newpieceIDBase;
			
		// add base to get final pieceID again	
		newpieceID	+= 12*(armyID-1);

		debugMSG2("IF LOOP", dx8,dy8,100);
		debugMSG2("piece promoted from " + clickedSquare.piece.pieceID + " to " + newpieceID, dx3, dy3,150);
		clickedSquare.piece.pieceID = newpieceID;

		// update piece image
		clickedSquare.piece.image = getImageFromPieceID(clickedSquare.piece.pieceID);

		// set new piece in boardArray
		boardArray[clickedSquare.x][clickedSquare.y] = clickedSquare.piece;

		debugMSG2("bA("+clickedSquare.x+","+clickedSquare.y+") set", dx8,dy8,100);


	} else {
		alert('Only original pawns can be promoted.');
	}

	// unhighlight piece and reset last clicked square
	unhighlightPiece(lastClickedSquare.piece);

	unclickSquare(clickedSquare);
	updateBoard();
}

function toggleImageSet() {

	if (imageSetToggler == 0) {
		setImages();
	} else {
		setImagesTrevor();
	}
	imageSetToggler = (imageSetToggler + 1) % 2;

	updateBoard();
	updateCaptureZone();
	drawDuelingBox();
	updateBoard();

}




function displayArmyIDs() {
	alert('whiteArmyID: ' + whiteArmyID + '\nblackArmyID: ' + blackArmyID);
}

/*
function printMoveList() {
	ML.printList(MLcxt);
}
//<button type="button" onclick="printMoveList()">Print Moves</button>
*/

//document.onmousemove=init; 
//document.onmousemove=toggleWhite; 


	//alert('script in head is done');
</script>
</head>



<body>
	
<!--          -->	
<!-- CANVASES -->	
<!--          -->	

<canvas id="myCanvas" width="674" height="420" style="border:2px solid #000000;">
Your browser does not support the canvas element.
</canvas>

<canvas id="moveListCanvas" width="200" height="420" style="border:2px solid #000000;">
Your browser does not support the canvas element.
</canvas>


<canvas id="debuggingCanvas" width="520" height="60" style="border:2px solid #000000;">
Your browser does not support the canvas element.
</canvas>

<!-- //         -->
<!-- // BUTTONS -->
<!-- //         -->

<br> <!-- start buttons to the left -->
<button type="button" onclick="toggleBlack()">Toggle Black</button>	
<button type="button" onclick="incrementBlackStoneCount()">B STN ++</button>
<button type="button" onclick="decrementBlackStoneCount()">B STN --</button>
<button type="button" onclick="promotePiece(lastClickedSquare)">Promote Piece</button> 
<button type="button" onclick="togglePsych()">Psych!</button>	
<br>
<button type="button" onclick="toggleWhite()">Toggle White</button> 
<button type="button" onclick="incrementWhiteStoneCount()">W STN ++</button> 
<button type="button" onclick="decrementWhiteStoneCount()">W STN --</button>
<button type="button" onclick="toggleImageSet()">Toggle Image Set</button>		
<br>
<!-- a few buttons for move list testing -->
<button type="button" onclick="takeBack()">Delete Move</button> 
<button type="button" onclick="addBlankMove()">Add Blank Move</button>



<!-- CANVAS -->
<!-- canvas for displaying a round of dueling states -->
<canvas id="duelingDisplayCanvas" width="900" height="900" style="border:2px solid #000000;">
Your browser does not support the canvas element.
</canvas>

<script type="text/javascript">


	//document.write("testing loop<br />");
	// get the context of the main canvases
	var c=document.getElementById("myCanvas");
	var cxt=c.getContext("2d");

	var debuggingCanvas=document.getElementById("debuggingCanvas");
	var debuggingContext=debuggingCanvas.getContext("2d");

	// for quick display
	var duelingDisplayCanvas=document.getElementById("duelingDisplayCanvas");
	var duelingDisplayContext=duelingDisplayCanvas.getContext("2d");

	// for displaying the move list
	var moveListCanvas=document.getElementById("moveListCanvas");
	var MLcxt=moveListCanvas.getContext("2d");

	function debugMSG2(msg, x, y, clearSize) {
		xclear = clearSize;
		yclear = 15;
		debuggingContext.fillStyle = "#FFFFFF";
		debuggingContext.fillRect(x-10,y-10,xclear,yclear);
		debuggingContext.fillStyle = "#000000";
		debuggingContext.fillText(msg, x, y);
	}

	function onCanvasClick(e) {
		getClickPosition(e);
		displayLastClickedSquare();

	}

	function onMM (e) {
			
		displayCursorPosition(e);

		if (psych == true ) {
			// psychedelic rectangle 1 and 2
			//psychedelicRectangleOne(debuggingContext,400,20,10,5,30,8);
			//psychedelicRectangleTwo(debuggingContext,200,10,40,40);
			//psychedelicRectangleTwo(debuggingContext,240,10,40,40);
			//psychedelicRectangleTwo(debuggingContext,280,10,40,40);
			//psychedelicRectangleTwo(debuggingContext,320,10,40,40);
			//psychedelicRectangleTwo(debuggingContext,360,10,40,40);


			//drawOutlineRectangles(context,x,y,xht,yht,borderThickness)
			drawOutlineRectangles(cxt,boardXBase,boardYBase,boardSize,boardSize,borderThickness);
			drawCaptureZoneBorder(cxt);
			drawDuelingZoneBorder(cxt);
			drawWhirlwindZoneBorder(cxt);

			updateBoard();
			updateCaptureZone();
			drawDuelingBox();
		}
	}

	// define events of the canvas here
	// make the canvas clickable
	c.onclick = onCanvasClick;
	c.onmouseover = onMM;
	c.onmousemove = onMM;
	//c.onclick = highlightSquare;



	// triages clicks in the dueling box
	function clickInDuelingBox(x,y) {

		// allow only one button to be clicked 
		// and acted upon; set this variable 
		// to true once any button has been
		// detected as clicked
		wasButtonClicked=false;
		buttonClicked=-1;

		// detect clicks in visible buttons
		for (var i=0; i<numberOfButtons; i++) {

			if (wasButtonClicked == false) {
				// DETECT CLICKS IN THE BUTTONS
				// if the button is set to visible, 
				// and the button state matches the current state,
				// then check the mouse coordinates
				if ( buttonArray[i] != null &&
						buttonArray[i].isVisible == 1 && 
						buttonArray[i].state == duelState) {

				
					if ( (x >= buttonArray[i].x && x < (buttonArray[i].x + buttonArray[i].width)) &&
							(y >= buttonArray[i].y && y < (buttonArray[i].y + buttonArray[i].height)) ) {

						debugMSG2("button["+i+"] clicked", dx1,dy1,125);
						wasButtonClicked=true;
						buttonClicked=i;
						lastClickedButton=i;
					
					}
				}
			}
		}

		//alert('BROKE AND I IS ' + buttonClicked)
		buttonArray[buttonClicked].doEvent();

		// update the dueling box after any button is clicked
		drawDuelingBox();


	} // END FUNCTION clickInDuelingBox()



// draws the dueling box
function drawDuelingBox() {

	if (displayDuelingStates == true) {
		//alert('drawing secondariesT');
	}

	stateFiveMSG1="";
	stateFiveMSG2="";
	stateFiveMSG3="";
	stateFiveMSG4="";
	stateFiveMSG5="";
	stateFiveMSG6="";
	stateFiveMSG7="";
	stateFiveMSG8="";	// stone count message
	stateFiveMSG9="";	// stone count message

	stateSixMSG1="";
	stateSixMSG2="";
	stateSixMSG3="";
	stateSixMSG4="";

	// STATE CHECKS
	// special conditions for visibility of certain buttons
	if (duelState == 0) {
		// reset some global variables
		doSkipStateSix=false;
		duelInitiationCost = 0;
		duelStartColor="";
		dueledColor="";

		ddcx=0 - ddcw;
		ddcy=bd;
	}
	if (duelState == 2) {
		// check if the player attempting to duel has no stones
		// you need stones to duel, so set the duel state to the 
		// error message state
		if ( ( duelingArmy == 0 && whiteStoneCount == 0 ) ||
			 ( duelingArmy == 1 && blackStoneCount == 0 ) ){
			// go to state 7
			setDuelState(7);
		}
	}
	if (duelState == 3) {
		// ZERO STONE AUTOMATION
		// whoever is the attacking army,
		// check if the OTHER army has zero stones,
		// if so, the attacking army automatically 
		// bids 1 stone, and the defender bids zero
		// and the state jumps to state 5
		if (duelingArmy == 0 && blackStoneCount == 0) {
			whiteBet = 1;
			blackBet = 0;
			automaticDuelFlag = true;
			setDuelState(5);
		
		} else if (duelingArmy == 1 && whiteStoneCount == 0) {
			whiteBet = 0;
			blackBet = 1;
			automaticDuelFlag = true;
			setDuelState(5);
		} else {
			if (whiteStoneCount == 0) {
				whiteBet = 0;
				setDuelState(4);
			} else if (whiteStoneCount == 1) {
				buttonArray[10].isVisible=0;
			}
		}
	}
	if (duelState == 4) {
		if (blackStoneCount == 0) {
			blackBet = 0;
			setDuelState(5);
		} else if (blackStoneCount == 1) {
			buttonArray[13].isVisible=0;
		}
	}
	if (duelState == 5) {
		// check for the case of whiteBet=0 and blackBet=0,
		// and trigger a state 6 skip flag if this is not the case
		if (blackBet != 0 || whiteBet != 0) {
			doSkipStateSix = true;
		} else {
			stateFiveMSG7="A BLUFF WAS CALLED!";
		}


		// compare whiteBet and blackBet,
		// and determine whether the duel starter bid
		// more than the dueled piece (?)

		// display the following messages:
		// [color] started the duel
		// [color] [did or did not] pay a stone to start the duel
		// white bid [whiteBet]
		// black bid [blackBet]
		// [duelingArmy] [did or did not] bid more stones than 
		//     [duel defender], so the defending piece
		//     [stays or is removed]
		// decrease whiteStoneCount by whiteBet
		// decrease blackStoneCount by blackBet
		// draw state 5 button
		//
		stateFiveMSG1="";
		if (duelingArmy == 0) {
			duelStartColor="White";
			dueledColor="Black";
		} else {
			duelStartColor="Black";
			dueledColor="White";
		}
		stateFiveMSG1=stateFiveMSG1 + duelStartColor + " started the duel.";


		stateFiveMSG2="";
		if (duelInitiationCost == 0) {
			stateFiveMSG2=stateFiveMSG2 + duelStartColor + " did not pay a stone to start the duel.";
		
		} else {
			stateFiveMSG2=stateFiveMSG2 + duelStartColor + " paid a stone to start the duel.";
		}

		stateFiveMSG3="";
		stateFiveMSG3=stateFiveMSG3 + "White bid " + whiteBet + " stones.";
		stateFiveMSG4="";
		stateFiveMSG4=stateFiveMSG4 + "Black bid " + blackBet + " stones.";


		stateFiveMSG5="";
		stateFiveMSG5=stateFiveMSG5 + duelStartColor;
		stateFiveMSG6="";
		didDuelStarterWin=0;
		if (duelingArmy == 0 && (whiteBet > blackBet)) {
			didDuelStarterWin=1;
		}
		if (duelingArmy == 1 && (blackBet > whiteBet)) {
			didDuelStarterWin=1;
		}
		if (didDuelStarterWin == 1) {
			stateFiveMSG5=stateFiveMSG5 + " bid more stones than " + dueledColor + ",";
		    stateFiveMSG6=stateFiveMSG6	+ "so the defending piece is REMOVED.";
			doesPieceStay=false;
		
		} else {
			stateFiveMSG5=stateFiveMSG5 + " did not bid more stones than " + dueledColor + ",";  
			stateFiveMSG6=stateFiveMSG6 + "so the defending piece STAYS.";
			doesPieceStay=true;
		}
		// ZERO STONE AUTOMATION
		if (automaticDuelFlag == true) {
		
			stateFiveMSG7 = "Duel was automatic because"; 
			stateFiveMSG8 = "defender had zero stones.";
		
		}

		decreaseWhiteStoneCountBy(whiteBet);
		decreaseBlackStoneCountBy(blackBet);

		// NOTATION
		moveString="D" + duelInitiationCost + ":" + whiteBet + "-" + blackBet;
		if (doesPieceStay == true) {
			moveString=moveString + "-STY";
		} else {
			moveString=moveString + "-RMV";
		}
		if (doSkipStateSix == true ) {
			ML.addDuelMove(moveString);
			ML.printList(MLcxt);
		}
	}
	if (duelState == 6) {
		// if state six skip flag is triggered, go to state 0
		if (doSkipStateSix == true) {
			doSkipStateSix = false;
			setDuelState(0);
			ddcx=0 - ddcw;
			ddcy=bd;

		} else {
		
			// display a message stating that the player 
			// who was dueled called a bluff
			stateSixMSG1=stateSixMSG1 + dueledColor + " called a bluff.";
			

			// display a message stating that the player
			// who was dueled may choose to gain a stone 
			// or make its attacker lose a stone
			stateSixMSG2=stateSixMSG2 + dueledColor + " may choose "; 
			stateSixMSG3=stateSixMSG3 + "to GAIN a stone,";
			stateSixMSG4=stateSixMSG4 + "or make " + duelStartColor + " LOSE a stone.";
		

		}
	
	}





	debugMSG2("duelState = " + duelState, dx4,dy4,75);
	
	// draw blank square for clean slate
	cxt.fillStyle = "#F8F8F8";
	cxt.fillRect(duelingZoneXBase,duelingZoneYBase,duelingZoneWidth,duelingZoneHeight);


	// DUEL STATE MESSAGES
	// draw text depending on state
	if (duelState == 0) {
		// reset duel flags
		automaticDuelFlag = false;
		writeDuelingPrompt(cxt,"Do you want to start a duel?",0); 
	} else if (duelState == 1) {
		writeDuelingPrompt(cxt,"Which army is starting",0); 
		writeDuelingPrompt(cxt,"the duel?",1); 
	} else if (duelState == 2) {
		writeDuelingPrompt(cxt,"Are you dueling a higher",0); 
		writeDuelingPrompt(cxt,"ranked piece?",1); 
		writeDuelingPrompt(cxt,"Pawn = 1",2); 
		writeDuelingPrompt(cxt,"Knight/Bishop = 2",3); 
		writeDuelingPrompt(cxt,"Rook = 3",4); 
		writeDuelingPrompt(cxt,"Queen = 4",5); 
		writeDuelingPrompt(cxt,"King = Cannot be dueled",6); 
	} else if (duelState == 3) {
		writeDuelingPrompt(cxt,"How many stones",0); 
		writeDuelingPrompt(cxt,"does white bid?",1); 
	} else if (duelState == 4) {
		writeDuelingPrompt(cxt,"How many stones",0); 
		writeDuelingPrompt(cxt,"does black bid?",1); 
	} else if (duelState == 5) {
		writeDuelingPrompt(cxt,stateFiveMSG1,0); 
		writeDuelingPrompt(cxt,stateFiveMSG2,1); 
		writeDuelingPrompt(cxt,stateFiveMSG3,2); 
		writeDuelingPrompt(cxt,stateFiveMSG4,3); 
		writeDuelingPrompt(cxt,stateFiveMSG5,4); 
		writeDuelingPrompt(cxt,stateFiveMSG6,5); 
		writeDuelingPrompt(cxt,stateFiveMSG7,6); 
		writeDuelingPrompt(cxt,stateFiveMSG8,7); 
		writeDuelingPrompt(cxt,"",8); 
	} else if (duelState == 6) {
		writeDuelingPrompt(cxt,stateSixMSG1,0); 
		writeDuelingPrompt(cxt,stateSixMSG2,1); 
		writeDuelingPrompt(cxt,stateSixMSG3,2); 
		writeDuelingPrompt(cxt,stateSixMSG4,3); 
	} else if (duelState == 7) {
		writeDuelingPrompt(cxt,"I AM ERROR.",0); 
		writeDuelingPrompt(cxt,"You will have zero stones",1); 
		writeDuelingPrompt(cxt,"at the start of this duel",2); 
		writeDuelingPrompt(cxt,"which disqualifies you",3); 
		writeDuelingPrompt(cxt,"from dueling.",4); 
	}



	// draw visible buttons
	for (var i=0; i<numberOfButtons; i++) {

		// DRAW THE BUTTONS
		// if the button is set to visible, draw the button
		if ( buttonArray[i] != null && 
				buttonArray[i].isVisible == 1 && 
				buttonArray[i].state == duelState) {
			if (psych == true) {
				cxt.strokeStyle = randomColorGenerator("HEX");
			} else {
				cxt.strokeStyle = "#000000"
			}
			cxt.strokeRect(buttonArray[i].x,buttonArray[i].y,buttonArray[i].width,buttonArray[i].height); 
			cxt.fillStyle = "#000000"
			cxt.fillText(buttonArray[i].text, (2 * buttonArray[i].x + buttonArray[i].width)/2- 15 , (2 * buttonArray[i].y + buttonArray[i].height)/2 );
			
		}

	}


















	// for debugging and displaying
	debugMSG2("lastClickedButton: " + lastClickedButton, dx9,dy9,125);
	// highlight the last clicked button from the previous state
		i = lastClickedButton; 
		duelingDisplayContext.fillStyle = "rgba(0, 255, 0, 0.35)";
		duelingDisplayContext.fillRect(buttonArray[i].x + ddcx - duelingZoneXBase,buttonArray[i].y + ddcy - duelingZoneYBase,buttonArray[i].width,buttonArray[i].height); 
	
	// shift screen
	bd=10;
	ddcx+=(ddcw+bd);
	if (ddcx + ddcw > 3*(ddcw+bd)) {
		ddcx = bd;
		ddcy+=(ddch+bd);
	}
	if (displayDuelingStates == true) {
		duelingDisplayContext.fillStyle = "#B0B0B0";
		duelingDisplayContext.fillRect(ddcx,ddcy,ddcw,ddch);

		// draw text depending on state
		if (duelState == 0) {
			displayDuelingPrompt(duelingDisplayContext,"Do you want to start a duel?",0, ddcx, ddcy); 
		} else if (duelState == 1) {
			displayDuelingPrompt(duelingDisplayContext,"Which army is starting",0, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"the duel?",1, ddcx, ddcy); 
		} else if (duelState == 2) {
			displayDuelingPrompt(duelingDisplayContext,"Are you dueling a higher",0, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"ranked piece?",1, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"Pawn = 1",2, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"Knight/Bishop = 2",3, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"Rook = 3",4, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"Queen = 4",5, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"King = Cannot be dueled",6, ddcx, ddcy); 
		} else if (duelState == 3) {
			displayDuelingPrompt(duelingDisplayContext,"How many stones",0, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"does white bid?",1, ddcx, ddcy); 
		} else if (duelState == 4) {
			displayDuelingPrompt(duelingDisplayContext,"How many stones",0, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,"does black bid?",1, ddcx, ddcy); 
		} else if (duelState == 5) {
			displayDuelingPrompt(duelingDisplayContext,stateFiveMSG1,0, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateFiveMSG2,1, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateFiveMSG3,2, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateFiveMSG4,3, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateFiveMSG5,4, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateFiveMSG6,5, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext," ",6, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext," ",7, ddcx, ddcy); 
		} else if (duelState == 6) {
			displayDuelingPrompt(duelingDisplayContext,stateSixMSG1,0, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateSixMSG2,1, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateSixMSG3,2, ddcx, ddcy); 
			displayDuelingPrompt(duelingDisplayContext,stateSixMSG4,3, ddcx, ddcy); 
		}



		// draw visible buttons
		for (var i=0; i < numberOfButtons; i++) {

			// DRAW THE BUTTONS
			// if the button is set to visible, draw the button
			if ( buttonArray[i] != null &&
					buttonArray[i].isVisible == 1 && 
					buttonArray[i].state == duelState) {
				duelingDisplayContext.strokeStyle = "#000000"
				duelingDisplayContext.strokeRect(buttonArray[i].x + ddcx - duelingZoneXBase,buttonArray[i].y + ddcy - duelingZoneYBase,buttonArray[i].width,buttonArray[i].height); 
				duelingDisplayContext.fillStyle = "#000000"
				duelingDisplayContext.fillText(buttonArray[i].text, (2 * (ddcx + buttonArray[i].x - duelingZoneXBase) + buttonArray[i].width)/2- 15 , (2 * (ddcy + buttonArray[i].y - duelingZoneYBase) + buttonArray[i].height)/2 );
				
			}
		}

		//alert('x,y=' + ddcx + ',' + ddcy);

	} // END IF DISPLAYDUELINGSTATES

	//alert('end of trying to display');


} // END FUNCTION drawDuelingBox()







function displayCursorPosition(e) {
	var mousecoords;

	// get the mouse coordinates of the click
	mousecoords = getCursorPosition(e);
	x=mousecoords.x;
	y=mousecoords.y;		

	// display the mouse coordinates in the debugging canvas
	debuggingContext.fillStyle = "#FFFFFF";
	debuggingContext.fillRect(100,30 - 12,100,20);
	debuggingContext.fillStyle = "#000000";
	debuggingContext.fillText("(" + x + "," + y + ")", 100, 30);

}







function getClickPosition(e) {

	var x;
	var y;
	var mousecoords;

	// get the mouse coordinates of the click
		mousecoords = getCursorPosition(e);
		x=mousecoords.x;
		y=mousecoords.y;		
		//alert('x:'+x+'\ny:'+y);
		
		// figure out which section of the screen was clicked
		//duel area is (430, 80) to (590, 240) 160x160 pixels
		if (x>=duelingZoneXBase && x<= duelingZoneXBase + duelingZoneWidth){
			if (y>=duelingZoneYBase && y<=duelingZoneYBase + duelingZoneHeight){
				//drawDuelingBox();
				clickInDuelingBox(x,y);
			}
		}


		// determines if clicks are on the board
		if (x>=boardXBase && x<= boardXBase + boardSize){
			if (y>=boardYBase && y<=boardYBase + boardSize){
				highlightSquare(x,y);
			}
		}

		// determines if clicks are on the capture zone
		if (x>=captureZoneXBase && x<= captureZoneXBase + captureZoneWidth){
			if (y>=captureZoneYBase && y<=captureZoneYBase + captureZoneHeight){
				clickInCaptureZone(x,y);
			}
		}



	} // END FUNCTION getClickPosition

// functions on squares of the board
function resetSquareOnBoard(i,j) {
	boardArray[i][j] = new piece(0,0);
}
function resetClickedSquare(clickedSquare) {
	clickedSquare.x = 0;
	clickedSquare.y = 0;
	clickedSquare.piece = new piece(0,0);
	clickedSquare.src = 0;
}
function unclickSquare(clickedSquare) {
	//unhighlightPiece(clickedSquare.piece);
	unhighlightSquare(clickedSquare);
	clickedSquare.src = 0;
}
function removePieceFromBoard(clickedSquare) {
	boardArray[clickedSquare.x][clickedSquare.y] = new piece(0,0);
}
function removePieceFromCaptureArray(clickedSquare) {
	captureArray[clickedSquare.x][clickedSquare.y] = new piece(0,0);
}
function unhighlightPiece(piece) {
	piece.highlight = "";
}
function unhighlightSquare(square) {

	if (square.piece.pieceID > 0) {
		piece.highlight = "";
	} 
	// else do nothing
}


	// this function processes clicks in the capture zone
	// the following uses should be supported:
	// 
	// PUTTING A PIECE BACK ON THE BOARD
	// a piece in the capture zone can be clicked, 
	// and then a following click on the board will
	// should place that piece on the board
	// 
	// REMOVING A PIECE FROM THE BOARD
	// clicking first on a piece on the board,
	// and then clicking on a square on the capture zone
	// should remove the piece from the board
	
	function clickInCaptureZone(x,y) {
		// figure out which capture square the cursor is in
		rawxcol= Math.floor( (x - captureZoneXBase)/captureZoneCellWidth + one );
		rawycol= Math.floor( (y - captureZoneYBase)/captureZoneCellHeight + one );
		
		// get the upper left coordinate of that box
		//xht = (xcol*captureZoneCellWidth) +ten - captureZoneCellWidth;
		//yht = (ycol*captureZoneCellHeight) +ten - captureZoneCellHeight;
		xht = (rawxcol*captureZoneCellWidth)  - captureZoneCellWidth;
		yht = (rawycol*captureZoneCellHeight) - captureZoneCellHeight;

		xcol = rawxcol - 1;
		ycol = rawycol - 1;
		debugMSG2("captureArray (" + xcol + "," + ycol + "): ", dx1, dy1,125);
		debugMSG2("captureArray (" + xcol + "," + ycol + "): " + captureArray[xcol][ycol].pieceID, dx1, dy1,125);
		debugMSG2("ULCOORD=" + xht + "," + yht + "-->" + xcol + "," + ycol, dx2,dy2,125);

		// check if click was on the 8x8 board
		// ensure that only squares get highlighted
		if (xcol >= 0 && xcol <= 7) {
			if (ycol >= 0 && ycol <= 3) {
				// updating pieces and movement
				//
				//
				// state-action table:
				// LAST CLICK:
				// 0-no last click/reset clicked square
				// 1-last click on boardArray was piece
				// 2-last click on boardArray was empty
				// 3-last click on captureArray was piece
				// 4-last click on captureArray was empty
				// *to differentiate last click types,
				// lastClickedSquare.src is 
				//           0 if reset,
				//           1 if from boardArray,
				// and is is 2 if from captureArray,
				//
				// CURRENT CLICK:
				// 5-current click on captureArray was piece
				// 6-current click on captureArray was empty
				//
				// ACTIONS depend on the above two conditions:
				// 0   - update last clicked square
				// 1,5 - piece on board gets placed in capture zone
				//       IN THE APPROPRIATE LOCATION (not where current click is)
				//       unhighlight piece in capture zone
				//       reset last square clicked
				// 1,6 - same as 1,5
				// 2,5 - highlight capture zone square. update last clicked square.
				// 2,6 - do nothing. update last clicked square
				// 3,5 - highlight new captured piece and unhighlight previous. 
				//       update last clicked square. 
				//       if same piece is clicked, unhighlight the piece 
				//       and reset last clicked.
				// 3,6 - unhighlight captured piece. reset last clicked square.
				// 4,5 - highlight captureArray piece. update last clicked square.
				// 4,6 - do nothing. reset last clicked square
				//


				// case 0 (lastClickedSquare does not exist/has been reset)
				if ( lastClickedSquare.src == 0 ) {

						// update last clicked square
						lastClickedSquare.x = xcol;
						lastClickedSquare.y = ycol;
						lastClickedSquare.piece = captureArray[xcol][ycol];
						displayLastClickedSquare();
						lastClickedSquare.src = 2;


				}


				// cases 1,5 and 1,6 above:
				else if (lastClickedSquare.piece.pieceID > 0 &&
					lastClickedSquare.src == 1 ) {
					
					var li = lastClickedSquare.x;
					var lj = lastClickedSquare.y;

					// unhighlight piece
					boardArray[li][lj].highlight = "";

					// put the piece in the capture zone
					putPieceInCaptureZone(boardArray[li][lj]);

					// reset square on board
					resetSquareOnBoard(li,lj);

					// reset last square clicked
					resetClickedSquare(lastClickedSquare);

				}



				// cases 2,5 and 2,6 above
				// also  4,5 and 4,6 above
				// which have the same outcomes
				// (2,5 ~ 4,5; and 2,6 ~ 4,6):
				else if ( lastClickedSquare.src > 0 &&
					lastClickedSquare.piece.pieceID == 0) {
					// square is empty

					// if clicked on captured piece
					if (captureArray[xcol][ycol].pieceID > 0) {
						// highlight capture square/piece
						captureArray[xcol][ycol].highlight = randomColorGenerator("RGBA");

						// update last clicked square
						lastClickedSquare.x = xcol;
						lastClickedSquare.y = ycol;
						//lastClickedSquare.piece = captureArray[xcol][5 - ycol];
						lastClickedSquare.piece = captureArray[xcol][ycol];
						displayLastClickedSquare();
						lastClickedSquare.src = 2;



					// else if clicked on empty capture square
					} else {
						resetClickedSquare(lastClickedSquare);
					}


				// cases 3,5 and 3,6 above:
				// 3-last click on captureArray was piece
				} else if ( lastClickedSquare.src == 2 &&
						lastClickedSquare.piece.pieceID > 0) {

					// if clicked on captured piece
					// 3,5 - highlight new captured piece and unhighlight previous. 
					//       update last clicked square. 
					//       if same piece is clicked, unhighlight the piece 
					//       and reset last clicked.
					if (captureArray[xcol][ycol].pieceID > 0) {

						// highlight new captured piece
						captureArray[xcol][ycol].highlight = randomColorGenerator("RGBA");

						// unhighlight previous piece
						lastClickedSquare.piece.highlight = "";

						// if same piece was clicked twice
						if (captureArray[xcol][ycol].positionID == lastClickedSquare.piece.positionID) {
							// piece is already unhighlighted from above code

							// reset last clicked square
							resetClickedSquare(lastClickedSquare);



						} else {
						
							// update last clicked square
							lastClickedSquare.x = xcol;
							lastClickedSquare.y = ycol;
							//lastClickedSquare.piece = captureArray[xcol][5 - ycol];
							lastClickedSquare.piece = captureArray[xcol][ycol];
							lastClickedSquare.src = 2;

						
						}

					




					// else if clicked on empty captured square
					// 3,6 - unhighlight captured piece. reset last clicked square.
					} else {

						// unhighlight previous piece
						lastClickedSquare.piece.highlight = "";


						// reset last clicked square
						resetClickedSquare(lastClickedSquare);
				
					}
				}

				// redraw the board to
				// clear previous highlights
				// and update moves
				updateBoard();
				updateCaptureZone();


			} // END IF YCOL
		} // END IF XCOL


	
		debugMSG2("last-clicked-square: (" + x + "," + y + "): " + getPieceNameFromPiece(lastClickedSquare.piece), dx5,dy5,125 );
	} // END function clickInCaptureZone
	












	function highlightSquare(x,y) {
		//alert('LAWL');

		debugMSG2("highlightSquare()", dx1,dy1,125);

		// TODO: change functions to make them work
		// with adjustable board sizes

		//figuring out which box the cursor is in
		xcol= (x-ten)/boardSquareSize + one;
		ycol= (y-ten)/boardSquareSize + one;
		
		xcol= Math.floor(xcol);
		ycol= Math.floor(ycol);
		
		//getting the upper left coordinate of that box
		xht = (xcol*boardSquareSize)+ten -boardSquareSize;
		yht = (ycol*boardSquareSize)+ten -boardSquareSize;

		// check if click was on the 8x8 board
		// ensure that only squares get highlighted





		// updating pieces and movement
		//
		//
		// state-action table:
		// LAST CLICK:
		// 0-starting condition
		// 1-last click on boardArray was piece
		// 2-last click on boardArray was empty
		// 3-last click on captureArray was piece
		// 4-last click on captureArray was empty
		// *to differentiate last click types,
		// lastClickedSquare.src is 
		//           0 if reset,
		//           1 if from boardArray,
		// and is is 2 if from captureArray,
		//
		// CURRENT CLICK:
		// 5-current click on boardArray is piece
		// 6-current click on boardArray is empty
		//
		// ACTIONS depend on the above two conditions:
		// 0,5 and 0,6: same as 2,5 and 2,6 and 4,5 and 4,6
		// 1-last click on boardArray was piece
		// 5-current click on boardArray is piece
		// 1,5 - two pieces have been clicked. 
		//       second piece on board gets placed in capture zone
		//       first piece on board gets moved to the second square clicked
		//       reset last square clicked
		//       *if same square is clicked twice: 
		//           unhighlight square, reset last clicked square
		//
		// 1,6 - move the last clicked piece to current square
		//       unhighlight piece
		//		 reset last clicked square
		//
		// 2,5 - highlight new square clicked
		//       update last clicked square
		//       
		// 2,6 - highlight new square clicked
		//       update last clicked square
		//
		// 3,5 - last click was captureArray piece and current click is boardArrayPiece
		//       put boardArray piece in capture zone
		//       put captureArray piece in current clicked square
		//       reset last clicked square
		//
		// 3,6 - last click was captureArray piece and current click is boardArray empty
		//       put captureZone piece into boardArray
		//       unhighlight piece in captureArray
		//       remove captureZone piece from captureArray
		//       reset last square clicked
		//
		//       
		// 4,5 - last click is captureArray empty, and boardArray piece is clicked
		//       update last square clicked
		//
		// 4,6 - last click is captureArray empty, and boardArray empty is clicked
		//       update last square clicked
				



		if (xcol >= 1 && xcol <= 8) {
			if (ycol >= 1 && ycol <= 8) {

				// starting condition
				if ( lastClickedSquare.src == 0 ) {

					boardArray[xcol][9 - ycol].highlight=squareHighlightString;
					lastClickedSquare.x = xcol;
					lastClickedSquare.y = 9-ycol;
					//alert('x = ' + xcol + ' and y = ' + (9 - ycol));
					lastClickedSquare.piece = boardArray[xcol][9 - ycol];
					lastClickedSquare.src = 1;
				}




				// 1-last click on boardArray was piece
				// 5-current click on boardArray is piece
				// 1,5 - two pieces have been clicked. 
				//       second piece on board gets placed in capture zone
				//       first piece on board gets moved to the second square clicked
				//       remove first piece from last square
				//       reset last square clicked
				//       *if same square is clicked twice: 
				//           unhighlight square, reset last clicked square
				//
				else if (lastClickedSquare.piece.pieceID > 0 &&
						lastClickedSquare.src == 1) {

					if (boardArray[xcol][9 - ycol].pieceID > 0 ) {



						// *if same square is clicked twice: 
						// unhighlight square, reset last clicked square
						if (boardArray[xcol][9 - ycol].positionID == lastClickedSquare.piece.positionID) {
							boardArray[xcol][9 - ycol].highlight = "";
							resetClickedSquare(lastClickedSquare);



						} else {
							// MOVE COMPLETED
							
							moveString=getNotationFromPieceID(lastClickedSquare.piece.pieceID) + " "; 
							moveString=moveString + getColumnLetter(lastClickedSquare.x) + lastClickedSquare.y + "x";
							moveString=moveString + getNotationFromPieceID(boardArray[xcol][9-ycol].pieceID)
							moveString=moveString + getColumnLetter(xcol) + (9-ycol); 



							// second piece on board gets placed in capture zone
							putPieceInCaptureZone(boardArray[xcol][9 - ycol]);
							// first piece on board gets moved to the second square clicked
							boardArray[xcol][9 - ycol] = lastClickedSquare.piece;







							// remove first piece from last square
							removePieceFromBoard(lastClickedSquare);
		
							// reset last square clicked
							resetClickedSquare(lastClickedSquare);


							// unhighlight square
							boardArray[xcol][9 - ycol].highlight = "";
						
							// write the notation to the screen
							ML.addMove(moveString);
							ML.printList(MLcxt);

						}

					
					
					// 6-current click on boardArray is empty
					// 1,6 - move the last clicked piece to current square
					// 		 remove piece from previous board square
					//       unhighlight piece
					//		 reset last clicked square
					} else if (boardArray[xcol][9 - ycol].pieceID == 0) {
						// MOVE COMPLETED
						// NOTATION
						moveString=getNotationFromPieceID(lastClickedSquare.piece.pieceID) + " "; 
						moveString=moveString + getColumnLetter(lastClickedSquare.x) + lastClickedSquare.y + "-";
					    moveString=moveString + getColumnLetter(xcol) + (9-ycol); 




						// MOVEMENT
						boardArray[xcol][9 - ycol] = lastClickedSquare.piece;
						boardArray[xcol][9 - ycol].highlight = "";
						removePieceFromBoard(lastClickedSquare);
						resetClickedSquare(lastClickedSquare);



						// print notation to screen
						ML.addMove(moveString);
						ML.printList(MLcxt);

					}
				} // END 1,5 and 1,6
			







				// 2-last click on boardArray was empty
				// 5-current click on boardArray is piece
				// 6-current click on boardArray is empty
				// 2,5 - highlight new square clicked
				//       update last clicked square
				//       
				// 2,6 - highlight new square clicked
				//       update last clicked square
				//
				// 2,5 and 2,6 outcomes are the same
				//
				else if (lastClickedSquare.piece.pieceID == 0 &&
						lastClickedSquare.src == 1) {

					boardArray[xcol][9 - ycol].highlight=squareHighlightString;
					lastClickedSquare.x = xcol;
					lastClickedSquare.y = 9-ycol;
					lastClickedSquare.piece = boardArray[xcol][9 - ycol];
					lastClickedSquare.src = 1;

					//if (boardArray[xcol][9 - ycol].pieceID > 0 ) {
					//}
					//else if (boardArray[xcol][9 - ycol].pieceID == 0) {
					//}
				}









				// 3-last click on captureArray was piece
				// 5-current click on boardArray is piece
				// 6-current click on boardArray is empty
				// 3,5 - last click was captureArray piece and current click is boardArrayPiece
				//       put boardArray piece in capture zone
				//       put captureArray piece in current clicked square
				//       reset last clicked square
				//
				// 3,6 - last click was captureArray piece and current click is boardArray empty
				//       put captureZone piece into boardArray
				//       remove captureZone piece from captureArray
				//       reset last square clicked
				//

				// 3-last click on captureArray was piece
				else if (lastClickedSquare.piece.pieceID > 0 &&
						lastClickedSquare.src == 2) {

					// 3,5 - last click was captureArray piece and current click is boardArrayPiece
					//       put boardArray piece in capture zone
					//       put captureArray piece in current clicked square
					//       remove captureZone piece from captureArray
					//       reset last clicked square
					//
					if (boardArray[xcol][9 - ycol].pieceID > 0 ) {

						putPieceInCaptureZone(boardArray[xcol][9 - ycol]);
						boardArray[xcol][9 - ycol] = lastClickedSquare.piece;

						//remove captureZone piece from captureArray
						removePieceFromCaptureArray(lastClickedSquare);

						resetClickedSquare(lastClickedSquare);

					}





					// 3,6 - last click was captureArray piece and current click is boardArray empty
					//       put captureZone piece into boardArray
					//       unhighlight piece in captureArray
					//       remove captureZone piece from captureArray
					//       reset last square clicked
					else if (boardArray[xcol][9 - ycol].pieceID == 0) {
						boardArray[xcol][9 - ycol] = lastClickedSquare.piece;

						// unhighlight piece
						unhighlightPiece(lastClickedSquare.piece);

						//remove captureZone piece from captureArray
						removePieceFromCaptureArray(lastClickedSquare);

						// reset last square clicked
						resetClickedSquare(lastClickedSquare);

					}
				}










				// 4-last click on captureArray was empty
				// 5-current click on boardArray is piece
				// 6-current click on boardArray is empty
				// 4,5 - last click is captureArray empty, and boardArray piece is clicked
				//		 highlight last square clicked
				//       update last square clicked
				//
				// 4,6 - last click is captureArray empty, and boardArray empty is clicked
				//		 highlight last square clicked
				//       update last square clicked
				//
				// 4,5 and 4,6 have the same outcomes
						

				else if (lastClickedSquare.piece.pieceID == 0 &&
						lastClickedSquare.src == 2) {

					boardArray[xcol][9 - ycol].highlight=squareHighlightString;
					lastClickedSquare.x = xcol;
					lastClickedSquare.y = 9-ycol;
					lastClickedSquare.piece = boardArray[xcol][9 - ycol];
					lastClickedSquare.src = 1;



					//if (boardArray[xcol][9 - ycol].pieceID > 0 ) {
					//}
					//else if (boardArray[xcol][9 - ycol].pieceID == 0) {
					//}
				}


				

				/*
				// if the last square clicked has 
				// a piece on it, 
				// AND the current click is not the
				// same square, then do the following:
				if (lastClickedSquare.piece.pieceID > 0 &&
						!(xcol == lastClickedSquare.x  
						 && ycol ==lastClickedSquare.y  )
						) {
					// if a piece already exists in the destination,
					// then this piece is captured, and is placed in the 
					// capture zone
					if (boardArray[xcol][9 - ycol].pieceID > 0) {
						putPieceInCaptureZone(boardArray[xcol][9-ycol]);

					}
					boardArray[xcol][9 - ycol] = lastClickedSquare.piece;

					// and also remove the piece from the old position
					boardArray[lastClickedSquare.x][9 - lastClickedSquare.y] = new piece(0,0);
					// if a piece is moved, then set the last clicked square
					// to zero, otherwise you have the GOD PIECE problem
					lastClickedSquare.piece = new piece(0,0);
					lastClickedSquare.src = 0;

					didPieceJustMove = true;
					//startDuel();
				
				}

				// removing highlight/unselecting a piece
				// if the square has a piece,
				// and it is the same square that was 
				// clicked previously,
				// then unhighlight the square
				if (lastClickedSquare.piece.pieceID > 0 &&
						(xcol == lastClickedSquare.x  
						 && ycol ==lastClickedSquare.y  )
						) {

					// set the last clicked square to zero
					lastClickedSquare.piece = new piece(0,0);
					lastClickedSquare.src = 0;

					didPieceJustMove = true;
				
				}


				// store the last square clicked
				if (didPieceJustMove == false) {
					lastClickedSquare.x = xcol;
					lastClickedSquare.y = ycol;
					lastClickedSquare.piece = boardArray[xcol][9 - ycol];
					lastClickedSquare.src = 1;
				}
				didPieceJustMove = false;
				*/






				// redraw the board to
				// clear previous highlights
				// and update moves
				updateBoard();
				updateCaptureZone();

			} // END IF YCOL
		} // END IF XCOL




		//putting a document write here removes the canvas 
		//document.write("testing click<br />" + xcol + "<br />" + ycol);

	} // END FUNCTION HIGHLIGHTSQUARE

function displayLastClickedSquare() {
	x=lastClickedSquare.x; 
	y=lastClickedSquare.y; 

	debugMSG2("last-clicked-square: (" + x + "," + y + "): " + getPieceNameFromPiece(lastClickedSquare.piece), dx5,dy5,300 );
}

function getPieceNameFromPiece(piece) {
	if (piece.pieceID > 0) {
		pieceFileName=piece.image.src.split("/"); 
		pieceName=pieceFileName[pieceFileName.length - 1];
	} else {
		pieceName="empty";
	}
	return pieceName;
}

// draws player names on the right side of screen
function drawPlayerNames(context) {
	var x = 425;
	var y1 = 25;
	var y2 = 395;

	// draw a white rectangle first
	// this serves to clear any previous names
	context.fillStyle = "#FFFFFF";
	context.fillRect(x,y1-10,200,20);
	context.fillRect(x,y2-10,200,20);

	// draw the player names and what army is chosen
	context.fillStyle = "#000000";
	context.fillText(player1Name + " is " + getArmyName(whiteArmyID), x,y2);
	context.fillText(player2Name + " is " + getArmyName(blackArmyID), x,y1);


}

// draws stones
function drawStones(context) {
	var x = 425;
	var y1 = 50;
	var y2 = 370;

	// draw a white rectangle first
	// this serves to clear any previous names
	context.fillStyle = "#FFFFFF";
	context.fillRect(x,y1-10,200,20);
	context.fillRect(x,y2-10,200,20);

	// draw the stones
	context.fillStyle = "#000000";
	context.fillText("Stones: " + whiteStoneCount, x,y2);
	context.fillText("Stones: " + blackStoneCount, x,y1);

	// TODO
	// draw in stone images randomly from images 1 to 5 (stone[1-5].png)
	textOffset = 15;
	xposition = x+50;
	stoneScale = 20;
	y = y2 - textOffset;
	for (var s=0; s < whiteStoneCount; s++) {
		randomnumber=Math.floor(Math.random()*(5));
		context.drawImage(stoneArray[randomnumber],xposition,y,stoneScale,stoneScale);
		xposition +=stoneScale; 

	}

	xposition = x+50;
	stoneScale = 20;
	y = y1 - textOffset;
	for (var s=0; s < blackStoneCount; s++) {
		randomnumber=Math.floor(Math.random()*(5));
		context.drawImage(stoneArray[randomnumber],xposition,y,stoneScale,stoneScale);
		xposition +=stoneScale; 
	}


}



// draws the outline rectangles
function drawOutlineRectangles(context,x,y,xht,yht,borderThickness) {

	// draws 4 outline rectangles
	// around a box starting at x,y
	// and xht x yht in dimension


	//var borderThickness=10;

	// top left border start
	var borderXBase=x - borderThickness;
	var borderYBase=y - borderThickness;

	var halfPixelOffset=0.5;
	var pixelOffset=1;

	if (psych == true) {
		context.fillStyle=randomColorGenerator("HEX");
	} else {
		context.fillStyle="#966F33";
	}
	leftBorderXStart = borderXBase + halfPixelOffset; 
	leftBorderYStart = borderYBase + halfPixelOffset;
	leftBorderWidth = borderThickness - pixelOffset;
	leftBorderHeight = yht + (2 * borderThickness) - pixelOffset;
	context.fillRect(leftBorderXStart,leftBorderYStart,leftBorderWidth,leftBorderHeight);

	topBorderXStart = leftBorderXStart;
	topBorderYStart = leftBorderYStart;
	topBorderWidth = xht + (2 * borderThickness) - pixelOffset; 
	topBorderHeight = borderThickness - pixelOffset;
	//context.fillStyle="#00b0b0";
	context.fillRect(topBorderXStart,topBorderYStart,topBorderWidth,topBorderHeight);

	rightBorderXStart = leftBorderXStart + xht + borderThickness;
	rightBorderYStart = leftBorderYStart;
	rightBorderWidth = borderThickness - pixelOffset;
	rightBorderHeight = yht + (2 * borderThickness) - pixelOffset;
	//context.fillStyle="#b000b0";
	context.fillRect(rightBorderXStart,rightBorderYStart,rightBorderWidth,rightBorderHeight);

	bottomBorderXStart = leftBorderXStart;
	bottomBorderYStart = leftBorderYStart + yht + borderThickness;
	bottomBorderWidth = xht + (2 * borderThickness) - pixelOffset; 
	bottomBorderHeight = borderThickness - pixelOffset;
	//context.fillStyle="#b0b000";
	context.fillRect(bottomBorderXStart,bottomBorderYStart,bottomBorderWidth,bottomBorderHeight);

}


//alert('functions defined');




// draw the board basics
drawOutlineRectangles(cxt,boardXBase,boardYBase,boardSize,boardSize,borderThickness);





// draw player names as text on the canvas
//alert('drawing player names');
drawPlayerNames(cxt);
drawStones(cxt);


	//timeA = new Date();
	//timeAString = timeA.toUTCString();
	//document.write("timeA was " + timeAString "<br />");


	// SET UP THE PIECES
	pieceSet(whiteArmyID,blackArmyID);

	//alert('PIECE SET');

	updateBoard();
	//drawBoard();
	drawCaptureZone();
	drawStones(cxt);


	//timeB = new Date();
	//document.write("timeB was " + timeB "<br />");

		

	// initialize has GUI-related drawings
	//init();



///////// BOB MESSING WITH DUELING BULLSHIT /////////////////

// functions for dueling
// writes a message in the dueling box context on the given line number,
// where line number begins as 0 at the top
function writeDuelingPrompt(context, message, line) {
	var textXOffset = 10;
	var textYOffset = 10 + 10*line;

	// draw a white rectangle first
	// this serves to clear any previous names
	context.fillStyle = "#FFFFFF";

	// write the prompt
	context.fillStyle = "#000000";
	context.fillText(message, duelingZoneXBase + textXOffset, duelingZoneYBase + textYOffset);
}
function displayDuelingPrompt(context, message, line, xpos, ypos) {
	var textXOffset = 10;
	var textYOffset = 10 + 10*line;

	// draw a white rectangle first
	// this serves to clear any previous names
	context.fillStyle = "#FFFFFF";

	// write the prompt
	context.fillStyle = "#000000";
	context.fillText(message, xpos + textXOffset, ypos + textYOffset);
}

function drawCaptureZoneBorder(cxt) {
	//dueling section border from (420, 70) to (600, 250)
	if (psych == true) {
		cxt.fillStyle=randomColorGenerator("HEX");
	} else {
		cxt.fillStyle="#966F33";
	}

	//drawOutlineRectangles(context,x,y,xht,yht,borderThickness)
	drawOutlineRectangles(cxt,captureZoneXBase,captureZoneYBase,captureZoneWidth,captureZoneHeight,borderThickness);

}

function drawDuelingZoneBorder(cxt) {
	//dueling section border from (420, 70) to (600, 250)
	cxt.fillStyle="#966F33";

	//drawOutlineRectangles(context,x,y,xht,yht,borderThickness)
	drawOutlineRectangles(cxt,duelingZoneXBase,duelingZoneYBase,duelingZoneWidth,duelingZoneHeight,borderThickness);

}


function drawWhirlwindZoneBorder(cxt) {
	cxt.fillStyle="#966F33";

	//drawOutlineRectangles(context,x,y,xht,yht,borderThickness)
	drawOutlineRectangles(cxt,whirlwindZoneXBase,whirlwindZoneYBase,whirlwindZoneWidth,whirlwindZoneHeight,borderThickness);

}


drawCaptureZoneBorder(cxt); 
drawDuelingZoneBorder(cxt);
drawWhirlwindZoneBorder(cxt);




//inner dueling area from (430, 80) to (590, 240) - a 160x160 pixel box

//ok here's what I'm looking for
//inner box refreshes every time its clicked

//STATE 0 (preduel)- box says in large text START DUEL
// any click within the box takes us to state 1

//STATE 1 (whoisdueling) - box that asks who is starting the duel 
/*
	three boxes that are clickable
		box 1: black
			set a variable for black dueling, then proceed to state 2
		box 2: white
			set a variable for white dueling, then proceed to state 2
		box 3: cancel
			take us back to state 0
*/

function setDuelStateZero() {
	duelState = 0;
	alert('L0L');
}

function setDuelStateOne() {
	duelState = 1;
	//alert('LOL');
}

// set dueling army to white, go to state 2
function pressButtonTwo() {

	// 0=white
	// 1=black
	duelingArmy=0;
	dueledArmy=(duelingArmy + 1) % 2; 
	setDuelState(2);

}

// set dueling army to black, go to state 2
function pressButtonThree() {

	// 0=white
	// 1=black
	duelingArmy=1;
	dueledArmy=(duelingArmy + 1) % 2; 
	setDuelState(2);

}

// go to state 0
function pressButtonFour() {
	setDuelState(0);
}

function pressButtonFive() {
	// check dueling army,
	// and decrease its stonecount by 1
	// go to state 3


	// check that the army has enough stones
	// before decrementing the stone count
	if ( ( duelingArmy == 0 && whiteStoneCount == 1 ) ||
		 ( duelingArmy == 1 && blackStoneCount == 1 ) ){
		// go to state 7
		setDuelState(7);
	} else {

		// 0=white
		// 1=black
		if (duelingArmy == 0) {
			decrementWhiteStoneCount();
		} else {
			decrementBlackStoneCount();
		}
		duelInitiationCost=1;

		setDuelState(3);
	}
}

function pressButtonSix() {
	setDuelState(3);
}

function pressButtonSeven() {
	setDuelState(1);
}

function pressButtonEight() {
	// set whitebid=0, go to state 4
	whiteBet = 0;
	setDuelState(4);
}

function pressButtonNine() {
	// set whitebid=1, go to state 4
	whiteBet = 1;
	setDuelState(4);
}

function pressButtonTen() {
	// set whitebid=2, go to state 4
	whiteBet = 2;
	setDuelState(4);
}

function pressButtonEleven() {
	// set black bid=0, go to state 4
	blackBet = 0;
	setDuelState(5);
}

function pressButtonTwelve() {
	// set black bid=1, go to state 4
	blackBet = 1;
	setDuelState(5);
}

function pressButtonThirteen() {
	// set black bid=2, go to state 4
	blackBet = 2;
	setDuelState(5);
}

function pressButtonFourteen() {
	// go to state 6
	setDuelState(6);
}

function pressButtonFifteen() {
	// increase defender stonecount by 1
	// go to state 0
	if (dueledArmy == 0) {
		incrementWhiteStoneCount();
	} else {
		incrementBlackStoneCount();
	}
	setDuelState(0);

	// NOTATION
	moveString=moveString.replace(/0-0-STY/, "BLF(+1)");
	ML.addDuelMove(moveString);
	ML.printList(MLcxt);

}

function pressButtonSixteen() {
	// decrease attacker stonecount by 1
	// go to state 0
	if (duelingArmy == 0) {
		decrementWhiteStoneCount();
	} else {
		decrementBlackStoneCount();
	}
	setDuelState(0);

	// NOTATION
	moveString=moveString.replace(/0-0-STY/, "BLF(-1)");
	ML.addDuelMove(moveString);
	ML.printList(MLcxt);
}

// the OK button for the error message window
function pressButtonSeventeen() {
	setDuelState(0);
}

function setDuelState(newDuelState) {
	duelState = newDuelState;
}
	
// should be placed in global section
// draw three boxes, each has text on it
// function createButton (xposition, yposition, width, height, visibility, state, text) 
buttonArray[0] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 65,65, 1, 0,"YES", setDuelStateOne );	
buttonArray[1] = new createButton(duelingZoneXBase+85, duelingZoneYBase+90, 65,65, 1, 0,"NO", setDuelStateZero );	
// state 1
//
buttonArray[2] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 40,65, 1, 1,"White", pressButtonTwo );	
//buttonArray[2].doEvent = pressButtonTwo;
buttonArray[3] = new createButton(duelingZoneXBase+60, duelingZoneYBase+90, 40,65, 1, 1,"Black", pressButtonThree );	
buttonArray[4] = new createButton(duelingZoneXBase+110, duelingZoneYBase+90, 40,65, 1, 1,"Cancel", pressButtonFour );	
// state 2
//
buttonArray[5] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 40,65, 1, 2,"YES", pressButtonFive );	
buttonArray[6] = new createButton(duelingZoneXBase+60, duelingZoneYBase+90, 40,65, 1, 2,"NO", pressButtonSix );	
buttonArray[7] = new createButton(duelingZoneXBase+110, duelingZoneYBase+90, 40,65, 1, 2,"Back", pressButtonSeven );	
// state 3
//
buttonArray[8] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 40,65, 1, 3,"0", pressButtonEight );	
buttonArray[9] = new createButton(duelingZoneXBase+60, duelingZoneYBase+90, 40,65, 1, 3,"1", pressButtonNine );	
buttonArray[10] = new createButton(duelingZoneXBase+110, duelingZoneYBase+90, 40,65, 1, 3,"2", pressButtonTen );	
// state 4
//
buttonArray[11] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 40,65, 1, 4,"0", pressButtonEleven );	
buttonArray[12] = new createButton(duelingZoneXBase+60, duelingZoneYBase+90, 40,65, 1, 4,"1", pressButtonTwelve );	
buttonArray[13] = new createButton(duelingZoneXBase+110, duelingZoneYBase+90, 40,65, 1, 4,"2", pressButtonThirteen );	
// state 5
//
buttonArray[14] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 140,65, 1, 5,"Ok", pressButtonFourteen );	
// state 6
//
buttonArray[15] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 65,65, 1, 6,"+1", pressButtonFifteen );	
buttonArray[16] = new createButton(duelingZoneXBase+85, duelingZoneYBase+90, 65,65, 1, 6,"-1", pressButtonSixteen );	
// state 7, the error message state
//
buttonArray[17] = new createButton(duelingZoneXBase+10, duelingZoneYBase+90, 140,65, 1, 7,"Ok", pressButtonSeventeen );	



//function createButton (xposition, yposition, width, height, visibility, state, text, fx) {
function createButton (xposition, yposition, width, height, visibility, state, text, fx) {
	this.x = xposition;
	this.y = yposition;
	this.width = width;
	this.height = height;
	this.isVisible = visibility;
	this.state = state;
	this.text = text;
	this.doEvent = fx;
}


//STATE 2 (duelrank)- box that states the color of the army that is starting the duel and asks if the target piece is higher rank
/*
	three boxes that are clickable
		box 1: yes (with a warning that the duel will cost a stone)
			remove a stone from the dueling army, and proceed to state 3
		box 2: no 
			proceed to state 3
		box 3: cancel (or undo)
			return to state 0 (or return to state 1)
*/

//STATE 3 (whitebid)- how many stones is WHITE bidding (probably include playername)
/*
	check white stone count.  
		If stone count = 0, go immediately to STATE 4.
		if stone count = 1, put a black rectangle over box 3 and have a click on box 3 do nothing (or go back to state 3)

	three boxes that are clickable
		box 1: 0
			set whitebid to 0, proceed to state 4
		box 2: 1
			set whitebid to 1, proceed to state 4
		box 3: 2 
			set whitebid to 2, proceed to state 4
*/


//STATE 4 (blackbid)- how many stones is BLACK bidding (probably include playername)
/*
	check black stone count.  
		If stone count = 0, go immediately to STATE 5.
		if stone count = 1, put a black rectangle over box 3 and have a click on box 3 do nothing (or go back to state 4)

	three boxes that are clickable
		box 1: 0
			set blackbid to 0, proceed to state 5
		box 2: 1
			set blackbid to 1, proceed to state 5
		box 3: 2 
			set blackbid to 2, proceed to state 5
*/

//STATE 5 (resolution)
/*
	display attackingarmy bid
	display defendingarmy bid
	
	compare the bids. case A if both players bid 0 case B of attacking army is higher, C if neither.
		case A: Bluff called.  
		case B: display attacking player wins, defending player loses his piece
		case C: display defending player wins, no piece is removed
	
	decrease blackstonecount by blackbid
	decrease whitestonecount by whitebid
	update stonecounts

display one box for ok, when clicked go to STATE 6
*/

//STATE 6 (calledbluffresolution)
/*
	if case B or C, go directly to STATE 0
	if bluff called, display two buttons
	
	button 1: gain a stone
		defending player's stonecount increases by 1, go to STATE 0
	button 2: remove a stone
		attacking player's stonecount decreased by 1, go to STATE 0
*/
				



	// the final start up
	// update the board
	updateBoard();
	updateCaptureZone();
	drawDuelingBox();


	// move list
	var ML = new moveList();
	init();




</script>

</body>
</html>
