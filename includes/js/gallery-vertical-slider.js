jQuery(document).ready(function ($) {
  //vertical width
  var mg_vrt_width = document.getElementById('mg_vrt_width');
  var dispVerWidth = document.getElementById('mg_displyVert_wdth');
  dispVerWidth.innerHTML = mg_vrt_width.value;
  mg_vrt_width.oninput = function () {
    dispVerWidth.innerHTML = this.value;
  }
  //vertical height
  var mg_vrt_height = document.getElementById('mg_vrt_height');
  var mg_Vslide_height = document.getElementById('mg_Vslide_height');
  mg_Vslide_height.innerHTML = mg_vrt_height.value;
  mg_vrt_height.oninput = function () {
    mg_Vslide_height.innerHTML = this.value;
  }
  //ThumbWidth
  var mg_thmb_width = document.getElementById('mg_thmb_width');
  var mg_thumbVWidt = document.getElementById('mg_thumbVWidt');
  mg_thumbVWidt.innerHTML = mg_thmb_width.value;
  mg_thmb_width.oninput = function () {
    mg_thumbVWidt.innerHTML = this.value;
  }
  //Show maximumThumb
  var mg_max_thumb = document.getElementById('mg_max_thumb');
  var mg_show_maxthumb = document.getElementById('mg_show_maxthumb');
  mg_show_maxthumb.innerHTML = mg_max_thumb.value;
  mg_max_thumb.oninput = function () {
    mg_show_maxthumb.innerHTML = this.value;
  }

  //breakpoints
  //breakpoints 480px height
  var mg_brekvrt_height = document.getElementById('mg_brekvrt_height');
  var mg_Vslide_brkheight = document.getElementById('mg_Vslide_brkheight');
  mg_Vslide_brkheight.innerHTML = mg_brekvrt_height.value;
  mg_brekvrt_height.oninput = function () {
    mg_Vslide_brkheight.innerHTML = this.value;
  }

  //breakpoints 480px thumbitems
  var mg_max_brkthumb = document.getElementById('mg_max_brkthumb');
  var mg_show_brkmaxthumb = document.getElementById('mg_show_brkmaxthumb');
  mg_show_brkmaxthumb.innerHTML = mg_max_brkthumb.value;
  mg_max_brkthumb.oninput = function () {
    mg_show_brkmaxthumb.innerHTML = this.value;
  }

  //breakpoints 641px height
  var mg_vrt_sixfoheight = document.getElementById('mg_vrt_sixfoheight');
  var mg_Vslide_sixfouroneheight = document.getElementById('mg_Vslide_sixfouroneheight');
  mg_Vslide_sixfouroneheight.innerHTML = mg_vrt_sixfoheight.value;
  mg_vrt_sixfoheight.oninput = function () {
    mg_Vslide_sixfouroneheight.innerHTML = this.value;
  }

  //breakpoints 641px thumbitems
  var mg_max_sixforthumb = document.getElementById('mg_max_sixforthumb');
  var mg_show_sixfomaxthumb = document.getElementById('mg_show_sixfomaxthumb');
  mg_show_sixfomaxthumb.innerHTML = mg_max_sixforthumb.value;
  mg_max_sixforthumb.oninput = function () {
    mg_show_sixfomaxthumb.innerHTML = this.value;
  }

  //breakpoints 800px height
  var mg_vrt_eightheight = document.getElementById('mg_vrt_eightheight');
  var mg_Vslide_eightheight = document.getElementById('mg_Vslide_eightheight');
  mg_Vslide_eightheight.innerHTML = mg_vrt_eightheight.value;
  mg_vrt_eightheight.oninput = function () {
    mg_Vslide_eightheight.innerHTML = this.value;
  }

  //breakpoints 800px thumbitems
  var mg_max_eigthumb = document.getElementById('mg_max_eigthumb');
  var mg_show_eightmaxthumb = document.getElementById('mg_show_eightmaxthumb');
  mg_show_eightmaxthumb.innerHTML = mg_max_eigthumb.value;
  mg_max_eigthumb.oninput = function () {
    mg_show_eightmaxthumb.innerHTML = this.value;
  }
});