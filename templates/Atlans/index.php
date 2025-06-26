<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 *
 * @version 1.2.6
 * @author Lautaro Angelico
 */

if (!defined('access') || !access) {
    die('Direct access not permitted.');
}

include('inc/template.functions.php');

$serverInfoCache = LoadCacheData('server_info.cache');
$srvInfo = is_array($serverInfoCache) && isset($serverInfoCache[1][0])
    ? explode("|", $serverInfoCache[1][0])
    : [];

$maxOnline = config('maximum_online', true);
$onlinePlayers = isset($srvInfo[3]) ? (int)$srvInfo[3] : 0;
$onlinePlayersPercent = ($maxOnline > 0 && check_value($maxOnline))
    ? round(($onlinePlayers * 100) / $maxOnline)
    : 0;

$currentPage = $_REQUEST['page'] ?? '';
$currentSubpage = $_REQUEST['subpage'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php $handler->websiteTitle(); ?></title>

    <meta name="generator" content="WebEngine <?php echo __WEBENGINE_VERSION__; ?>"/>
    <meta name="author" content="Lautaro Angelico"/>
    <meta name="description" content="<?php config('website_meta_description'); ?>"/>
    <meta name="keywords" content="<?php config('website_meta_keywords'); ?>"/>

    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php $handler->websiteTitle(); ?>" />
    <meta property="og:description" content="<?php config('website_meta_description'); ?>" />
    <meta property="og:image" content="<?php echo __PATH_IMG__; ?>webengine.jpg" />
    <meta property="og:url" content="<?php echo __BASE_URL__; ?>" />
    <meta property="og:site_name" content="<?php $handler->websiteTitle(); ?>" />

    <link rel="shortcut icon" href="<?php echo __PATH_TEMPLATE__; ?>favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700|Cinzel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>style.css" rel="stylesheet">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>profiles.css" rel="stylesheet">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>castle-siege.css" rel="stylesheet">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>override.css" rel="stylesheet">

    <script>const baseUrl = '<?php echo __BASE_URL__; ?>';</script>
</head>
<body>
    <div class="global-top-bar">
        <div class="global-top-bar-content container">
            <div class="row">
                <div class="col-xs-6 text-left global-top-bar-nopadding">
                    <?php if (config('language_switch_active', true)): ?>
                        <?php templateLanguageSelector(); ?>
                    <?php endif; ?>
                </div>
                <div class="col-xs-6 text-right global-top-bar-nopadding">
                    <?php if (isLoggedIn()): ?>
                        <a href="<?php echo __BASE_URL__; ?>usercp/" class="btn btn-link btn-sm"><?php echo lang('module_titles_txt_3'); ?></a>
                        <span class="global-top-bar-separator">|</span>
                        <a href="<?php echo __BASE_URL__; ?>logout/" class="logout btn btn-link btn-sm"><?php echo lang('menu_txt_6'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo __BASE_URL__; ?>register/" class="btn btn-link btn-sm"><?php echo lang('menu_txt_3'); ?></a>
                        <span class="global-top-bar-separator">|</span>
                        <a href="<?php echo __BASE_URL__; ?>login/" class="btn btn-link btn-sm"><?php echo lang('menu_txt_4'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <nav id="navbar" class="main-navigation">
        <?php templateBuildNavbar(); ?>
    </nav>

    <header id="header" class="site-header text-center">
        <a href="<?php echo __BASE_URL__; ?>" aria-label="<?php config('server_name'); ?> Home">
            <img class="webengine-mu-logo img-responsive center-block" src="<?php echo __PATH_TEMPLATE_IMG__; ?>logo.png" alt="<?php config('server_name'); ?> Logo" title="<?php config('server_name'); ?>"/>
        </a>
    </header>

    <section class="header-info-container">
        <div class="header-info container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="header-info-block">
                        <?php if (check_value(config('maximum_online', true))): ?>
                        <div class="row">
                            <div class="col-xs-6 text-left"><strong><?php echo lang('sidebar_srvinfo_txt_5'); ?>:</strong></div>
                            <div class="col-xs-6 text-right online-count"><?php echo number_format($onlinePlayers); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="webengine-online-bar">
                                    <div class="webengine-online-bar-progress" style="width:<?php echo $onlinePlayersPercent; ?>%;"></div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-xs-6 text-left"><strong><?php echo lang('server_time'); ?>:</strong></div>
                            <div class="col-xs-6 text-right"><time id="tServerTime">&nbsp;</time> <span id="tServerDate">&nbsp;</span></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 text-left"><strong><?php echo lang('user_time'); ?>:</strong></div>
                            <div class="col-xs-6 text-right"><time id="tLocalTime">&nbsp;</time> <span id="tLocalDate">&nbsp;</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main id="container" class="main-content-area">
        <div id="content" class="container">
            <div class="row">
                <?php if ($currentPage === 'usercp' && $currentSubpage !== ''): ?>
                    <div class="col-md-8"><?php $handler->loadModule($currentPage, $currentSubpage); ?></div>
                    <div class="col-md-4"><?php include(__PATH_TEMPLATE_ROOT__ . 'inc/modules/sidebar.php'); ?></div>
                <?php else: ?>
                    <div class="col-xs-12">

                        <!-- Panel de Novedades -->
                        <section class="panel custom-panel-theme mb-4">
                            <div class="panel-heading">
                                <h4 class="panel-title"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Novedades del Servidor</h4>
                            </div>
                            <div class="panel-body">
                                <p><strong>📅 Última actualización:</strong> 20 de junio de 2025</p>

                                <ul class="list-unstyled" style="font-size: 16px; line-height: 1.8;">
                                    <li>🎉 ¡<strong>Nuevo evento PvP</strong> cada domingo a las 20:00 ARG!</li>
                                </ul>

                                <hr>

                                <h4 class="text-center"> Bienvenidos a Mui-Chronicles S6 EP3</h4>
                                <p style="font-size: 15px; text-align: justify;">
                                    Acabamos de abrir un nuevo servidor <strong>Mu Online Season 6 EP3</strong>. Bienvenidos a <strong>Mui-Chronicles</strong>, un proyecto creado con pasión para durar muchos años y reunir una comunidad fiel y competitiva.
                                </p>
                                <p style="font-size: 15px; text-align: justify;">
                                    Nuestro servidor corre sobre <strong>Amazon AWS</strong>, asegurando un entorno <strong>rápido, seguro y escalable</strong>, ideal para disfrutar sin interrupciones.
                                </p>

                                <hr>

<div class="text-center" style="margin: 20px 0;">
    <p style="font-size: 14px;">¿Querés sumarte a la comunidad y chatear con otros jugadores?</p>
    <a href="https://chat.whatsapp.com/EcjMiLMM24oEKL5Gog5Zgk" target="_blank" class="btn btn-success" style="padding: 5px 15px; font-size: 13px;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" width="14" style="vertical-align: middle; margin-right: 6px;">
        Unirse al grupo de WhatsApp
    </a>
</div>
                            </div>
                        </section>

                        <?php $handler->loadModule($currentPage, $currentSubpage); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <?php include(__PATH_TEMPLATE_ROOT__ . 'inc/modules/footer.php'); ?> <br>
                                <!-- Panel de Donaciones -->
                        <section class="panel custom-panel-theme text-center mb-4">
                            <div class="panel-heading">
                                <h4 class="panel-title"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Apóyanos con una donación</h4>
                            <div class="panel-body">
    <p style="font-size: 14px;">Gracias a tu apoyo, este servidor puede seguir creciendo y ofreciendo contenido de calidad. ¡Cualquier aporte suma!</p>
    <a href="https://link.mercadopago.com.ar/muchronicles" class="btn btn-sm btn-primary btn-donate">
        Donar
    </a>
</div>
                        </section>


    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo __PATH_TEMPLATE_JS__; ?>main.js"></script>
    <script src="<?php echo __PATH_TEMPLATE_JS__; ?>events.js"></script>
</body>
</html>
