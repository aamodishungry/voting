let loading= document.getElementById("loading");
setTimeout(function(){
    loading.style.opacity=0;
    setTimeout(function(){
        loading.style.display = "none";
    },500);
},3000);
// For buttons with class 'side'
const buttonClicklogin= document.querySelector(".side");
buttonClicklogin.addEventListener("click",function(){
    window.location.href="auth.htm?mode=login";
});
// For buttons with class 'down'
const buttonClicklog= document.querySelector(".down");
buttonClicklog.addEventListener("click",function(){
    window.location.href="auth.htm?mode=login";
});
//for About US!
const buttonide = document.querySelector(".up");
buttonide.addEventListener("click",function(){window.location.reload()});
const buttonClicksign= document.querySelector(".sign");
buttonClicksign.addEventListener("click",function(){
    window.location.href="auth.htm?mode=signup";
});