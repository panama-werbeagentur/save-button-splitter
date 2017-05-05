<?php

///
/// Register buttonbar hook
///
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Backend\Template\Components\ButtonBar']['getButtonsHook'][]
    = sprintf('%s->%s', \Panama\SaveButtonSplitter\Hook\ButtonBarHook::class, 'getButtons');
