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