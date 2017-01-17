var gl_mobile_menu = document.getElementById( "glMobileMenu" );

gl_mobile_menu.addEventListener( "click", handle_nav_click, false );

function handle_nav_click() {

    var gl_nav = document.getElementById( "glNav" );

    var gl_nav_display_prop = getComputedStyle( gl_nav ).display;

    if ( gl_nav_display_prop == 'none' ) {

        show_navigation();

    } else if ( gl_nav_display_prop == 'block' ) {

        hide_navigation();

    }

}

function setClass( el, className ) {

    if ( el.classList )

        el.classList.add( className );

    else

        el.className += ' ' + className;

}

function removeClass( el, className ) {

    if ( el.classList )

        el.classList.remove( className );

    else

        el.className = el.className.replace( new RegExp( '(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi' ), ' ' );

}

window.addEventListener( 'resize', handle_nav_resize, false );

function handle_nav_resize() {

    if ( window.innerWidth < 768 ) {

        hide_navigation();

    } else {

        show_navigation();

    }

}

function show_navigation() {

    var gl_nav = document.getElementById( "glNav" );

    gl_nav.style.display = 'block';

    setClass( gl_mobile_menu, 'toggled' );

}

function hide_navigation() {

    var gl_nav = document.getElementById( "glNav" );

    gl_nav.style.display = 'none';

    removeClass( gl_mobile_menu, 'toggled' );

}

var gl_popup_overlay = document.getElementById( "glPopupOverlay" );

gl_popup_overlay.addEventListener( "click", handle_overlay_click, false );

var gl_popup_close = document.getElementById( "glPopupClose" );

gl_popup_close.addEventListener( "click", handle_close_click, false );

var gl_popup = document.getElementById( "glPopup" );

function handle_overlay_click(){

    close_gl_popup();

}

function handle_close_click(){

    close_gl_popup();

}

document.addEventListener( 'keyup', function( e ) {

    if( e.keyCode == 27 ) {

        close_gl_popup();

    }

}, false );

function close_gl_popup(){

    gl_popup_overlay.style.display = 'none';
    gl_popup.style.display = 'none';

    var gl_popup_content = document.getElementById( 'glPopupContent' );

    var gl_sections = gl_popup_content.children;

    for ( var index = 0; index < gl_sections.length; ++index) {
        gl_sections[index].style.display = 'none';
    }

}

function openPopup( section_id ) {

    close_gl_popup();

    var gl_section = document.getElementById( section_id );

    gl_popup_overlay.style.display = 'block';

    gl_popup.style.display = 'block';

    gl_section.style.display = 'block';

}

var item_one = document.getElementById( 'itemOne' );

item_one.addEventListener( 'click', function( event ){

    event.preventDefault();

    openPopup( 'sectionOne' );

}, false );

var item_two = document.getElementById( 'itemTwo' );

item_two.addEventListener( 'click', function( event ){

    event.preventDefault();

    openPopup( 'sectionTwo' );

}, false );