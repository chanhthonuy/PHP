// HOME.JS CODE. ##

// Define Text Fields and Value Holders. ##
function dynamicSort(property) {
	var sortOrder = 1;
	if (property[0] === "-") {
		sortOrder = -1;
		property = property.substr(1);
	}
	return function (a,b) {
		var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
		return result * sortOrder;
	};
}

// Draw Pie Chart. ##
$(document).ready(function() {
	var ctx = $("#pieChart").get(0).getContext("2d");
	var animation = true;
	if (data.length == 0) {
		animation = false;
		data[0] = {
			value: 1,
			color: "#999999",
			label: "No Profiles"
		};
	}
	data.sort(dynamicSort("-value"));
	if (other != null) {
		data[data.length-1].value = other;
	}
	var style = {
		segmentShowStroke: true,
		animateScale: false,
		animateRotate: true,
		segmentStrokeColor: "#000",
		segmentStrokeWidth: 1,
		animationEasing: "easeOutQuad",
		animation: PHP.Home * animation
	};
	var piechart = new Chart(ctx).Pie(data, style);
});

// Main Table. ##
var val = PHP.Balance_net;
var obj = document.getElementById("net_bal");
var style = "background-color:"+PHP.Color_home+";text-align:center;border-color:#000;";
if (val<-0.001) {
	obj.style = style+"color:#f66;";
} else {
	obj.style = style+"color:#fff;";
}
obj.innerHTML = moneyFormat(""+val);
var val = PHP.Balance_cash;
var obj = document.getElementById("cash_bal");
var style = "background-color:"+PHP.Color_home+";text-align:center;border-color:#000;";
if (val<-0.001) {
	obj.style = style+"color:#f66;";
} else {
	obj.style = style+"color:#fff;";
}
obj.innerHTML = moneyFormat(""+val);
var val = PHP.Balance_debt;
var obj = document.getElementById("debt_bal");
var style = "background-color:"+PHP.Color_home+";text-align:center;border-color:#000;";
if (val<-0.001) {
	obj.style = style+"color:#fff;";
} else {
	obj.style = style+"color:#f66;";
}
obj.innerHTML = moneyFormat(""+val);
var val = PHP.Balance_receivables;
var obj = document.getElementById("receivables_bal");
var style = "background-color:"+PHP.Color_home+";text-align:center;border-color:#000;";
if (val<-0.001) {
	obj.style = style+"color:#f66;";
} else {
	obj.style = style+"color:#fff;";
}
obj.innerHTML = moneyFormat(""+val);
