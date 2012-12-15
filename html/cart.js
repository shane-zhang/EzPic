var Shopping_List;
var Order = 0;
var MyCart = new Array();
var list = new Array();
MyCart['name'] = new Array();
MyCart['count'] = new Array();
MyCart['price'] = new Array();
var INIT = false;
var Old_Cookie = getCookie("cart");

if(Old_Cookie==null)
{
//	alert("Welcome!");
}
else
{
//	alert("Second");
	var Cookie_Handle = Old_Cookie.split(";");
	Cookie_Handle.pop();
	var i=0;
	for(TempItem in  Cookie_Handle)
	{
		MyCart['count'][Cookie_Handle[TempItem].split(',')[0]]=Cookie_Handle[TempItem].split(',')[1];
		list[i++]=Cookie_Handle[TempItem].split(',')[0];
	}
	
	window.Order = Cookie_Handle.length;
	
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var All_Goods;
			All_Goods = xmlhttp.responseText.split(';');
			All_Goods.pop();
			for(TempItem in All_Goods)
			{
				if(MyCart['count'][All_Goods[TempItem].split(',')[0]]!=null)
				{
					MyCart['name'][All_Goods[TempItem].split(',')[0]] = All_Goods[TempItem].split(',')[1];
					MyCart['price'][All_Goods[TempItem].split(',')[0]] = All_Goods[TempItem].split(',')[2];
					getFresh();
				}
			}
		}
	}
	xmlhttp.open("GET","goods.php?catid=all",true);
	xmlhttp.send();
}

function setCookie(c_name,value,exdays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate()+exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie = c_name + "=" +c_value;
}

function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}


function loadXMLDoc(InCatid)
{
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open("GET","goods.php?catid="+InCatid,false);
	xmlhttp.send();
	var good = document.getElementById("Goods")
	good.innerHTML=xmlhttp.responseText;
}

function buySomething(InPid,InName,InPrice)
{
	if(MyCart['count'][InPid]!=undefined)
	{
		MyCart['count'][InPid]++;
	}
	else
	{
		MyCart['count'][InPid] = 1;
		MyCart['name'][InPid] = InName;
		MyCart['price'][InPid] = InPrice;
		list[Order] = InPid;
		Order++;
	}
	getFresh();
	getCookieFresh();
}

function getDetail(InPid)
{
	var loader = new XMLHttpRequest();
	loader.open("GET","details.php?pid="+InPid,false);
	loader.send();
	var box = document.getElementById("box");
	var temp = document.createElement("div");
	temp.innerHTML = loader.responseText;
	temp = temp.getElementsByClassName("det")[0];
	box.innerHTML = temp.innerHTML;
	box.style.display="block";
	var backStr = '<button type="button" onclick="closeBox()">close</button>';
	box.innerHTML = box.innerHTML+backStr;
}

function closeBox()
{
	var box = document.getElementById("box");
	box.style.display="none";
}

function openBox(ID)
{
	var injection = document.getElementById(ID);
	var box = document.getElementById("box");
	box.innerHTML = injection.innerHTML;
	box.style.display="block";
}

function getCookieFresh()
{
	var Str_Cookie="";
	for(TempItem in MyCart['count'])
	{
		Str_Cookie += TempItem + ','+MyCart['count'][TempItem]+';';
	}
	setCookie("cart",Str_Cookie);
}

