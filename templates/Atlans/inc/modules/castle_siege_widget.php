<?php
/**
 * WebEngine CMS - Castle Siege Sidebar Widget
 * Este archivo carga dinámicamente la información del Castle Siege para la barra lateral.
 */

// Asegúrate de que access esté definido para seguridad (aunque ya lo hace index.php)
if(!defined('access') || !access) {
    die('Direct access not permitted.');
}

// Incluir la clase CastleSiege
// __PATH_CLASSES__ debería apuntar a includes/classes/ donde está class.castlesiege.php
// Si tu estructura de WebEngine es estándar, esto debería ser suficiente.
// Si no, necesitarás ajustar la ruta.
require_once(__PATH_CLASSES__ . 'class.castlesiege.php');

$castleSiege = new CastleSiege();
$siegeData = $castleSiege->siegeData();

// Verifica si hay datos válidos del castillo y si el módulo está habilitado
$hasCastleOwner = false;
$ownerGuild = null;
if (is_array($siegeData) && isset($castleSiege) && is_object($castleSiege) && $castleSiege->moduleEnabled() && $siegeData['castle_data'][_CLMN_MCD_OCCUPY_] == 1 && isset($siegeData['castle_owner_alliance'][0])) {
    $hasCastleOwner = true;
    $ownerGuild = $siegeData['castle_owner_alliance'][0];
}
?>

<div class="panel castle-owner-widget custom-panel-theme">
    <div class="panel-heading">
        <h3 class="panel-title">Castle Siege</h3>
    </div>
    <div class="panel-body">
        <?php if ($hasCastleOwner) { ?>
            <div class="row">
                <div class="col-sm-6 text-center">
                    <?php echo returnGuildLogo($ownerGuild['G_Mark'], 100); ?>
                </div>
                <div class="col-sm-6">
                    <span class="alt">Dueño del Castillo</span><br />
                    <a href="<?php echo __BASE_URL__; ?>profile/guild/req/<?php echo urlencode($ownerGuild['G_Name']); ?>/" target="_blank"><?php echo $ownerGuild['G_Name']; ?></a><br /><br />
                    <span class="alt">Guild Master</span><br />
                    <a href="<?php echo __BASE_URL__; ?>profile/player/req/<?php echo urlencode($ownerGuild['G_Master']); ?>/" target="_blank"><?php echo $ownerGuild['G_Master']; ?></a>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>Actualmente no hay un dueño de castillo registrado.</p>
                    <?php if (isset($castleSiege) && is_object($castleSiege) && !$castleSiege->moduleEnabled()) { ?>
                        <p>El módulo de Castle Siege no está habilitado en la configuración del CMS.</p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-12 text-center">
                <span class="alt">Etapa</span><br />
                <?php
                if(is_array($siegeData) && isset($siegeData['current_stage'])) {
                    echo $siegeData['current_stage']['title'];
                } else {
                    echo 'Información no disponible';
                }
                ?>
                <br /><br />
                <span class="alt">Batalla Castle Siege</span><br />
                <?php
                if(is_array($siegeData) && isset($siegeData['next_stage_countdown'])) {
                    echo $siegeData['next_stage_countdown'];
                } else {
                    echo 'Información no disponible';
                }
                ?>
                <br /><br />
                <a href="<?php echo __BASE_URL__; ?>castlesiege" class="btn btn-castlewidget btn-xs">Información del Castillo</a>
            </div>
        </div>
    </div>
</div>