window.nightMode = _ => {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) return;

    for(let i=0; i<240;i++){
        let star=document.createElement("div")
        star.setAttribute("class", "star");
        document.body.appendChild(star)
    }
}
