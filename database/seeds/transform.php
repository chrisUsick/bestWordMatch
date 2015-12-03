<?php
$greenCardsRaw = DOMDocument::load('greenWordsRaw.xml');
$redCardsRaw = DOMDocument::load('redWordsRaw.xml');
$transform = DOMDocument::load('transform.xsl');
$proc = new XSLTProcessor;
$proc->importStyleSheet($transform);

foreach (['greenCards.xml' => $greenCardsRaw, 'redCards.xml' => $redCardsRaw] as $fileName => $raw) {
  $DOM =  $proc->transformToDoc($raw);
  if ($DOM->schemaValidate('cardsSchema.xsd')) {
    $DOM->save($fileName);
  }
}

?>
