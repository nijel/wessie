if(top != self) { window.top.location.href=location; }

function highlight(what,color){
    if (typeof(what.style) != 'undefined'){
        oldBackground=what.style.backgroundColor;
        what.style.backgroundColor = color;
    }
    return true;
}

function unhighlight(what){
    if (typeof(what.style) != 'undefined') what.style.backgroundColor = oldBackground;
    return true;
}