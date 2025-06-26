<?php
/**
 * Online Players
 * https://webenginecms.org/
 * 
 * @version 1.0.0
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2019 Lautaro Angelico, All Rights Reserved
 * @build w641ba01901cb0925ec50f543e59acbd
 */

// File Name
$file_name = basename(__FILE__);

// Run Cron
$OnlinePlayers = new \Plugin\OnlinePlayers\OnlinePlayers();
$OnlinePlayers->updateCache();

// UPDATE CRON
updateCronLastRun($file_name);