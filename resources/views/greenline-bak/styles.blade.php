<style>
    @import url("//fonts.googleapis.com/css?family=Lato:100|Open+Sans:300,400,800&subset=latin,cyrillic");
    @import url("//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
    @font-face {
        font-family: 'EngraversGothic BT Regular';
        /*src:url("//l.gauzymall.com/css/fonts/tt0586m_.ttf");*/
        src:url("/css/tt0586m_.ttf");
    }
    #xr_g_searchInput{
        height:36px;
        line-height: 36px;
        padding-left: 3em;
        min-width:20rem;
        width:100%;
        border-radius: 4px;
        border:solid 1px #00bf80;
        color:#444;
        transition: all .8s ease-in;
        display: inline-block;
    }
    #xr_g_searchField{
        position: relative;
    }
    #xr_g_searchField:before{
        display: block;
        position: absolute;
        left: 0;
        margin: auto 0;
        width: 2em;
        font-family: 'FontAwesome';
        height: 2em;
        text-align: center;
        line-height: 2em;
        color:#00bf80;
        font-size; 2em;
        opacity: .5;
        content: '\f002';
        transition: all .2s ease-in;
    }
    #xr_g_searchField:before:focus{
        opacity: 1;
    }
    .main__area{
        max-width:132rem!important;
    }
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
        font-size: 1em!important;
    }

    .gl-container a {
        display: inline-block;
        color: #fff !important;
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
    .gl-logo a{
        font-family: 'EngraversGothic BT Regular';
        text-transform: uppercase;
        letter-spacing: .2em;
        font-size: 16px;
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
        font-family: 'Open Sans'!important;
        font-weight: 400!important;
        color:rgba(255,255,255,.8)!important;
        font-size: 16px!important;
        transition: all 0.2s ease-in;
    }
    .gl-nav ul li a:hover {
        color:rgba(255,255,255,1)!important;
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

    .gl-popup-content section {
        line-height: 1.6em;
        font-size: 16px;
        font-family: 'Lato', 'Open Sans', Helvetica, Arial, sans-serif;
    }
    .gl-popup-content section p{
        margin-top: .8em;
    }
    .gl-popup-content section ul{
        margin:0 4em;
        text-align: left;
        list-style: disc;
    }
    .gl-popup-content section ul li{

    }
    .gl-popup-content section h1,.gl-popup-content section h2,.gl-popup-content section h3{
        font-weight: 800;
        font-family: 'Lato', 'Open Sans', Helvetica, Arial, sans-serif;
        font-size: 120%;
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
<!--<link href="/css/greenline.css" rel="stylesheet">-->
