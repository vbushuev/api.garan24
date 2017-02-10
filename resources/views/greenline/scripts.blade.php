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


    <!-- Yandex.Metrika counter -->
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter{{$yandex_metric or $yandexCounterId}} = new Ya.Metrika({
                    id:{{$yandex_metric or $yandexCounterId}},
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");

    if(document.getElementById( 'howtobuy' )!=null)document.getElementById( 'howtobuy' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_howtobuy' );}, false );
    if(document.getElementById( 'shipping' )!=null)document.getElementById( 'shipping' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_shipping' );}, false );
    if(document.getElementById( 'payment' )!=null)document.getElementById( 'payment' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_payment' );}, false );
    if(document.getElementById( 'installments' )!=null)document.getElementById( 'installments' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_installments' );}, false );
    if(document.getElementById( 'sale' )!=null)document.getElementById( 'sale' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_sale' );}, false );
    if(document.getElementById( 'about' )!=null)document.getElementById( 'about' ).addEventListener( 'click', function( event ){event.preventDefault();openPopup( 'section_about' );}, false );
