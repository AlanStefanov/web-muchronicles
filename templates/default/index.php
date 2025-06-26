<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 *
 * @version 1.2.6
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2025 Lautaro Angelico, All Rights Reserved
 *
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */

// Ensure direct access is denied for security
if (!defined('access') || !access) {
    die('Direct access not permitted.');
}

// Include core template functions
include('inc/template.functions.php');

// Fetch server information from cache
$serverInfoCache = LoadCacheData('server_info.cache');
$srvInfo = is_array($serverInfoCache) && isset($serverInfoCache[1][0])
    ? explode("|", $serverInfoCache[1][0])
    : [];

// Calculate online player statistics
$maxOnline = config('maximum_online', true);
$onlinePlayers = isset($srvInfo[3]) ? (int)$srvInfo[3] : 0;
$onlinePlayersPercent = ($maxOnline > 0 && check_value($maxOnline))
    ? round(($onlinePlayers * 100) / $maxOnline)
    : 0; // Ensures division by zero is handled

// Initialize request variables for page and subpage if not set
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

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

        <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>style.css" rel="stylesheet" media="screen">
        <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>profiles.css" rel="stylesheet" media="screen">
        <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>castle-siege.css" rel="stylesheet" media="screen">
        <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>override.css" rel="stylesheet" media="screen">

        <script>
            const baseUrl = '<?php echo __BASE_URL__; ?>';
        </script>
    </head>
    <body>
        <div class="global-top-bar">
            <div class="global-top-bar-content container"> <div class="row">
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

        <nav id="navbar" class="main-navigation"> <?php templateBuildNavbar(); ?>
        </nav>

        <header id="header" class="site-header text-center"> <a href="<?php echo __BASE_URL__; ?>" aria-label="<?php config('server_name'); ?> Home">
        <img class="webengine-mu-logo img-responsive center-block" src="<?php echo __PATH_TEMPLATE_IMG__; ?>logo.png" alt="<?php config('server_name'); ?> Logo" title="<?php config('server_name'); ?>"/> </a>
		</header>

        <section class="header-info-container"> <div class="header-info container"> <div class="row">
                    <div class="col-xs-12">
                        <div class="header-info-block">
                            <?php if (check_value(config('maximum_online', true))): ?>
                            <div class="row">
                                <div class="col-xs-6 text-left">
                                    <strong><?php echo lang('sidebar_srvinfo_txt_5'); ?>:</strong>
                                </div>
                                <div class="col-xs-6 text-right online-count">
                                    <?php echo number_format($onlinePlayers); ?>
                                </div>
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
                                <div class="col-xs-6 text-left">
                                    <strong><?php echo lang('server_time'); ?>:</strong>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <time id="tServerTime">&nbsp;</time> <span id="tServerDate">&nbsp;</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 text-left">
                                    <strong><?php echo lang('user_time'); ?>:</strong>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <time id="tLocalTime">&nbsp;</time> <span id="tLocalDate">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <main id="container" class="main-content-area"> <div id="content" class="container"> <div class="row">
                    <?php if ($currentPage === 'usercp' && $currentSubpage !== ''): ?>
                        <div class="col-md-8"> <?php $handler->loadModule($currentPage, $currentSubpage); ?>
                        </div>
                        <div class="col-md-4"> <?php include(__PATH_TEMPLATE_ROOT__ . 'inc/modules/sidebar.php'); ?>
                        </div>
                    <?php else: ?>
                        <div class="col-xs-12">
                            <?php if (empty($currentPage)): ?>
                                <section class="panel panel-default mb-4"> <div class="panel-heading">
                                        <h3 class="panel-title"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Novedades del Servidor</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p><strong>Última actualización:</strong> 10 de junio de 2025</p>
                                        <ul>
                                            <li>🎉 ¡Nuevo evento PvP semanal todos los domingos!</li>
                                            <li>⚒️ Se balancearon las clases DK y SM.</li>
                                            <li>🏰 Siege ahora otorga joyas y créditos.</li>
                                        </ul>
                                    </div>
                                </section>

<section class="panel panel-primary text-center mb-4"> <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Apóyanos con una donación</h3>
    </div>
                                    <div class="panel-body">
                                        <p>Gracias a tu aporte seguimos mejorando el servidor.</p>
                                        <a href="https://link.mercadopago.com.ar/muchronicles" class="btn btn-lg btn-primary btn-donate">
                                            Ir a Donaciones
                                        </a>
                                    </div>
                                </section>
                            <?php endif; ?>

                            <?php $handler->loadModule($currentPage, $currentSubpage); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <footer class="footer">
            <?php include(__PATH_TEMPLATE_ROOT__ . 'inc/modules/footer.php'); ?>
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

        <script src="<?php echo __PATH_TEMPLATE_JS__; ?>main.js"></script>
        <script src="<?php echo __PATH_TEMPLATE_JS__; ?>events.js"></script>
        </body>
</html>