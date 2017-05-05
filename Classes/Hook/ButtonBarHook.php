<?php

namespace Panama\SaveButtonSplitter\Hook;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Ruben Pascal Abel <r.abel@panama.de>, Panama Werbeagentur GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Backend\Template\Components\Buttons\SplitButton;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Event
 */
class ButtonBarHook implements SingletonInterface {

    /**
     * Splits out the Save buttons
     *
     * @param array $params
     * @param \TYPO3\CMS\Backend\Template\Components\ButtonBar $pObj
     *
     * @return array
     */
    public function getButtons(array $params, ButtonBar $pObj) {
        /** @var \TYPO3\CMS\Backend\Template\Components\Buttons\AbstractButton $buttons */
        $buttonGroups = &$params['buttons']['left'];

        if(!empty($buttonGroups) && is_array($buttonGroups)) {
            foreach ($buttonGroups as $key => $buttonGroup) {
                foreach ($buttonGroup as $button) {
                    if ($button instanceof SplitButton) {
                        /** @var array $items */
                        $items = $button->getButton();
                        /** @var \TYPO3\CMS\Backend\Template\Components\Buttons\InputButton $primary */
                        $primary = $items['primary'];

                        if (!empty($primary) && is_object($primary) && $primary instanceof InputButton && $primary->getName() == '_savedok') {
                            $buttonGroups[$key] = $items['options'] ?: [];
                            array_unshift($buttonGroups[$key], $primary);
                            break 2;
                        }
                    }
                }
            }
        }

        return $params['buttons'];
    }

}
