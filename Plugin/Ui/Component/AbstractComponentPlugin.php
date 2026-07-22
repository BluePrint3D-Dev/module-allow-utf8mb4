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
namespace BluePrint3D\AllowUtf8mb4\Plugin\Ui\Component;

use Magento\Ui\Component\AbstractComponent;

class AbstractComponentPlugin
{
    public function afterGetJsConfig(AbstractComponent $subject, array $result): array
    {
        if (!empty($result)) {
            $result = $this->scrubEmojiValidationRule($result);
        }
        return $result;
    }

    private function scrubEmojiValidationRule(array $data): array
    {
        foreach ($data as $key => $value) {
            if ($key === 'validate-no-utf8mb4-characters') {
                unset($data[$key]);
            } elseif (is_array($value)) {
                $data[$key] = $this->scrubEmojiValidationRule($value);
            }
        }
        return $data;
    }
}