let chg_button = document.getElementById("sub");
let inputs = document.querySelectorAll("input[type=text], input[type=tel], input[type=email]");
let secondPhone = document.getElementById("phone2");
let secondPhoneField = document.getElementById("phone2-card-example");
let example_fields = [];
let labels = [];
for (let i = 0; i < inputs.length; i++) {
	example_fields.push(document.getElementById(inputs[i].id + "-card-example"));
	labels.push(document.querySelector("label[for=" + inputs[i].id + "]"));
}
// функция, которая добавляет или убирает звездочки в лейблах обязательных полей
let checkRequires = function () {
	for (let i = 0; i < labels.length; i++) {
		if (labels[i]) {
			if (inputs[i].required) {
				if (labels[i].innerHTML.indexOf("*") === -1) labels[i].innerHTML += " *";
			}
			else {
				labels[i].innerHTML = labels[i].innerHTML.replace(/\*/g, "");
			}
		}
	}
}
checkRequires();
// -------------------- сбор данных со всех радиокнопок
let radioButtons = document.querySelectorAll("input[type=radio]");
let name_field = document.getElementById("name-card-example");
let position_field = document.getElementById("position-card-example");
let setPreferences = function(object) {
		switch (object.name) {
			case "straigthen":
				switch (object.value) {
					case "L":
						name_field.style.textAlign = "left";
						name_field.style.marginLeft ="50px";
						break;
					case "C":
						name_field.style.textAlign = "center";
						break;
					case "R":
						name_field.style.textAlign = "right";
						name_field.style.marginRight ="50px";
						break;
					default:
						break;
				}
				break;
			case "straigthen2":
				switch (object.value) {
					case "L":
						position_field.style.textAlign = "left";
						position_field.style.marginLeft ="50px";
						break;
					case "C":
						position_field.style.textAlign = "center";
						break;
					case "R":
						position_field.style.textAlign = "right";
						position_field.style.marginRight ="50px";
						break;
					default:
						break;
				}
				break;
			case "fsize":
				switch (object.value) {
					case "24":
						name_field.style.fontSize = "24px";
						break;
					case "26":
						name_field.style.fontSize = "26px";
						break;
					case "28":
						name_field.style.fontSize = "28px";
						break;
					default:
						break;
				}
				break;
			case "fsize2":
				switch (object.value) {
					case "14":
						position_field.style.fontSize = "14px";
						break;
					case "16":
						position_field.style.fontSize = "16px";
						break;
					case "18":
						position_field.style.fontSize = "18px";
						break;
					default:
						break;
				}
				break;
			case "color":
				switch (object.value) {
					case "1":
						name_field.style.color = "#000";
						break;
					case "2":
						name_field.style.color = "#3F88E8";
						break;
					case "3":
						name_field.style.color = "#E83F56";
						break;
					case "4":
						name_field.style.color = "#097A14";
						break;
					case "5":
						name_field.style.color = "#DCA40A";
						break;
					case "6":
						name_field.style.color = "#DC0AD5";
						break;
					default:
						break;
				}
				break;
			case "color2":
				switch (object.value) {
					case "1":
						position_field.style.color = "#202020";
						break;
					case "2":
						position_field.style.color = "#474747";
						break;
					case "3":
						position_field.style.color = "#636363";
						break;
					case "4":
						position_field.style.color = "#9E9E9E";
						break;
					case "5":
						position_field.style.color = "#BBBBBB";
						break;
					case "6":
						position_field.style.color = "#E3E3E3";
						break;
					default:
						break;
				}
				break;
			default:
				break;
		}
	}
// ----------------------- настройка добавления еще одного телефона
let addPhone = document.getElementById("addPhone");
let removePhone = document.getElementById("removePhone");
let innerBlock = document.getElementsByClassName("inner-block");
let hiddenBlock = document.getElementsByClassName("hidden-block");
let phone1 = document.getElementById("phone");
//
addPhone.addEventListener('click', function() {
	secondPhone.value = "";
	secondPhoneField.innerHTML = "";
	hiddenBlock[0].classList.toggle("none");
	innerBlock[0].classList.toggle("none");
	secondPhoneField.classList.toggle("none");
	secondPhone.setAttribute("required", "required");
});
removePhone.addEventListener('click', function() {
	hiddenBlock[0].classList.toggle("none");
	innerBlock[0].classList.toggle("none");
	secondPhoneField.classList.toggle("none");
	secondPhone.value = "no_extra_phone";
	secondPhone.removeAttribute("required");
});
// --------------------- определение почты и адреса как обязательных полей
let showMail = document.getElementById("showMail");
let showLocation = document.getElementById("showLocation");
showMail.addEventListener('click', function (){
	if (!showMail.checked) { 
		mail_input.removeAttribute("required");
	} else {
		mail_input.setAttribute("required", "required");
	}
	checkRequires();
});
showLocation.addEventListener('click', function () {
	if (!showLocation.checked) {
		location_input.removeAttribute("required");
	} else {
		location_input.setAttribute("required", "required");
	}
	checkRequires();
});
// --------------------- настройка видимости адреса и почты
let mail_field = document.getElementById("mail-card-example");
let location_field = document.getElementById("location-card-example");
let mail_input = document.getElementById("mail");
let location_input = document.getElementById("location");
let showData = function (object) {
	if (object.id === "showMail") {
		if (!object.checked) {
			mail_field.style.display = "none";
		} else {
			mail_field.style.display = "block";
		}	
	} else if (object.id == "showLocation") {
		if (!object.checked) {
			location_field.style.display = "none";
		} else {
			location_field.style.display = "block";
		}
	}
}
// ----------------------- кнопка применить
chg_button.addEventListener('click', function() {
	empty = false;
	showData(showMail);
	showData(showLocation);
	for (let i = 0; i < inputs.length; i++) {
		if (inputs[i].value === "" && inputs[i].required) {
			empty = true;
			inputs[i].style.borderColor = "#d5265b";
		}
		else {
			inputs[i].style.borderColor = "rgb(156,156,156)";
		}
	}
	if (empty) {
		alert("Пожалуйста, заполните все поля!");
		return;
	}
	for (let i = 0; i < inputs.length; i++) {
		example_fields[i].innerHTML = inputs[i].value; 
	}
	for (let i = 0; i < radioButtons.length; i++) {
		if (radioButtons[i].checked === true) {
			setPreferences(radioButtons[i]);
		}
	}
});