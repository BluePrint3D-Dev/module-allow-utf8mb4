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
<p>This module converts the crucial tables (Products, CMS Pages, CMS Blocks) to <code>utf8mb4</code> with collation <code>utf8mb4_unicode_ci</code> on install via a Data Patch, then keeps them there with a CLI command and a cron safety net (see <strong>⚠️ Important</strong> below — this part is not optional).</p>

<p><strong>The result:</strong> Crisp, clean emojis and full 4-byte Unicode support across your entire frontend and backend.</p>

<h2>✨ Features</h2>
<ul>
    <li><strong>Emoji Compatibility:</strong> Add emojis to product descriptions, category titles, and CMS blocks.</li>
    <li><strong>Zero Core Overrides:</strong> Built using native Magento 2 Data Patches and architecture.</li>
    <li><strong>Self-Healing:</strong> A cron job re-applies the correct charset every 15 minutes if it drifts (see below for why this happens).</li>
    <li><strong>Data Safe:</strong> Alters collation and character sets without destroying or truncating existing store data.</li>
</ul>

<hr />

<h2>⚠️ Important: Run this after every <code>setup:upgrade</code></h2>
<p><strong>Magento's declarative schema does not support column-level charset overrides</strong> — only table-level. Because of this, every single time you run <code>bin/magento setup:upgrade</code> (not just on install — every deploy, every module update, every Magento version bump), Magento silently regenerates these columns using its own global default charset and reverts them off <code>utf8mb4</code>. This is a Magento core limitation, not a bug in this module, and there is no way to fix it via <code>db_schema.xml</code>.</p>

<p>If a product or CMS content is saved with emoji while the columns are in this reverted state, MySQL will silently replace the emoji with <code>?</code> at write time — and that data loss is <strong>permanent</strong>. Re-running the conversion afterwards fixes the column, but cannot recover characters already overwritten with <code>?</code>.</p>

<p>Two things protect against this:</p>
<ol>
    <li><strong>A cron job</strong> (<code>blueprint3d_allowutf8mb4_reassert_charset</code>) runs every 15 minutes and self-heals the drift automatically. This is a safety net, not a guarantee — content saved with emoji during that window can still be corrupted before the cron job catches up.</li>
    <li><strong>The CLI command below</strong>, which fixes it immediately. <strong>Always run this manually right after any <code>setup:upgrade</code></strong>, especially if you or anyone else might be editing product/CMS content around the same time as a deploy:</li>
</ol>
<pre><code>php bin/magento setup:upgrade
php bin/magento blueprint3d:utf8mb4:convert</code></pre>
<p>It's safe to run repeatedly — it only touches columns that have actually drifted and no-ops otherwise.</p>

<hr />

<h2>📦 Installation</h2>

<p><strong>1. Install via Composer</strong></p>
<pre><code>composer require blueprint3d/module-allow-utf8mb4</code></pre>

<p><strong>2. Enable the module</strong></p>
<pre><code>php bin/magento module:enable BluePrint3D_AllowUtf8mb4</code></pre>

<p><strong>3. Run the database upgrade, then immediately re-assert the charset</strong> (see ⚠️ above for why the second command is required)</p>
<pre><code>php bin/magento setup:upgrade
php bin/magento blueprint3d:utf8mb4:convert</code></pre>

<p><strong>4. Compile and flush cache</strong></p>
<pre><code>php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:flush</code></pre>

<hr />

<h2>👨‍💻 Usage</h2>
<p>Once installed and upgraded, go to <strong>Content &gt; Blocks</strong> or <strong>Catalog &gt; Products</strong> and start pasting emojis! 🚀🍕🛒 Just remember: after every future <code>setup:upgrade</code>, run <code>bin/magento blueprint3d:utf8mb4:convert</code> straight away.</p>

<hr />

<h2>📜 License</h2>
<p><strong>Copyright &copy; 2026 BluePrint3D Ltd. All rights reserved.</strong></p>

<p>This software is provided free of charge for personal or commercial use. However, the resale, redistribution, or sublicensing of this source code, modified or unmodified, for direct financial gain is strictly prohibited.</p>

<p>Please see the <code>LICENSE.txt</code> file for full terms and conditions.</p>

<p>
    <strong>Owned by:</strong> BluePrint3D Ltd (Company Registration Number: 13473806)<br />
    <strong>Email:</strong> <a href="mailto:support@blueprint3d.dev">support@blueprint3d.dev</a>
</p>