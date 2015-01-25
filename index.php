<!doctype html>

<?php include "head.php" ?>

<!-- Tabs -->

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Turnier hinzufügen</a></li>
		<li><a href="#tabs-2">Fechter hinzufügen</a></li>
		<li><a href="#tabs-3">Turnierlisten exportieren</a></li>
	</ul>
	<div id="tabs-1"><?php include "subpages/Tournament.php" ?></div>
	<div id="tabs-2"><?php include "subpages/AddFencer.php" ?></div>
	<div id="tabs-3"><?php include "subpages/ExportList.php" ?></div>
</div>

<?php include "foot.php" ?>