function getFresh()
{
	Shopping_List = 'What you have bought:<br /><table border="1">\n<tr><th>Name</th><th>Number</th><th>Total</th><th>+</th><th>-</th></tr>';
	document.getElementById('list').innerHTML="";
	for(var i=0;i<Order;i++)
	{
		var TempItem = list[i];
		var li = document.createElement('li');
		li.innerHTML = MyCart['name'][TempItem];
		var span1 = document.createElement('span');
		span1.innerHTML = MyCart['count'][TempItem];
		li.appendChild(span1);
		var span2 = document.createElement('span');
		span2.innerHTML = MyCart['price'][TempItem];
		li.appendChild(span2);
		document.getElementById('list').appendChild(li);
		var input1 = document.createElement('input');
		input1.setAttribute('type','hidden');
		input1.setAttribute('name','item_number_'+(i+1));
		input1.setAttribute('value',TempItem);
		li.appendChild(input1);
		var input2 = document.createElement('input');
		input2.setAttribute('type','hidden');
		input2.setAttribute('name','item_name_'+(i+1));
		input2.setAttribute('value',MyCart['name'][TempItem]);
		li.appendChild(input2);
		var input3 = document.createElement('input');
		input3.setAttribute('type','number');
		input3.setAttribute('name','quantity_'+(i+1));
		input3.setAttribute('value',MyCart['count'][TempItem]);
		li.appendChild(input3);
		var input4 = document.createElement('input');
		input4.setAttribute('type','hidden');
		input4.setAttribute('name','amount_'+(i+1));
		input4.setAttribute('value',MyCart['price'][TempItem]);
		li.appendChild(input4);
		
		Shopping_List = Shopping_List + "\n<tr>"+"<td>"+MyCart['name'][TempItem] +"</td>"+"<td>"+"&#167;"+MyCart['count'][TempItem]+"</td>"+"<td>"+MyCart['price'][TempItem]*MyCart['count'][TempItem]+"</td>"+'<td><button type="button" onclick="addGoods('+TempItem+')">+</button></td>'+'<td><button type="button" onclick="dropGoods('+TempItem+')">-</button></td>'+"</tr>";
	}
	var sum;
	sum = 0;
	for(TempItem in MyCart['count'])
	{
		sum += MyCart['price'][TempItem]*MyCart['count'][TempItem];
	}
	Shopping_List = Shopping_List + '<tr><th colspan="3">'+"All_Total<span id='amount'>"+sum+"</span></th></tr>";
	Shopping_List = Shopping_List + "</table>"+'<br /><button type="button" onclick="reset()">Empty</button>';
	document.getElementById("Shopping_List").innerHTML = Shopping_List;
	if(INIT==true)
	{
		window.Interface.updateItem(Order);
	}
}

function reset()
{
	alert("Empty?");
	MyCart['name'] = new Array();
	MyCart['count'] = new Array();
	MyCart['price'] = new Array();
	Order = 0;
	setCookie("cart","");
	getFresh();
}

function buyThem(a)
{
	if(document.getElementById("amount")==null||parseFloat(document.getElementById("amount").innerHTML)==0)
	{
		return false;
	}
	else
	{
//		json = JSON.stringify(MyCart['count']);
//		alert(json);
		var bill="";
		for(TempItem in MyCart['count'])
		{
			bill += TempItem + ','+MyCart['count'][TempItem]+';';
		}
		
		var xmlhttp;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function()
		{
			var temp = "";
			temp += xmlhttp.readyState;
			temp += "This is temp";
			temp += xmlhttp.status;
//			alert(temp);
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var temp = xmlhttp.responseText.split(';');
//				alert(xmlhttp.responseText);
				a.invoice.value =  temp[1];
//				alert(temp[1]);
				a.custom.value = temp[0];
//				alert(temp[0]);
				
				MyCart['name'] = new Array();
				MyCart['count'] = new Array();
				MyCart['price'] = new Array();
				Order = 0;
				setCookie("cart","");
				a.submit();
			}
		}
		
		var json = bill.split(";");
		json.pop();
		var CartJSONPid = new Array();
		var CartJSONNum = new Array();
		var CartJSON1 = {};
		CartJSON1["currency"] = a.currency_code.value;
		CartJSON1["merchant"] = a.business.value;
		CartJSON1["cart"] = new Array();
		for(TempItem in  json)
		{
			CartJSONPid[TempItem]=json[TempItem].split(',')[0];
			CartJSONNum[TempItem]=json[TempItem].split(',')[1];

			CartJSON1["cart"][TempItem] = {};
			CartJSON1["cart"][TempItem]["pid"] = CartJSONPid[TempItem];
			CartJSON1["cart"][TempItem]["num"] = CartJSONNum[TempItem];
		}
		
//		alert(JSON.stringify(CartJSON1));
		
		bill = "bill="+JSON.stringify(CartJSON1);
//		alert(bill);
		
		xmlhttp.open("POST","bill_process.php",true);
		
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("Content-length", bill.length);
		xmlhttp.setRequestHeader("Connection", "close");
		xmlhttp.send(bill);
//		alert(bill);
		return false;
	}
}

function addGoods(InPid)
{
	MyCart['count'][InPid]++;
	getCookieFresh();
	getFresh();
}

function dropGoods(InPid)
{
	MyCart['count'][InPid]--;
	getCookieFresh();
	if(MyCart['count'][InPid]==0)
	{
		delete MyCart['count'][InPid];
		delete MyCart['name'][InPid];
		delete MyCart['price'][InPid];
		alert("Clear Out!");
		setCookie("cart","");
	}
	getFresh();
}

function androidInit()
{
	window.INIT = true;
	var left = document.getElementById("left");
	left.style.display = "none";
}