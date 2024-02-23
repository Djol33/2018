function makeAjax(){
    let xhr = new XMLHttpRequest();
    let filter = document.querySelector("#filter").value;
    xhr.open("GET", `admin_filter.php?filter=${filter}`);
    xhr.send()
    xhr.onreadystatechange = function () {
        if(xhr.readyState==4, xhr.status==200){
            let res = JSON.parse(xhr.responseText);
            let str="<tbody>"
            for(let i = 0; i<res.length ;i++){
                str+=`<tr><td>${res[i].id}</td>
                <td>${res[i].naslov}</td><td>${res[i].tekst}</td>
                <td><img src='${res[i].slika}' alt ='slika'/></td>
                <td>${res[i].datum}</td>
                </tr>
                `
            }
            str+="</tbody>";
            let tbody = document.querySelector("tbody");
            tbody.innerHTML=str;
        }
      }
}
window.addEventListener("load", function(){
    makeAjax();
})
let filter = document.querySelector("#filter")
filter.addEventListener("change", function(){
    makeAjax();
})