<?php


if(session_id() == ''){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Cover Template · Bootstrap v5.0</title>

    <!-- actual-->
    <link href="./css/frame/styles.css" rel="stylesheet">
    <link href="./css/text_styles/styles.css" rel="stylesheet">
    <link href="./css/header/static_header.css" rel="stylesheet">
    <link href="./css/header/sticky_header.css" rel="stylesheet">
    <link href="./css/buttons/NavigationButton.css" rel="stylesheet">
    <link href="./css/buttons/SimpleButton.css" rel="stylesheet">
    <link href="./css/buttons/SlideButton.css" rel="stylesheet">
    <link href="./css/buttons/InputButton.css" rel="stylesheet">
    <link href="./css/carousel/style_new.css" rel="stylesheet">
    <link href="./css/content/styles.css" rel="stylesheet">
    <link href="./css/drag_and_drop/styles.css" rel="stylesheet">
    <link href="./css/table/styles.css" rel="stylesheet">
    <link href="./css/scroll/styles.css" rel="stylesheet">
    <link href="./css/popup/styles.css" rel="stylesheet">

    <!-- actual-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="./js_php/header/scripts.js"></script>
    <script src="./js_php/carousel/scripts.js"></script>
    <script src="./js_php/section_pgsql/scripts.js"></script>
    <script src="./js_php/popup/scripts.js"></script>
    <script src="./js_php/common/scripts.js"></script>
    <script src="./js_php/table/scripts.js"></script>
    <script src="./js_php/section_web_storage/scripts.js"></script>
    <script src="./js_php/section_ftp/scripts.js"></script>

</head>


<body >

    <main class="bg_color">
        <header>
            <div class="cover_container title_container">
                <div class="title f_0 title_text">
                    <h3>Cover</h3>
                </div>
                <div class="f_1"></div>
                <div class="user_info_container f_0 simple_text">
                    <span id="user_info">Необходимо войти в систему!</span>
                </div>
                <div class="logon_container f_0 ">
                    <button id="logon" class="button sb_color_normal sb_size_normal button_text">
                        <div class="border"></div>
                        <div class="neon"></div>
                        <div>
                            <span class="span" role="button" >Авторизация</span>
                            <span class="span_blur" >Авторизация</span>

                        </div>
                    </button>
                </div>
            </div>
         </header>

         <main class="content_root flex_column">
             <header class="header_content bg_color">
                 <div class="cover_container z_50 ">
                     <nav class="navigation navigation-theme navigation_text">
                         <a class="navigation-link active" aria-current="page" href="#web_dev">WEB-разработка</a>
                         <a class="navigation-link " href="#web_storage">WEB-storage</a>
                         <a class="navigation-link" href="#web_dev3">Features</a>
                         <a class="navigation-link" href="#web_dev4">Features</a>
                         <a class="navigation-link" href="#web_dev5">Features</a>
                         <a class="navigation-link" href="#web_dev6">Features</a>
                         <a class="navigation-link" href="#">Contact</a>
                     </nav>
                 </div>
             </header>
             <div class="section_root f_1">

                 <section id="web_dev" >
                     <div class="carousel">
                         <div class="slide_holder" onscroll="onScroll(this)">
                             <div class="slide flex_column bg_image web_links_image">
                                 <div class="cover_container flex_row ">
                                     <section  class="f_1 flex_row f_centred" >
                                         <div class=" f_0 width_100">
                                             <div class="border_container transparence_4">
                                                 <div class="indent_10 flex_colum simple_text ">
                                                     <h1>Раздел WEB-разработки</h1>
                                                     <p style="word-wrap: break-word">URL-ссылки на тестовые сайты, находящиеся внутри контейнера</p>
                                                     <p>Расположение сайтов в подключенном томе /var/www/html: </p>
                                                     <div class="flex_row ">
                                                         <a  href="<?php echo 'https://'.$_SERVER['SERVER_NAME'].':'.getenv('HTTPS_PORT_TEST_1') ?>">
                                                             <button class="button sb_color_warn sb_size_slim button_text" >
                                                                 <div class="border"></div>
                                                                 <div class="neon"></div>
                                                                 <div>
                                                                     <span class="span" role="button"  >./web_test_1/</span>
                                                                     <span class="span_blur">./web_test_1/</span>
                                                                 </div>
                                                             </button>
                                                         </a>
                                                         <a  href="<?php echo 'https://'.$_SERVER['SERVER_NAME'].':'.getenv('HTTPS_PORT_TEST_2') ?>">
                                                         <button class="button sb_color_accept sb_size_slim button_text" >
                                                             <div class="border"></div>
                                                             <div class="neon"></div>
                                                             <div >
                                                                 <span class="span" role="button"  >./web_test_2/</span>
                                                                 <span class="span_blur">./web_test_2/</span>
                                                             </div>
                                                         </button>
                                                         </a>
                                                             <a  href="<?php echo 'https://'.$_SERVER['SERVER_NAME'].':'.getenv('HTTPS_PORT_TEST_3') ?>">
                                                         <button class="button sb_color_normal sb_size_normal button_text" >
                                                             <div class="border"></div>
                                                             <div class="neon"></div>
                                                             <div >
                                                                 <span class="span" role="button" >./web_test_3/</span>
                                                                 <span class="span_blur">./web_test_3/</span>
                                                             </div>
                                                         </button>
                                                             </a>
                                                     </div>
                                                     <p>Более подробная информация в документации по контейнеру.</p>
                                                  </div>



                                             </div>

                                         </div>

                                         <div class="f_1 filling_box">

                                         </div>

                                     </section>


                                 </div>

                             </div>
                             <div class="slide flex_column bg_image database_image">
                                 <div class="cover_container flex_row ">
                                     <section  class="f_1 flex_row f_centred" >
                                         <div class="f_1">

                                         </div>
                                         <div class=" f_0 width_100">
                                             <div id="database" class="border_container transparence_4">
                                                 <div class="indent_10 flex_colum simple_text ">
                                                     <h1>Database</h1>
                                                     <p>Сервер postgresql, в отдельном, изолироанном контейнере c редустановленной базой для jwt авторизации.</p>
                                                     <p>PGAdmin, в отдельном, изолироанном контейнере.</p>
                                                     <p>Подключение:</p>
                                                     <ul>
                                                         <li>Через контейнер хоста: <span class="bash_text">docker exec -it pgsql /bin/bash</span></li>
                                                         <li>Через pgadmin по <a class="bash_text" href="<?php echo 'https://'.$_SERVER['SERVER_NAME'].':'.getenv('HTTPS_PORT_TEST_3') ?>/pgadmin/">ссылке</a>.</li>
                                                         <li>Из контейнеров в изолированной сети по порту <span class="cursive">5432</span>.</li>
                                                     </ul>
                                                     <p>Предустановлена база для jwt авторизации.</p>

                                                 </div>



                                             </div>

                                         </div>



                                     </section>


                                 </div>
                             </div>
                         </div>
                         <div class="l_arrow display_none"> <label onclick="onClick_arrow(this)"><</label></div>
                         <div class="r_arrow"> <label onclick="onClick_arrow(this)">></label></div>
                     </div>

                 </section>

                 <section id="web_storage" class="my_arrows">
                     <div class="carousel">
                         <div class="slide_holder" onscroll="onScroll(this)">
                             <div class="slide flex_column bg_image web_storage_image">
                                 <div class="cover_container flex_row ">
                                     <section  class="f_1 flex_row f_centred" >
                                         <div class=" f_0 width_100 max_height_100">
                                             <div class="border_container transparence_4">
                                                 <div class="indent_10 flex_colum simple_text ">
                                                     <h1>WEB Storage</h1>
                                                     <p>Загрузка файлов на WEB server и прямые ссылки для wget и т.д.</p>
                                                     <div id="drop-area" class="f_1">
                                                             <form >
                                                                 <input type="hidden" name="<?php echo ini_get('session.upload_progress.name');?>" value="first"/>
                                                                 <p>Загрузите файлы нажав на область или перетащив их в выделенную область.</p>
                                                                 <p>Свободно: <span id="avail" class="bash_text">---</span> из <span id="used" class="bash_text">---</span></p>
                                                                 <input type="file" id="fileElem" multiple onchange="handleFiles(this.files)">
                                                                 <label class="drop_label" for="fileElem"></label>
                                                                 <div class="progress_bar_root">
                                                                     <div class="progress_bar_area">
                                                                         <label id="progress_bar_label">0%</label>
                                                                         <div class="progress_bar">
                                                                             <div id="progress_bar" class="progress">
                                                                             </div>
                                                                         </div>

                                                                     </div>
                                                                     <div class="progress_bar">
                                                                         <div class="progress_2">
                                                                         </div>
                                                                     </div>
                                                                 </div>


                                                             </form>

                                                     </div>
                                                     <div class="table_root f_0">
                                                         <table id="file_table" class="table table_text">

                                                             <tr class="sticky_table_header bg_color">
                                                                 <th class="column_num f_0">№</th>
                                                                 <th class="f_1">Имя</th>

                                                             </tr>

                                                         </table>
                                                     </div>

                                                 </div>
                                             </div>

                                             <div class="f_1 filling_box">

                                             </div>

                                     </section>
                                 </div>
                             </div>
                             <div class="slide flex_column bg_image ftp_image">
                                 <div class="cover_container flex_row ">
                                     <section  class="f_1 flex_row f_centred" >
                                         <div class=" f_0 width_100">
                                             <div id="ftp" class="border_container transparence_8">
                                                 <div class="indent_10 flex_colum simple_text ">
                                                     <h1>FTP</h1>
                                                     <p>FTP к тому же каталогу, что и WEB Storage.</p>
                                                     <p>Все пользователи получают доступ к одному каталогу <span class="bash_text">/share/</span></p>
                                                     <p>При необходимости можно настроить индивидуальную папку каждому пользователю при сборке контейнера.</p>
                                                     <p>Шаюлон настройки пользователей в файле <span class="bash_text">.users</span>:</p>
                                                     <ul>
                                                         <li>Полный доступ к корневому каталогу: <span class="bash_text">user1|password|true|1005|</span></li>
                                                         <li>Доступ только к папке <span class="bash_text">/share/</span>: <span class="bash_text">user2|password|false|1006|</span></li>
                                                     </ul>
                                                     <p>Цифры это UID пользователя.</p>
                                                 </div>
                                             </div>

                                             <div class="f_1 filling_box">

                                             </div>

                                     </section>
                                 </div>
                             </div>
                         </div>
                         <div class="l_arrow display_none"> <label onclick="onClick_arrow(this)"><</label></div>
                         <div class="r_arrow"> <label onclick="onClick_arrow(this)">></label></div>
                     </div>

                 </section>

                 <section id="web_dev3" class="web_dev" >

                 </section>
                 <section id="web_dev4" class="web_dev" >

                 </section>
                 <section id="web_dev5" class="web_dev" >

                 </section>
             </div>





         </main>

         <footer class="footer_static f_0 bg_color">
             <div class="cover_container mt-auto text-white-50">
                 <p>Cover template for <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
             </div>
             </footer>
     </main>

    <div class='popup_area'>
        <div id="popup_scroll" class="flex_column popup_scroll">

        </div>
    </div>
</body>


<script type="text/javascript" src="./js_php/drag_and_drop/drag_and_drop.js"></script>

</html>