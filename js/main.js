/**
*	The main javascript for the entire site
*
*/

	
	var submitted;
	// set the width of thumbnails
	$( document ).ready(function() {
		console.log("ready!");
		changeModelWidth();
		$(".model").hover(function() {
			thumbHover($(this));
		}, function() {
			thumbUnhover($(this));
		});
		
	});
	
	// keep track of number of elements in database
	var numElements = 4;
	

	/* ---------------- NAV JAVASCRIPT ------------------*/
	 
	/**
	* This makes the line under nav button appear
	* on the hover
	*/
	function navHover(element) {
		 // make line visible
		 var el = $(element).find('.anav');
		 el.css("visibility", "visible");
		 console.log("hovering");
		
		// handle width of line
		var parentnum = $(element).width();
		if(element.innerHTML == "LOGIN") {
		 	el.css("width", 53 + "px");
		} else {
			el.css("width", parentnum + "px");
		}
	 }
	
	/**
	* This makes the line under nav button disappear
	* on the unhover
	*/
	function navUnhover(element) {
		console.log("unhovering");
		 var el = $(element).find('.anav');
		 el.css("visibility", "hidden");
	 }




	
	/* ---------------- SELECT MODEL GRID JAVASCRIPT ------------------*/

	/**
	* This function changes the width of the model imgs to 
	* always be 1/2 of the page
	*/
	function changeModelWidth() {
		var w = $(window).width();
		var calc = w/3;
		var calcH = (240*calc)/342;
		var thumb = $(".model");
		thumb.css("width", calc);
		thumb.css("height", calcH);
		$('.model').each(function( index) {
			var src = "img/clickbg.png";
			if ($(this).attr("src") == src) {
				$(this).css("width", calc);
				$('thumb').css("width", calc);
				$(this).css("height", calcH);
				$('thumb').css("height", calcH);

			}
		});
		$('.mtitle').each(function( index) {
			var name = $(this);
			var thumbheight = $(thumb).height();
			var top = (thumbheight*80)/100;
			name.css("top", top + "px");
		});
	}


	/**
	* This function brings up the name caption when the
	* user hovers over the model photo
	* @peram: the model element that called the function
	*/
	function thumbHover(element) {

			isRunning = true;
			var el = $(element).find('.thumbH');
			var name = $(element).find('.mtitle');
			var src = "img/thumbhover.png";
			
			if (el.attr("src") == src) {
				var h = $(".model").height();
				var id = setInterval(frame, 5);
				var op = 0;
				function frame() {
					if (op >= h) {
						clearInterval(id);
					} else {
						op = op + 30;
						el.css("height", op + "px");
					}
				}
				name.css("visibility", "visible");
			}	
			
	}
	/**
	* This function brings down the name caption when the
	* user unhovers over the model photo
	* @peram: the model element that called the function
	*/
	function thumbUnhover(element) {

			var el = $(element).find('.thumbH');
			var name = $(element).find('.mtitle');
			var src = "img/thumbhover.png";
			if (el.attr("src") == src) {
				name.css("visibility", "hidden");
				var h = $(".model").height();
				var id = setInterval(frame, 5);
				var op = h;
				function frame() {
					if (op <= 0) {
						clearInterval(id);
					} else {
						op = op - 30;
						el.css("height", op + "px");
					}
				}
			}
	}
	
	var selected = [];
	
	/**
	* This function brings up the image
	* over the thumbnail and the name so that the user
	* knows that the model has been selected.
	*/
	function thumbClick(element) {
		///selected.push($(element).attr('id'));
		console.log("clicked");
		var el = $(element).find('.thumbH');
		var src = "img/clickbg.png";
		var name = $(element).find('.mtitle');
		var thumb = $(".model").height();
		var top = (thumb*65)/100;
		if (el.attr("src") != src) {
			var el = $(element).find('.thumbH');
			var src = "img/clickbg.png";
			el.attr("src", src);
			name.css("top", top + "px");
		} else {
			var el = $(element).find('.thumbH');
			var src2 = "img/thumbhover.png";
			el.attr("src", src2);
			thumbUnhover(element);
			var top2 = (thumb*80)/100;
			name.css("top", top2 + "px");
		}
		
		
	}
	
