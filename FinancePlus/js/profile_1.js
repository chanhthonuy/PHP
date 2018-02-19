// PROFILE.JS CODE. ##

// Input Fields. ##
styleDollar("ipt1", "num1", "+", PHP.Pos, PHP.Neg, 0, true);
styleDollar("ipt2", "num2", "-", PHP.Pos, PHP.Neg, 0, true);
styleDollar("ipt3", "num3", "", PHP.Pos, PHP.Neg, 0, true);

// Balance Alert Message. ##
var alt = "Alert: Your Balance is ";
if (Number(PHP.Balance) <= Number(PHP.Low)) {
	alt += "Low";
} else if (Number(PHP.Balance) >= Number(PHP.High)) {
	alt += "High";
} else {
	alt = "";
}

// Header Balance Display. ##
$("#balance").html(moneyFormat(PHP.Balance));

$("#new_balance").html(moneyFormat(PHP.Balance));

var link = PHP.Link;
if (link != "") {
	var title = document.getElementById("link");
	title.href = link;
	title.target = "_blank";
}

$("#timein").datetimepicker({
	format: "m-d-Y H:00:00 a"
});

$("#timein").blur(function() {
	var ths = this.value;
	ths = ths.replace("-", "/");
	ths = ths.replace("-", "/");
	ths = ths.replace("am", "");
	ths = ths.replace("pm", "");
	var v = new Date(ths);
	//v.setHours(v.getHours(), v.getMinutes(), 0);
	var d = $("#date");
	var t = addZero(v.getMonth()+1)+"-"+addZero(v.getDate())+"-"+v.getFullYear()+" "+hours(v.getHours())+":"+addZero(v.getMinutes())+":"+addZero(v.getSeconds())+" "+ampm(v.getHours());
	var n = v.getFullYear()+"-"+(v.getMonth()+1)+"-"+v.getDate()+" "+v.getHours()+":"+v.getMinutes()+":"+v.getSeconds();
	if (n.includes("NaN")) {
		d.val(null);
		this.value = null;
	} else {
		d.val(n);
		this.value = t;
	}
	valAdd();
});
$("#chk_today").change(function() {
	var a = this.checked;
	var f = $("#timein");
	var d = $("#date");
	var t = new Date();
	var n = "";
	if (a) {
		n = t.getFullYear()+"-"+(t.getMonth()+1)+"-"+t.getDate()+" "+t.getHours()+":"+t.getMinutes()+":"+t.getSeconds();
		t = addZero(t.getMonth()+1)+"-"+addZero(t.getDate())+"-"+t.getFullYear()+" "+hours(t.getHours())+":"+addZero(t.getMinutes())+":"+addZero(t.getSeconds())+" "+ampm(t.getHours());
		d.val(n);
		f.val(t);
		f.prop("disabled", true);
	} else {
		f.val("");
		d.val(null);
		f.prop("disabled", false);
	}
	valAdd();
});
$("#chk_deposit, #chk_withdrawal, #chk_transfer").change(function() {
	if (this.id == "chk_deposit") {
		a = $("#ipt1");
		b = $("#ipt2");
		c = $("#ipt3");
		x = $("#num2");
		y = $("#num3");
	} else if (this.id == "chk_withdrawal") {
		a = $("#ipt2");
		b = $("#ipt1");
		c = $("#ipt3");
		x = $("#num1");
		y = $("#num3");
	} else if (this.id == "chk_transfer") {
		a = $("#ipt3");
		b = $("#ipt1");
		c = $("#ipt2");
		x = $("#num1");
		y = $("#num2");
	}
	a.prop("disabled", false);
	b.prop("disabled", true);
	c.prop("disabled", true);
	b.val(null);
	c.val(null);
	b.attr('placeholder','');
	c.attr('placeholder','');
	x.val("");
	y.val("");
	valAdd();
});

function valAdd() {
	var n1 = $("#num1").val();
	var n2 = $("#num2").val();
	var n3 = $("#num3").val();
	var d = $("#date").val();
	var b = $("#sub_btn");
	var ready = false;
	if (d != "") {
		if (n1 + n2 + n3 != 0) {
			ready = true;
		}
	}
	if (ready) {
		b.prop("disabled", false);
		b.attr('class', 'btn btn-success');
	} else {
		b.prop("disabled", true);
		b.attr('class', 'btn btn-default');
	}
}

$("#ipt1, #ipt2, #ipt3").blur(function() {
	var bal = Number(PHP.Balance)+Number($("#num1").val())+Number($("#num2").val())+Number($("#num3").val());
	if (bal < -0.001) $("#new_balance").css("color",PHP.Neg); else $("#new_balance").css("color", PHP.Pos);
	$("#new_balance").html(moneyFormat(""+bal));
	valAdd();
});

// Graph. ##
var ctx = document.getElementById('lineGraph');
let lineChart = new Chart(ctx, {
	type: 'line',
	data: {
		labels: graph_data,
		datasets: [{
			fill: true,
			lineTension: 0.1,
			backgroundColor: PHP.Color_graph+"aa",
			borderColor: PHP.Color_graph,
			borderCapStyle: 'butt',
			borderDash: [],
			borderDashOffset: 0.0,
			borderJoinStyle: 'miter',
			pointBorderColor: PHP.Color_graph,
			pointBackgroundColor: "#fff",
			pointBorderWidth: 3,
			pointHoverRadius: 2,
			pointHoverBackgroundColor: PHP.Color_graph,
			pointHoverBorderWidth: 2,
			pointRadius: 0,//1
			pointHitRadius: 10,
			data: graph_data
		}]
	},
	options: {
		legend: {
			display: false
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
				}
			}]
		},
		title: {
			display: true,
			text: alt,
			fontColor: "#f00"
		},
	}
});

function hours(a) {
	if (a == 0) a = 12;
	if (a > 12) a = a - 12;
	if (a < 10) a = "0" + a;
	return a;
}
function addZero(a) {
	if (a < 10) a = "0" + a;
	return a;
}
function ampm(a) {
	if (a < 12) return "am"; else return "pm";
}
