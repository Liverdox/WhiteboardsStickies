<!DOCTYPE html>
<html>
<head>
	<title>Whiteboards+Stickies</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet"> 
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script src="./js/ajax.js"></script>
</head>
<body>
    <?php
		if(!isset($_COOKIE["team"])) {
            header('Location: ./main');
        }
	?>
	<div id="app">
		<div class="backgrounds">
			<div class="back1" v-show="isBackground === 1">
				<div style="background: #FFF3F3;">1</div>
				<div style="background: #F5F5F5;">2</div>
				<div style="background: #F5F5F5;">3</div>
				<div style="background: #EBFFEF;">4</div>
			</div>
			<div class="back2" v-show="isBackground === 2">
				<div style="background: #FFF3F3;">1</div>
				<div style="background: #EBFFEF;">2</div>
				<div style="background: #F5F5F5;">3</div>
			</div>
		</div>
		<div class="menu" style="z-index: 1;">
			<ol>
				<li class="menu-item">
					<svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg" class="add" v-on:click="isStickAdd = !isStickAdd"><path d="m256 512c-141.164062 0-256-114.835938-256-256s114.835938-256 256-256 256 114.835938 256 256-114.835938 256-256 256zm0-480c-123.519531 0-224 100.480469-224 224s100.480469 224 224 224 224-100.480469 224-224-100.480469-224-224-224zm0 0"/><path d="m368 272h-224c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h224c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m256 384c-8.832031 0-16-7.167969-16-16v-224c0-8.832031 7.167969-16 16-16s16 7.167969 16 16v224c0 8.832031-7.167969 16-16 16zm0 0"/></svg>
					<ol class="sticker-width" v-show="isStickAdd">
						<li v-on:click="pushSticker('small-sticker')">Small</li>
						<li v-on:click="pushSticker('large-sticker')">Large</li>
						<li v-on:click="pushCircleSticker()">Circle(delete dblclick)</li>
					</ol>
				</li>
				<li class="menu-item" v-on:click="changeBack">
					<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 271.673 271.673" style="enable-background:new 0 0 271.673 271.673;" xml:space="preserve" class="button-change-background">
						<path d="M114.939,0H10.449C4.678,0,0,4.678,0,10.449v104.49c0,5.771,4.678,10.449,10.449,10.449h104.49c5.771,0,10.449-4.678,10.449-10.449V10.449C125.388,4.678,120.71,0,114.939,0z"/>
						<path d="M261.224,0h-104.49c-5.771,0-10.449,4.678-10.449,10.449v104.49c0,5.771,4.678,10.449,10.449,10.449h104.49c5.771,0,10.449-4.678,10.449-10.449V10.449C271.673,4.678,266.995,0,261.224,0z"/>
						<path d="M114.939,146.286H10.449C4.678,146.286,0,150.964,0,156.735v104.49c0,5.771,4.678,10.449,10.449,10.449h104.49c5.771,0,10.449-4.678,10.449-10.449v-104.49C125.388,150.964,120.71,146.286,114.939,146.286z"/>
						<path d="M261.224,146.286h-104.49c-5.771,0-10.449,4.678-10.449,10.449v104.49c0,5.771,4.678,10.449,10.449,10.449h104.49c5.771,0,10.449-4.678,10.449-10.449v-104.49C271.673,150.964,266.995,146.286,261.224,146.286z"/>
					</svg>
				</li>
				
			</ol>
		</div>


		<div class="sticker" v-for="(sticker, i) in stickers" :class="sticker.cls" :style="sticker.st" v-on:mousedown="mousedownSticker($event, i, 'stickers')">
			<div class="edit" v-on:click="showModal(i)">
				<svg id="Capa_1" enable-background="new 0 0 515.555 515.555" height="512" viewBox="0 0 515.555 515.555" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m496.679 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/><path d="m303.347 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/><path d="m110.014 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/></svg>
			</div>
			<div class="sticker-content">
				{{ sticker.content }}
			</div>
			<div class="comments" v-if="sticker.cls === 'comments-sticker'">
				<hr>
				<h3>Comments:</h3>
				<div class="first-comment">{{ sticker.firstComment }}</div>
				<div class="other-comments" v-show="sticker.comments.length">+{{ sticker.comments.length }}</div>
			</div>
		</div>

		<div id="modal" v-show="modal.isActive">
			<div id="modal-content" :style="{background: modal.st.background, transform: modal.st.transform}">
				<div id="modal-edit">
					<textarea id="modal-text" maxlength="250">{{ modal.content }}</textarea>
				</div>
				<div class="modal-buttons">
					<button class="modal-save" v-on:click="saveModalText">Save</button>
					<button class="modal-delete" v-on:click="deleteSticker">Delete</button>
				</div>
				
			</div>
		</div>
		<svg width="62" height="67" viewBox="0 0 62 67" class="circle-sticker" v-for="(circleSticker, i) in circleStickers" :style="circleSticker.st"  v-on:mousedown="mousedownSticker($event, i, 'circleStickers')" v-on:dblclick="deleteCircleSticker(i)"><g filter="url(#filter0_f)"><path d="M31 62C45.3594 62 57 50.3594 57 36L31 10C16.6406 10 5 21.6406 5 36C5 50.3594 16.6406 62 31 62Z" fill="black" fill-opacity="0.1"/></g><path d="M31 60C47.5685 60 61 46.5685 61 30L31 0C14.4315 0 1 13.4315 1 30C1 46.5685 14.4315 60 31 60Z"/><path d="M61 30C44.4315 30 31 16.5685 31 0L61 30Z" fill="black" fill-opacity="0.15"/><defs><filter id="filter0_f" x="0" y="5" width="62" height="62" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/><feGaussianBlur stdDeviation="2.5" result="effect1_foregroundBlur"/></filter></defs></svg>
	</div>
	<h2 class="name-team">
		<?php
			echo "Login: " . $_COOKIE["login"];
		?>
	</h2>
	<script>
		function getRandInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}


		function getRandColor() {
			let colors =  [["#FFF6C8", "#84793F"], ["#E0FFC8", "#5D843F"], ["#C8FFF2", "#3E8473"],
				["#C8F2FF", "#3F7485"], ["#C8DBFF", "#3F5785"], ["#E0C8FF", "#5C3D84"],
				["#FFC8C8", "#853D3D"], ["#FFE6C8", "#86543F"]][getRandInt(0, 7)];

			return {background: colors[0], color: colors[1]}
		}


		let app = new Vue({
			el: "#app",
			data: {
				isBackground: 2,
				isStickAdd: false,
				stickers: [],
				circleStickers: [],
				modal: {
					isActive: false,
					content: "Edit me.",
					elemInd: 0,
					st: {}
				}
			},
			methods: {
				changeBack: function() {
					this.isBackground = this.isBackground > 1 ? 0 : (this.isBackground + 1);
				},
				pushSticker: function(cls) {
					this.stickers.push( new Sticker(cls) );
					messageSend({circleStickers: app.circleStickers, stickers: app.stickers});
				},
				pushCircleSticker: function() {
					this.circleStickers.push({
						st: {
							left: getRandInt(10, 80) + "%",
							top: getRandInt(10, 80) + "%",
							fill: getRandColor().background
						}
					});
					messageSend({circleStickers: app.circleStickers, stickers: app.stickers});
				},
				showModal: function(i) {
					this.modal.st = this.stickers[i].st;
					this.modal.elemInd = i;
					document.getElementById("modal-text").value= this.stickers[i].content;					
					this.modal.isActive = true;
				},
				saveModalText: function() {
					this.stickers[this.modal.elemInd].content = document.getElementById("modal-text").value;
					this.modal.isActive = false;
					messageSend({circleStickers: app.circleStickers, stickers: app.stickers});
				},
				deleteSticker: function() {
					this.stickers.splice(this.modal.elemInd, 1);
					this.modal.isActive = false;
					messageSend({circleStickers: app.circleStickers, stickers: app.stickers});
				},
				deleteCircleSticker: function(i) {
					this.circleStickers.splice(i, 1);
					messageSend({circleStickers: app.circleStickers, stickers: app.stickers});
				},
				mousedownSticker: function(e, i, stickers) {
					let elem = e.currentTarget;
					let shiftX = e.clientX - elem.getBoundingClientRect().left;
					let shiftY = e.clientY - elem.getBoundingClientRect().top;

					moveAt(e.pageX, e.pageY);

					function moveAt(pageX, pageY) {
						let clientWidth = document.documentElement.clientWidth;
						let clientHeight = document.documentElement.clientHeight;
						if(pageX - shiftX < 0) {
							app[stickers][i].st.left = 0;						
						} else if (pageX - shiftX + elem.clientWidth > clientWidth) {
							app[stickers][i].st.left = (1 - elem.clientWidth/clientWidth) * 100 + "%";
						} else {
							app[stickers][i].st.left = 100 * (pageX - shiftX) / clientWidth + "%";
						}

						if(pageY - shiftY < 0) {
							app[stickers][i].st.top = 0;	
						} else if(pageY - shiftY + elem.clientHeight > clientHeight) {
							app[stickers][i].st.top = (1 - elem.clientHeight/clientHeight) * 100 + "%";
						} else {
							app[stickers][i].st.top = 100 * (pageY - shiftY) / clientHeight + "%";
						}
						
					}

					function onMouseMove(e) {
						moveAt(e.clientX, e.pageY);
					}

					document.addEventListener('mousemove', onMouseMove);

					function removeListener() {
						document.removeEventListener('mousemove', onMouseMove);
						window.removeEventListener("mouseup", removeListener);
						messageSend({circleStickers: app.circleStickers, stickers: app.stickers});
					}

					window.addEventListener("mouseup", removeListener);

				}
			}
		})

		function Sticker(cls) {
			this.content = "Edit me";
			this.cls = cls;
			this.st = Object.assign(getRandColor(),
				{left: getRandInt(0, 80) + "%", top: getRandInt(0, 80) + "%", transform: "rotate("+ getRandInt(-1, 1) +"deg)" });
			if(cls === "comments-sticker") {
				this.firstComment = "Edit me";
				this.comments = [];
			}
		}
	</script>
</body>
</html>