/* ------------------------- VIEW VIDEO JAVASCRIPT ------------------------- */

	var playing;

	
	/**
	* This function does all the work to show the video;
	* It sets up the controls and sets the size of the video.
	*/
	function showVideo() {
			
			$('#models').css("display", "none");
			$('#viewbut').css("display", "none");
			$('#video').css("display", "inline-block");
			var video = $('#mainVid');
			var vidH = (window.innerWidth*1080)/1920;
			var playTop = vidH/2 - 20;
			$(playBut).css("top", playTop + "px");
			$('#vidcover').css("height", vidH);
			$('#savebut').css("display", "inline");
			
			var seek = document.getElementById("seek-bar");
			var video = document.getElementById("mainVid");
			var volume = document.getElementById("volume-bar");
			
			// change the video time when seek bar is changed
			seek.addEventListener("change", function() {
				var time = video.duration * (seek.value/100);
				video.currentTime = time;
			});
			console.log("showing video2");
	
			// change where the seek bar handle is
			video.addEventListener("timeupdate", function() {
				var value = (100/video.duration) * video.currentTime;
				seek.value = value;
			});
			
			// make the video not try to play as seek handle moves
			seek.addEventListener("mousedown", function() {
				video.pause();
				playing = false;
				$('#playBut').attr("src", "img/play.png");
				$('#vidcover').css("opacity", 1);
				$('#seek').css("opacity", 1);
				$('#volume').css("opacity", 1);
			});
			
			// now the volume
			volume.addEventListener("change", function() {
				video.volume = volume.value;
			});
	}

	/**
	* This function plays the video if it is not
	* playing, and pauses it if it is playing.
	*/
	function playVideo() {
		var seek = document.getElementById("seek-bar");
		var volume = document.getElementById("volume-bar");
		
		var vid = document.getElementById("mainVid");
		// if video is paused, then play it
		if (vid.paused) {
			vid.play();
			playing = true;
			$('#playBut').attr("src", "img/pause.png");
			var id = setInterval(frame, 5);
			var op = 1;
			// animate out the black screen
			function frame() {
				if (op <= 0) {
					clearInterval(id);
				} else {
					op = op - .1;
					$('#vidcover').css("opacity", op);
					$('#playBut').css("opacity", op);
				}
			}
			$('#seek').css("opacity", 0);
			$('#volume').css("opacity", 0);
			
		} else {
			// if it was playing, then pause
			vid.pause();
			playing = false;
			$('#playBut').attr("src", "img/play.png");
			$('#vidcover').css("opacity", 1);
			bringBackPaused();
		}
		
		
	}
	
	/**
	* This function brings back the black screen
	* the controls and everything else.
	*/
	function bringBack() {
		var vid = document.getElementById("mainVid");
		console.log("opacity: " + $('#vidcover').css("opacity"));
		// make sure that it is plaving and vidcover is on 
		// before taking it off
		if (playing && ($('#vidcover').css("opacity") != 1)) {
			var id = setInterval(frame, 5);
			var op = 0;
			$('#playBut').attr("src", "img/pause.png");
			function frame() {
				if (op >= 1) {
					clearInterval(id);
				} else {
					op = op + .1;
					$('#vidcover').css("opacity", op);
					$('#playBut').css("opacity", op);
				}
			}
			$('#seek').css("opacity", 1);
			$('#volume').css("opacity", 1);
		}
	}

	/**
	* This function brings back the controls after the
	* video is paused
	*/
	function bringBackPaused() {
		$('#playBut').attr("src", "img/play.png");
		$('#vidcover').css("opacity", 1);
		$('#playBut').css("opacity", 1);
		var seek = document.getElementById("seek-bar");
		var volume = document.getElementById("volume-bar");
		$('#seek').css("opacity", 1);
		$('#volume').css("opacity", 1);
	}

	/**
	* This function animates away the black video cover
	*	and all of the controls.
	*/
	function goAway() {
		var vid = document.getElementById("mainVid");
		if (playing && ($('#vidcover').css("opacity") == 1)) {
			var id = setInterval(frame, 5);
			var op = 1;
			function frame() {
				if (op <= 0) {
					clearInterval(id);
				} else {
					op = op - .1;
					$('#vidcover').css("opacity", op);
					$('#playBut').css("opacity", op);
				}
			}
			$('#seek').css("opacity", 0);
			$('#volume').css("opacity", 0);
		}
		
	}


