// MONEY.JS CODE. ##

var field = [];

function styleDollar(ipt, num, only, pos, neg, def_val, col) {
	// The Default text when left blank. (MONEY FORMAT) ##
	if (pos == "") {
		pos = "#000";
	}
	if (neg == "") {
		neg = "#bb0000";
	}
	var def = def_val+"";
	document.getElementById(ipt).onblur = function() {
		var n = document.getElementById(num);
		if (this.value == "") {
			this.value = def;
			this.value = parseFloat(this.value.replace(/,/g, "")).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			this.value = "$" + this.value;
			this.placeholder = "";
			n.value = def.replace("$", "");
			field[ipt] = Math.round(100*Number(n.value))/100;
		} else {
			if (only == "+") {
				this.value = this.value.replace("--", "");
				this.value = this.value.replace("-", "");
			} else if (only == "-") {
				if (this.value[0] != '-') {
					this.value = "-" + this.value;
				}
			}
			this.value = this.value.replace("$", "");
			this.value = this.value.replace(/,/g, "");
			this.value = Math.round(100*Number(this.value))/100;
			
			n.value = this.value;
			field[ipt] = this.value;
			this.value = parseFloat(this.value.replace(/,/g, "")).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			if (this.value == "NaN") {
				this.placeholder = "Invalid Value";
				n.value = null;
				this.value = "";
			} else {
				this.value = "$" + this.value;
				this.value = this.value.replace("$-", "-$");
			}
		}
		if (col) {
			if (this.value[0] == '-') {
				this.style.color = neg;
			} else {
				this.style.color = pos;
			}
		}
	};
}

function display(d,a) {
	if ((String(a) == "NaN") || (String(a) == "undefined")) d.value = ""; else d.value = a;
}

function moneyFormat(a) {
	if (a == "") return "";
	a = "$" + parseFloat(a.replace(/,/g, "")).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	a = a.replace("$-", "-$");
	return a;
}
