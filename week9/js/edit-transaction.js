// EDIT-TRANSACTION.JS CODE. ##

// FROM 'money.js': Define Text Fields and Value Holders. ##
styleDollar("ipt1", "num1", "+", PHP.Pos, PHP.Neg, 0, true);
styleDollar("ipt2", "num2", "-", PHP.Pos, PHP.Neg, 0, true);
styleDollar("ipt3", "num3", "", PHP.Pos, PHP.Neg, 0, true);

// On Load. ##
$("#timein").datetimepicker({
	format: "m-d-Y H:00:00"
});

$("#ipt1").prop("disabled", true);
$("#ipt2").prop("disabled", true);
$("#ipt3").prop("disabled", true);
if ($("#num1").val() != '') {
	$("#ipt1").val(moneyFormat($("#num1").val()));
	$("#ipt1").prop("disabled", false);
	$("#chk_deposit").prop("checked", true);
}
if ($("#num2").val() != '') {
	$("#ipt2").val(moneyFormat($("#num2").val()));
	$("#ipt2").prop("disabled", false);
	$("#chk_withdrawal").prop("checked", true);
}
if ($("#num3").val() != '') {
	$("#ipt3").val(moneyFormat($("#num3").val()));
	$("#ipt3").prop("disabled", false);
	$("#chk_transfer").prop("checked", true);
}
$(function() {
	var v = new Date($("#date").val());
	var t = addZero(v.getMonth()+1)+"-"+addZero(v.getDate())+"-"+v.getFullYear()+" "+hours(v.getHours())+":"+addZero(v.getMinutes())+":"+addZero(v.getSeconds())+" "+ampm(v.getHours());
	$("#timein").val(t);
});
	
$("#timein").blur(function() {
	var v = new Date(this.value);
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
		b.attr('class', 'btn btn-warning');
	} else {
		b.prop("disabled", true);
		b.attr('class', 'btn btn-default');
	}
}

$("#ipt1, #ipt2, #ipt3").blur(function() {
	valAdd();
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

valAdd();