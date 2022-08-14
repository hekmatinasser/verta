let menu, flat_menu = [];


$(document).ready(function () {
    $.getJSON('assert/content.min.json?v=1', function(response) {
        menu = response.data;
        flat(menu);
        hljs.highlightAll();
    });
})

function fill(data, child) {
    $("#menu").html(generateMenu(data, child))
}
function search() {
    let term = document.getElementById("search").value.toLowerCase();
    if(term) {
        fill(flat_menu.filter(function (item) {
            return item.name.toLowerCase().search(term) > -1
        }), term);
    }
    else {
        fill(menu);
    }
}
function generateMenu(items, child) {
    let markup = '';
    for(let i in items) {
        let item = items[i];
        markup += `<li><a ${child ? 'class="child"' : 'class="parent"'} href="#${item.id}">${item.name}</a>`
        if (item.hasOwnProperty('children')) {
            markup += `<ul>${generateMenu(item.children, item.id)}</ul>`
        }
        markup += `</li>`
    }
    return markup;
}
function flat(items) {
    for(let i in items) {
        let item = items[i];
        flat_menu.push({
            "id": item.id,
            "name": item.name,
        })
        if (item.hasOwnProperty('children')) {
            flat(item.children);
        }
    }
}
