/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | wessie - web site system                                             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2001 Michal Cihar                                      |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 |
// | USA                                                                  |
// +----------------------------------------------------------------------+
// | Authors: Michal Cihar <cihar at email dot cz>                        |
// +----------------------------------------------------------------------+
//
// $Id$

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

function open_browse_window(dir){
    close_browse_window=1;
    browse_window=window.open('./file_list.php?dir='+dir,'Select file','personalbar=0,status=0,dependent=1,toolbar=0,height=400,width=472,innerHeight=400,innerWidth=462');
    return true;
}

/* Following part is taken from Riki Fridrich (http://acid.nfo.sk) and a bit modified: */
function gE(e,f){
    if(document.layers){
        f=(f)?f:self;
        var V=f.document.layers;
        if(V[e])
            return V[e];
        for(var W=0;W<V.length;)
            t=gE(e,V[W++]);
        return t;
    }
    if(f.document.all)
        return f.document.all[e];
    return f.document.getElementById(e);
}
