const inpValue = document.querySelector(".hd input")
const cancel = document.querySelector(".icon")
const chats = document.querySelector(".allcon .chats");



cancel.onclick = () => {
    inpValue.classList.toggle("active")
    //inpValue.focus()
    inpValue.value = "";
}


inpValue.onkeyup = () => {
    const searchValue = inpValue.value
    if(searchValue !== "") {
        inpValue.classList.add("active")
    }
    else {
        inpValue.classList.remove("active")
    }
    const xhttp = new XMLHttpRequest()
    xhttp.onload = () => {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
            let data = xhttp.response
            chats.innerHTML = data
        }
    }
    xhttp.open("POST","search.php", true)
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded")
    xhttp.send("searchValue=" + searchValue);
}


setInterval(() => {
    
    const xhttp = new XMLHttpRequest()
    xhttp.onload = () => {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
            let data = xhttp.response
            if(!inpValue.classList.contains("active")) {
                chats.innerHTML = data
            }
        }
    }
    xhttp.open("GET","users.php",true)
    xhttp.send()
}, 500)