<?php

/**
 * @var yii\web\View $this
 * @var String $heading
 * @var String $title
 * @var String|array $body
 *
 */

if (!is_array($body)) {
    $body = [$body];
}

$this->title = $heading;

?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
    }

    .faq-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #211F30; /* primaryColor */
    }

    .faq {
        margin-bottom: 20px;
    }

    .faq-question {
        background-color: #D4ABE1; /* primaryLight */
        color: white;
        padding: 15px;
        border-radius: 5px;
    }

    .faq-answer {
        margin-top: 10px;
        padding: 15px;
        border-left: 4px solid #FF97A8; /* secondaryLight */
        background-color: #F1F1F1; /* Light gray for contrast */
        border-radius: 5px;
    }

    .faq-answer p {
        margin: 10px 0;
    }

</style>

<div class="faq-container">
    <h1><?=$heading?></h1>
    <div class="faq">
        <div class="faq-question">
            <h2><?=$title?></h2>
        </div>
        <div class="faq-answer">
            <?php
            foreach ($body as $paragraph) {
                echo '<p>' . htmlspecialchars($paragraph) . '</p>';
            }
            ?>
        </div>
    </div>
</div>