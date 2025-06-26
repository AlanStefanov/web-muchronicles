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
?>
<style>
    /* Estilos para que el video sea responsivo */
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* Relación de aspecto 16:9 (altura/ancho) */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000; /* Fondo negro mientras carga */
        margin-bottom: 0px; /* Ya no es necesario margin-bottom aquí, el panel lo maneja */
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Estos son los estilos que apliqué en el mensaje anterior para que los colores coincidan.
       Si ya los tienes en un archivo CSS externo de tu tema, puedes borrarlos de aquí.
    */
    .panel-sidebar {
        background-color: #1a2228; /* Ejemplo: color de fondo oscuro de tus otros paneles */
        border: 1px solid #1abc9c; /* Ejemplo: color de borde turquesa de tus otros paneles */
        color: #ecf0f1; /* Ejemplo: color de texto claro */
    }

    .panel-sidebar .panel-heading {
        background-color: #1abc9c; /* Color de fondo del encabezado del panel */
        border-bottom: 1px solid #16a085; /* Borde inferior del encabezado */
        color: #ffffff; /* Color del texto del encabezado */
    }

    .panel-sidebar .panel-title {
        color: inherit; /* Asegura que el título herede el color del texto del heading */
    }

    .panel-sidebar .panel-body {
        background-color: #1a2228; /* Asegura que el cuerpo del panel tenga el mismo fondo */
        color: #ecf0f1; /* Asegura que el texto dentro del cuerpo del panel sea claro */
        padding-bottom: 10px; /* Ajusta el padding si el mensaje "Actualizamos el video..." queda muy pegado */
    }

    .panel-sidebar .panel-body p {
        color: inherit; /* Hereda el color del texto del panel-body */
    }

</style>

