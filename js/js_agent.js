var XMLHttpRequestObject = false;
if (window.XMLHttpRequest)
{
  XMLHttpRequestObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
  XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

var xmlHttp;
function load_content(adres)
{
      if(xmlHttp==null)
      { //w zależności od przeglądarki tworzymy obiekt XMLHTTP
         if(window.ActiveXObject)xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); //dla IE
	 else if(window.XMLHttpRequest)xmlHttp = new XMLHttpRequest();  //Firefox, Opera, Safari itp.
      }
      if (xmlHttp == null){alert("Nie udało się zainicjować obiektu xmlHttpRequest!");return;} //jeśli obiekt nie został utworzony, zwracamy, błąd a skrypt zostaje przerwany

      xmlHttp.onreadystatechange = function(){ //funkcja ma za zadanie wyświetlić wyniki zwrócone przez serwer
         if (xmlHttp.readyState == 4 || xmlHttp.status == 200) //sprawdzamy czy udało się pobrać zawartość strony (readyState=4) lub czy serwer nie zwrócił błędu(status=200 oznacza że jest OK)
         document.getElementById("content").innerHTML = xmlHttp.responseText; //zwrócony tekst zapisujemy do warstwy i tu nie przepiuje polskich znaków!!! metodą get..

      };
      xmlHttp.open("POST", adres); //ustawiamy metodę i adres żądania
	  //XMLHttpRequestObject.setRequestHeader('Content-Type' ,'application/x-www-form-urlencode');//!!! po zakomentowaniu zadziało, funcja tego nie znana
      xmlHttp.send(null); //wysyłamy żądanie
	  xmlHttp.overrideMimeType('text/html; charset=utf-8');
}

function swiec(a, maks)
{
        for(ir=1;ir<=maks;ir++)
         {
           document.getElementById("m"+ir).className = "noactive";
         }
        document.getElementById("m"+a).className = "active";
}

function sprawdz1(formularz)
{
	i=2;
	
		var pole = formularz.elements[i];
		if (!pole.disabled && !pole.readonly && (pole.type == "text" || pole.type == "password" || pole.type == "textarea") && pole.value == "")
		{
			alert("Podaj dane kontaktowe!");
			return false;
		}
	
	return true;
}

//Komentarz ?
function flash(id, kolor, czas, kolor2, czas2)
{
	document.getElementById(id).style.color = kolor;
	setTimeout('flash("' + id + '","' + kolor2 + '",' + czas2 + ',"' + kolor + '",' + czas + ')', czas);
}
