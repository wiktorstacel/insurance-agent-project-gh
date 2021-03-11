/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

const cookieContainer = document.querySelector(".cookie_container");
const cookieButton = document.querySelector(".cookie_button");

cookieButton.addEventListener('click', () => {
    cookieContainer.classList.remove("active");
    localStorage.setItem("cookieBannerDisplayed", "true");
})

setTimeout(() => {
    if(!localStorage.getItem("cookieBannerDisplayed")){
    cookieContainer.classList.add("active");
    }
}, 2000)

//it was tried to put this code here beacause now is loaded dynamicaly with form - in this case would be static down on each page
//src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
//        async defer


//const node1 = document.getElementsByClassName('title'); //gives HTMLCollection - index[0..1..2..n.length] array pod warunkiem dodania: Array.from(document.getElementsByClassName('title'))
//console.log(node1);
/*const button1 = document.querySelector('.btn-1234');
console.log(button1);
button1.addEventListener('click', e => {
    console.log(e.target.name);
    const button2 = document.getElementsByName('button_click_me');
    console.log(button2);
});*/


//const titles = document.querySelector('h1');
//console.log(titles);


//let vals = [5,4,9,2,1];

/*function isEven(num) {
    return (num%2 == 0) 
}
vals = vals.filter(isEven);*/

/*vals = vals.filter(x => !(x % 2 == 1))
console.log(vals);*/

/*let s = "It was  a dark and stormy night.";
let words = s.split(/\W+/).filter(word => word.length);// >= 3
console.log(words);*/

/*let vals = [4,8,1,2,9];
console.log(vals);
vals = vals.map(x => x * 2);
console.log(vals);*/

/*vals = Array(100).fill(0).map(Math.random);
console.log(vals);*/


//ADDING ELEMENT TO THE PAGE
/*const temp = document.getElementById("links");
const div = document.createElement("div");
const strong = document.createElement("strong"); //the same effect as: div.innerHtml = "<strong>Hello World</strong>"
strong.innerText = "Hello World 3";              //
div.append(strong);                              //
temp.append(div);*/


/*const temp = document.getElementById("links");
//temp.append("Hello World"); //wstawienie string
const div = document.createElement("div");
div.innerText = "Hello World"; //div.textContent = "Hello World 2";
//temp.appendChild(div); //działa bo wstawia node
temp.append(div);*/


//REMOVING ELEMENT FROM THE PAGE
/*const temp = document.getElementById("footer");
const div = document.querySelector('#links');
div.remove(); //usuwa całkiem element ze strony
temp.append(div); //dodaje spowrotem w tym przypadku*/


/*const temp = document.getElementById("footer");
const div = document.querySelector('#links');
temp.removeChild(div);*/


//ATTRIBUTE
/*const temp = document.getElementById("footer");
//console.log(temp.getAttribute('title')); // to samo: console.log(temp.title);
//console.log(temp.setAttribute('name', 'footerek')); //to samo: temp.name = 'footerek' - ale tylko to zmiany wart jak już atrybut istnieje
temp.removeAttribute('title');*/


//DATASET
/*const temp = document.getElementById("footer");
console.log(temp.dataset.test);
console.log(temp.dataset.longerName);
temp.dataset.newName = "Vishwas";*/


//CLASSES
/*const temp = document.getElementById("footer");
temp.style.backgroundColor = "red"; //UWAGA background-color ===>>> backgroundColor - w takim użyciu (nie w css)
 */


//DOM Traversal
/*const node1 = Array.from(document.getElementsByClassName('title')); //HTMLCollection
console.log(node1);
node1.forEach(changeColor);*/


/*const node1 = document.querySelectorAll('.title'); //NodeList
console.log(node1);
node1.forEach(changeColor); //przy querySelectorAll nie trzeba Array.from (jak getElementsByClassName)żeby wykonać forEach
*/


//https://www.youtube.com/watch?v=v7rSSy8CaYE&list=WL&index=2 7:47
//Grandparent, Parent, Children - podobne jak VolleyManager i odczytywanie XML
/*const grandparent = document.querySelector(".grandparent");
const parents = Array.from(grandparent.children); //(1 poziom niżej) //Array dla możliwości użycia forEach
const parentOne = parents[0];
const parentTwo = parentOne.nextElementSibling; //(ten sam poziom, kolejny element)
const parentOne = parentTwo.previousElementSibling; // (ten sam poziom, poprzedni element)
const children = parentOne.children; //(jeszcze 1 poziom niżej)
changeColor(children[0])*/


/*const grandparent = document.querySelector(".grandparent");
const children = grandparent.querySlectorAll(".child"); //przejście 2 poziomy niżej
children.forEach(changeColor);*/


//Function for few examples above
/*function changeColor(element) {
    element.style.backgroundColor = "red";
}*/