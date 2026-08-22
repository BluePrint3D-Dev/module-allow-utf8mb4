<h1>BluePrint3D - Allow UTF8MB4 (Emoji Support) for Magento 2 🚀</h1>

<p>
    <a href="#"><img src="https://img.shields.io/badge/Magento-2.4.x-orange.svg" alt="Magento Version" /></a>
    <a href="#"><img src="https://img.shields.io/badge/PHP-8.1%20|%208.2%20|%208.3-blue.svg" alt="PHP Version" /></a>
    <a href="#"><img src="https://img.shields.io/badge/License-Proprietary-lightgrey.svg" alt="License" /></a>
</p>

<p>A lightweight, bulletproof Magento 2 module that permanently enables <code>utf8mb4</code> encoding across your database. Finally, you can use emojis, extended multilingual characters, and complex Unicode symbols anywhere in your store without Magento destroying them.</p>

<hr />

<h2>🛑 The Problem</h2>
<p>By default, older versions of Magento 2 configure MySQL tables to use the legacy 3-byte <code>utf8</code> (or <code>utf8mb3</code>) character set. If a content manager or customer attempts to save a 4-byte character—like an emoji (🔥) or a rare Unicode symbol—Magento and MySQL will silently crash the string, chopping off the text and replacing your carefully crafted content with <code>???</code>.</p>

<h2>🛠️ The Solution</h2>
<p>This module injects a targeted Data Patch into Magento's deployment cycle. It automatically converts crucial tables (like Products, CMS Pages, CMS Blocks, and Customer Data) to <code>utf8mb4</code> and adjusts the active collation to <code>utf8mb4_unicode_ci</code>.</p>

<p><strong>The result:</strong> Crisp, clean emojis and full 4-byte Unicode support across your entire frontend and backend.</p>

<h2>✨ Features</h2>
<ul>
    <li><strong>Emoji Compatibility:</strong> Add emojis to product descriptions, category titles, and CMS blocks.</li>
    <li><strong>Zero Core Overrides:</strong> Built using native Magento 2 Data Patches and architecture.</li>
    <li><strong>Future-Proof Deployments:</strong> Automatically applies the correct database collations on deployment (<code>setup:upgrade</code>).</li>
    <li><strong>Data Safe:</strong> Alters collation and character sets without destroying or truncating existing store data.</li>
</ul>

<hr />

<h2>📦 Installation</h2>

<p><strong>1. Install via Composer</strong></p>
<pre><code>composer require blueprint3d/module-allow-utf8mb4</code></pre>

<p><strong>2. Enable the module</strong></p>
<pre><code>php bin/magento module:enable BluePrint3D_AllowUtf8mb4</code></pre>

<p><strong>3. Run the database upgrade (This applies the UTF8MB4 Data Patch)</strong></p>
<pre><code>php bin/magento setup:upgrade</code></pre>

<p><strong>4. Compile and flush cache</strong></p>
<pre><code>php bin/magento setup:di:compile
php bin/magento cache:flush</code></pre>

<hr />

<h2>👨‍💻 Usage</h2>
<p>There is no Admin UI required. Once installed and upgraded, the module works silently in the background. Simply go to <strong>Content &gt; Blocks</strong> or <strong>Catalog &gt; Products</strong> and start pasting emojis! 🚀🍕🛒</p>

<hr />

<h2>📜 License</h2>
<p><strong>Copyright &copy; 2026 BluePrint3D Ltd. All rights reserved.</strong></p>

<p>This software is provided free of charge for personal or commercial use. However, the resale, redistribution, or sublicensing of this source code, modified or unmodified, for direct financial gain is strictly prohibited.</p>

<p>Please see the <code>LICENSE.txt</code> file for full terms and conditions.</p>

<p>
    <strong>Owned by:</strong> BluePrint3D Ltd (Company Registration Number: 13473806)<br />
    <strong>Email:</strong> <a href="mailto:support@blueprint3d.dev">support@blueprint3d.dev</a>
</p>