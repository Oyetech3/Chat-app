const form = document.querySelector(".form")
const inputText = form.querySelector(".msg")
const sendMsg = form.querySelector("button")
const content = document.querySelector(".content")


form.onsubmit = (e) => {
    e.preventDefault()
}

content.onmouseenter = () => {
    content.classList.add("active")
}
content.onmouseleave = () => {
    content.classList.remove("active")
}

sendMsg.onclick = () => {
    const xhttp = new XMLHttpRequest()
    xhttp.open("POST","sendmsg.php",true)
    xhttp.onload = () => {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
            //let data = xhttp.response
            //console.log(data)
            inputText.value = ""
            autoScroll();
        }
    }
    //xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded")
    let newForm = new FormData(form)
    xhttp.send(newForm)
}

setInterval(() => {
    const xhttp = new XMLHttpRequest()
    xhttp.open("POST","getmsg.php",true)
    xhttp.onload = () => {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
            let data = xhttp.response
            content.innerHTML = data
            if(!content.classList.contains("active")) {
                autoScroll()
            }
        }
    }
    let newForm = new FormData(form)
    xhttp.send(newForm)
}, 500);

function autoScroll() {
    content.scrollTop = content.scrollHeight
}