
window.onscroll = function() {
	growShrinkLogo();
};

window.onload = function(){
	growShrinkLogo();
	updatePersonalisedMessage();
	updateVarForm();
};

window.resize = function(){
	growShrinkLogo();
	updatePersonalisedMessage();
	updateVarForm();
};

// Media Query 

function growShrinkLogo() {
	var logo = document.getElementById("firewok-logo");
	var header = document.getElementById("masthead");

	if ((document.body.scrollTop > 5) || 
		(document.documentElement.scrollTop > 5) || 
		(window.matchMedia("(max-width: 768px)").matches === true)
		){
		logo.style.width = '50px';
		header.classList.add("scrolled");
	} 
	else {
		if (window.matchMedia("(max-width: 768px)").matches === false) {
			logo.style.width = '100px';
		}
		header.classList.remove("scrolled");
	}
}

function mainMargin() {
	var header = document.getElementById("masthead");
	var content =  document.getElementById("main");
	var headerHeight = header.offsetHeight;

	/*content.style.marginTop = headerHeight+40+"px";*/

}

function showAllReviews() {
	var reviews = document.querySelectorAll("#reviews .commentlist");
	reviews.classList.add("showall");
}


/*

Varible product page

*/

/* Personal Message */

function updatePersonalisedMessage(){

	var pers = document.getElementById("personalised");
	var savedMessage = "";

	// Initiate function
	if (pers !== null){
		// on load
		togglePersonalised(pers,savedMessage);
		// on selector change
		pers.addEventListener("change", function(){
			togglePersonalised(pers,savedMessage);
		});
	}

}

function togglePersonalised(p,m) {
	// check value
	var val = p.value;
	var message = document.getElementById("alg-product-input-fields-table");
	var messageInput = document.getElementById("alg_wc_pif_local_1");
	if (val == "Yes") {
		messageInput.value = m;
		if (!message.classList.contains("curtainIn")) {
			message.classList.toggle("curtainIn");	
		}			
	}
	else{
		if (message.classList.contains("curtainIn")) {
			message.classList.toggle("curtainIn");
		}
		savedMessage = messageInput.value;
		messageInput.value = "";
	}
}


function updateVarForm() {
	var varForm = document.getElementsByClassName("variations_form");
	if (varForm.length !== 0) {
		// Update initial price
		updateVarPrice();
		var selectors = document.querySelectorAll(".variations select");
		for (var i = selectors.length - 1; i >= 0; i--) {
			// Update price on change
			selectors[i].addEventListener("change", function(){
				updateVarPrice();
			});
		}
	}
}


function updateVarPrice(){
	var t = 0;
	var checkPrice = setInterval( function(){
		var summaryPrice = document.querySelectorAll(".summary p.price");
		var variationPrice = document.querySelectorAll(".woocommerce-variation-price span.price span.amount");
		if (variationPrice.length !== 0) {
			if (summaryPrice[0].textContent !== variationPrice[0].lastChild.textContent) {
				summaryPrice[0].textContent = "£"+variationPrice[0].lastChild.textContent;
				window.clearInterval(checkPrice);
			}
		}
		if (t > 5){
			window.clearInterval(checkPrice);
			console.log("tock");
		}	
		t++;
		console.log(t);	 
	},200);	
}