/*----------------------- THE UPLOAD FORM FUNCTIONS -----------------------------*/
	
	/**
	* Opens up the form if you want to upload a model
	*/
	function upload() {
		
		$('#contribute').css("height", 1610 + "px");
		$('#upl').css("display", "none");
		document.getElementById("contText").innerHTML = "JOIN THE COMMUNITY. INSPIRE PEOPLE WITH YOUR MODELS.";	
		$('#formHid').css('display', 'block');
		
		
	}
	/**
	*	Deletes text in text box when you click the box.
	*/
	function nameText(el) {
		el.value = "";
	}

	/* ------------------------- SMOOTH SCROLL JAVASCRIPT ------------------------- */

	$(function() {
			  $('a[href*="#"]:not([href="#"])').click(function() {
			    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			      var target = $(this.hash);
			      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			      if (target.length) {
			        $('html, body').animate({
			          scrollTop: target.offset().top
			        }, 1000);
			        return false;
			      }
			    }
			  });
			});

	
	/*-------------------- Functions to deal with the database ----------------------*/
	
	var entryCount = 0;
	var loopCount = 1;
	var activeLoop = 0;
	
	/**
	* Count entries in database
	*/
	function countEntries() {
		entryCount = entryCount +1;
	}
	
	/**
	*	Count the loops (sets of 9 models)
	*/
	function countLoops() {
		loopCount = loopCount + 1;
	}
	
	/**
	* Calculate the position of each of the loops
	* They should lie side by side
	* So that the user scrolls through chunks of 9 models
	*/
	function calcLoops() {
		for (var i = 0; i < loopCount; i++) {
			var d = "#loop" + i;
			console.log("d is: " + d);
			$(d).css("position", "absolute");
			var num = i * 100;
			var numString = num + "vw";
			$(d).css("left", numString);	
			$(d).css("top", "0px");
			$(d).css("overflow", "hidden");
			$(d).css("width", "100vw");
			$(d).css("display", "inline");
		}
		$('#loop0').css("position", "relative");
		$('#Larrow').css("display", "none");
		if (entryCount < 10) {
			$('#Rarrow').css("display", "none");
		}
		var number = Math.ceil(entryCount/3);
		var thumby = document.getElementsByClassName("model")[1];
		var heighty = window.getComputedStyle(thumby).getPropertyValue("height");
		heighty = heighty.slice(0,-2);
		heighty = Number(heighty);
		var needed = heighty*number + 350;
		console.log("number: " + number + " and heighty: " + heighty + " needed: " + needed);
		$("#viewbut").css("margin-top", needed + "px");
		
	}
	
	/**
	*	When user wants to see models to the right
	*	SO it moves all the models left
	*/
	function moveLeft() {
		activeLoop = activeLoop +1;
		// if we are at the end of loops, then hide the right arrow
		if (activeLoop == loopCount-1) {
			$('#Rarrow').css("display", "none");
		}
		$('#Larrow').css("display", "block");
		var op = 0;
		var id = setInterval(frame, 5);
		/// animate them over nicely
		function frame() {
			if (op >= 100) {
				clearInterval(id);
			} else {
				op = op + 1;
				for (var i = 0; i < loopCount; i++) {
					var d = "#loop" + i;
					var is = (i - (activeLoop-1))*100;
					var need = is - op;
					var numString = need + "vw";
					$(d).css("left", numString);
				}	
			}
		}
		
	}
	
	/**
	*	When user wants to see models to the left
	*	SO it moves all the models right
	*/
	function moveRight() {
		activeLoop = activeLoop - 1;
		// display right arrow
		$('#Rarrow').css("display", "block");
		// if we are at last loop, then hide left arrow
		if (activeLoop == 0) {
			$('#Larrow').css("display", "none");
		}
		var op = 0;
		var id = setInterval(frame, 1);
		// animate through nicely
		function frame() {
			if (op >= 100) {
				clearInterval(id);
			} else {
				op = op + 1;
				for (var i = 0; i < loopCount; i++) {
					var d = "#loop" + i;
					var is = (i - (activeLoop+1))*100;
					var need = is + op;
					var numString = need + "vw";
					$(d).css("left", numString);
				}	
			}
		}
		
	}