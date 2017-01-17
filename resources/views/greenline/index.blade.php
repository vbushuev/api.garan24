<style>
    @import url("//fonts.googleapis.com/css?family=Lato:100|Open+Sans:300,400,800&subset=latin,cyrillic");
    @import url("//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
    .gl-clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    .gl {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
        height:50px;
        line-height: 50px;
    }

    .gl-container {
        background-color: #00bf80;
        position: relative;
        height:50px;
        line-height: 50px;
    }

    .gl-container a {
        display: inline-block;
        color: #fff;
        text-decoration: none;
        font-family: sans-serif;
        line-height: 1.6em;
        padding: 10px 15px;
    }

    .gl-header {
        width: 100%;
        height:50px;
        line-height: 50px;
    }

    .gl-logo {
        float: left;
        height:50px;
        line-height: 50px;
    }

    .gl-container a:hover {
        color: #444;
    }

    .gl-nav {
        display: none;
    }

    .gl-nav ul {
        display: block;
        list-style: none;
        padding: 0;
        margin: 0;

    }

    .gl-nav ul li {
        display: block;
        height:50px;
        line-height: 50px;
    }

    .gl-nav ul li a {
        font-family: 'Lato', 'Open Sans', Helvetica, Arial, sans-serif;
        font-weight: normal;
        font-size: 0.9em;
    }

    .gl-mobile-menu-icon {
        float: right;
    }

    .gl-mobile-menu-icon button {
        background: none;
        border: none;
        color: #fff;
        font-size: 1em;
        line-height: 1.6em;
        padding: 10px 15px;
        text-transform: uppercase;
        font-weight: bold;
        cursor: pointer;
    }

    .gl-mobile-menu-icon button:focus {
        outline: none;
    }

    .gl-mobile-menu-icon button:hover {
        color: #444;
    }

    .gl-mobile-menu-icon button.toggled {
        color: #444;
    }

    .gl-popup-overlay {
        width: 100%;
        height: 100%;
        top: 45px;
        background: rgba(0,0,0,0.7);
        position: fixed;
        z-index: 9997;
        cursor: pointer;
    }

    .gl-popup {
        position: fixed;
        top: 45px;
        background: #fff;
        padding: 15px;
        width: 100%;
        max-width: 1170px;
        z-index: 9998;
        transform: translateX(-50%);
        left: 50%;
        min-height: 20px;
        box-sizing: border-box;
        box-shadow: 0 4px 24px rgba(0,0,0,0.5);
    }

    .gl-popup-close {
        display: block;
        float: right;
        line-height: 40px;
        font-size: 14px;
        text-transform: uppercase;
        background: none;
        border: none;
        cursor: pointer;
        color: #777;
        transition: all 0.2s ease-in;
        padding: 0;
    }

    .gl-popup-close:focus {
        outline: none;
    }

    .gl-popup-close:hover {
        color: red;
    }

    .gl-popup-content {
        max-height: 25em;
        overflow-y: scroll;
        width: 100%;
    }

    .gl-mobile-invisible {
        display: none;
    }

    .gl-row {
        height:inherit;
        line-height: inherit;
    }

    @media screen and (min-width: 768px) {

        .gl-logo {
            float: left;
        }

        .gl-nav {
            display: block;
        }

        .gl-nav ul {
            display: inline-block;
        }

        .gl-nav__left {
            float: left;
        }

        .gl-nav__right {
            float: right;
        }

        .gl-nav ul li {
            float: left;
        }

        .gl-header {
            width: auto;
            float: left;
        }

        .gl-mobile-menu-icon {
            display: none;
        }

        .gl-mobile-visible {
            display: none;
        }

        .gl-mobile-invisible {
            display: inline;
        }

    }

    @media screen and (min-width: 1024px) {



    }

    @media screen and (min-width: 1200px) {

        .gl-row {
            width: 1170px;
            margin: 0 auto;
        }

    }
</style>
<link href="css/greenline.css" rel="stylesheet">
<div class="gl">
    <div class="gl-container">
        <div class="gl-row gl-clearfix">
            <div class="gl-header gl-clearfix">
                <div class="gl-logo">
                    <a href="#"><strong>Gauzymall</strong></a>
                </div>
                <div class="gl-mobile-menu-icon">
                    <button id="glMobileMenu"><i class="fa fa-bars" aria-hidden="true"></i></button>
                </div>
            </div>
            <nav class="gl-nav" id="glNav">
                <ul class="gl-nav__left gl-clearfix">
                    <li><a href="javascript:{0}" id="itemOne">Как купить</a></li>
                    <li><a href="javascript:{0}" id="itemTwo">Доставка</a></li>
                    <li><a href="javascript:{0}">Оплата</a></li>
                    <li><a href="javascript:{0}">Рассрочка</a></li>
                </ul>
                <ul class="gl-nav__right gl-clearfix">
                    <li><a href="#">Акция</a></li>
                    <li><a href="#">О нас</a></li>
                    <li><a href="tel:88007075103"><span class="gl-mobile-visible">Телефон </span>8 800 707 51 03</a></li>
                    <li><a href="mailto:info@garan24.ru"><i class="fa fa-envelope-o gl-mobile-invisible" aria-hidden="true"></i><span class="gl-mobile-visible">Электронная почта</span></a></li>
                    <li><a href="#"><i class="fa fa-language gl-mobile-invisible" aria-hidden="true"></i><span class="gl-mobile-visible">Перевод</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!--
<div style="width: 100%; max-width: 1170px; margin: 0 auto; padding: 50px 15px; box-sizing: border-box;">
    <h1>{{ $site  }}</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce cursus, velit nec rutrum auctor, nisl libero lacinia lorem, ut venenatis elit sem vitae nisl. Cras a felis eu dui luctus vehicula tempus sed neque. Etiam ut purus et tortor venenatis commodo et vel urna. Nullam convallis enim non orci maximus, id consequat lectus scelerisque. Quisque eget posuere nisi. Donec dignissim porta purus vel vestibulum. Sed rhoncus maximus sapien, a tempus augue hendrerit eget. Phasellus quis turpis velit. Proin congue a lectus et congue. Duis vitae lorem a odio lobortis convallis. Nullam efficitur velit eget augue finibus finibus. Quisque vestibulum interdum odio a vehicula. Donec quis ante eget dui egestas bibendum quis dignissim massa. Etiam scelerisque nulla at sapien pellentesque, ac tristique nulla congue. Mauris nec quam mauris.</p>
    <p>Cras massa est, porttitor id leo a, accumsan porttitor sem. Mauris facilisis metus mauris, at bibendum augue pharetra eu. Etiam elementum, est eu interdum elementum, neque massa gravida ante, eu molestie nibh ante quis est. Nunc viverra venenatis dictum. Morbi tempor cursus tortor quis condimentum. Nulla eget porttitor risus. Vivamus blandit tortor in ligula interdum, eget luctus orci elementum. Maecenas lacus lacus, rutrum in mattis id, volutpat sit amet urna. Donec aliquam elementum nibh quis efficitur. Proin lobortis justo vel elit vulputate, sit amet iaculis lorem porttitor. Duis at lacus dui. Sed nec mauris sit amet est convallis consequat accumsan vitae nulla.</p>
    <p>Proin porta lectus pretium ipsum scelerisque faucibus. Vivamus eu sapien porttitor, maximus lorem eget, iaculis orci. Sed viverra finibus mi, sed vestibulum urna malesuada quis. Sed ac tellus vitae urna lobortis semper. Cras vel mollis erat, et interdum eros. Sed luctus vitae nulla sit amet faucibus. Cras massa elit, posuere id venenatis rutrum, placerat eu justo. Fusce euismod, mi id sollicitudin scelerisque, sem orci luctus odio, vitae venenatis lorem sapien in dui. Praesent at tempor quam.</p>
    <p>Cras euismod tristique risus nec sodales. Aenean pulvinar lacus ut feugiat sollicitudin. Donec lobortis lorem in ullamcorper bibendum. Nulla euismod nulla eget nisi tempor, at posuere sem tristique. Pellentesque vehicula libero et hendrerit interdum. Nunc et justo ullamcorper, imperdiet urna eu, semper risus. Sed non elit ante. Sed porta lectus vitae ipsum eleifend blandit. Phasellus in ipsum lacinia, congue neque a, eleifend est. Vivamus a orci interdum, dapibus nisi sed, convallis nibh. In eget feugiat lorem. Curabitur eget urna vel justo vulputate maximus.</p>
    <p>Vivamus tempus, tellus ut cursus sagittis, felis ex faucibus nisi, vitae congue dolor risus nec odio. Etiam imperdiet mattis mi ut facilisis. Curabitur sit amet dui vel ligula rhoncus ultricies eget a sem. Praesent ut vestibulum lectus. Donec interdum ex sed iaculis aliquet. Fusce at lobortis est, dignissim placerat ex. Nulla sollicitudin augue sit amet massa sollicitudin pharetra. In enim diam, laoreet eget convallis non, consectetur a massa. Fusce faucibus tincidunt felis at blandit. Curabitur vitae feugiat felis. Phasellus non felis sit amet dui pharetra malesuada. Fusce in egestas urna.</p>
</div>
-->
<div class="gl-popup-overlay" id="glPopupOverlay" style="display: none;"></div>
<div class="gl-popup" id="glPopup" style="display: none;">
    <button class="gl-popup-close" id="glPopupClose">Закрыть</button>
    <div class="gl-popup-content" id="glPopupContent">
        <section id="sectionOne" style="display: none;">
            <h3>Section 1</h3>
            @if ( $site == 'brandalley' )
                <strong>Text for {{ $site  }}</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut posuere ipsum. Fusce quis urna in quam consequat fermentum. Aliquam semper sagittis orci. Curabitur sapien erat, tincidunt non auctor at, tempus sit amet nulla. Pellentesque eu aliquet libero. Nulla volutpat at dui vitae ultrices. Cras sollicitudin risus nisi, ornare sodales ante pellentesque vitae. Suspendisse aliquet diam at enim placerat placerat. Aliquam ac vestibulum nulla</p>
                <p>Sed sed velit turpis. Proin in ultricies nunc, id tristique ante. Integer porta pellentesque ipsum, nec accumsan arcu tristique eget. Proin ultrices aliquam libero, sit amet rutrum lacus maximus vel. Donec dui diam, cursus vel dignissim eu, consectetur sed massa. Aenean enim metus, ultrices ac urna sed, maximus lobortis ex. Sed a placerat tortor, in vehicula orci. Nulla placerat ac nunc at varius. Maecenas tincidunt ex quis vehicula pretium.</p>
                <p>Maecenas eget rutrum lorem. Nunc ultricies, tortor eget fringilla convallis, nisi sapien suscipit diam, a convallis erat lacus vehicula erat. Donec risus nisi, commodo vitae fringilla non, consequat non nunc. Sed a sollicitudin arcu. Proin feugiat posuere dolor. Suspendisse fringilla lectus lorem, non semper lorem molestie vel. Duis laoreet pellentesque venenatis. Pellentesque pulvinar tempor accumsan. Ut sed orci a quam imperdiet consectetur vitae maximus diam. Phasellus faucibus purus ac efficitur posuere. Curabitur nec tristique purus, ut tincidunt est. Quisque ac urna vehicula, dapibus metus et, malesuada erat. Mauris ornare magna id finibus ullamcorper. Nunc pharetra sapien vel leo volutpat, porttitor finibus justo porttitor. Nam in neque finibus lectus placerat tincidunt at ut ante. Mauris aliquet mauris ut lorem cursus feugiat.</p>
                <p>Maecenas dapibus dui vel molestie sodales. Cras nec consequat metus. Proin eu ante eget lectus convallis vestibulum id vitae magna. Morbi interdum, diam nec lacinia egestas, massa eros congue justo, vel tempus elit odio id quam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas fringilla lacus ut venenatis congue. Donec non ex et magna venenatis imperdiet id a turpis. Maecenas pulvinar nunc eu arcu viverra, a maximus ligula porttitor.</p>
                <p>Donec sollicitudin eget felis ut molestie. In fermentum tortor dapibus magna tempus, eu tincidunt ante pulvinar. Ut sodales sem venenatis malesuada elementum. Morbi blandit diam est, in fringilla tortor commodo vitae. Pellentesque in diam sed est volutpat fringilla vitae eget enim. Quisque et scelerisque neque, sed euismod mauris. Nulla hendrerit scelerisque mauris, sed pellentesque felis ultrices vitae. Pellentesque laoreet sem nec cursus dapibus. Phasellus nibh est, pretium non augue eget, lobortis vulputate ex. Quisque iaculis vulputate finibus. Etiam cursus, tortor et ultrices iaculis, tellus velit varius odio, non volutpat urna neque eu odio. Duis congue dolor vitae varius finibus. Aenean auctor rhoncus luctus. Ut id neque lacinia, auctor lacus at, venenatis lacus. Integer in elit vitae libero ultrices venenatis id et augue.</p>
            @elseif ( $site == 'ctshirts' )
                <strong>Text for {{ $site  }}</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut posuere ipsum. Fusce quis urna in quam consequat fermentum. Aliquam semper sagittis orci. Curabitur sapien erat, tincidunt non auctor at, tempus sit amet nulla. Pellentesque eu aliquet libero. Nulla volutpat at dui vitae ultrices. Cras sollicitudin risus nisi, ornare sodales ante pellentesque vitae. Suspendisse aliquet diam at enim placerat placerat. Aliquam ac vestibulum nulla</p>
                <p>Sed sed velit turpis. Proin in ultricies nunc, id tristique ante. Integer porta pellentesque ipsum, nec accumsan arcu tristique eget. Proin ultrices aliquam libero, sit amet rutrum lacus maximus vel. Donec dui diam, cursus vel dignissim eu, consectetur sed massa. Aenean enim metus, ultrices ac urna sed, maximus lobortis ex. Sed a placerat tortor, in vehicula orci. Nulla placerat ac nunc at varius. Maecenas tincidunt ex quis vehicula pretium.</p>
                <p>Maecenas eget rutrum lorem. Nunc ultricies, tortor eget fringilla convallis, nisi sapien suscipit diam, a convallis erat lacus vehicula erat. Donec risus nisi, commodo vitae fringilla non, consequat non nunc. Sed a sollicitudin arcu. Proin feugiat posuere dolor. Suspendisse fringilla lectus lorem, non semper lorem molestie vel. Duis laoreet pellentesque venenatis. Pellentesque pulvinar tempor accumsan. Ut sed orci a quam imperdiet consectetur vitae maximus diam. Phasellus faucibus purus ac efficitur posuere. Curabitur nec tristique purus, ut tincidunt est. Quisque ac urna vehicula, dapibus metus et, malesuada erat. Mauris ornare magna id finibus ullamcorper. Nunc pharetra sapien vel leo volutpat, porttitor finibus justo porttitor. Nam in neque finibus lectus placerat tincidunt at ut ante. Mauris aliquet mauris ut lorem cursus feugiat.</p>
                <p>Maecenas dapibus dui vel molestie sodales. Cras nec consequat metus. Proin eu ante eget lectus convallis vestibulum id vitae magna. Morbi interdum, diam nec lacinia egestas, massa eros congue justo, vel tempus elit odio id quam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas fringilla lacus ut venenatis congue. Donec non ex et magna venenatis imperdiet id a turpis. Maecenas pulvinar nunc eu arcu viverra, a maximus ligula porttitor.</p>
                <p>Donec sollicitudin eget felis ut molestie. In fermentum tortor dapibus magna tempus, eu tincidunt ante pulvinar. Ut sodales sem venenatis malesuada elementum. Morbi blandit diam est, in fringilla tortor commodo vitae. Pellentesque in diam sed est volutpat fringilla vitae eget enim. Quisque et scelerisque neque, sed euismod mauris. Nulla hendrerit scelerisque mauris, sed pellentesque felis ultrices vitae. Pellentesque laoreet sem nec cursus dapibus. Phasellus nibh est, pretium non augue eget, lobortis vulputate ex. Quisque iaculis vulputate finibus. Etiam cursus, tortor et ultrices iaculis, tellus velit varius odio, non volutpat urna neque eu odio. Duis congue dolor vitae varius finibus. Aenean auctor rhoncus luctus. Ut id neque lacinia, auctor lacus at, venenatis lacus. Integer in elit vitae libero ultrices venenatis id et augue.</p>
            @endif
        </section>
        <section id="sectionTwo" style="display: none;">
            <h3>Section 2</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sodales massa vel sapien sodales lobortis. Ut commodo in tortor non sodales. Aliquam at placerat orci, ac aliquam justo. Suspendisse potenti. Donec ornare metus vel lacus dictum, at mattis nunc rutrum. Morbi sit amet eros vehicula purus euismod hendrerit at nec libero. Sed at lectus turpis. Suspendisse eu elit et metus hendrerit tincidunt sit amet at velit.</p>
            <p>Vivamus nec lorem ac leo commodo molestie sed non turpis. Aliquam erat volutpat. Curabitur egestas ipsum sed volutpat facilisis. Morbi at massa vitae est gravida fermentum vel eu est. Fusce posuere pretium rutrum. Morbi velit ex, volutpat ac pharetra facilisis, suscipit sed felis. Maecenas ante sem, fringilla nec faucibus vel, lobortis sodales urna.</p>
            <p>Duis gravida facilisis dictum. Suspendisse commodo odio sit amet tellus semper cursus. Duis nec rutrum eros. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam felis magna, maximus sollicitudin porta ac, finibus ultrices dui. Donec tristique massa dui, sodales rutrum mauris placerat et. Praesent sodales velit quis massa dapibus, ac tempor turpis ultricies. Cras vehicula luctus auctor. Nam tempor augue et neque elementum, eu consectetur diam mattis. Integer vitae fringilla est, nec rhoncus ligula. Sed pretium odio in erat auctor, sed pellentesque arcu sagittis. Ut dolor sapien, hendrerit id elit in, bibendum auctor felis. Duis non tempus mauris. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <p>Nam rhoncus accumsan lacus, at elementum lorem elementum ut. Sed augue tortor, maximus sed dictum at, accumsan sed erat. Nam eu nisl posuere, ultricies purus eu, vehicula ligula. Aliquam dui urna, feugiat at venenatis ac, fringilla non ex. Donec at interdum nisi, nec elementum quam. Nulla odio nulla, porttitor egestas ornare in, sollicitudin ut nisi. Sed justo arcu, sagittis quis molestie sed, posuere vel elit. Ut aliquam elit eget orci maximus congue. Duis lacinia eros sed dolor iaculis consequat. Curabitur sit amet purus eget mauris fermentum ornare.</p>
            <p>Donec at dolor nibh. Maecenas quis velit elit. Proin interdum ac justo ac rhoncus. Praesent ipsum ligula, venenatis a placerat sit amet, pretium a leo. Nullam vitae velit accumsan, faucibus est non, euismod justo. Vestibulum eget neque condimentum, fermentum dui nec, consequat dui. Donec aliquet tortor eget fermentum aliquet. Nulla a massa erat. Etiam aliquet faucibus finibus. Quisque fringilla purus quis nunc posuere, eget pellentesque eros lacinia. Nulla eu eleifend lorem. Pellentesque odio lorem, gravida nec elit quis, posuere tempor risus. Sed eu blandit tellus.</p>
        </section>
    </div>
</div>
<script>
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

</script>
