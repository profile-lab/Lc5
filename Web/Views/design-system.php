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
        <div class="design-system-row-name">Typografy</div>
        <code><?= trim(htmlspecialchars('
<h1>Title H1</h1>
<h2>Title H2</h2>
<h3>Title H3</h3>
<h4>Title H4</h4>
<h5>Title H5</h5>
<h6>Subtitle</h6>
<p>Paragraph...</p>
<div>Text.</div>
')) ?>
        </code>
        <div class="design-system-row-samples">
            <h1>Title H1</h1>
            <h2>Title H2</h2>
            <h3>Title H3</h3>
            <h4>Title H4</h4>
            <h5>Title H5</h5>
            <h6>Subtitle</h6>
            <p>Paragraph Lorem ipsum dolor sit amet. <b>Bold strong</b> <i>Italic text</i> and normal.</p>
            <div>Normal text in body or paragraph: Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias.</div>
        </div>
    </section>
    <section class="design-system-row">
        <div class="design-system-row-name">Colors</div>
        <code><?= trim(htmlspecialchars('
<div class="bg-primary">.primary</div>
<div class="bg-secondary">.secondary</div>
<div class="bg-dark">.dark</div>
<div class="bg-light">.light</div>
')) ?>
        </code>
        <div class="design-system-row-samples">

            <div class="design-system-row-samples-cols">
                <div class="dummy-box dummy-border bg-primary">.bg-primary</div>
                <div class="dummy-box dummy-border bg-secondary">.bg-secondary</div>
                <div class="dummy-box dummy-border bg-dark">.bg-dark</div>
                <div class="dummy-box dummy-border bg-light">.bg-light</div>
            </div>

        </div>
        <code><?= trim(htmlspecialchars('
<div class="primary">.primary</div>
<div class="secondary">.secondary</div>
<div class="dark">.dark</div>
<div class="light">.light</div>
')) ?>
        </code>
        <div class="design-system-row-samples">

            <div class="design-system-row-samples-cols">
                <div class="dummy-box dummy-border bg-primary">.primary</div>
                <div class="dummy-box dummy-border bg-secondary">.secondary</div>
                <div class="dummy-box dummy-border bg-dark">.dark</div>
                <div class="dummy-box dummy-border bg-light">.light</div>
            </div>

        </div>
    </section>
    <section class="design-system-row">
        <div class="design-system-row-name">Buttons and Links</div>
        <code><?= trim(htmlspecialchars('
<button>Button</button>
<a class="button" href="#">Link button</a>
')) ?>
        </code>
        <div class="design-system-row-samples">
            <button>Button</button>
            <a class="button" href="#">Link button</a>
        </div>
        <code><?= trim(htmlspecialchars('
<button class="link">Button txt</button>
<a class="link" href="#">Link</a>
')) ?>
        </code>
        <div class="design-system-row-samples">
            <button class="link">Button txt</button>
            <a class="link" href="#">Link</a>
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

        .dummy-box {
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