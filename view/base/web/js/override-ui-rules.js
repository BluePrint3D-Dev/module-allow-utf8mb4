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
define([], function () {
    'use strict';

    return function (rules) {
        // Create a proper rule object that Knockout understands
        var alwaysPass = function () {
            return true;
        };

        alwaysPass.handler = function () {
            return true;
        };

        alwaysPass.message = '';

        // Safely overwrite the rule
        rules['validate-no-utf8mb4-characters'] = alwaysPass;

        return rules;
    };
});