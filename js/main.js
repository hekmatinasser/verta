let menu, flat_menu = [];


$(document).ready(function () {
    $.getJSON('assert/content.min.json?v=1', function(response) {
        menu = response.data;
        flat(menu);
        fill(menu);
        $(".content article").html(generateContent(response.data));
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
function generateContent(items) {
    let markup = '';
    for(let i in items) {
        let item = items[i];
        markup += `<section id="${item.id}">`
        if(item.title) {
            markup += `<h2>${item.title}</h2>`
        }
        if(item.description) {
            markup += `<p>${item.description}</p>`
        }
        if(item.raw) {
            markup += item.raw
        }
        if (item.hasOwnProperty('children')) {
            markup += generateEntity(item.children, item.id)
        }
        markup += `</section>`
    }
    return markup;
}
function generateEntity(items) {
    let markup = '';
    for(let i in items) {
        let item = items[i];
        markup += `<div class="entity" id="${item.id}">`
        markup += `<h3 class="name"><a href="#${item.id}">${item.title}</a></h3>`
        markup += `<p class="description">${item.description}</p>`
        if(item.raw) {
            markup += item.raw
        }
        if(item.arguments) {
            markup += `<h4>Arguments</h4>`;
            markup += `<ul class="arguments">`;
            for(let key in item.arguments) {
                let argument = item.arguments[key];
                markup += `<li><span class="type">${argument.type}</span>: <span class="name">${argument.name}</span>`;
                if(argument.descrption) {
                    markup += `<p class="description">${argument.descrption}</p>`;
                }
                markup += `</li>`;
            }
            markup += `</ul>`
        }
        if(item.return) {
            markup += `<h4>Return</h4>`;
            markup += `<p class="return">${item.return}</p>`;
        }
        if(item.exception) {
            markup += `<h4>Exception</h4>`;
            markup += `<p class="exception">${item.exception}</p>`;
        }
        if(item.example) {
            markup += `<h4>Example</h4>`;
            markup += `<pre class="example"><code class="language-php">${item.example}</code></pre>`;
        }
        markup += `</div>`
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
