<?php
use CodeIgniter\HTTP\Header;
use CodeIgniter\CodeIgniter;

$errorId = uniqid('error', true);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> | Debug</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Poppins:wght@300;400;600&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --onyx: #070404;
            --dark-gray: #120b0c;
            --gold: #f5deb3;
            --gold-low: rgba(245, 222, 179, 0.1);
            --gold-muted: rgba(245, 222, 179, 0.6);
            --white: #ffffff;
            --error-red: #ff5f5f;
            --transit: cubic-bezier(0.23, 1, 0.32, 1);
        }

        /* 1. GLOBAL & SCROLLBAR */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--onyx);
            color: #ccc;
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            background-image: url("https://www.transparenttextures.com/patterns/black-linen.png");
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--onyx); }
        ::-webkit-scrollbar-thumb { background: var(--gold-low); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold-muted); }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }

        /* 2. HEADER SECTION */
        .header {
            background: linear-gradient(to bottom, #1a1112, var(--onyx));
            padding: 60px 0 40px;
            border-bottom: 1px solid var(--gold-low);
            position: relative;
        }
        .environment-bar {
            position: absolute;
            top: 20px;
            left: 40px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold-muted);
        }
        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--white);
            margin-bottom: 15px;
        }
        .header h1 span { color: var(--error-red); opacity: 0.8; }
        .header p {
            font-size: 1.1rem;
            color: var(--gold);
            max-width: 800px;
        }
        .search-btn {
            display: inline-block;
            margin-top: 15px;
            color: var(--white);
            text-decoration: none;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--gold);
            padding-bottom: 2px;
            transition: 0.3s;
        }
        .search-btn:hover { color: var(--gold); border-color: var(--white); }

        /* 3. SOURCE CODE VIEW */
        .source-container {
            margin-top: -30px;
            z-index: 10;
            position: relative;
        }
        .file-path {
            background: var(--dark-gray);
            padding: 15px 25px;
            border-radius: 15px 15px 0 0;
            border: 1px solid var(--gold-low);
            border-bottom: none;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: var(--gold-muted);
        }
        .source {
            background: #0d0d0d;
            border: 1px solid var(--gold-low);
            border-radius: 0 0 15px 15px;
            padding: 20px;
            overflow-x: auto;
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        }
        /* Overriding CI Default Highlighting Styles */
        .source pre { font-family: 'JetBrains Mono', monospace !important; font-size: 13px !important; }
        .source .line.highlight { background: rgba(255, 95, 95, 0.15) !important; border-left: 3px solid var(--error-red); }

        /* 4. TABS SYSTEM */
        .debug-tabs { margin: 60px 0; }
        .tabs-list {
            display: flex;
            list-style: none;
            gap: 10px;
            border-bottom: 1px solid var(--gold-low);
            margin-bottom: 30px;
            overflow-x: auto;
        }
        .tabs-list li a {
            display: block;
            padding: 12px 25px;
            text-decoration: none;
            color: var(--gold-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            transition: 0.3s;
        }
        .tabs-list li a:hover, .tabs-list li.active a {
            color: var(--gold);
            border-bottom: 2px solid var(--gold);
        }

        /* 5. TABLES & CONTENT */
        .content { display: none; animation: fadeIn 0.5s var(--transit); }
        .content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        h3 { font-family: 'Playfair Display', serif; color: var(--gold); margin: 30px 0 15px; font-size: 1.4rem; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.02);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 40px;
            border: 1px solid var(--gold-low);
        }
        th, td { padding: 15px 20px; text-align: left; font-size: 13px; border-bottom: 1px solid var(--gold-low); }
        th { background: rgba(245, 222, 179, 0.05); color: var(--gold); text-transform: uppercase; letter-spacing: 1px; width: 30%; }
        td { color: #aaa; font-family: 'JetBrains Mono', monospace; }
        tr:last-child td { border-bottom: none; }

        /* Trace List */
        .trace { list-style: none; }
        .trace li {
            background: rgba(255,255,255,0.01);
            border: 1px solid var(--gold-low);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .trace li:hover { background: rgba(245, 222, 179, 0.03); border-color: var(--gold-muted); }
        .trace-meta { font-size: 11px; color: var(--gold-muted); margin-bottom: 8px; }
        .trace-call { font-family: 'JetBrains Mono', monospace; color: var(--white); font-size: 14px; }

        .args {
            background: #000;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            display: none;
            border: 1px solid var(--gold-low);
        }

        .prev-exception {
            background: rgba(255, 95, 95, 0.05);
            border: 1px solid rgba(255, 95, 95, 0.2);
            padding: 25px;
            border-radius: 15px;
            margin: 20px 0;
            position: relative;
        }
    </style>

    <script>
        function toggle(id) {
            var el = document.getElementById(id);
            el.style.display = (el.style.display === 'block') ? 'none' : 'block';
            return false;
        }

        function init() {
            const tabs = document.querySelectorAll('.tabs-list a');
            const contents = document.querySelectorAll('.content');

            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = tab.getAttribute('href').replace('#', '');
                    
                    tabs.forEach(t => t.parentElement.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));

                    tab.parentElement.classList.add('active');
                    document.getElementById(target).classList.add('active');
                });
            });

            // Set first tab active
            if(tabs.length > 0) tabs[0].click();
        }
    </script>
