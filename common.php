<?php

/**
 *  Escapes HTML for output
 *  (Prevents XSS Attacks)
 */

function escape($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
