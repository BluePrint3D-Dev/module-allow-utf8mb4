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
var config = {
    config: {
        mixins: {
            'Magento_Ui/js/lib/validation/rules': {
                'BluePrint3D_AllowUtf8mb4/js/override-ui-rules': true
            },
            'mage/validation': {
                'BluePrint3D_AllowUtf8mb4/js/override-mage-rules': true
            }
        }
    }
};