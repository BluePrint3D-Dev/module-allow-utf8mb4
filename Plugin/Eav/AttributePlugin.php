<?php
/**
 * Copyright (c) 2026 BluePrint3D Ltd. All rights reserved.
 * 
 * This software is provided free of charge for personal or commercial use.
 * Resale, redistribution, or sublicensing of this source code, modified or 
 * unmodified, for direct financial gain is strictly prohibited.
 *
 * @author    BluePrint3D Ltd <support@blueprint3d.dev>
 * @copyright 2026 BluePrint3D Ltd (Company No. 13473806)
 * @license   Custom Proprietary EULA (See LICENSE.txt)
 */
namespace BluePrint3D\AllowUtf8mb4\Plugin\Eav;

use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;

class AttributePlugin
{
    public function afterGetValidationRules(AbstractAttribute $subject, $result)
    {
        if (is_array($result)) {
            unset($result['validate-no-utf8mb4-characters']);
        }
        return $result;
    }
}