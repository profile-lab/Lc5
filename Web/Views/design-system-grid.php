<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= __base_assets_folder__ . 'css/style-default.css' ?>" />
</head>

<body class="">
    <nav id="design_system">
        <a href="/design-system">Design System</a>
        <a href="/design-system-grid">Grid</a>
    </nav>
    <section class="design-system-row">
        <div class="design-system-row-name">GRID</div>
        <code><?= trim(htmlspecialchars('
<div class="myIn">
    <div class="col-full">.col-full</div>
</div>
<div class="myIn">
    <div class="col-1-2">.col-1-2</div>
    <div class="col-1-2">.col-1-2</div>
</div>
        ')) ?>
        </code>
        <div class="design-system-row-samples">

            <div class="myIn">
                <div class="col-full">.col-full</div>
            </div>
            <div class="myIn">
                <div class="col-1-2">.col-1-2</div>
                <div class="col-1-2">.col-1-2</div>
            </div>
        </div>
    </section>



    
    <style>
        .design-system-row {
            padding: 1rem;
            background: #FFF;
            border-bottom: 1px solid #f1f1f1;
        }

        .design-system-row code {
            display: block;
            font-family: monospace;
            font-size: .8rem;
            line-height: 1.5;
            border-radius: 1rem;
            margin: .5rem 0;
            padding: 1rem;
            background: #f1f1f1;
            white-space: break-spaces;
        }

        .design-system-row-name {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            font-size: 1rem;
            padding: .5em 1.275em;
            font-weight: 900;
            text-transform: uppercase;
            color: #6d6d6d;
        }

        .design-system-row-samples {
            display: block;
            padding: 0 0;
        }
        .design-system-row-samples-cols {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 1rem;
        }
        .dummy-border {
            border: #f1f1f1 1px solid;
        }
        .dummy-box{
            padding: 1rem;
            min-width: 6rem;
            min-height: 4rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .design-system-row-samples .myIn>div {
            padding: 1rem;
            background: #fafafa;
            margin: 1rem 0;
            border: #f0f0f0 1px solid;
            border-right: none;
        }

        .design-system-row-samples .myIn>div:last-child {
            border-right: #f1f1f1 1px solid;
        }

        nav#design_system {
            background: #1f1f1f;
            color: #f1f1f1;
            font-weight: 700;
        }

        nav#design_system a {
            color: #f1f1f1;
            padding: 1rem;
            display: inline-block;
        }
    </style>
</body>

</html>