<div class="row">
    <div class="col-xs-8">
        <div class="panel panel-sidebar">
            <div class="panel-heading">
                <h3 class="panel-title">Eramos tan jovenes...</h3>
            </div>
            <div class="panel-body">
                <div class="video-container">
                    <!-- Aquí se ha modificado el src para incluir ?autoplay=1&mute=1 -->
                    <iframe
                        width="560"
                        height="315"
                        src="https://www.youtube.com/embed/ufLfPGMeM2s?autoplay=1&mute=1"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                    </iframe>
                </div>
                <p class="text-center">Actualizamos el video todas las semanas.</p>
            </div>
        </div>
    </div>
    <div class="col-xs-4">
        <?php
        if(!isLoggedIn()) {
            echo '<div class="panel panel-sidebar">';
                echo '<div class="panel-heading">';
                    echo '<h3 class="panel-title">'.lang('module_titles_txt_2').' <a href="'.__BASE_URL__.'forgotpassword" class="btn btn-primary btn-xs pull-right">'.lang('login_txt_4').'</a></h3>';
                echo '</div>';
                echo '<div class="panel-body">';
                    echo '<form action="'.__BASE_URL__.'login" method="post">';
                        echo '<div class="form-group">';
                            echo '<input type="text" class="form-control" id="loginBox1" name="webengineLogin_user" required>';
                        echo '</div>';
                        echo '<div class="form-group">';
                            echo '<input type="password" class="form-control" id="loginBox2" name="webengineLogin_pwd" required>';
                        echo '</div>';
                        echo '<button type="submit" name="webengineLogin_submit" value="submit" class="btn btn-primary">'.lang('login_txt_3').'</button>';
                    echo '</form>';
                echo '</div>';
            echo '</div>';

            echo '<div class="sidebar-banner"><a href="'.__BASE_URL__.'register"><img src="'.__PATH_TEMPLATE_IMG__.'sidebar_banner_join.jpg"/></a></div>';
        } else {
            echo '<div class="panel panel-sidebar panel-usercp">';
                echo '<div class="panel-heading">';
                    echo '<h3 class="panel-title">'.lang('usercp_menu_title').' <a href="'.__BASE_URL__.'logout" class="btn btn-primary btn-xs pull-right">'.lang('login_txt_6').'</a></h3>';
                echo '</div>';
                echo '<div class="panel-body">';
                    templateBuildUsercp();
                echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-xs-4">
        <?php
        // Top Level
        $levelRankingData = LoadCacheData('rankings_level.cache');
        $topLevelLimit = 10;
        if(is_array($levelRankingData)) {
            $topLevel = array_slice($levelRankingData, 0, $topLevelLimit+1);
            echo '<div class="panel panel-sidebar">';
                echo '<div class="panel-heading">';
                    echo '<h3 class="panel-title">'.lang('rankings_txt_1').'<a href="'.__BASE_URL__.'rankings/level" class="btn btn-primary btn-xs pull-right" style="text-align:center;width:22px;">+</a></h3>';
                echo '</div>';
                echo '<div class="panel-body" style="min-height:400px;">';
                    echo '<table class="table table-condensed">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th class="text-center">'.lang('rankings_txt_10').'</th>'; // Character
                                echo '<th class="text-center">'.lang('rankings_txt_11').'</th>'; // Class
                                echo '<th class="text-center">'.lang('rankings_txt_12').'</th>'; // Level
                            echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach($topLevel as $key => $row) {
                            if($key == 0) continue;
                            echo '<tr>';
                                echo '<td class="text-center">'.playerProfile($row[0]).'</td>';
                                echo '<td class="text-center">'.getPlayerClass($row[1]).'</td>';
                                echo '<td class="text-center">'.number_format($row[2]).'</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                    echo '</table>';
                echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="col-xs-4">
        <?php
        // Top Guilds
        $guildRankingData = LoadCacheData('rankings_guilds.cache');
        $topGuildLimit = 10;
        if(is_array($guildRankingData)) {
            $rankingsConfig = loadConfigurations('rankings');
            $topGuild = array_slice($guildRankingData, 0, $topGuildLimit+1);
            echo '<div class="panel panel-sidebar">';
                echo '<div class="panel-heading">';
                    echo '<h3 class="panel-title">'.lang('rankings_txt_4').'<a href="'.__BASE_URL__.'rankings/guilds" class="btn btn-primary btn-xs pull-right" style="text-align:center;width:22px;">+</a></h3>';
                echo '</div>';
                echo '<div class="panel-body" style="min-height:400px;">';
                    echo '<table class="table table-condensed">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th class="text-center">'.lang('rankings_txt_17').'</th>'; // Guild Name
                                echo '<th class="text-center">'.lang('rankings_txt_28').'</th>'; // Logo
                                echo '<th class="text-center">'.lang('rankings_txt_19').'</th>'; // Score
                            echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach($topGuild as $key => $row) {
                            if($key == 0) continue;
                            $multiplier = $rankingsConfig['guild_score_formula'] == 1 ? 1 : $rankingsConfig['guild_score_multiplier'];
                            echo '<tr>';
                                echo '<td class="text-center">'.guildProfile($row[0]).'</td>';
                                echo '<td class="text-center">'.returnGuildLogo($row[3], 20).'</td>';
                                echo '<td class="text-center">'.number_format(floor($row[2]*$multiplier)).'</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                    echo '</table>';
                echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="col-xs-4">
        <?php
        // Event Timers
        echo '<div class="panel panel-sidebar panel-sidebar-events">';
            echo '<div class="panel-heading">';
                echo '<h3 class="panel-title">'.lang('event_schedule').'</h3>';
            echo '</div>';
            echo '<div class="panel-body" style="min-height:400px;">';
                echo '<table class="table table-condensed">';
                    echo '<tr>';
                        echo '<td><span id="bloodcastle_name"></span><br /><span class="smalltext">'.lang('event_schedule_start').'</span></td>';
                        echo '<td class="text-right"><span id="bloodcastle_next"></span><br /><span class="smalltext" id="bloodcastle"></span></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span id="devilsquare_name"></span><br /><span class="smalltext">'.lang('event_schedule_start').'</span></td>';
                        echo '<td class="text-right"><span id="devilsquare_next"></span><br /><span class="smalltext" id="devilsquare"></span></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span id="chaoscastle_name"></span><br /><span class="smalltext">'.lang('event_schedule_start').'</span></td>';
                        echo '<td class="text-right"><span id="chaoscastle_next"></span><br /><span class="smalltext" id="chaoscastle"></span></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span id="dragoninvasion_name"></span><br /><span class="smalltext">'.lang('event_schedule_start').'</span></td>';
                        echo '<td class="text-right"><span id="dragoninvasion_next"></span><br /><span class="smalltext" id="dragoninvasion"></span></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span id="goldeninvasion_name"></span><br /><span class="smalltext">'.lang('event_schedule_start').'</span></td>';
                        echo '<td class="text-right"><span id="goldeninvasion_next"></span><br /><span class="smalltext" id="goldeninvasion"></span></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><span id="castlesiege_name"></span><br /><span class="smalltext">'.lang('event_schedule_start').'</span></td>';
                        echo '<td class="text-right"><span id="castlesiege_next"></span><br /><span class="smalltext" id="castlesiege"></span></td>';
                    echo '</tr>';
                echo '</table>';
            echo '</div>';
        echo '</div>';
        ?>
    </div>
</div>