</head>
<body onload="init()">

    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="environment-bar">
                <?= esc(date('H:i:s')) ?> &bull; PHP <?= esc(PHP_VERSION) ?> &bull; CI <?= esc(CodeIgniter::CI_VERSION) ?> &bull; <?= ENVIRONMENT ?>
            </div>
            <h1>
                <?= esc($title) ?> 
                <span><?= esc($exception->getCode() ? ' #' . $exception->getCode() : '') ?></span>
            </h1>
            <p><?= nl2br(esc($exception->getMessage())) ?></p>
            <a class="search-btn" href="https://www.google.com/search?q=<?= urlencode('CodeIgniter 4 ' . $title . ' ' . $exception->getMessage()) ?>" rel="noreferrer" target="_blank">
                <i class="fab fa-google"></i> Find Solution &rarr;
            </a>
        </div>
    </div>

    <!-- Source -->
    <div class="container source-container">
        <div class="file-path">
            <i class="far fa-file-code"></i> <?= esc(clean_path($file)) ?> : <b><?= esc($line) ?></b>
        </div>
        <?php if (is_file($file)) : ?>
            <div class="source">
                <?= static::highlightFile($file, $line, 15); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Previous Exceptions -->
    <div class="container">
        <?php
        $last = $exception;
        while ($prevException = $last->getPrevious()) {
            $last = $prevException;
            ?>
            <div class="prev-exception">
                <div style="font-size: 10px; color: var(--error-red); letter-spacing: 2px; margin-bottom: 10px;">CAUSED BY</div>
                <h4 style="color: var(--white); font-family: 'Playfair Display'; margin-bottom: 5px;">
                    <?= esc($prevException::class) ?> #<?= esc($prevException->getCode()) ?>
                </h4>
                <p style="color: var(--gold-muted); font-size: 13px;"><?= nl2br(esc($prevException->getMessage())) ?></p>
                <div style="font-family: monospace; font-size: 11px; margin-top: 10px; opacity: 0.5;">
                    <?= esc(clean_path($prevException->getFile()) . ':' . $prevException->getLine()) ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Debug Info -->
    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE) : ?>
    <div class="container debug-tabs">

        <ul class="tabs-list">
            <li><a href="#backtrace">Backtrace</a></li>
            <li><a href="#server">Server</a></li>
            <li><a href="#request">Request</a></li>
            <li><a href="#response">Response</a></li>
            <li><a href="#files">Files</a></li>
            <li><a href="#memory">Memory</a></li>
        </ul>

        <div class="tab-content">

            <!-- Backtrace -->
            <div class="content" id="backtrace">
                <ul class="trace">
                <?php foreach ($trace as $index => $row) : ?>
                    <li>
                        <div class="trace-meta">
                            <?php if (isset($row['file']) && is_file($row['file'])) : ?>
                                <?= esc(clean_path($row['file']) . ' : ' . $row['line']) ?>
                            <?php else: ?>
                                {PHP internal code}
                            <?php endif; ?>
                        </div>

                        <div class="trace-call">
                            <?php if (isset($row['class'])) : ?>
                                <?= esc($row['class'] . $row['type'] . $row['function']) ?>
                                <?php if (! empty($row['args'])) : ?>
                                    <?php $argsId = $errorId . 'args' . $index ?>
                                    <a href="#" style="color: var(--gold); font-size: 11px; margin-left: 10px;" onclick="return toggle('<?= esc($argsId, 'attr') ?>');">[ arguments ]</a>
                                    <div class="args" id="<?= esc($argsId, 'attr') ?>">
                                        <table>
                                            <?php
                                            $params = null;
                                            if (! str_ends_with($row['function'], '}')) {
                                                $mirror = isset($row['class']) ? new ReflectionMethod($row['class'], $row['function']) : new ReflectionFunction($row['function']);
                                                $params = $mirror->getParameters();
                                            }
                                            foreach ($row['args'] as $key => $value) : ?>
                                                <tr>
                                                    <th><?= esc(isset($params[$key]) ? '$' . $params[$key]->name : "#{$key}") ?></th>
                                                    <td><pre style="white-space: pre-wrap;"><?= esc(print_r($value, true)) ?></pre></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <?= esc($row['function']) ?>()
                            <?php endif; ?>
                        </div>

                        <?php if (isset($row['file']) && is_file($row['file']) && isset($row['class'])) : ?>
                            <div class="source" style="margin-top: 15px; box-shadow: none; border-radius: 8px;">
                                <?= static::highlightFile($row['file'], $row['line']) ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>

            <!-- Server -->
            <div class="content" id="server">
                <?php foreach (['_SERVER', '_SESSION'] as $var) : ?>
                    <?php if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var])) continue; ?>
                    <h3>$<?= esc($var) ?></h3>
                    <table>
                        <thead><tr><th>Key</th><th>Value</th></tr></thead>
                        <tbody>
                        <?php foreach ($GLOBALS[$var] as $key => $value) : ?>
                            <tr><th><?= esc($key) ?></th><td><?= is_string($value) ? esc($value) : '<pre>'.esc(print_r($value, true)).'</pre>' ?></td></tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach ?>
            </div>

            <!-- Request -->
            <div class="content" id="request">
                <?php $request = service('request'); ?>
                <h3>Request Details</h3>
                <table>
                    <tbody>
                        <tr><th>Path</th><td><?= esc($request->getUri()) ?></td></tr>
                        <tr><th>Method</th><td><?= esc($request->getMethod()) ?></td></tr>
                        <tr><th>IP Address</th><td><?= esc($request->getIPAddress()) ?></td></tr>
                        <tr><th>User Agent</th><td><?= esc($request->getUserAgent()->getAgentString()) ?></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Response -->
            <div class="content" id="response">
                <?php $response = service('response'); $response->setStatusCode(http_response_code()); ?>
                <h3>Response Status</h3>
                <table>
                    <tr><th>Status</th><td><?= esc($response->getStatusCode() . ' - ' . $response->getReasonPhrase()) ?></td></tr>
                </table>
            </div>

            <!-- Files -->
            <div class="content" id="files">
                <h3>Included Files</h3>
                <ol style="padding-left: 20px; font-family: monospace; font-size: 12px; color: var(--gold-muted);">
                <?php foreach (get_included_files() as $file) :?>
                    <li style="margin-bottom: 5px;"><?= esc(clean_path($file)) ?></li>
                <?php endforeach ?>
                </ol>
            </div>

            <!-- Memory -->
            <div class="content" id="memory">
                <h3>Memory Metrics</h3>
                <table>
                    <tr><th>Usage</th><td><?= esc(static::describeMemory(memory_get_usage(true))) ?></td></tr>
                    <tr><th>Peak Usage</th><td><?= esc(static::describeMemory(memory_get_peak_usage(true))) ?></td></tr>
                    <tr><th>Limit</th><td><?= esc(ini_get('memory_limit')) ?></td></tr>
                </table>
            </div>

        </div>
    </div>
    <?php endif; ?>

    <div style="text-align: center; padding: 40px; font-size: 10px; color: var(--gold-low); letter-spacing: 2px;">
        COFFEE TIME DEBUG CONSOLE &bull; 2026
    </div>

</body>
</html>