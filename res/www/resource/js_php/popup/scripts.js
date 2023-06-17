

function addAnimation(body) {
    let dynamicStyles = null;
    if (!dynamicStyles) {
        dynamicStyles = document.createElement('style');
        document.head.appendChild(dynamicStyles);
    }

    dynamicStyles.sheet.insertRule(body, dynamicStyles.length);
}

function popupEvent(text){
    console.log("popupEvent");
    let popup_root = document.createElement("div");
    popup_root.className = "popup_root";
    let popup_span_area = document.createElement("div");
    popup_span_area.className = "popup_span_area";
    let popup_bg = document.createElement("div");
    popup_bg.className = "popup_bg";
    let span = document.createElement("span");
    span.innerText = text;
    let popup_scroll = document.getElementById("popup_scroll");
    let popup_root_on_delete = [];
    popup_scroll.querySelectorAll('.popup_root').forEach((elem) => {
        if (elem.offsetHeight===0){
            popup_root_on_delete.push(elem);
        }
    });
    Array.prototype.forEach.call( popup_root_on_delete, function( node ) {
        node.parentNode.removeChild( node );
    });
    popup_span_area.appendChild(span);
    popup_root.appendChild(popup_span_area);
    popup_root.appendChild(popup_bg);
    popup_scroll.appendChild(popup_root);
    let height = popup_root.offsetHeight;
    popup_root.style.height = "0";
    popup_root.style.animation = "popup_collapse 10s 1";
    console.log(height);
    addAnimation(`
@keyframes popup_collapse  {

  0% {
    opacity: 0;
    height: 0;
  }
  10%{
    height: `+height+`px
  }
  30%,
  70% {
    opacity: 1;

  }
  80% {

    opacity: 0;
    height: `+height+`px
  }
  100%{
    height: 0;
  }

}
    `);

}